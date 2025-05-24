-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema blogplatform
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema blogplatform
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `blogplatform` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
USE `blogplatform` ;

-- -----------------------------------------------------
-- Table `blogplatform`.`roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blogplatform`.`roles` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `blogplatform`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blogplatform`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `role_id` INT NOT NULL,
  `firstname` VARCHAR(50) NOT NULL,
  `lastname` VARCHAR(50) NOT NULL,
  `username` VARCHAR(50) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) VISIBLE,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE,
  INDEX `role_id_idx` (`role_id` ASC) VISIBLE,
  CONSTRAINT `role_id`
    FOREIGN KEY (`role_id`)
    REFERENCES `blogplatform`.`roles` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `blogplatform`.`posts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blogplatform`.`posts` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `first_image` VARCHAR(255) NOT NULL,
  `second_image` VARCHAR(255) NULL DEFAULT NULL,
  `first_paragraph` TEXT NOT NULL,
  `second_paragraph` TEXT NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `user_id_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `user_id`
    FOREIGN KEY (`user_id`)
    REFERENCES `blogplatform`.`users` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci
ROW_FORMAT = COMPRESSED
KEY_BLOCK_SIZE = 16;


-- -----------------------------------------------------
-- Table `blogplatform`.`comments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blogplatform`.`comments` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `post_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `comment` VARCHAR(255) NOT NULL,
  `parent_comment_id` INT NULL DEFAULT NULL,
  `commented_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `user_id_idx` (`user_id` ASC) VISIBLE,
  INDEX `post_id_idx` (`post_id` ASC) VISIBLE,
  INDEX `comments_parent_comment_id_idx` (`parent_comment_id` ASC) VISIBLE,
  CONSTRAINT `comments_parent_comment_id`
    FOREIGN KEY (`parent_comment_id`)
    REFERENCES `blogplatform`.`comments` (`id`),
  CONSTRAINT `comments_post_id`
    FOREIGN KEY (`post_id`)
    REFERENCES `blogplatform`.`posts` (`id`),
  CONSTRAINT `comments_user_id`
    FOREIGN KEY (`user_id`)
    REFERENCES `blogplatform`.`users` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `blogplatform`.`likes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blogplatform`.`likes` (
  `likes_user_id` INT NOT NULL,
  `likes_post_id` INT NOT NULL,
  `liked_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`likes_user_id`, `likes_post_id`),
  INDEX `likes_user_id_idx` (`likes_user_id` ASC) VISIBLE,
  INDEX `likes_post_id_idx` (`likes_post_id` ASC) VISIBLE,
  CONSTRAINT `likes_post_id`
    FOREIGN KEY (`likes_post_id`)
    REFERENCES `blogplatform`.`posts` (`id`),
  CONSTRAINT `likes_user_id`
    FOREIGN KEY (`likes_user_id`)
    REFERENCES `blogplatform`.`users` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `blogplatform`.`tags`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blogplatform`.`tags` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 21
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `blogplatform`.`post_tags`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blogplatform`.`post_tags` (
  `post_id` INT NOT NULL,
  `tag_id` INT NOT NULL,
  PRIMARY KEY (`post_id`, `tag_id`),
  INDEX `tag_id_idx` (`tag_id` ASC) VISIBLE,
  CONSTRAINT `post_id`
    FOREIGN KEY (`post_id`)
    REFERENCES `blogplatform`.`posts` (`id`),
  CONSTRAINT `tag_id`
    FOREIGN KEY (`tag_id`)
    REFERENCES `blogplatform`.`tags` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

INSERT INTO roles (id, name)
VALUES (1, 'Admin'), (2, 'User');

INSERT INTO users (role_id, firstname, lastname, username, email, password)
VALUES (1, 'Marlon', 'Kazazi', 'marlonk10', 'kazazim.25@gmail.com', 'Marlon10'),
(2, 'Marlon', 'Kazazi', 'loni', 'marlon.kazazi@fshnstudent.info', '12345678'),
(2, 'Marlon', 'Kazazi', 'lonzo', 'marlon.kazazi10@gmail.com', 'kazazi25');

INSERT INTO tags (name)
VALUES ("Personal"), 
	   ("Lifestyle"), 
       ("Travel"), 
       ("Food & Recipes"), 
       ("Health & Wellness"), 
       ("Fitness"), 
       ("Fashion"), 
       ("Beauty"), 
       ("DIY & Crafts"), 
       ("Parenting"),
       ("Technology"),
       ("Reviews"),
       ("Education"),
       ("Finance & Budgeting"),
       ("Business & Entrepreneurship"),
       ("Productivity"),
       ("Career"),
       ("Self-Improvement"),
       ("News & Opinions"),
       ("Relationships");*/

INSERT INTO posts (id, user_id, title, first_image, first_paragraph)
VALUES (1, 1, 'My first post!!!', '.\\public\\images\\blog5.jpg', 
'Very happy to share my first post in this new platform! More to come...'),
(2, 1, 'It\'s me, MARIO!', '.\\public\\images\\blog2.jpg', 
'This year it is the 40th anniversary and I hope they release a newer version of the game this year.'),
(3, 1, 'Lorem Ipsum', '.\\public\\images\\blog1.jpg', 
'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...');

INSERT INTO post_tags (post_id, tag_id)
VALUES (1, 3), (2, 12), (3, 11);

INSERT INTO likes (id, likes_user_id, likes_post_id)
VALUES (1, 1, 1), (2, 1, 2), (3, 1, 3), (4, 2, 1), (5, 2, 2), (6, 2, 3), (7, 3, 1), (8, 3, 2), (9, 3, 3);

INSERT INTO comments (id, post_id, user_id, comment, parent_comment_id)
VALUES (1, 1, 2, 'Nice pic. Cheers mate!', null),
	     (2, 2, 3, 'I\'ve played this game since I was 6. Best game ever :)', null),
       (3, 2, 2, 'I know, right? But I think Super Sonic is better.', 2),
       (4, 1, 1, 'Thank you', 1);
