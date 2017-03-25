CREATE TABLE `MyTwitter`.`Tweet` ( `id` INT NOT NULL AUTO_INCREMENT , `userId` INT NOT NULL , `text` VARCHAR(140) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL , `creationDate` DATETIME NOT NULL , PRIMARY KEY (`id`), FOREIGN KEY (`userId`) REFERENCES User(`id`)) ENGINE = InnoDB;

CREATE TABLE `MyTwitter`.`Comment` ( `id` INT NOT NULL AUTO_INCREMENT , `userId` INT NOT NULL , `postId` INT NOT NULL , `creationDate` DATETIME NOT NULL , `text` VARCHAR(60) NOT NULL , PRIMARY KEY (`id`), FOREIGN KEY (`userId`) REFERENCES User(`id`), FOREIGN KEY (`postId`) REFERENCES Tweet(`id`)) ENGINE = InnoDB;