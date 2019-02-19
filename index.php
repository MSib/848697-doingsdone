<?php

    require_once('data.php');

    require_once('functions.php');

    $category = get_projects_current_user($connect, $current_user_email);

    $tasks = get_tasks_current_user($connect, $current_user_email);

    $content = include_template('index.php',[
        'category' => $category,
        'tasks' => $tasks,
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
        //'username' => $username,
        'current_user_email' => $current_user_email
        ]);

    print($layout_content);

?>
