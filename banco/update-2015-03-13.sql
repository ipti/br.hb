ALTER TABLE `anatomy` 
DROP FOREIGN KEY `fk_anatomy_student`;
ALTER TABLE `anatomy` 
ADD CONSTRAINT `fk_anatomy_student`
  FOREIGN KEY (`student`)
  REFERENCES `student` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE `campaign`  DROP FOREIGN KEY `fk_campaign_person_user`;
ALTER TABLE `campaign`  ADD CONSTRAINT `fk_campaign_person_user`
  FOREIGN KEY (`coordinator`)
  REFERENCES `person_user` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;
  
ALTER TABLE `campaign_has_driver` 
DROP FOREIGN KEY `fk_campaign_has_driver_campaign`;
ALTER TABLE `campaign_has_driver` 
ADD CONSTRAINT `fk_campaign_has_driver_campaign`
  FOREIGN KEY (`campaign`)
  REFERENCES `campaign` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE `campaign_has_driver` 
DROP FOREIGN KEY `fk_campaign_has_driver_person_driver`;
ALTER TABLE `campaign_has_driver` 
ADD CONSTRAINT `fk_campaign_has_driver_person_driver`
  FOREIGN KEY (`driver`)
  REFERENCES `person_driver` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;


ALTER TABLE `campaign_has_vehicle` 
DROP FOREIGN KEY `fk_campaign_has_vehicle_campaign`;
ALTER TABLE `campaign_has_vehicle` 
ADD CONSTRAINT `fk_campaign_has_vehicle_campaign`
  FOREIGN KEY (`campaign`)
  REFERENCES `campaign` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;
  ALTER TABLE `campaign_has_vehicle` 
DROP FOREIGN KEY `fk_campaign_has_vehicle_vehicle`;
ALTER TABLE `campaign_has_vehicle` 
ADD CONSTRAINT `fk_campaign_has_vehicle_vehicle`
  FOREIGN KEY (`vehicle`)
  REFERENCES `vehicle` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE `classroom` 
DROP FOREIGN KEY `fk_classroom_school`;
ALTER TABLE `classroom` 
ADD CONSTRAINT `fk_classroom_school`
  FOREIGN KEY (`school`)
  REFERENCES `school` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;
  
ALTER TABLE `classroom_has_event` 
DROP FOREIGN KEY `fk_classroom_has_event_classroom`;
ALTER TABLE `classroom_has_event` 
ADD CONSTRAINT `fk_classroom_has_event_classroom`
  FOREIGN KEY (`classroom`)
  REFERENCES `classroom` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;
  ALTER TABLE `classroom_has_event` 
DROP FOREIGN KEY `fk_classroom_has_event_event`,
DROP FOREIGN KEY `fk_classroom_has_event_team`;
ALTER TABLE `classroom_has_event` 
ADD CONSTRAINT `fk_classroom_has_event_event`
  FOREIGN KEY (`event`)
  REFERENCES `event` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `fk_classroom_has_event_team`
  FOREIGN KEY (`team`)
  REFERENCES `team` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE `consultation` 
DROP FOREIGN KEY `fk_consultation_term`;
ALTER TABLE `consultation` 
ADD CONSTRAINT `fk_consultation_term`
  FOREIGN KEY (`term`)
  REFERENCES `term` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE `consultation` 
DROP FOREIGN KEY `fk_consultation_person_doctor`;
ALTER TABLE `consultation` 
ADD CONSTRAINT `fk_consultation_person_doctor`
  FOREIGN KEY (`doctor`)
  REFERENCES `person_doctor` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;
  
ALTER TABLE `drives` 
DROP FOREIGN KEY `fk_drives_event`;
ALTER TABLE `drives` 
ADD CONSTRAINT `fk_drives_event`
  FOREIGN KEY (`event`)
  REFERENCES `event` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;
  
ALTER TABLE `drives` 
DROP FOREIGN KEY `fk_drives_person_driver`,
DROP FOREIGN KEY `fk_drives_route`,
DROP FOREIGN KEY `fk_drives_vehicle`;
ALTER TABLE `drives` 
ADD CONSTRAINT `fk_drives_person_driver`
  FOREIGN KEY (`driver`)
  REFERENCES `person_driver` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `fk_drives_route`
  FOREIGN KEY (`start`)
  REFERENCES `route` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `fk_drives_vehicle`
  FOREIGN KEY (`vehicle`)
  REFERENCES `vehicle` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

  
ALTER TABLE `enrollment` 
DROP FOREIGN KEY `fk_enrollment_classroom`;
ALTER TABLE `enrollment` 
ADD CONSTRAINT `fk_enrollment_classroom`
  FOREIGN KEY (`classroom`)
  REFERENCES `classroom` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;
  
ALTER TABLE `enrollment` 
DROP FOREIGN KEY `fk_enrollment_student`;
ALTER TABLE `enrollment` 
ADD CONSTRAINT `fk_enrollment_student`
  FOREIGN KEY (`student`)
  REFERENCES `student` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;


ALTER TABLE `event` 
DROP FOREIGN KEY `fk_event_adress`,
DROP FOREIGN KEY `fk_event_campaign`;
ALTER TABLE `event` 
ADD CONSTRAINT `fk_event_adress`
  FOREIGN KEY (`address`)
  REFERENCES `address` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `fk_event_campaign`
  FOREIGN KEY (`campaign`)
  REFERENCES `campaign` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE `hemoglobin` 
DROP FOREIGN KEY `fk_hemoglobin_term`;
ALTER TABLE `hemoglobin` 
ADD CONSTRAINT `fk_hemoglobin_term`
  FOREIGN KEY (`agreed_term`)
  REFERENCES `term` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;
  
ALTER TABLE `kinship` 
DROP FOREIGN KEY `fk_kinship_person_external`,
DROP FOREIGN KEY `fk_kinship_student`;
ALTER TABLE `kinship` 
ADD CONSTRAINT `fk_kinship_person_external`
  FOREIGN KEY (`responsible`)
  REFERENCES `person_external` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `fk_kinship_student`
  FOREIGN KEY (`student`)
  REFERENCES `student` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;
  
ALTER TABLE `member` 
DROP FOREIGN KEY `fk_member_person`,
DROP FOREIGN KEY `fk_member_team`;
ALTER TABLE `member` 
ADD CONSTRAINT `fk_member_person`
  FOREIGN KEY (`person`)
  REFERENCES `person` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `fk_member_team`
  FOREIGN KEY (`team`)
  REFERENCES `team` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE `person` 
DROP FOREIGN KEY `fk_person_address`;
ALTER TABLE `person` 
ADD CONSTRAINT `fk_person_address`
  FOREIGN KEY (`address`)
  REFERENCES `address` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;
  
ALTER TABLE `person_doctor` 
DROP FOREIGN KEY `fk_person_doctor_person`;
ALTER TABLE `person_doctor` 
ADD CONSTRAINT `fk_person_doctor_person`
  FOREIGN KEY (`person`)
  REFERENCES `person` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE `person_driver` 
DROP FOREIGN KEY `fk_person_driver_person`;
ALTER TABLE `person_driver` 
ADD CONSTRAINT `fk_person_driver_person`
  FOREIGN KEY (`person`)
  REFERENCES `person` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;
  
ALTER TABLE `person_external` 
DROP FOREIGN KEY `fk_person_external_person`;
ALTER TABLE `person_external` 
ADD CONSTRAINT `fk_person_external_person`
  FOREIGN KEY (`person`)
  REFERENCES `person` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE `person_user` 
DROP FOREIGN KEY `fk_person_user_person`;
ALTER TABLE `person_user` 
ADD CONSTRAINT `fk_person_user_person`
  FOREIGN KEY (`person`)
  REFERENCES `person` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;
  
ALTER TABLE `prescription` 
DROP FOREIGN KEY `fk_prescription_consultation`,
DROP FOREIGN KEY `fk_prescription_stock`;
ALTER TABLE `prescription` 
ADD CONSTRAINT `fk_prescription_consultation`
  FOREIGN KEY (`consultation`)
  REFERENCES `consultation` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `fk_prescription_stock`
  FOREIGN KEY (`stock`)
  REFERENCES `stock` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE `route` 
DROP FOREIGN KEY `fk_route_address`,
DROP FOREIGN KEY `fk_route_campaign`,
DROP FOREIGN KEY `fk_route_route`,
DROP FOREIGN KEY `fk_route_team`;
ALTER TABLE `route` 
ADD CONSTRAINT `fk_route_address`
  FOREIGN KEY (`address`)
  REFERENCES `address` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `fk_route_campaign`
  FOREIGN KEY (`campaign`)
  REFERENCES `campaign` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `fk_route_route`
  FOREIGN KEY (`next`)
  REFERENCES `route` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `fk_route_team`
  FOREIGN KEY (`team`)
  REFERENCES `team` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;
  
ALTER TABLE `school` 
DROP FOREIGN KEY `fk_school_address`,
DROP FOREIGN KEY `fk_school_person_external`;
ALTER TABLE `school` 
ADD CONSTRAINT `fk_school_address`
  FOREIGN KEY (`address`)
  REFERENCES `address` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `fk_school_person_external`
  FOREIGN KEY (`principal`)
  REFERENCES `person_external` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE `school_has_event` 
DROP FOREIGN KEY `fk_school_has_event_event`;
ALTER TABLE `school_has_event` 
ADD CONSTRAINT `fk_school_has_event_event`
  FOREIGN KEY (`event`)
  REFERENCES `event` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE `stock` 
DROP FOREIGN KEY `fk_stock_campaign`,
DROP FOREIGN KEY `fk_stock_item`,
DROP FOREIGN KEY `fk_stock_person`;
ALTER TABLE `stock` 
ADD CONSTRAINT `fk_stock_campaign`
  FOREIGN KEY (`campaign`)
  REFERENCES `campaign` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `fk_stock_item`
  FOREIGN KEY (`item`)
  REFERENCES `item` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `fk_stock_person`
  FOREIGN KEY (`person`)
  REFERENCES `person` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE `student` 
DROP FOREIGN KEY `fk_student_address`;
ALTER TABLE `student` 
ADD CONSTRAINT `fk_student_address`
  FOREIGN KEY (`address`)
  REFERENCES `address` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;
  
ALTER TABLE `team` 
DROP FOREIGN KEY `fk_team_campaign`;
ALTER TABLE `team` 
ADD CONSTRAINT `fk_team_campaign`
  FOREIGN KEY (`campaign`)
  REFERENCES `campaign` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE `term`  DROP FOREIGN KEY `fk_term_enrollment`;
ALTER TABLE `term`  ADD CONSTRAINT `fk_term_enrollment`
  FOREIGN KEY (`enrollment`)
  REFERENCES `enrollment` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE `term` 
DROP FOREIGN KEY `fk_term_campaign`;
ALTER TABLE `term` 
ADD CONSTRAINT `fk_term_campaign`
  FOREIGN KEY (`campaign`)
  REFERENCES `campaign` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;


