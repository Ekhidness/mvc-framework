<section>
    <h2>Новый телефонный номер</h2>
    <?php if (!empty($message)): ?><output class="error"><?= $message ?></output><?php endif; ?>
    <form method="post">
        <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
        <label>Номер<input type="Number" name="Number" min="0" max="99999999999" required></label>
        <label>Помещение<select name="RoomID" required>
            <?php foreach ($rooms as $r): ?>
                <option value="<?= $r->RoomID ?>"><?= $r->RoomNumber ?> (<?= $r->department->DepartmentName ?>)</option>
            <?php endforeach; ?>
        </select></label>
        <button type="submit">Сохранить</button>
    </form>
</section>