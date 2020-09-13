CREATE TABLE `tables` (
  `id` char(36) NOT NULL,
  `code` char(4) NOT NULL,
  `is_open` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
);
