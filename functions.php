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
    };

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
    function get_username_from_db($connect, $user_id) {
        $sql = "SELECT username FROM users WHERE id =  '" . mysqli_real_escape_string($connect, $user_id) . "';";
        $result = db_fetch_data($connect, $sql)[0]['username'];
        return $result;
    };

    // Получаем из БД список всех проектов
    function get_projects($connect) {
        $sql = "SELECT projects.title, projects.id FROM projects JOIN users ON users.id = projects.user_id ORDER BY projects.id DESC";
        $result = db_fetch_data($connect, $sql);
        return $result;
    };

    // Получаем из БД список проектов для текущего пользователя
    function get_projects_current_user($connect, $user_id) {
        $sql = "SELECT DISTINCT projects.id AS id, projects.title AS title FROM projects JOIN tasks ON projects.id = tasks.project_id WHERE tasks.user_id = '" . mysqli_real_escape_string($connect, $user_id) . "' ORDER BY projects.title ASC";
        $result = db_fetch_data($connect, $sql);
        return $result;
    };

    // Получаем из БД список задач для текущего пользователя
    function get_tasks_current_user($connect, $user_id) {
        $sql =
            "SELECT
                tasks.id AS id,
                tasks.title AS task,
                tasks.date_execution AS day_of_complete,
                projects.title AS category,
                projects.id AS category_id,
                tasks.status AS completed,
                tasks.file AS file
            FROM
                tasks
            JOIN
                projects
            ON
                tasks.project_id = projects.id
            WHERE
                tasks.user_id = '" . mysqli_real_escape_string($connect, $user_id) . "' ORDER BY
                date_create
            ASC";
        $result = db_fetch_data($connect, $sql);
        return $result;
    };

    // Проверка на существование параметра с идентификатором проекта
    function check_param_project($cat, $category) {
        if (isset($cat)) {
            if (in_array((int)$cat, array_column($category, 'id'))) {
                return (int)$cat;
            } else {
                header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
                exit;
            }
        }
    };

    // Отсеять задачи, оставить только для выбранного проекта, если проект не выбран, то вернёт все задачи
    function select_task_from_project($tasks, $cat_id) {
        $result = [];
        if (isset($cat_id)){
            foreach ($tasks as $task_value) {
                if ($task_value['category_id'] === (string)$cat_id) {
                    $result[] = $task_value;
                };
            };
        } else {
            $result = $tasks;
        };
        return $result;
    };

    // Проверка даты
    function validateDate($date, $format = 'd.m.Y') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    };

    // Проверка валидации формы добавления задачи
    function validate_form_add($task, $categories) {
        $errors = [];
        if (empty($task['name'])) {
            $errors['name'] = 'Это поле надо заполнить';
        };

        if (!empty($task['project'])) {
            if (!in_array((int)$task['project'], array_column($categories, 'id'))) {
                $errors['project'] = 'Проект не найден, выберите другой проект из списка';
            };
        } else {
            $errors['project'] = 'Проект не выбран, выберите проект из списка';
        };

        if (!empty($task['date'])) {
            if (!validateDate($task['date'])) {
                $errors['date'] = 'Неверная дата';
            };
            if (strtotime($task['date']) < strtotime('midnight')) {
                $errors['date'] = 'Дата выполнения должна быть в будущем';
            };
        };

        if (!empty($_FILES['preview']['name'])) {
            if (!$_FILES['preview']['error']) {
                if (!$_FILES['preview']['size']) {
                    $errors['preview'] = 'Выбран пустой файл';
                };
            } else {
                $errors['preview'] = 'Ошибка загрузки файла: ' . $_FILES['preview']['error'];
            };
        };
        return $errors;
    };

    // Добавление новой задачи в БД
    function add_task($link, $id, $task, $file) {
        $result = [];
        if ($link) {
            mysqli_set_charset($link, "utf8");
            $file_path = isset($file) ? mysqli_real_escape_string($link, $file) : NULL;
            $date = !empty($task['date']) ? mysqli_real_escape_string($link, date('Y-m-d', strtotime($task['date']))) : NULL;
            $project = isset($task['project']) ? mysqli_real_escape_string($link, $task['project']) : NULL;
            $id = isset($id) ? mysqli_real_escape_string($link, $id) : NULL;
            $name = isset($task['name']) ? mysqli_real_escape_string($link, $task['name']) : NULL;
            $sql = "INSERT INTO tasks (
                    title,
                    user_id,
                    project_id
                    " . (isset($date) ? ', date_execution' : '') . "
                    " . (!empty($file_path) ? ', file' : '') . "
                ) VALUES ('" .
                    $name . "', '" .
                    $id . "', '" .
                    $project . "'" .
                    (isset($date) ? ", '" . $date . "'" : "") . "" .
                    (!empty($file_path) ? ", '" . $file_path . "'" : "") . "
                )";
            $result = mysqli_query($link, $sql);
        } else {
            $result = 'Ошибка БД: ' . mysqli_error($link);
        };
        return $result;
    };

    // Валидация формы регистрации
    function validate_form_register($link, $register) {
        if (!empty($register['email'])) {
            if (filter_var($register['email'], FILTER_VALIDATE_EMAIL)) {
                mysqli_set_charset($link, "utf8");
                $sql = "SELECT Count(users.email) as count FROM users WHERE users.email = '" . mysqli_real_escape_string($link, $register['email']) . "';";
                if(db_fetch_data($link, $sql)[0]['count']) {
                    $errors['email'] = 'Еmail занят';
                };
            } else {
                $errors['email'] = 'Неверный email';
            };
        } else {
            $errors['email'] = 'Поле не заполненно';
        };

        if (empty($register['password'])) {
            $errors['password'] = 'Поле не заполненно';
        };

        if (empty($register['name'])) {
            $errors['name'] = 'Поле не заполненно';
        };

        return $errors;
    };

    // Добавление нового пользователя в БД
    function add_user($link, $register) {
        $result = [];
        if ($link) {
            mysqli_set_charset($link, "utf8");
            $file_path = isset($file) ? mysqli_real_escape_string($link, $file) : NULL;
            $date = !empty($task['date']) ? mysqli_real_escape_string($link, date('Y-m-d', strtotime($task['date']))) : NULL;
            $project = isset($task['project']) ? mysqli_real_escape_string($link, $register['name']) : NULL;
            $id = isset($id) ? mysqli_real_escape_string($link, $id) : NULL;
            $name = isset($task['name']) ? mysqli_real_escape_string($link, $task['name']) : NULL;
            $sql = "INSERT INTO users (
                    email,
                    username,
                    password
                ) VALUES('" .
                    mysqli_real_escape_string($link, $register['email']) . "', '" .
                    mysqli_real_escape_string($link, $register['name']) . "', '" .
                    password_hash($register['password'], PASSWORD_DEFAULT) . "');";
            $result = mysqli_query($link, $sql);
        } else {
            $result = 'Ошибка БД: ' . mysqli_error($link);
        };
        return $result;
    };

    // Валидация формы авторизации
    function validate_form_auth($link, $auth) {
        $errors = [];

        if (empty($auth['password'])) {
            $errors['password'] = 'Поле не заполненно';
        };

        if (!empty($auth['email'])) {
            if (!filter_var($auth['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Невалидный email';
            };
        } else {
            $errors['email'] = 'Поле не заполненно';
        };

        if (empty($errors)) {
            if ($link) {
                mysqli_set_charset($link, "utf8");
                $sql = "SELECT id, password FROM users WHERE email = '" . mysqli_real_escape_string($link, $auth['email']) . "';";
                $res = db_fetch_data($link, $sql);
                if (!empty($res[0])) {
                    if (!password_verify($auth['password'], $res[0]['password'])) {
                        $errors['invalid'] = true;
                    };
                };
            } else {
                $errors['invalid'] = true;
            };
        };

        if (empty($errors)) {
            $result['id'] = $res[0]['id'];
        } else {
            $result['errors'] = $errors;
        };

        return $result;
    };

    function validate_form_project($project, $categories) {
        $errors = [];

        if (empty($project['name'])) {
            $errors['name'] = 'Поле не заполненно';
        } else {
            if (in_array($project['name'], array_column($categories, 'title'))) {
                $errors['name'] = 'Такой проект уже есть';
            };
        };

        return $errors;
    };

    function add_project($link, $user_id, $project) {
        $result = [];
        if ($link) {
            mysqli_set_charset($link, "utf8");
            $sql = "INSERT INTO projects (
                    user_id,
                    title
                ) VALUES('" .
                    mysqli_real_escape_string($link, $user_id) . "', '" .
                    mysqli_real_escape_string($link, $project['name']) . "');";
            $result = mysqli_query($link, $sql);
        } else {
            $result = 'Ошибка БД: ' . mysqli_error($link);
        };
        return $result;
    };

    function checked_task($link, $task_id, $status) {
        $result = [];
        if ($link) {
            mysqli_set_charset($link, "utf8");
            $sql = "UPDATE tasks SET status = '" . mysqli_real_escape_string($link, $status) . "' WHERE id = '" . mysqli_real_escape_string($link, $task_id) . "';";
            $result = mysqli_query($link, $sql);
        } else {
            $result = 'Ошибка БД: ' . mysqli_error($link);
        };
        return $result;
    };

    // Проверяем, подходит ли задача под условие фильтра, в случае успеха вернёт true
    function filtering_task($filter, $day_of_complete) {
        // $midnight = date('Y-m-d H:i:s', strtotime('midnight'));
        // $now = date('Y-m-d H:i:s', strtotime('now'));
        // $tomorrow = date('Y-m-d H:i:s', strtotime('tomorrow midnight'));
        // $after_tomorrow = date('Y-m-d H:i:s', strtotime('2 day midnight'));
        // $after_three_days = date('Y-m-d H:i:s', strtotime('3 day midnight'));
        if ($filter === 'all') {
            return true;
        } elseif (!empty($day_of_complete)) {
            switch ($filter) {
                case 'today':
                        if ((
                            strtotime('midnight') <= strtotime($day_of_complete)
                            ) && (
                            strtotime('tomorrow midnight') > strtotime($day_of_complete)
                            )) {
                            return true;
                        };
                        break;
                    case 'tomorrow':
                        if ((
                            strtotime('tomorrow midnight') <= strtotime($day_of_complete)
                            ) && (
                            strtotime('2 day midnight') > strtotime($day_of_complete)
                            )) {
                            return true;
                        };
                        break;
                    case 'overdue':
                        if (strtotime('now') > strtotime($day_of_complete)) {
                            return true;
                        };
                        break;
                };
        } else {
            return false;
        };
    };

    // Вернёт результат поиска
    function search_query($connect, $user_id, $search) {
        if (!empty(trim($search))) {
            $sql =
                "SELECT
                    tasks.id AS id,
                    tasks.title AS task,
                    tasks.date_execution AS day_of_complete,
                    projects.title AS category,
                    projects.id AS category_id,
                    tasks.status AS completed,
                    tasks.file AS file
                FROM
                    tasks
                JOIN
                    projects
                ON
                    tasks.project_id = projects.id
                WHERE
                    tasks.user_id = '" . mysqli_real_escape_string($connect, $user_id) . "'
                AND
                    MATCH(tasks.title) AGAINST('" . mysqli_real_escape_string($connect, $search) . "')
                ORDER BY
                    date_create
                ASC";
            return db_fetch_data($connect, $sql);
        };
    return false;
    };

    function get_id_users_overdue_tasks ($link) {
        $sql =
        "SELECT DISTINCT
            users.id AS id
        FROM
            users
        JOIN
            tasks
        ON
            tasks.user_id = users.id
        WHERE
            tasks.date_execution < CURRENT_TIMESTAMP
        AND
            tasks.status = 0";
        $result = db_fetch_data($link, $sql);
        return $result;
    };

    // Возвращает все просроченные задания
    function get_overdue_tasks($link) {
        $sql =
            "SELECT
                users.id AS id,
                users.email AS email,
                users.username AS username,
                tasks.title AS title,
                tasks.date_execution AS date_execution
            FROM
                users
            JOIN
                tasks
            ON
                tasks.user_id = users.id
            WHERE
                tasks.date_execution < CURRENT_TIMESTAMP
            AND
                tasks.status = 0";
        $result = db_fetch_data($link, $sql);
        return $result;
    };
?>
