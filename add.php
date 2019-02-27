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

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $task = $_POST;
        if (!empty($task)) {
            // Массив с ошибками формы
            $errors = validate_form_add($task, $categories);

            // Если ошибок нет, то выполняем запрос, и очищаем поля
            if (empty($errors)) {
                //var_dump($_FILES);
                /*
                print(
                    $_FILES['preview']['name'] . '     ' .
                    $_FILES['preview']['type'] . '     ' .
                    $_FILES['preview']['tmp_name'] . '     ' .
                    $_FILES['preview']['error'] . '     ' .
                    $_FILES['preview']['size'] . '     ');*/
                $fi = finfo_open(FILEINFO_MIME_TYPE);
                $fn = $_FILES['preview']['tmp_name'];
                $ft = finfo_file($fi, $fn);
                var_dump($ft . '     ' . $_FILES['preview']['type']);
                // тут будет запрос в БД
                unset($task);
                //header("Location: index.php?task=add");
            };
        };
    }


    // Начало HTML кода
    $content = include_template('form-task.php',[
        'categories' => $categories,
        'task' => $task,
        'errors' => $errors,
        'get_date_from_post' => $get_date_from_post,
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
