CREATE TABLE `seats` (
  `id` char(36) NOT NULL,
  `table_id` char(36) NOT NULL,
  `player_id` char(36) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
);
