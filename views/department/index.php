<section>
    <h2>Подразделения</h2>
    <nav><a href="<?= app()->route->getUrl('/sys/departments/create') ?>">Добавить подразделение</a></nav>
    
    <table>
        <thead>
            <tr>
                <th>Название</th>
                <th>Тип</th>
                <th>Кол-во помещений</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($departments as $d): ?>
            <tr>
                <td><?= $d->DepartmentName ?></td>
                <td>
                    <?= $d->departmentType ? $d->departmentType->DepartmentTypeName : '-' ?>
                </td>
                <td><?= $d->rooms_count ?? 0 ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>