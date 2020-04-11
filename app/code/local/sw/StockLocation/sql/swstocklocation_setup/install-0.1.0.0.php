<?php


die('Sw StockLocation module setup');


$installer = $this;
$installer->startSetup();


$sql = "

CREATE TABLE `sw_sl_block` (
	`id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `sw_sl_box` (
	`id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `sw_sl_location` (
	`id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `sw_sl_section` (
	`id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `sw_sl_shelf` (
	`id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `sw_sl_zone` (
	`id` int(11) NOT NULL,
	`name` varchar(20) NOT NULL,
	`coordinates` varchar(20) NOT NULL,
	`dimensions` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `sw_sl_block`		ADD PRIMARY KEY (`id`);

ALTER TABLE `sw_sl_box`			ADD PRIMARY KEY (`id`);

ALTER TABLE `sw_sl_location`	ADD PRIMARY KEY (`id`);

ALTER TABLE `sw_sl_section`		ADD PRIMARY KEY (`id`);

ALTER TABLE `sw_sl_shelf`		ADD PRIMARY KEY (`id`);

ALTER TABLE `sw_sl_zone`		ADD PRIMARY KEY (`id`);

ALTER TABLE `sw_sl_zone` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

COMMIT;

";



$installer->run($sql);

$installer->endSetup();
$installer->installEntities();


/*




ALTER TABLE `sw_sl_shelf` ADD `length` INT(10) NOT NULL AFTER `name`;
ALTER TABLE `sw_sl_shelf` ADD `width` INT(10) NOT NULL AFTER `length`;
ALTER TABLE `sw_sl_shelf` ADD `height` INT(10) NOT NULL AFTER `width`;

ALTER TABLE `sw_sl_shelf` ADD `sp_x` INT(10) NOT NULL AFTER `height`;
ALTER TABLE `sw_sl_shelf` ADD `sp_y` INT(10) NOT NULL AFTER `sp_x`;
ALTER TABLE `sw_sl_shelf` ADD `sp_z` INT(10) NOT NULL AFTER `sp_y`;



ALTER TABLE `sw_sl_box` ADD `length` INT(10) NOT NULL AFTER `name`;
ALTER TABLE `sw_sl_box` ADD `width` INT(10) NOT NULL AFTER `length`;
ALTER TABLE `sw_sl_box` ADD `height` INT(10) NOT NULL AFTER `width`;

ALTER TABLE `sw_sl_box` ADD `sp_x` INT(10) NOT NULL AFTER `height`;
ALTER TABLE `sw_sl_box` ADD `sp_y` INT(10) NOT NULL AFTER `sp_x`;
ALTER TABLE `sw_sl_box` ADD `sp_z` INT(10) NOT NULL AFTER `sp_y`;



ALTER TABLE `sw_sl_section` ADD `length` INT(10) NOT NULL AFTER `name`;
ALTER TABLE `sw_sl_section` ADD `width` INT(10) NOT NULL AFTER `length`;
ALTER TABLE `sw_sl_section` ADD `height` INT(10) NOT NULL AFTER `width`;




*/