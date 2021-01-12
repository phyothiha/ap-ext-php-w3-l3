DROP TABLE IF EXISTS `users`, `posts`, `comments`;

CREATE TABLE IF NOT EXISTS `users`(
    `id` INT(11) PRIMARY KEY AUTO_INCREMENT, 
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `role` TINYINT(1) DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS `posts`(
    `id` INT (11) PRIMARY KEY AUTO_INCREMENT,
    `title` TEXT NOT NULL,
    `content` LONGTEXT NOT NULL,
    `image` TEXT DEFAULT NULL,
    `author_id` INT(11) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS `comments`(
    `id` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `content` LONGTEXT NOT NULL,
    `author_id` INT(11) NOT NULL,
    `post_id` INT(11) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
);