CREATE TABLE `users` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(100) NOT NULL DEFAULT '' COMMENT '姓名',
    `email` varchar(100) NOT NULL DEFAULT '' COMMENT '邮箱',
    `phone` varchar(20) DEFAULT '' COMMENT '电话',
    `age` int(3) DEFAULT 0 COMMENT '年龄',
    `status` tinyint(1) DEFAULT 1 COMMENT '状态：1正常，0禁用',
    `create_time` datetime DEFAULT NULL COMMENT '创建时间',
    `update_time` datetime DEFAULT NULL COMMENT '更新时间',
    PRIMARY KEY (`id`),
    UNIQUE KEY `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户表';