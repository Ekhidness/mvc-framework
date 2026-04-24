<section>
    <h2>Телефонные номера</h2>
    <nav>
        <a href="<?= app()->route->getUrl('/sys/phones/create') ?>">Добавить номер</a>
        <a href="<?= app()->route->getUrl('/sys/phones/attach') ?>">Управление номерами</a>
    </nav>
    <table>
        <thead><tr><th>Номер</th><th>Помещение</th><th>Подразделение</th><th>Абонент</th></tr></thead>
        <tbody>
        <?php foreach ($phones as $p): ?>
            <tr>
                <td><?= $p->Number ?></td>
                <td><?= $p->room->RoomNumber ?></td>
                <td><?= $p->room->department->DepartmentName ?></td>
                <td><?= $p->subscriber ? $p->subscriber->Surname . ' ' . $p->subscriber->Name : 'Свободен' ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>