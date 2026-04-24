<section>
    <h2>Новое помещение</h2>
    <?php if (!empty($message)): ?><output class="error"><?= $message ?></output><?php endif; ?>
    <form method="post">
        <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
            <label>Номер помещения
                <input type="number" name="RoomNumber" min="1" step="1" max="9999" inputmode="numeric" required>
            </label>
        <label>Тип<select name="RoomTypeID" required>
            <?php foreach ($types as $t): ?>
                <option value="<?= $t->RoomTypeID ?>"><?= $t->RoomTypeName ?></option>
            <?php endforeach; ?>
        </select></label>
        <label>Подразделение<select name="DepartmentID" required>
            <?php foreach ($departments as $d): ?>
                <option value="<?= $d->DepartmentID ?>"><?= $d->DepartmentName ?></option>
            <?php endforeach; ?>
        </select></label>
        <button type="submit">Сохранить</button>
    </form>
</section>