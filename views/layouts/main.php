<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Внутренняя телефонная связь</title>
    <link rel="stylesheet" href="<?= app()->settings->getRootPath() ?>/css/main.css">
</head>
<body>
<header>
    <nav>
        <a href="<?= app()->route->getUrl('/hello') ?>">Главная</a>
        <?php if (app()->auth::check()): ?>
            <?php if (app()->auth::user()->isAdmin()): ?>
                <a href="<?= app()->route->getUrl('/admin/users') ?>">Сисадмины</a>
            <?php endif; ?>
            <?php if (app()->auth::user()->canAccessSystem()): ?>
                <a href="<?= app()->route->getUrl('/sys/departments') ?>">Подразделения</a>
                <a href="<?= app()->route->getUrl('/sys/rooms') ?>">Помещения</a>
                <a href="<?= app()->route->getUrl('/sys/subscribers') ?>">Абоненты</a>
                <a href="<?= app()->route->getUrl('/sys/phones') ?>">Телефоны</a>
                <a href="<?= app()->route->getUrl('/sys/phones/attach') ?>">Прикрепить номер</a>
                <a href="<?= app()->route->getUrl('/sys/phones/by-department') ?>">Номера по отделам</a>
            <?php endif; ?>
            <a href="<?= app()->route->getUrl('/logout') ?>">Выход (<?= app()->auth::user()->Login ?>)</a>
        <?php else: ?>
            <a href="<?= app()->route->getUrl('/login') ?>">Вход</a>
        <?php endif; ?>
    </nav>
</header>
<main>
    <?= $content ?? '' ?>
</main>
<footer>
    <small>&copy; <?= date('Y') ?> Система учёта внутренней телефонной связи</small>
</footer>
</body>
</html>