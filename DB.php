<?php
namespace Photos;
use mysqli;
class DB {

    static $host = "localhost";
    static $user = "root";
    static $password = "";
    static $database = "photos1";

    public $link;

  public function __construct() {
    $this->link = new mysqli(DB::$host, DB::$user, DB::$password, DB::$database);
    $this->link->set_charset(charset: "utf8mb4");
  }

public function get_all_photos() {
    $sql_result = $this->link->query( query: "SELECT * FROM `photos` ORDER BY `Id` DESC");
    if ($sql_result->num_rows) {
        return $sql_result->fetch_all( mode: MYSQLI_ASSOC);
    }
    return [];
}

public function get_user_photos($uid) {
    $sql_result = $this->link->query( query: "SELECT * FROM `photos` WHERE `Uid` = $uid ORDER BY `Id` DESC");
    if ($sql_result->num_rows) {
        return $sql_result->fetch_all( mode: MYSQLI_ASSOC);
    }
    return [];
}

public function check_user($login, $password) {
    $stmt = $this->link->prepare("SELECT * FROM `users` WHERE `Email` = ? AND `Password` = ? LIMIT 1");
    $stmt->bind_param("ss", $login, $password);
    $stmt->execute();
    $sql_result = $stmt->get_result();
    if ($sql_result->num_rows) {
        $user = $sql_result->fetch_assoc();
        return $user["id"] ?? $user["Id"] ?? false;
    }
    return false;
}

public function check_login($login) {
    $stmt = $this->link->prepare("SELECT 1 FROM `users` WHERE `Email` = ? LIMIT 1");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $sql_result = $stmt->get_result();
    if ($sql_result->num_rows) {
        return true;
    }
    return false;
}

public function new_user($login, $password) {
    $stmt = $this->link->prepare("INSERT INTO `users` (`Name`, `Password`, `Email`) VALUES ('', ?, ?)");
    $stmt->bind_param("ss", $password, $login);
    $stmt->execute();
}

public function new_photo($uid, $image, $text) {
    $this->link->query( query: "INSERT INTO `photos` (`Uid`, `Image`, `Text`, `Tags`) VALUES ($uid, '$image', '$text', '')");
}

public function get_photo_by_id($photo_id) {
    $sql_result = $this->link->query(
        query: "SELECT `p`.*, `u`.`Name` FROM `photos` `p` LEFT JOIN `users` `u` ON `u`.`Id` = `p`.`Uid` WHERE `p`.`Id` = $photo_id"
    );
    if ($sql_result->num_rows) {
        return $sql_result->fetch_assoc();
    }
    return false;
}

public function get_photo_comments($photo_id) {
    $sql_result = $this->link->query(
        query: "SELECT `c`.*, `u`.`Name` FROM `comments` `c` LEFT JOIN `users` `u` ON `u`.`Id` = `c`.`Uid` WHERE `c`.`Pid` = $photo_id ORDER BY `Id` DESC"
    );
    if ($sql_result->num_rows) {
        return $sql_result->fetch_all(mode: MYSQLI_ASSOC);
    }
    return [];
}

public function add_comment($pid, $uid, $text) {
    $date = date(format: "Y-m-d");
    $this->link->query(query: "INSERT INTO `comments` (`Pid`, `Uid`, `Text`, `Post_date`) VALUES ($pid, $uid, '$text', '$date')");
    $last_id = $this->link->insert_id;
    $inserted_comment = $this->link->query(
        query: "SELECT `c`.*, `u`.`Name` FROM `comments` `c` LEFT JOIN `users` `u` ON `u`.`Id` = `c`.`Uid` WHERE `c`.`Id` = $last_id"
    );
    return $inserted_comment->fetch_assoc();
}
}
