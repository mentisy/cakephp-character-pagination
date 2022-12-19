CREATE TABLE `movies`
(
    `id`      INT          NULL,
    `title` VARCHAR(255) NULL DEFAULT NULL,
    `link` VARCHAR(255) NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `users`
(
    `id`      INT          NULL,
    `name` VARCHAR(255) NULL DEFAULT NULL,
    `email` VARCHAR(255) NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
);
