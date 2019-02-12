<?php
    // показывать или нет выполненные задачи
    $show_complete_tasks = rand(0, 1);

    // создаём массив данных
    $category = ['Входящие','Учеба','Работа','Домашние дела','Авто'];

    $tasks = [
        [
            'task' => 'Собеседование в IT компании',
            'day_of_complete' => '01.12.2019',
            'category' => $category[2],
            'completed' => 0
        ],
        [
            'task' => 'Выполнить тестовое задание',
            'day_of_complete' => '25.12.2019',
            'category' => $category[2],
            'completed' => 0
        ],
        [
            'task' => 'Сделать задание первого раздела',
            'day_of_complete' => '21.12.2019',
            'category' => $category[1],
            'completed' => 1
        ],
        [
            'task' => 'Встреча с другом',
            'day_of_complete' => '22.12.2019',
            'category' => $category[0],
            'completed' => 0
        ],
        [
            'task' => 'Купить корм для кота',
            'day_of_complete' => NULL,
            'category' => $category[3],
            'completed' => 0
        ],
        [
            'task' => 'Заказать пиццу',
            'day_of_complete' => NULL,
            'category' => $category[3],
            'completed' => 0
        ]
    ];

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
