<header>
    <a href="index.php">Главная</a>
    <?php if ($user_id): ?>
    <a id="show_add_photo" href="#">Фото</a>
    <?php endif; ?>
    <a href="#">Посты</a>
    <a href="user.php">Личный кабинет</a>
    <?php if ($user_id): ?>
    <a href="logout.php">Выйти</a>
    <?php endif; ?>
</header>