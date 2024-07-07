-- users
CREATE TABLE IF NOT EXISTS `users` (
    `user_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_name` varchar(255) NOT NULL,
    `user_email` varchar(255) NOT NULL,
    `user_password` varchar(255) NOT NULL,
    `user_role` enum('admin', 'staff') NOT NULL DEFAULT 'staff',
    `user_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=Inactive, 1=Active',
    `user_created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `user_updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`user_id`)
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