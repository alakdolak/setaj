ALTER TABLE `config` ADD `project_limit_6` INT(1) NOT NULL DEFAULT '2' AFTER `service_limit`, ADD `project_limit_5` INT(1) NOT NULL DEFAULT '2' AFTER `project_limit_6`, ADD `project_limit_4` INT(1) NOT NULL DEFAULT '2' AFTER `project_limit_5`, ADD `project_limit_3` INT(1) NOT NULL DEFAULT '2' AFTER `project_limit_4`, ADD `project_limit_2` INT(1) NOT NULL DEFAULT '2' AFTER `project_limit_3`, ADD `project_limit_1` INT(1) NOT NULL DEFAULT '2' AFTER `project_limit_2`;
ALTER TABLE `config` CHANGE `project_limit` `project_limit_7` INT(11) NOT NULL;

