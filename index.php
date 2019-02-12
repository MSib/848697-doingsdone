<?php

    require_once('data.php');

    require_once('functions.php');

    $content = include_template('index.php',[
        'category' => $category,
        'tasks' => $tasks,
        'show_complete_tasks' => $show_complete_tasks,
        'deadline' => $deadline,
        'format_date' => $format_date,
        'my_timezone' => $my_timezone
        ]);

    $layout_content = include_template('layout.php',[
        'content' => $content,
        'category' => $category,
        'tasks' => $tasks,
        'title_page' => $title_page,
        'username' => $username
        ]);

    print($layout_content);

?>
