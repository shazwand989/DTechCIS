-- users
CREATE TABLE IF NOT EXISTS `users` (
    `user_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_name` varchar(255) NOT NULL,
    `user_email` varchar(255) NOT NULL,
    `user_username` varchar(255) NULL,
    `user_phone` varchar(255) NULL,
    `user_address` varchar(255) NULL,
    `user_postcode` varchar(255) NULL,
    `user_city` varchar(255) NULL,
    `user_state` varchar(255) NULL,
    `user_country` varchar(255) NULL DEFAULT 'Malaysia',
    `user_password` varchar(255) NOT NULL,
    `user_role` enum('admin', 'cot_officer', 'pkt_management') NOT NULL,
    `user_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=Inactive, 1=Active',
    `user_profile_picture` varchar(255) DEFAULT 'default.png',
    `user_created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `user_updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `user_deleted_at` datetime DEFAULT NULL,
    PRIMARY KEY (`user_id`),
    UNIQUE KEY `user_email` (`user_email`),
    UNIQUE KEY `user_username` (`user_username`)
);

INSERT
    IGNORE INTO `users` (
        `user_id`,
        `user_name`,
        `user_email`,
        `user_username`,
        `user_password`,
        `user_role`
    )
VALUES
    (
        1,
        'Izwan Danial',
        'developerizwan27@gmail.com',
        'admin',
        '$2y$10$wa9qGTTKY0kGGBD.M38SYO8XbQakq3cZ5JQhLWrIwPF6w9.8lRKma',
        -- password is @Admin123
        'admin'
    );

-- FORGOT PASSWORD
CREATE TABLE IF NOT EXISTS `forgot_password` (
    `forgot_password_id` int(11) NOT NULL AUTO_INCREMENT,
    `forgot_password_user_id` int(11) NOT NULL,
    `forgot_password_token` varchar(255) NOT NULL,
    `forgot_password_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=Inactive, 1=Active',
    `forgot_password_created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `forgot_password_updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`forgot_password_id`),
    FOREIGN KEY (`forgot_password_user_id`) REFERENCES `users`(`user_id`)
);

CREATE TABLE IF NOT EXISTS `categories` (
    `category_id` int(11) NOT NULL AUTO_INCREMENT,
    `category_name` varchar(255) NOT NULL,
    `category_created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `category_updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`category_id`)
);

INSERT
    IGNORE INTO `categories` (
        `category_id`,
        `category_name`
    )
VALUES
    (1, 'Collaboration'),
    (2, 'Research and Innovation'),
    (3, 'Expert service'),
    (4, 'Teaching and Learning'),
    (5, 'Publication'),
    (6, 'Recognition'),
    (7, 'Income generation');

-- categories sub for folder for categories 
CREATE TABLE IF NOT EXISTS `categories_sub` (
    `category_sub_id` int(11) NOT NULL AUTO_INCREMENT,
    `category_sub_name` varchar(255) NOT NULL,
    `category_sub_category_id` int(11) NOT NULL,
    `category_sub_created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `category_sub_updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`category_sub_id`),
    FOREIGN KEY (`category_sub_category_id`) REFERENCES `categories`(`category_id`)
);

CREATE TABLE IF NOT EXISTS `documents` (
    `document_id` int(11) NOT NULL AUTO_INCREMENT,
    `document_title` varchar(255) NOT NULL,
    `document_description` text NOT NULL,
    `document_date` date NOT NULL,
    `document_file` varchar(255) NOT NULL,
    `document_user_id` int(11) NOT NULL,
    `document_category_sub_id` int(11) NOT NULL,
    `document_created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `document_updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`document_id`),
    FOREIGN KEY (`document_user_id`) REFERENCES `users`(`user_id`),
    FOREIGN KEY (`document_category_sub_id`) REFERENCES `categories_sub`(`category_sub_id`)
);