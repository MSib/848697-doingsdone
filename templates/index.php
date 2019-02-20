<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="index.php" method="post">
    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">
    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
        <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
        <a href="/" class="tasks-switch__item">Повестка дня</a>
        <a href="/" class="tasks-switch__item">Завтра</a>
        <a href="/" class="tasks-switch__item">Просроченные</a>
    </nav>

    <label class="checkbox">
        <input class="checkbox__input visually-hidden show_completed" type="checkbox" <?php if ($show_complete_tasks === 1): ?> checked <?php endif; ?>>
        <span class="checkbox__text">Показывать выполненные</span>
    </label>
</div>

<table class="tasks">
    <?php
        set_timezone($my_timezone);
        foreach($tasks_from_project as $tasks_key => $tasks_value): ?>
        <?php if ((($show_complete_tasks === 1) and ($show_complete_tasks === (int)$tasks_value['completed'])) or ((int)$tasks_value['completed'] === 0)): ?>
        <tr class="tasks__item task <?=get_task_class_completed_and_important($tasks_value, $deadline);?>">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="1">
                        <span class="checkbox__text"><?=htmlspecialchars($tasks_value['task']);?></span>
                    </label>
                </td>

                <td class="task__file">
                    <a class="download-link" href="#">Home.psd</a>
                </td>

                <td class="task__date"><?php if ($tasks_value['day_of_complete'] !== NULL) { echo date('d.m.Y', strtotime(strip_tags($tasks_value['day_of_complete']))); } else { echo 'Нет'; } ?>
                </td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
</table>
