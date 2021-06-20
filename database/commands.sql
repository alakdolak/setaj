ALTER TABLE `project_buyers` ADD `adv_status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `adv`, ADD `file_status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `adv_status`;
