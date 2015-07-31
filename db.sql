CREATE SCHEMA `greenb_cms`
  DEFAULT CHARACTER SET utf8;

CREATE TABLE `greenb_cms`.`tokens` (
  `uid`            INT(10) UNSIGNED NOT NULL,
  `token`          VARCHAR(40)      NOT NULL,
  `last_access_ip` VARCHAR(64) DEFAULT NULL,
  `expired`        TIMESTAMP,
  `last_access`    DATETIME    DEFAULT NULL,
  `created`        DATETIME    DEFAULT NULL,
  KEY `idx_uid` (`uid`),
  KEY `idx_token` (`token`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE `greenb_cms`.`masterusers` (
  `id`        INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email`     VARCHAR(128)     NOT NULL,
  `password`  VARCHAR(64)      NOT NULL,
  `name`      VARCHAR(100)     NOT NULL,
  `is_active` TINYINT(1)       NOT NULL DEFAULT '1',
  `created`   DATETIME                  DEFAULT NULL,
  `modified`  DATETIME                  DEFAULT NULL,

  PRIMARY KEY (`id`),
  KEY `loginid_idx` (`email`, `password`),
  KEY `is_active_idx` (`is_active`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = utf8;

CREATE TABLE `greenb_cms`.`cashier` (
  `id`           BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `loginid`      VARCHAR(60)         NOT NULL,
  `password`     VARCHAR(64)         NOT NULL,
  `display_name` VARCHAR(250)        NOT NULL,
  `phone`        VARCHAR(50)         NOT NULL,
  `address`      VARCHAR(100)                 DEFAULT NULL,
  `email`        VARCHAR(100)                 DEFAULT NULL,
  `created`      DATETIME                     DEFAULT NULL,
  `modified`     DATETIME                     DEFAULT NULL,
  `status`       INT(11)             NOT NULL DEFAULT '1',

  PRIMARY KEY (`id`),
  KEY `loginid_key` (`loginid`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = utf8;


CREATE SCHEMA `greenb_printer`
  DEFAULT CHARACTER SET utf8;

CREATE TABLE `greenb_printer`.`image` (
  `id`           INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`         VARCHAR(50)      NOT NULL,
  `filename`     VARCHAR(128)     NOT NULL,
  `path`         VARCHAR(128)     NOT NULL,
  `mime_type`    VARCHAR(4)                DEFAULT NULL,
  `display_mode` INT(1)           NOT NULL DEFAULT 1,
  `signature`    VARCHAR(255)     NOT NULL,
  `created`      DATETIME         NULL     DEFAULT NULL,
  `modified`     DATETIME         NULL     DEFAULT NULL,

  PRIMARY KEY (`id`),
  KEY `id_idx` (`id`),
  KEY `signature_idx` (`signature`)

)
  ENGINE = InnoDB
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = utf8;

ALTER TABLE `greenb_printer`.`image`
ADD COLUMN `album_id` INT(10) NOT NULL
AFTER `id`;
ALTER TABLE `greenb_printer`.`image`
CHANGE COLUMN `name` `title` VARCHAR(50) NOT NULL;


CREATE TABLE `greenb_printer`.`album` (
  `id`                 INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `is_use_third_party` VARCHAR(20)               DEFAULT NULL,
  `thrird_party_id`    VARCHAR(50)      NOT NULL,
  `name`               VARCHAR(50)      NOT NULL,
  `description`        TEXT                      DEFAULT NULL,
  `display_mode`       INT(1)           NOT NULL DEFAULT 1,
  `created`            DATETIME         NULL     DEFAULT NULL,
  `modified`           DATETIME         NULL     DEFAULT NULL,

  PRIMARY KEY (`id`),
  KEY `id_idx` (`id`),
  KEY `thrird_party_id_idx` (`thrird_party_id`)

)
  ENGINE = InnoDB
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = utf8;

CREATE TABLE `greenb_printer`.`fruits` (
  `id`       INT(10)      NOT NULL AUTO_INCREMENT,
  `name`     VARCHAR(100) NOT NULL,
  `abbr_cd`  VARCHAR(120) NOT NULL,
  `created`  DATETIME     NULL     DEFAULT NULL,
  `modified` DATETIME     NULL     DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_idx` (`id`),
  KEY `abbr_cd_idx` (`abbr_cd`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = utf8;
