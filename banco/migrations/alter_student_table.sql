-- Adicionando as colunas da nova ficha de cadastrado do aluno
ALTER TABLE `student`
ADD `responsible_1_name` VARCHAR(255) NULL;

ALTER TABLE `student`
ADD `responsible_1_telephone` VARCHAR(14) NULL;

ALTER TABLE `student`
ADD `responsible_1_kinship` INT(11) NULL;

ALTER TABLE `student`
ADD `responsible_1_email` INT(11) NULL;

ALTER TABLE `student`
ADD `responsible_2_name` VARCHAR(255) NULL;

ALTER TABLE `student`
ADD `responsible_2_telephone` VARCHAR(14) NULL;

ALTER TABLE `student`
ADD `responsible_2_kinship` INT(11) NULL;

ALTER TABLE `student`
ADD `responsible_2_email` INT(11) NULL;

-- Se o estudante tem alergia
ALTER TABLE `student`
ADD `allergy` INT(11) DEFAULT 0 NULL;

ALTER TABLE `student`
ADD `allergy_text` VARCHAR(255) NULL;

-- Se o estudante tem anemia
ALTER TABLE `student`
ADD `anemia` INT(11) DEFAULT 0 NULL;

ALTER TABLE `student`
ADD `anemia_text` VARCHAR(255) NOT NULL;

-- Atualizar valores das colunas responsible_1_name e responsible_2_name
UPDATE `student`
SET `responsible_1_name` = `mother`,
    `responsible_2_name` = `father`;

-- Removendo as colunas antigas de nome da mãe e do pai
ALTER TABLE `student`
DROP COLUMN `mother`;

ALTER TABLE `student`
DROP COLUMN `father`;