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

    function get_task_class_completed_and_important ($tasks_value, $deadline) {
        $result;
            if ($tasks_value['completed'] === 1) {
                $result = $result.' task--completed';
            }
            elseif (((strtotime($tasks_value['day_of_complete']) < strtotime('now') + $deadline) and (strtotime($tasks_value['day_of_complete']) > strtotime('now') - $deadline)) and ($tasks_value['day_of_complete'] !== NULL)) {
                $result = $result.' task--important';
            }
        return $result;
    };

    function get_username_from_db($connect, $email) {
        if ($connect == false) {
            $result = 'Error DB';
        } else {
            $sql = "SELECT username FROM users WHERE email = '$email';";
            $req = mysqli_query($connect, $sql);
            $result = $req[0];
        };
        return $result;
    }

?>
