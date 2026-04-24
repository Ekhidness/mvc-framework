<section>
    <h2>Номера по подразделениям</h2>
    <form method="get">
        <label>Подразделение<select name="department_id">
            <option value="">Все подразделения</option>
            <?php foreach ($departments as $d): ?>
                <option value="<?= $d->DepartmentID ?>"><?= $d->DepartmentName ?></option>
            <?php endforeach; ?>
        </select></label>
        <button type="submit">Показать</button>
    </form>
    <table>
        <thead><tr><th>Номер</th><th>Помещение</th><th>Абонент</th></tr></thead>
        <tbody>
        <?php foreach ($phones as $p): ?>
            <tr>
                <td><?= $p->Number ?></td>
                <td><?= $p->room->RoomNumber ?></td>
                <td><?= $p->subscriber ? $p->subscriber->Surname . ' ' . $p->subscriber->Name : 'Свободен' ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>