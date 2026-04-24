<section>
    <h2>Создание подразделения</h2>
    <?php if (!empty($message)): ?><output class="error"><?= $message ?></output><?php endif; ?>
    <form method="post">
        <input type="hidden" name="csrf_token" value="<?= app()->auth->generateCSRF() ?>">
        <label>Название
            <input type="text"
                   name="DepartmentName"
                   pattern="[a-zA-Zа-яА-ЯёЁ]([a-zA-Zа-яА-ЯёЁ -]*[a-zA-Zа-яА-ЯёЁ])?"
                   required>
        </label>
        <label>Тип подразделения
            <select name="DepartmentTypeID" required>
                <?php foreach ($types as $t): ?>
                    <option value="<?= $t->DepartmentTypeID ?>"><?= $t->DepartmentTypeName ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <button type="submit">Создать</button>
    </form>
</section>