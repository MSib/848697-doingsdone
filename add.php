<?php

    require_once('data.php');

    require_once('functions.php');

    // Запрос в БД, список проектов для текущего пользователя
    $category = get_projects_current_user($connect, $current_user_id);

    // Запрос в БД, список всех проектов
    $categories = get_projects($connect);

    // Если есть параметр 'cat', то передаём в переменную, иначе ничего не записываем
    $go_to_category = check_param_project($_GET['cat'], $category);

    // Запрос в БД, список задач для текущего пользователя
    $tasks = get_tasks_current_user($connect, $current_user_id);


    // Начало HTML кода
    $content = include_template('form-task.php',[
        'categories' => $categories,
    ]);

    $layout_content = include_template('layout.php',[
        'content' => $content,
        'connect' => $connect,
        'category' => $category,
        'tasks' => $tasks,
        'title_page' => $title_page,
        'current_user_id' => $current_user_id
        ]);

    print($layout_content);

?>
