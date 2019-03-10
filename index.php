<?php
    $go_to_category;
    $tasks_from_project;

    require_once('data.php');

    require_once('init.php');

    require_once('functions.php');

    if (isset($_SESSION['id'])) {
        // Выполняется после отметки пользователем задачи как выполненной.
        if (isset($_GET['task_id']) && isset($_GET['check'])) {
            checked_task($connect, $_GET['task_id'], $_GET['check']);
        };

        if (isset($_GET['show_completed'])) {
            $show_complete_tasks = ($_GET['show_completed'] === '1') ? 1: 0;
        };

        // Определяем, выбран ли фильтр
        $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

        // Запрос имени пользователя
        $username = get_username_from_db($connect, $current_user_id);

        // Запрос в БД, список проектов для текущего пользователя
        $category = get_projects_current_user($connect, $current_user_id);

        // Если есть параметр 'cat', то передаём в переменную, иначе ничего не записываем
        $go_to_category = check_param_project($_GET['cat'], $category);

        // Запрос в БД, список задач для текущего пользователя
        $tasks = get_tasks_current_user($connect, $current_user_id, $filter);

        // Если есть id категории, то применяем только задачи для этой категории
        // при неправильном значении - 404
        // при отсутсвии значения - весь список задач для текущего пользователя
        $tasks_from_project = select_task_from_project($tasks, $go_to_category);


        // Начало HTML кода
        $content = include_template('index.php',[
            'filter' => $filter,
            'category' => $category,
            'tasks_from_project' => $tasks_from_project,
            'show_complete_tasks' => $show_complete_tasks,
            'deadline' => $deadline,
            'format_date' => $format_date,
            'my_timezone' => $my_timezone,
            'connect' => $connect
            ]);
    } else {
        $content = include_template('guest.php',[]);
    };

    $layout_content = (isset($_SESSION['id'])) ? (include_template('layout.php',[
        'content' => $content,
        'connect' => $connect,
        'category' => $category,
        'tasks' => $tasks,
        'title_page' => $title_page,
        'username' => $username,
        'current_user_id' => $current_user_id
        ])) : (include_template('layout.php',[
        'content' => $content,
        'guest' => 'index'
        ]));

    print($layout_content);


?>
