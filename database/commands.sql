CREATE TABLE `seraj`.`tutorials` ( `id` INT NOT NULL AUTO_INCREMENT , `title` VARCHAR(500) NOT NULL , `pic` VARCHAR(500) NULL , `path` VARCHAR(500) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE `medal` (
  `id` int(11) NOT NULL,
  `name` varchar(400) NOT NULL,
  `pic` varchar(400) NOT NULL,
  `8` int(3) NOT NULL,
  `9` int(3) NOT NULL,
  `10` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `medal`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `medal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
