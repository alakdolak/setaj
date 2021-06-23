UPDATE `project` set physical = 0 WHERE title LIKE "%دوبله%";
UPDATE `project` set physical = 0 WHERE title LIKE "%کمدی%";
UPDATE `project` set physical = 0 WHERE title LIKE "%گویندگی%";
UPDATE `project` set physical = 0 WHERE title LIKE "%آشپز%";
UPDATE `project` set physical = 0 WHERE title LIKE "%عروسکی%";
UPDATE `project` set physical = 0 WHERE title LIKE "%محلّه%"
UPDATE `product` set physical = 0 WHERE project_id in (SELECT p.id from project_buyers pb, project p WHERE p.id = pb.project_id and p.physical = 0);
ALTER TABLE `product` ADD `grade_id` INT NOT NULL AFTER `physical`, ADD INDEX (`grade_id`);
UPDATE `product` set grade_id = (SELECT u.grade_id from project_buyers pb, users u WHERE product.user_id = u.id and product.project_id = pb.project_id and pb.user_id = u.id) WHERE 1;
UPDATE product SET created_at = DATE_ADD(created_at, INTERVAL 1 YEAR) ;
UPDATE product SET created_at = DATE_SUB(created_at, INTERVAL 1 MONTH) ;
