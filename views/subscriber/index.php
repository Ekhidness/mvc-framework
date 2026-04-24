<section>
    <h2>Абоненты</h2>
    <nav><a href="<?= app()->route->getUrl('/sys/subscribers/create') ?>">Добавить абонента</a></nav>

    <form method="get" style="display: flex; gap: 1rem; margin-bottom: 1rem;">
        <label>Подразделение
            <select name="department_id">
                <option value="">Все подразделения</option>
                <?php foreach ($departments as $d): ?>
                    <option value="<?= $d->DepartmentID ?>" <?= ($_GET['department_id'] ?? '') == $d->DepartmentID ? 'selected' : '' ?>>
                        <?= htmlspecialchars($d->DepartmentName) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>Поиск по ФИО
            <input type="text" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" placeholder="Фамилия...">
        </label>

        <button type="submit">Фильтр</button>
        <?php if (!empty($_GET['search']) || !empty($_GET['department_id'])): ?>
            <a href="<?= app()->route->getUrl('/sys/subscribers') ?>">Сбросить</a>
        <?php endif; ?>
    </form>

    <table>
        <thead>
        <tr>
            <th>Фото</th>
            <th>ФИО</th>
            <th>Дата рождения</th>
            <th>Подразделение</th>
            <th>Телефоны</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($subscribers as $s): ?>
            <?php
            $deptName = '-';
            if ($s->phones->isNotEmpty()) {
                $firstPhone = $s->phones->first();
                if ($firstPhone->room && $firstPhone->room->department) {
                    $deptName = $firstPhone->room->department->DepartmentName;
                }
            }
            ?>
            <tr>
                <td>
                    <?php if (!empty($s->Photo)): ?>
                        <img src="/<?= htmlspecialchars($s->Photo) ?>" alt="Фото" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; vertical-align: middle;">
                    <?php else: ?>
                        <span style="color: #888; font-size: 0.85rem;">Нет фото</span>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($s->Surname) ?> <?= htmlspecialchars($s->Name) ?> <?= htmlspecialchars($s->Patronymic) ?></td>
                <td><?= htmlspecialchars($s->BirthdayDate) ?></td>
                <td><?= htmlspecialchars($deptName) ?></td>
                <td>
                    <?php if ($s->phones->isNotEmpty()): ?>
                        <?php foreach ($s->phones as $p): ?>
                            <?= htmlspecialchars($p->Number) ?><br>
                        <?php endforeach; ?>
                    <?php else: ?>
                        Нет номеров
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?= app()->route->getUrl('/sys/subscribers/phones') ?>?id=<?= $s->SubscriberID ?>">Все номера</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>