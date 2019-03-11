<?php
    require_once('data.php');
    require_once('init.php');
    require_once('functions.php');
    require_once('vendor/autoload.php');

    $users = get_id_users_overdue_tasks($connect);
    $tasks = get_overdue_tasks($connect);

    foreach($users as $users_value) {
                //print($msg_content);
                //print($users_value['email']);
            $transport = new Swift_SmtpTransport("smtp.mail.ru", 465);
            $transport->setUsername("doingsdone@msib.top");
            $transport->setPassword("Qwerty1");

            $mailer = new Swift_Mailer($transport);

            $logger = new Swift_Plugins_Loggers_ArrayLogger();
            $mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));

            $message = new Swift_Message();
            $message->setSubject("Уведомление от сервиса «Дела в порядке»");
            $message->setFrom(['doingsdone@msib.top' => '«Дела в порядке»']);
            $message->setBcc($tasks['email'], $tasks['username']);

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
            }
    };



?>
