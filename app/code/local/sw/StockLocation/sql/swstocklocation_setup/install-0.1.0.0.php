<?php


die('Sw StockLocation module setup');


$installer = $this;
$installer->startSetup();


$sql = "

--
-- Table structure for table `sw_sl_block`
--

CREATE TABLE `sw_sl_block` (
  `id` int(11) NOT NULL,
  `id_zone` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `length` int(10) NOT NULL,
  `width` int(10) NOT NULL,
  `height` int(10) NOT NULL,
  `sp_x` int(10) NOT NULL,
  `sp_y` int(10) NOT NULL,
  `sp_z` int(10) NOT NULL,
  `coordinates` varchar(20) NOT NULL,
  `dimensions` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sw_sl_box`
--

CREATE TABLE `sw_sl_box` (
  `id` int(11) NOT NULL,
  `id_typebox` int(11) NOT NULL,
  `id_shelf` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `length` int(10) NOT NULL,
  `width` int(10) NOT NULL,
  `height` int(10) NOT NULL,
  `sp_x` int(10) NOT NULL,
  `sp_y` int(10) NOT NULL,
  `sp_z` int(10) NOT NULL,
  `coordinates` varchar(20) NOT NULL,
  `dimensions` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sw_sl_location`
--

CREATE TABLE `sw_sl_location` (
  `id` int(11) NOT NULL,
  `id_zone` int(11) DEFAULT NULL,
  `id_block` int(11) DEFAULT NULL,
  `id_shelf` int(11) DEFAULT NULL,
  `id_box` int(11) DEFAULT NULL,
  `id_section` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sw_sl_location_product`
--

CREATE TABLE `sw_sl_location_product` (
  `id_location` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `priority` int(3) NOT NULL,
  `qty` int(5) NOT NULL,
  `qty_estimated` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sw_sl_section`
--

CREATE TABLE `sw_sl_section` (
  `id` int(11) NOT NULL,
  `id_box` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `length` int(10) NOT NULL,
  `width` int(10) NOT NULL,
  `height` int(10) NOT NULL,
  `dimensions` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sw_sl_shelf`
--

CREATE TABLE `sw_sl_shelf` (
  `id` int(11) NOT NULL,
  `id_block` int(11) NOT NULL,
  `name` varchar(11) NOT NULL,
  `length` int(10) NOT NULL,
  `width` int(10) NOT NULL,
  `height` int(10) NOT NULL,
  `sp_x` int(10) NOT NULL,
  `sp_y` int(10) NOT NULL,
  `sp_z` int(10) NOT NULL,
  `coordinates` varchar(20) NOT NULL,
  `dimensions` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sw_sl_typebox`
--

CREATE TABLE `sw_sl_typebox` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sw_sl_zone`
--

CREATE TABLE `sw_sl_zone` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `length` int(10) NOT NULL,
  `width` int(10) NOT NULL,
  `height` int(10) NOT NULL,
  `sp_x` int(10) NOT NULL,
  `sp_y` int(10) NOT NULL,
  `sp_z` int(10) NOT NULL,
  `coordinates` varchar(20) NOT NULL,
  `dimensions` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sw_sl_block`
--
ALTER TABLE `sw_sl_block`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `FK_sw_sl_block_sw_sl_zone` (`id_zone`);

--
-- Indexes for table `sw_sl_box`
--
ALTER TABLE `sw_sl_box`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_sw_sl_box_sw_sl_typebox` (`id_typebox`),
  ADD KEY `FK_sw_sl_box_sw_sl_shelf` (`id_shelf`);

--
-- Indexes for table `sw_sl_location`
--
ALTER TABLE `sw_sl_location`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_sw_sl_location_sw_sl_zone` (`id_zone`),
  ADD KEY `FK_sw_sl_location_sw_sl_shelf` (`id_shelf`),
  ADD KEY `FK_sw_sl_location_sw_sl_section` (`id_section`),
  ADD KEY `FK_sw_sl_location_sw_sl_box` (`id_box`),
  ADD KEY `FK_sw_sl_location_sw_sl_block` (`id_block`);

--
-- Indexes for table `sw_sl_location_product`
--
ALTER TABLE `sw_sl_location_product`
  ADD PRIMARY KEY (`id_location`,`id_product`);

--
-- Indexes for table `sw_sl_section`
--
ALTER TABLE `sw_sl_section`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_sw_sl_section_sw_sl_box` (`id_box`);

--
-- Indexes for table `sw_sl_shelf`
--
ALTER TABLE `sw_sl_shelf`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_sw_sl_shelf_sw_sl_block` (`id_block`);

--
-- Indexes for table `sw_sl_typebox`
--
ALTER TABLE `sw_sl_typebox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sw_sl_zone`
--
ALTER TABLE `sw_sl_zone`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sw_sl_block`
--
ALTER TABLE `sw_sl_block`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sw_sl_box`
--
ALTER TABLE `sw_sl_box`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sw_sl_location`
--
ALTER TABLE `sw_sl_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sw_sl_section`
--
ALTER TABLE `sw_sl_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sw_sl_shelf`
--
ALTER TABLE `sw_sl_shelf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sw_sl_typebox`
--
ALTER TABLE `sw_sl_typebox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sw_sl_zone`
--
ALTER TABLE `sw_sl_zone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sw_sl_block`
--
ALTER TABLE `sw_sl_block`
  ADD CONSTRAINT `FK_sw_sl_block_sw_sl_zone` FOREIGN KEY (`id_zone`) REFERENCES `sw_sl_zone` (`id`);

--
-- Constraints for table `sw_sl_box`
--
ALTER TABLE `sw_sl_box`
  ADD CONSTRAINT `FK_sw_sl_box_sw_sl_shelf` FOREIGN KEY (`id_shelf`) REFERENCES `sw_sl_shelf` (`id`),
  ADD CONSTRAINT `FK_sw_sl_box_sw_sl_typebox` FOREIGN KEY (`id_typebox`) REFERENCES `sw_sl_typebox` (`id`);

--
-- Constraints for table `sw_sl_location`
--
ALTER TABLE `sw_sl_location`
  ADD CONSTRAINT `FK_sw_sl_location_sw_sl_block` FOREIGN KEY (`id_block`) REFERENCES `sw_sl_block` (`id`),
  ADD CONSTRAINT `FK_sw_sl_location_sw_sl_box` FOREIGN KEY (`id_box`) REFERENCES `sw_sl_box` (`id`),
  ADD CONSTRAINT `FK_sw_sl_location_sw_sl_section` FOREIGN KEY (`id_section`) REFERENCES `sw_sl_section` (`id`),
  ADD CONSTRAINT `FK_sw_sl_location_sw_sl_shelf` FOREIGN KEY (`id_shelf`) REFERENCES `sw_sl_shelf` (`id`),
  ADD CONSTRAINT `FK_sw_sl_location_sw_sl_zone` FOREIGN KEY (`id_zone`) REFERENCES `sw_sl_zone` (`id`);

--
-- Constraints for table `sw_sl_location_product`
--
ALTER TABLE `sw_sl_location_product`
  ADD CONSTRAINT `FK_sw_sl_location_product_sw_sl_location` FOREIGN KEY (`id_location`) REFERENCES `sw_sl_location` (`id`);

--
-- Constraints for table `sw_sl_section`
--
ALTER TABLE `sw_sl_section`
  ADD CONSTRAINT `FK_sw_sl_section_sw_sl_box` FOREIGN KEY (`id_box`) REFERENCES `sw_sl_box` (`id`);

--
-- Constraints for table `sw_sl_shelf`
--
ALTER TABLE `sw_sl_shelf`
  ADD CONSTRAINT `FK_sw_sl_shelf_sw_sl_block` FOREIGN KEY (`id_block`) REFERENCES `sw_sl_block` (`id`);
COMMIT;

";



$installer->run($sql);

$installer->endSetup();
$installer->installEntities();


