<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
<?php
    foreach ($tasks as $tasks_value) {
        if($user_id['id'] === $tasks_value['id']) {
            print('Уважаемый, ' . $tasks_value['username'] . '. У вас запланирована задача ' . $tasks_value['title'] . ' на ' . date('d.m.Y', strtotime($tasks_value['date_execution'])) . '<br>');
        }
    }
?>
</body>
</html>
