<section>
    <h2>Системные администраторы</h2>
    <nav><a href="<?= app()->route->getUrl('/admin/users/create') ?>">Добавить сисадмина</a></nav>
    <table>
        <thead><tr><th>Логин</th><th>Статус</th></tr></thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user->Login ?></td>
                <td><?= $user->IsBlocked ? 'Заблокирован' : 'Активен' ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>