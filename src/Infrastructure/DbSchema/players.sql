CREATE TABLE `players` (
  `id` char(36) NOT NULL,
  `game_id` char(36) NOT NULL,
  `play_pile` text NOT NULL,
  `winning_pile_count` int unsigned NOT NULL,
  `tie_breaker_pile` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
);
