CREATE TABLE `games` (
  `id` char(36) NOT NULL,
  `turn_index` int unsigned NOT NULL,
  `draw_pile` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
);
