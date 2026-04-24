<section>
    <h2>Добавить системного администратора</h2>
    <?php if (!empty($message)): ?><output class="error"><?= $message ?></output><?php endif; ?>
    <form method="post">
        <input name="csrf_token" type="hidden" value="<?= app()->auth->generateCSRF() ?>"/>
        <label>Логин<input type="text" name="login" required></label>
        <label>Пароль<input type="password" name="password" required></label>
        <button type="submit">Создать</button>
    </form>
</section>