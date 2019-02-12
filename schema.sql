CREATE DATABASE doingsdone
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE doingsdone;

CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL UNIQUE,
    user_id INT NOT NULL,
    title VARCHAR(100) NOT NULL
);

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL UNIQUE,
    user_id INT NOT NULL,
    project_id INT,
    date_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_completed TIMESTAMP,
    status INT DEFAULT 0,
    title VARCHAR(100) NOT NULL,
    file VARCHAR(255),
    date_execution TIMESTAMP
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    date_registration TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email VARCHAR(100) NOT NULL UNIQUE,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(40) NOT NULL
);

CREATE INDEX title_index ON tasks(title);
CREATE INDEX date_execution_index ON tasks(date_execution);
CREATE INDEX email_index ON users(email);
