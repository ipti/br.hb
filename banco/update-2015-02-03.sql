ALTER TABLE `campaign` 
DROP FOREIGN KEY `fk_campaign_person_user`;

ALTER TABLE `campaign` 
CHANGE COLUMN `coordinator` `coordinator` INT(11) NULL ;

ALTER TABLE `campaign` 
ADD CONSTRAINT `fk_campaign_person_user`
  FOREIGN KEY (`coordinator`)
  REFERENCES `person_user` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
ALTER TABLE `campaign` 
DROP INDEX `fk_campanha_evento2_idx` ,
DROP INDEX `fk_campanha_evento1_idx` ;

ALTER TABLE `campaign` 
CHANGE COLUMN `begin` `begin` DATE NOT NULL ,
CHANGE COLUMN `end` `end` DATE NOT NULL ;
