CREATE DATABASE IF NOT EXISTS `mvc_app`;

USE `mvc_app`;

-- Tabla para la información personal del usuario
CREATE TABLE `user_details` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(50) NOT NULL,
    `phone` varchar(15) NOT NULL,
    `email` varchar(100) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uniq_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Tabla para las credenciales del usuario
CREATE TABLE `user_credentials` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `username` varchar(50) NOT NULL,
    `password` varchar(255) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uniq_username` (`username`),
    FOREIGN KEY (`user_id`) REFERENCES `user_details`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Agrega la restricción UNIQUE a la columna `email`
ALTER TABLE `user_details`
    ADD CONSTRAINT `uniq_email` UNIQUE (`email`);

-- Agrega la restricción UNIQUE a la columna `username`
ALTER TABLE `user_credentials`
    ADD CONSTRAINT `uniq_username` UNIQUE (`username`);