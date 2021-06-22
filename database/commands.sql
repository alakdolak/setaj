ALTER TABLE `project_buyers` CHANGE `adv_status` `adv_status` INT(1) NOT NULL DEFAULT '0';
ALTER TABLE `project_buyers` CHANGE `file_status` `file_status` INT(1) NOT NULL DEFAULT '0';
ALTER TABLE `tag` ADD `second_name` VARCHAR(400) NULL DEFAULT NULL AFTER `type`;
UPDATE `tag` SET `second_name` = 'تندرستی' WHERE `tag`.`id` = 8;
UPDATE `tag` SET `second_name` = 'تفکـــــر' WHERE `tag`.`id` = 9;
UPDATE `tag` SET `second_name` = 'کــــردار' WHERE `tag`.`id` = 10;
