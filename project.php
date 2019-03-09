<?php

    require_once('data.php');

    require_once('init.php');

    require_once('functions.php');

    if (!isset($_SESSION['id'])) {
        header("Location: /index.php");
        exit;
    }

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
        $project = $_POST;
        if (!empty($project)) {
            // Массив с ошибками формы
            $errors = validate_form_project($project, $categories);
            // Если ошибок нет, то выполняем запрос, и очищаем поля
            if (empty($errors)) {
                $res = add_project($connect, $current_user_id, $project);

                // Если ошибок не возникло, переходим на главную страницу
                if ($res) {
                    unset($project);
                    header("Location: index.php");
                    exit;
                } else {
                    $error_page[] = 'Ошибка выполнения запроса добавления задачи';
                };
            } elseif(empty($username)) {
                $error_page[] = 'Ошибка добавления задачи. Пользователь не найден.';
            };
        };
    }


    // Начало HTML кода
    $content = (empty($error_page)) ? include_template('form-project.php',[
        'categories' => $categories,
        'project' => $project,
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
