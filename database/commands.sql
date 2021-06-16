CREATE TABLE `citizen_attach` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `citizen_attach`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

ALTER TABLE `citizen_attach`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `citizen_attach`
  ADD CONSTRAINT `citizenForeignInAttach` FOREIGN KEY (`project_id`) REFERENCES `citizen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE `citizen_pic` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `citizen_pic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

ALTER TABLE `citizen_pic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `citizen_pic`
  ADD CONSTRAINT `citizenForeignInPic` FOREIGN KEY (`project_id`) REFERENCES `citizen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `citizen` ADD `tag_id` INT NOT NULL AFTER `hide`, ADD INDEX (`tag_id`);

CREATE TABLE `seraj`.`citizen_grade` ( `id` INT NOT NULL AUTO_INCREMENT , `project_id` INT NOT NULL , `grade_id` INT NOT NULL , PRIMARY KEY (`id`), INDEX (`project_id`), INDEX (`grade_id`)) ENGINE = InnoDB;


ALTER TABLE `citizen_grade` ADD CONSTRAINT `citizenForeignInGrade` FOREIGN KEY (`project_id`) REFERENCES `citizen`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `citizen_grade` ADD CONSTRAINT `gradeForeignInCitizenGrade` FOREIGN KEY (`grade_id`) REFERENCES `grade`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE `citizen_buyers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `point` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `citizen_buyers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `project_unique` (`user_id`,`project_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `project_id` (`project_id`);

ALTER TABLE `citizen_buyers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `citizen_buyers`
  ADD CONSTRAINT `projectForeignInCitizenBuyer` FOREIGN KEY (`project_id`) REFERENCES `citizen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userForeignInCitizenBuyer` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `citizen_buyers` ADD `description` LONGTEXT NULL DEFAULT NULL AFTER `point`;
DROP TABLE `seraj`.`likes`;
DROP TABLE ` bookmarks `;
