-- Добавляем пользователей
INSERT INTO users SET email = 'viktor@mydomain.ru', username = 'Виктор', password = 'passVic';
INSERT INTO users SET email = 'nikolai@mydomain.ru', username = 'Николай', password = 'passNic';

-- Добавляем проекты
INSERT INTO projects SET user_id = '1', title = 'Входящие';
INSERT INTO projects SET user_id = '1', title = 'Учеба';
INSERT INTO projects SET user_id = '2', title = 'Работа';
INSERT INTO projects SET user_id = '1', title = 'Домашние дела';
INSERT INTO projects SET user_id = '2', title = 'Авто';

-- Добавляем задачи
INSERT INTO tasks SET user_id = '2', project_id = '3', title = 'Собеседование в IT компании', date_execution = '2019-12-01';
INSERT INTO tasks SET user_id = '2', project_id = '3', title = 'Выполнить тестовое задание', date_execution = '2019-12-25';
INSERT INTO tasks SET user_id = '1', project_id = '2', status = '1', title = 'Сделать задание первого раздела', date_execution = '2019-12-21';
INSERT INTO tasks SET user_id = '1', project_id = '1', title = 'Встреча с другом', date_execution = '2019-12-22';
INSERT INTO tasks SET user_id = '1', project_id = '4', title = 'Купить корм для кота';
INSERT INTO tasks SET user_id = '1', project_id = '4', title = 'Заказать пиццу';

-- Запрос списка из всех проектов для одного пользователя
SELECT p.title FROM projects p JOIN users u ON u.id = p.user_id WHERE u.username = 'Виктор';

-- Запрос списка из всех задач для одного проекта;
SELECT t.title FROM tasks t JOIN projects p ON p.id = t.project_id WHERE p.title = 'Работа';

-- Запрос пометить задачу как выполненную;
UPDATE tasks SET status = '1' WHERE title = 'Собеседование в IT компании';

-- Запрос обновить название задачи по её идентификатору.
UPDATE tasks SET title = 'Новое название задачи' WHERE id = '4';
