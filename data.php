<?php
    //Данные для подключения к БД
    $connect = mysqli_connect('localhost','root', '','doingsdone');

    // показывать или нет выполненные задачи
    $show_complete_tasks = rand(0, 1);

    //Информация о текущем пользователе
    $current_user_id = '1';


    // Название страницы
    $title_page = 'Дела в порядке';

    // Имя пользователя
    $username = 'Константин';

    // Времени до крайнего срока, по заданию 24 часа (86400 секунд)
    $deadline = 86400;

    // Формат Даты
    $format_date = 'd.m.Y';

    // Мой часовой пояс
    $my_timezone = 'Asia/Yekaterinburg';
?>
