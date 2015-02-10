ALTER TABLE `consultation` 
	DROP INDEX `fk_consulta_aluno1_idx` ;
ALTER TABLE `consultation` 
	DROP FOREIGN KEY `fk_consultation_student`;
ALTER TABLE `consultation` 
	DROP COLUMN `student`;

ALTER TABLE `consultation` 
	ADD COLUMN `term` INT(11) NULL AFTER `delivered`;
ALTER TABLE `consultation` 
	ADD INDEX `fk_consultation_term1_idx` (`term` ASC);
ALTER TABLE `consultation` 
	ADD CONSTRAINT `fk_consultation_term`
	  FOREIGN KEY (`term`)
	  REFERENCES `term` (`id`)
	  ON DELETE NO ACTION
	  ON UPDATE NO ACTION;
