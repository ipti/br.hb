ALTER TABLE `hbdb`.`address` 
CHANGE COLUMN `state` `state` VARCHAR(2) NULL ,
CHANGE COLUMN `city` `city` VARCHAR(60) NULL ,
CHANGE COLUMN `neighborhood` `neighborhood` VARCHAR(30) NULL COMMENT '6' ,
CHANGE COLUMN `street` `street` VARCHAR(100) NULL ,
CHANGE COLUMN `number` `number` VARCHAR(10) NULL ,
CHANGE COLUMN `postal_code` `postal_code` VARCHAR(8) NULL ;
