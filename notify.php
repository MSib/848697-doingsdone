<?php
    require_once('data.php');
    require_once('init.php');
    require_once('functions.php');
    require_once('vendor/autoload.php');

    $users = get_id_users_overdue_tasks($connect);
    $tasks = get_overdue_tasks($connect);

    foreach($users as $users_value) {
        $transport = new Swift_SmtpTransport("phpdemo.ru", 25);
        $transport->setUsername("keks@phpdemo.ru");
        $transport->setPassword("htmlacademy");

        $mailer = new Swift_Mailer($transport);

        $logger = new Swift_Plugins_Loggers_ArrayLogger();
        $mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));

        $message = new Swift_Message();
        $message->setSubject("Уведомление от сервиса «Дела в порядке»");
        $message->setFrom(['keks@phpdemo.ru' => '«Дела в порядке»']);
        $message->addTo($users_value['email'], $users_value['username']);

        $msg_content = include_template('notify.php',[
            'tasks' => $tasks,
            'user_id' => $users_value
            ]);
        $message->setBody($msg_content, 'text/html');
        $result = $mailer->send($message);

        if ($result) {
            print("Рассылка успешно отправлена");
        }
        else {
            print("Не удалось отправить рассылку: " . $logger->dump());
        };
    };



?>
