INSERT INTO `users`(`name`, `password`, `email`, `role`)
VALUES('admin', 'admin', 'admin@gmail.com', 1);

INSERT INTO `posts`(`title`, `content`, `image`, `author_id`)
VALUES 
    ('Post 1', 'Lorem Ipsum Text 1', null, 1),
    ('Post 2', 'Lorem Ipsum Text 2', null, 1),
    ('Post 3', 'Lorem Ipsum Text 3', null, 1),
    ('Post 4', 'Lorem Ipsum Text 4', null, 1);