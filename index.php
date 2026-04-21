<?php
$link = new mysqli("localhost", "root", "", "photos1");
$link->set_charset("utf8");
$data = $link->query("SELECT * FROM `photos`")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Проект 12-11</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="media.css">
</head>
<body>    

    <header>
            <a href="#">Главная</a>
            <a id="show_add_photo" href="#">Фото</a>
            <a href="#">Посты</a>
            <a href="#">Личный кабинет</a>
    </header>
    <h1>Галерея</h1>
    <div id="grid">
        <?php foreach ($data as $photo): ?>
            <div class="photo">
                <img src="<?= $photo["Image"] ?>" alt="">
                <p><?= $photo["Text"] ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <div id="add_new_photo">
        <div>
            <input id="new_photo_src" type="text" placeholder="Картинка">
            <input id="new_photo_text" type="text" placeholder="Подпись">
            <button id="add_photo">Добавить</button>
            <button id="cancel">Отмена</button>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>