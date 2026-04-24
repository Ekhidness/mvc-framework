<section>
    <h2>Управление привязкой номеров</h2>
    <form method="post">
        <input name="csrf_token" type="hidden" value="<?= app()->auth->generateCSRF() ?>"/>

        <label>Выберите номер телефона<select name="phone_id" required>
                <option value="">-- Выберите номер --</option>
                <?php foreach ($phones as $p): ?>
                    <option value="<?= $p->PhoneID ?>">
                        <?= $p->Number ?>
                        (<?= $p->room->RoomNumber ?? '-' ?>)
                        - Статус: <?= $p->subscriber ? 'Занят (' . $p->subscriber->Surname . ' ' . $p->subscriber->Name . ')' : 'Свободен' ?>
                    </option>
                <?php endforeach; ?>
            </select></label>

        <label>Действие с абонентом<select name="subscriber_id">
                <option value="">Освободить номер</option>

                <?php foreach ($subscribers as $s): ?>
                    <?php
                    $deptName = 'Не указан';
                    if ($s->phones->isNotEmpty()) {
                        $firstPhone = $s->phones->first();
                        if ($firstPhone->room && $firstPhone->room->department) {
                            $deptName = $firstPhone->room->department->DepartmentName;
                        }
                    }
                    ?>
                    <option value="<?= $s->SubscriberID ?>">
                        Привязать к: <?= $s->Surname ?> <?= $s->Name ?> (<?= $deptName ?>)
                    </option>
                <?php endforeach; ?>
            </select></label>

        <button type="submit">Применить</button>
    </form>
</section>