<section>
    <h2>Система ВТС</h2>
    <p>Добро пожаловать в систему учёта внутренней телефонной связи.</p>
    <nav>
        <?php if (app()->auth::user()->isAdmin()): ?>
            <a href="<?= app()->route->getUrl('/admin/users') ?>">Управление сисадминами</a>
        <?php endif; ?>
        <a href="<?= app()->route->getUrl('/sys/departments') ?>">Перейти к справочникам</a>
    </nav>
</section>