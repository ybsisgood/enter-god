CREATE TABLE `maintenance` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `status` TINYINT(1) NOT NULL DEFAULT '0',
  `message` TEXT,
  PRIMARY KEY (`id`)
);