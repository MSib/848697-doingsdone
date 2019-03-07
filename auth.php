<?php

    require_once('data.php');

    require_once('functions.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $auth = $_POST;
        if (!empty($auth)) {
            // Массив с ошибками формы
            $result = validate_form_auth($connect, $auth);

            // Если ошибок нет, то выполняем запрос, и очищаем поля
            if (empty($result['errors'])) {
                $res = authorization($connect, $auth, $result['id']);

                // Если ошибок не возникло, переходим на главную страницу
                if ($res) {
                    unset($auth);
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
    $content = (empty($error_page)) ? include_template('auth.php',[
        'auth' => $auth,
        'errors' => $result['errors']
        ]) : include_template('error.php',[
        'error_page' => $error_page
        ]);
    $layout_content = include_template('layout.php',[
        'content' => $content,
        'connect' => $connect,
        'title_page' => $title_page
        ]);

    print($layout_content);
?>
