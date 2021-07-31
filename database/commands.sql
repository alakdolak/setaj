ALTER TABLE `config` ADD `show_project` BOOLEAN NOT NULL DEFAULT TRUE AFTER `project_limit_1`, ADD `show_product` BOOLEAN NOT NULL DEFAULT TRUE AFTER `show_project`, ADD `show_service` BOOLEAN NOT NULL DEFAULT TRUE AFTER `show_product`, ADD `show_citizen` BOOLEAN NOT NULL DEFAULT TRUE AFTER `show_service`, ADD `show_shop` BOOLEAN NULL DEFAULT TRUE AFTER `show_citizen`, ADD `show_free` BOOLEAN NOT NULL DEFAULT TRUE AFTER `show_shop`, ADD `min_star` INT(3) NOT NULL AFTER `show_free`, ADD `min_money` INT(4) NOT NULL AFTER `min_star`, ADD `min_health` INT(3) NOT NULL AFTER `min_money`, ADD `min_think` INT(3) NOT NULL AFTER `min_health`;
ALTER TABLE `config` ADD `min_behavior` INT(3) NOT NULL AFTER `min_think`;
ALTER TABLE `project` ADD `extra` BOOLEAN NOT NULL DEFAULT FALSE AFTER `updated_at`;
ALTER TABLE `config` CHANGE `show_free` `show_extra` TINYINT(1) NOT NULL DEFAULT '1';
ALTER TABLE `config` ADD `extra_limit` INT NOT NULL DEFAULT '3' AFTER `min_behavior`;
ALTER TABLE `product` ADD `extra` BOOLEAN NOT NULL DEFAULT FALSE AFTER `start_time_buy`;
ALTER TABLE `config` ADD `show_sell_extra` BOOLEAN NOT NULL DEFAULT FALSE AFTER `extra_limit`;
ALTER TABLE `grade` ADD `priority` INT(2) NOT NULL AFTER `name`;
UPDATE `grade` SET `priority` = '1' WHERE `grade`.`id` = 9;
UPDATE `grade` SET `priority` = '2' WHERE `grade`.`id` = 4;
UPDATE `grade` SET `priority` = '3' WHERE `grade`.`id` = 5;
UPDATE `grade` SET `priority` = '4' WHERE `grade`.`id` = 6;
UPDATE `grade` SET `priority` = '5' WHERE `grade`.`id` = 7;
UPDATE `grade` SET `priority` = '6' WHERE `grade`.`id` = 8;
UPDATE `grade` SET `priority` = '7' WHERE `grade`.`id` = 3;

