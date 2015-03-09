ALTER TABLE `enrollment` 
ADD COLUMN `id` INT NOT NULL AUTO_INCREMENT AFTER `classroom`,
DROP PRIMARY KEY,
ADD PRIMARY KEY (`id`);
ALTER TABLE `enrollment` 
CHANGE COLUMN `id` `id` INT(11) NOT NULL AUTO_INCREMENT FIRST;

ALTER TABLE `term` 
DROP FOREIGN KEY `fk_term_student`;
ALTER TABLE `term` 
CHANGE COLUMN `student` `enrollment` INT(11) NOT NULL ;
ALTER TABLE `term` 
ADD CONSTRAINT `fk_term_student`
  FOREIGN KEY (`enrollment`)
  REFERENCES `student` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `term` 
DROP FOREIGN KEY `fk_term_student`;

ALTER TABLE `hbdb`.`term` 
CHANGE COLUMN `enrollment` `enrollment` INT(11) NULL ;

ALTER TABLE `term` 
ADD INDEX `fk_term_enrollment_idx` (`enrollment` ASC);
ALTER TABLE `term` 
ADD CONSTRAINT `fk_term_enrollment`
  FOREIGN KEY (`enrollment`)
  REFERENCES `enrollment` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
ALTER TABLE `term` 
DROP FOREIGN KEY `fk_term_enrollment`;
ALTER TABLE `term` 
CHANGE COLUMN `enrollment` `enrollment` INT(11) NOT NULL ;
ALTER TABLE `term` 
ADD CONSTRAINT `fk_term_enrollment`
  FOREIGN KEY (`enrollment`)
  REFERENCES `enrollment` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
