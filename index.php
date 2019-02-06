<?php

    require_once('data.php');

    require_once('functions.php');

    $content = include_template('index.php',[
        'category' => $category,
        'tasks' => $tasks,
        'show_complete_tasks' => $show_complete_tasks
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
