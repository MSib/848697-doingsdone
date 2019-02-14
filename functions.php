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
?>
