SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;

START TRANSACTION;

SET time_zone = "+00:00";

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` char(36) NOT NULL COMMENT 'unique id of category',
  `is_visible` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'visibility flag, true / false',
  `parent_id` char(36) DEFAULT NULL COMMENT 'parent category id',
  `slug` varchar(48) NOT NULL COMMENT 'slug for category',
  `name` varchar(255) NOT NULL COMMENT 'name of category'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Categories';

ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`) USING BTREE,
  ADD KEY `is_visible` (`is_visible`),
  ADD KEY `parent_id` (`parent_id`);

TRUNCATE TABLE `categories`;

INSERT INTO `categories` (`id`, `is_visible`, `parent_id`, `slug`, `name`) VALUES
('bd1a168d-21e6-11e8-9754-0242c0640a02', 1, 'bd1a2281-21e6-11e8-9754-0242c0640a02', 'categoryA2-slug', 'CategoryA2 Name'),
('bd1a2281-21e6-11e8-9754-0242c0640a02', 1, NULL, 'categoryA1-slug', 'CategoryA1 Name'),
('d364a92c-21e6-11e8-9754-0242c0640a02', 0, 'bd1a168d-21e6-11e8-9754-0242c0640a02', 'categoryA3-slug', 'CategoryA3 Name'),
('d364b5df-21e6-11e8-9754-0242c0640a02', 1, 'd364a92c-21e6-11e8-9754-0242c0640a02', 'categoryA4-slug', 'CategoryA4 Name'),
('d3c57bb5-21e6-11e8-9754-0242c0640a02', 1, 'd3c56c40-21e6-11e8-9754-0242c0640a02', 'categoryB2-slug', 'CategoryB2 Name'),
('d3c57bb8-21e6-11e8-9754-0242c0640a02', 1, 'd3c57bb5-21e6-11e8-9754-0242c0640a02', 'categoryB3-1-slug', 'CategoryB3-1 Name'),
('d3c57bb9-21e6-11e8-9754-0242c0640a02', 1, 'd3c57bb8-21e6-11e8-9754-0242c0640a02', 'categoryB4-1-slug', 'CategoryB4-1 Name'),
('d3c57bb2-21e6-11e8-9754-0242c0640a02', 1, 'd3c57bb1-21e6-11e8-9754-0242c0640a02', 'categoryB4-2-slug', 'CategoryB4-2 Name'),
('d3c57bb1-21e6-11e8-9754-0242c0640a02', 0, 'd3c57bb5-21e6-11e8-9754-0242c0640a02', 'categoryB3-2-slug', 'CategoryB3-2 Name'),
('d3c56c40-21e6-11e8-9754-0242c0640a02', 1, NULL, 'categoryB1-slug', 'CategoryB1 Name');


COMMIT;