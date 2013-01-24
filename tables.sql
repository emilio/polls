CREATE TABLE IF NOT EXISTS `polls` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL,
  `various_answers` tinyint(1) NOT NULL DEFAULT '0',
  `total_votes` bigint(20) NOT NULL DEFAULT '0',
  `slug` varchar(200) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `polls_answers` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `text` varchar(200) NOT NULL,
  `votes` bigint(20) NOT NULL DEFAULT '0',
  `poll_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY `poll_id` REFERENCES `polls`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `polls_ip` (
  `voter_ip` varchar(15) NOT NULL,
  `poll_id` bigint(20) NOT NULL,
  `answer_id` bigint(20) NOT NULL DEFAULT '0',
  KEY `voter_ip` (`voter_ip`),
  FOREIGN KEY `poll_id` REFERENCES `polls`(`id`) ON DELETE CASCADE,
  FOREIGN KEY `answer_id` REFERENCES `answers`(`id`) ON DELETE CASCADE

  KEY `answer_id` (`answer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;