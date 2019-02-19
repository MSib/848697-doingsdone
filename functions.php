<?php
    function include_template($name, $data) {
        $name = 'templates/' . $name;
        $result = '';

        if (!is_readable($name)) {
            return $result;
        }

        ob_start();
        extract($data);
        require $name;

        $result = ob_get_clean();

        return $result;
    }

    // Функция возвращает число задач для переданного проекта
    function count_matches_in_array ($arr, $val) {
        $result = 0;
        foreach ($arr as $key => $value) {
            if ($value['category'] === $val) {
                $result++;
            }
        }
        return $result;
    };

    // Проверка и установка временной зоны
    function set_timezone ($timezone) {
        if (date_default_timezone_get() !== $timezone) {
            date_default_timezone_set($timezone);
        }
        return date_default_timezone_get();
    };

    // Определяем дополнительные классы для задач (выполненные, и с исходящим сроком выполнения)
    function get_task_class_completed_and_important ($tasks_value, $deadline) {
        $result;
            if ((int)$tasks_value['completed'] === 1) {
                $result = $result . ' task--completed';
            }
            elseif (((strtotime($tasks_value['day_of_complete']) < strtotime('now') + $deadline) and (strtotime($tasks_value['day_of_complete']) > strtotime('now') - $deadline)) and ($tasks_value['day_of_complete'] !== NULL)) {
                $result = $result . ' task--important';
            }
        return $result;
    };

    // Выполнение запросов выборки
    function db_fetch_data($connect, $sql) {
        $result = [];
        if ($connect) {
            mysqli_set_charset($connect, "utf8");
            $query = mysqli_query($connect, $sql);
            $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
        } else {
            $result = 'Ошибка БД: ' . mysqli_error($query);
        };
        return $result;

    };

    // Получаем имя пользователя из БД
    function get_username_from_db($connect, $email) {
        $sql = "SELECT username FROM users WHERE email =  '" . htmlspecialchars($email) . "';";
        $result = db_fetch_data($connect, $sql)[0]['username'];
        return $result;
    };

    // Получаем из БД список проектов для текущего пользователя
    function get_projects_current_user($connect, $email) {
        $sql = "SELECT projects.title, projects.id FROM projects JOIN users ON users.id = projects.user_id WHERE users.email = '" . htmlspecialchars($email) . "' ORDER BY projects.title ASC";
        $result = db_fetch_data($connect, $sql);
        return $result;
    }

    // Получаем из БД список задач для текущего пользователя
    function get_tasks_current_user($connect, $email) {
        $sql = "SELECT tasks.title AS task, tasks.date_execution AS day_of_complete, projects.title AS category, tasks.status AS completed FROM users JOIN tasks ON tasks.user_id = users.id JOIN projects ON tasks.project_id = projects.id WHERE users.email = '" . htmlspecialchars($email) . "'";
        $result = db_fetch_data($connect, $sql);
        return $result;
    }

?>
