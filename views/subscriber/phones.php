<section>
    <h2>Номера абонента: <?= $subscriber->Surname ?> <?= $subscriber->Name ?></h2>
    <table>
        <thead><tr><th>Номер</th><th>Помещение</th></tr></thead>
        <tbody>
        <?php foreach ($subscriber->phones as $p): ?>
            <tr>
                <td><?= $p->Number ?></td>
                <td><?= $p->room->RoomNumber ?> (<?= $p->room->department->DepartmentName ?>)</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <nav><a href="<?= app()->route->getUrl('/sys/subscribers') ?>">Назад к списку</a></nav>
</section>