<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="index.php" method="post">
    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">
    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
        <a href="/index.php?filter=all" class="tasks-switch__item<?=($filter === 'all') ? ' tasks-switch__item--active' : NULL?>">Все задачи</a>
        <a href="/index.php?filter=today" class="tasks-switch__item<?=($filter === 'today') ? ' tasks-switch__item--active' : NULL?>">Повестка дня</a>
        <a href="/index.php?filter=tomorrow" class="tasks-switch__item<?=($filter === 'tomorrow') ? ' tasks-switch__item--active' : NULL?>">Завтра</a>
        <a href="/index.php?filter=overdue" class="tasks-switch__item<?=($filter === 'overdue') ? ' tasks-switch__item--active' : NULL?>">Просроченные</a>
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
                        <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="<?=$tasks_value['id'];?>"<?=$tasks_value['completed'] === '1' ? 'checked' : NULL;?>>
                        <span class="checkbox__text"><?=htmlspecialchars($tasks_value['task']);?></span>
                    </label>
                </td>
                <td class="task__file">
                    <?php if (htmlspecialchars($tasks_value['file'])):?>
                        <a class="download-link" href="/<?=htmlspecialchars($tasks_value['file'])?>"><?=htmlspecialchars($tasks_value['file'])?></a>
                    <?php endif; ?>
                </td>
                <td class="task__date"><?php if ($tasks_value['day_of_complete'] !== NULL) { echo date('d.m.Y', strtotime(strip_tags($tasks_value['day_of_complete']))); } else { echo 'Нет'; } ?>
                </td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
</table>
