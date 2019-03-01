<?php

    require_once('data.php');

    require_once('functions.php');

    // Запрос имени пользователя
    $username = get_username_from_db($connect, $current_user_id);

    // Запрос в БД, список проектов для текущего пользователя
    $category = get_projects_current_user($connect, $current_user_id);

    // Запрос в БД, список всех проектов
    $categories = get_projects($connect);

    // Если есть параметр 'cat', то передаём в переменную, иначе ничего не записываем
    $go_to_category = check_param_project($_GET['cat'], $category);

    // Запрос в БД, список задач для текущего пользователя
    $tasks = get_tasks_current_user($connect, $current_user_id);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $register = $_POST;
        if (!empty($register)) {
            // Массив с ошибками формы
            $errors = validate_form_register($connect, $register);

            // Если ошибок нет, то выполняем запрос, и очищаем поля
            if (empty($errors)) {
                $file = $_FILES['preview'];
                if (!empty($file['name'])) {
                    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $filename = uniqid() . (!empty($extension) ? '.' : '') . $extension;
                    move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/' . $filename);
                };
                $res = add_user($connect, $register);

                // Если ошибок не возникло, переходим на главную страницу
                if ($res) {
                    unset($register);
                    header("Location: index.php");
                    exit;
                } else {
                    $error_page[] = 'Ошибка добавления задачи';
                };
            };
        };
    }


    // Начало HTML кода
    $content = (empty($error_page)) ? include_template('register.php',[
        'categories' => $categories,
        'register' => $register,
        'errors' => $errors,
        'get_date_from_post' => $get_date_from_post
        ]) : include_template('error.php',[
        'error_page' => $error_page
        ]);
    $layout_content = include_template('layout.php',[
        'content' => $content,
        'connect' => $connect,
        'category' => $category,
        'tasks' => $tasks,
        'title_page' => $title_page,
        'username' => $username,
        'current_user_id' => $current_user_id
        ]);

    print($layout_content);

?>
