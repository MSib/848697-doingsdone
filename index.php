<?php
    $go_to_category;
    $tasks_from_project;

    require_once('data.php');

    require_once('functions.php');

    // Запрос в БД, список проектов для текущего пользователя
    $category = get_projects_current_user($connect, $current_user_email);

    // Если есть параметр 'cat', то передаём в переменную, иначе ничего не записываем
    $go_to_category = check_param_project($_GET['cat'], $category);

    // Запрос в БД, список задач для текущего пользователя
    $tasks = get_tasks_current_user($connect, $current_user_email);

    // Если есть id категории, то применяем только задачи для этой категории
    // при неправильном значении - 404
    // при отсутсвии значения - весь список задач для текущего пользователя
    $tasks_from_project = select_task_from_project($tasks, $go_to_category);


    // Начало HTML кода
    $content = include_template('index.php',[
        'category' => $category,
        'tasks_from_project' => $tasks_from_project,
        'show_complete_tasks' => $show_complete_tasks,
        'deadline' => $deadline,
        'format_date' => $format_date,
        'my_timezone' => $my_timezone,
        'connect' => $connect
        ]);

    $layout_content = include_template('layout.php',[
        'content' => $content,
        'connect' => $connect,
        'category' => $category,
        'tasks' => $tasks,
        'title_page' => $title_page,
        'current_user_email' => $current_user_email
        ]);

    print($layout_content);

?>
