<?php
if (isset($_POST['login'], $_POST['password'])) {
    require "vendor/autoload.php";
    $db = new \Photos\DB();
    $login_exist = $db->check_login($_POST['login']);
    if ($login_exist) {
        header( header: "Location: user.php?sign_error=login");
    }
    else {
        $db->new_user($_POST['login'], $_POST['password']);
        header( header: "Location: user.php?sign_success=ok");
    }
}
