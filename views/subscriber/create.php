<section>
    <h2>Новый абонент</h2>
    <?php if (!empty($message)): ?><output class="error"><?= $message ?></output><?php endif; ?>
    <form method="post" enctype="multipart/form-data">
        <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
        <label>Фамилия<input type="text" name="Surname" required></label>
        <label>Имя<input type="text" name="Name" required></label>
        <label>Отчество<input type="text" name="Patronymic"></label>
        <label>Дата рождения<input type="date" name="BirthdayDate" required></label>
        <label>Подразделение<select name="DepartmentID" required>
            <?php foreach ($departments as $d): ?>
                <option value="<?= $d->DepartmentID ?>"><?= $d->DepartmentName ?></option>
            <?php endforeach; ?>
        </select></label>
        <label>Фото<input type="file" name="Photo" accept="image/*"></label>
        <button type="submit">Сохранить</button>
    </form>
</section>