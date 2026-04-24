<section>
    <h2>Авторизация</h2>
    <?php if (!empty($message)): ?><output class="error"><?= $message ?></output><?php endif; ?>
    <?php if (!app()->auth::check()): ?>
        <form method="post">
            <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
            <label>Логин<input type="text" name="login" required></label>
            <label>Пароль<input type="password" name="password" required></label>
            <button type="submit">Войти</button>
        </form>
    <?php endif; ?>
</section>