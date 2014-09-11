ALTER TABLE `hbdb`.`school` 
DROP FOREIGN KEY `fk_school_person_external`;
ALTER TABLE `hbdb`.`school` 
CHANGE COLUMN `principal` `principal` INT(11) NULL ;
ALTER TABLE `hbdb`.`school` 
ADD CONSTRAINT `fk_school_person_external`
  FOREIGN KEY (`principal`)
  REFERENCES `hbdb`.`person_external` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;