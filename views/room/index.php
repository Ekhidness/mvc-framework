<section>
    <h2>Помещения</h2>
    <nav><a href="<?= app()->route->getUrl('/sys/rooms/create') ?>">Добавить помещение</a></nav>
    <table>
        <thead><tr><th>Номер</th><th>Тип</th><th>Подразделение</th></tr></thead>
        <tbody>
        <?php foreach ($rooms as $r): ?>
            <tr>
                <td><?= $r->RoomNumber ?></td>
                <td><?= $r->type->RoomTypeName ?></td>
                <td><?= $r->department->DepartmentName ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>