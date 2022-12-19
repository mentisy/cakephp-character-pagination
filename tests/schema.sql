CREATE TABLE `movies`
(
    `id`    INT NOT NULL,
    `title` VARCHAR(255) NULL DEFAULT NULL,
    `link`  VARCHAR(255) NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `users`
(
    `id`    INT NOT NULL,
    `name`  VARCHAR(255) NULL DEFAULT NULL,
    `email` VARCHAR(255) NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
);
