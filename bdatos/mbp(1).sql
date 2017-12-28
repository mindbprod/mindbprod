-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 28, 2017 at 02:43 AM
-- Server version: 5.5.53-0ubuntu0.14.04.1
-- PHP Version: 7.0.7-4+deb.sury.org~trusty+1

SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mbp`
--

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id_city` int(11) NOT NULL,
  `id_state` int(11) NOT NULL,
  `city_code` varchar(100) NOT NULL,
  `city_name` varchar(100) NOT NULL
) ;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id_city`, `id_state`, `city_code`, `city_name`) VALUES
(1, 1, 'GIRARDOT', 'GIRARDOT'),
(2, 2, 'BOGOTA', 'BOGOTA'),
(6, 1, 'ZIPAQUIRA', 'ZIPAQUIRÁ'),
(7, 1, 'CHIA', 'CHIA'),
(8, 1, 'SOACHA', 'SOACHA');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id_company` int(11) NOT NULL,
  `id_city` int(11) DEFAULT NULL,
  `company_number` varchar(50) DEFAULT NULL,
  `company_name` varchar(500) NOT NULL,
  `company_address` varchar(500) DEFAULT NULL,
  `company_fest_desc` text NOT NULL,
  `company_observations` text
) ;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id_company`, `id_city`, `company_number`, `company_name`, `company_address`, `company_fest_desc`, `company_observations`) VALUES
(3, 8, 'test test 1', 'test 1', 'street test 1', 'juegos de mesa', 'observations test 1 test 1'),
(23, 1, 'test 2', 'test 2', 'teste 3 street', 'espectáculos', 'asdf'),
(24, 1, 'test 3', 'test 3', 'teste 3 street', 'música', 'asdf'),
(26, 1, 'test 4', 'test 4', 'teste 3 street', 'circo', 'asdf'),
(27, 1, 'test 5', 'test 5', 'teste 3 street 3', 'asdfa asdf  deportes extremos 2 slslkjdf', 'asdf'),
(28, 1, 'test 6', 'test 6', 'teste 3 street', 'deportes extremos', 'asdf'),
(30, 1, 'test 9', 'test 9', 'test 9 street', 'test 9 company desc', 'test 9 observations'),
(31, 2, 'test 10', 'test 10', 'test 10', 'test 10 cmp desc', 'test observations');

-- --------------------------------------------------------

--
-- Table structure for table `company_tcompany`
--

CREATE TABLE `company_tcompany` (
  `id_company` int(11) NOT NULL,
  `id_typecompany` int(11) NOT NULL
) ;

--
-- Dumping data for table `company_tcompany`
--

INSERT INTO `company_tcompany` (`id_company`, `id_typecompany`) VALUES
(23, 1),
(24, 1),
(27, 1),
(28, 1),
(30, 1),
(3, 2),
(24, 2),
(26, 2),
(28, 2),
(31, 2);

-- --------------------------------------------------------

--
-- Table structure for table `continent`
--

CREATE TABLE `continent` (
  `id_continent` int(11) NOT NULL,
  `continent_code` varchar(50) NOT NULL,
  `continent_name` varchar(50) NOT NULL
) ;

--
-- Dumping data for table `continent`
--

INSERT INTO `continent` (`id_continent`, `continent_code`, `continent_name`) VALUES
(1, 'AMERICA', 'AMERICA');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id_country` int(11) NOT NULL,
  `id_continent` int(11) NOT NULL,
  `country_code` varchar(100) NOT NULL,
  `country_name` varchar(100) NOT NULL
) ;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id_country`, `id_continent`, `country_code`, `country_name`) VALUES
(1, 1, 'COLOMBIA', 'COLOMBIA');

-- --------------------------------------------------------

--
-- Table structure for table `email`
--

CREATE TABLE `email` (
  `id_email` int(11) NOT NULL,
  `id_company` int(11) NOT NULL,
  `email` varchar(500) NOT NULL
) ;

--
-- Dumping data for table `email`
--

INSERT INTO `email` (`id_email`, `id_company`, `email`) VALUES
(2, 27, '1@asdf.com'),
(3, 27, '2@asdf.com'),
(4, 28, '3@asdf.com'),
(5, 28, '4@asdf.com'),
(10, 23, '9@asdf.com'),
(11, 23, '10@asdf.com'),
(12, 24, '11@asdf.com'),
(13, 24, '12@asdf.com'),
(14, 26, '13@asdf.com'),
(15, 26, '14@asdf.com'),
(16, 27, '15@asdf.com'),
(17, 27, '16@asdf.com'),
(18, 28, '17@asdf.com'),
(19, 28, '18@asdf.com'),
(21, 30, 'test9@test9.com'),
(22, 31, 'adsf@asdf.com'),
(36, 3, '5@lkjd.com'),
(37, 3, '6@asd.omc'),
(38, 3, '7@asdf.com'),
(39, 3, '8@asdf.com');

-- --------------------------------------------------------

--
-- Table structure for table `observation`
--

CREATE TABLE `observation` (
  `id_observation` int(11) NOT NULL,
  `id_company` int(11) DEFAULT NULL,
  `observation` text NOT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `id_sperson` int(11) NOT NULL,
  `person_id` varchar(50) NOT NULL,
  `person_name` varchar(50) NOT NULL,
  `person_lastname` varchar(50) NOT NULL
) ;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`id_sperson`, `person_id`, `person_name`, `person_lastname`) VALUES
(1, '80760766', 'Mauricio', 'Vargas'),
(2, '80760767', 'Mauricio', 'Vargas'),
(3, '80760768', 'Rodrigo', 'Velez'),
(4, '80760769', 'Marcel', 'Quintino');

-- --------------------------------------------------------

--
-- Table structure for table `register_company`
--

CREATE TABLE `register_company` (
  `id_user` int(11) NOT NULL,
  `id_company` int(11) NOT NULL,
  `register_date` timestamp NOT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `social_network`
--

CREATE TABLE `social_network` (
  `id_snetwork` int(11) NOT NULL,
  `id_company` int(11) NOT NULL,
  `id_typesnetwork` int(11) NOT NULL,
  `snetwork` varchar(100) NOT NULL
) ;

--
-- Dumping data for table `social_network`
--

INSERT INTO `social_network` (`id_snetwork`, `id_company`, `id_typesnetwork`, `snetwork`) VALUES
(1, 28, 1, 'sdf'),
(2, 28, 2, 'lkjlkj'),
(5, 23, 1, 'red 3'),
(6, 23, 2, 'red 4'),
(7, 24, 2, 'red 5'),
(8, 24, 2, 'red 6'),
(9, 26, 2, 'red7'),
(10, 26, 1, 'red 8'),
(11, 27, 3, 'red 9'),
(12, 27, 3, 'red 10'),
(14, 30, 1, 'test9'),
(15, 31, 1, 'adsfadf'),
(17, 3, 1, 'red 1'),
(18, 3, 2, 'red 2');

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `id_state` int(11) NOT NULL,
  `id_country` int(11) NOT NULL,
  `state_code` varchar(100) NOT NULL,
  `state_name` varchar(100) NOT NULL
) ;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`id_state`, `id_country`, `state_code`, `state_name`) VALUES
(1, 1, 'CUNDINAMARCA', 'CUNDINAMARCA'),
(2, 1, 'BOGOTA', 'BOGOTA');

-- --------------------------------------------------------

--
-- Table structure for table `telephone`
--

CREATE TABLE `telephone` (
  `id_telephone` int(11) NOT NULL,
  `id_typetelephone` int(11) DEFAULT NULL,
  `id_company` int(11) DEFAULT NULL,
  `telephone_number` varchar(50) DEFAULT NULL
) ;

--
-- Dumping data for table `telephone`
--

INSERT INTO `telephone` (`id_telephone`, `id_typetelephone`, `id_company`, `telephone_number`) VALUES
(1, 1, 23, '223215465465'),
(2, 1, 24, '223215465465'),
(4, 1, 26, '223215465465'),
(5, 1, 27, '223215465465'),
(6, 1, 28, '223215465465'),
(8, 1, 30, '9879780'),
(9, 1, 31, '23423'),
(10, NULL, 3, '3156548954');

-- --------------------------------------------------------

--
-- Table structure for table `type_company`
--

CREATE TABLE `type_company` (
  `id_typecompany` int(11) NOT NULL,
  `typecompany_code` varchar(100) NOT NULL,
  `typecompany_name` varchar(100) NOT NULL
) ;

--
-- Dumping data for table `type_company`
--

INSERT INTO `type_company` (`id_typecompany`, `typecompany_code`, `typecompany_name`) VALUES
(1, 'ACTIVITIES', 'Activities'),
(2, 'PLACES', 'Places');

-- --------------------------------------------------------

--
-- Table structure for table `type_snetwork`
--

CREATE TABLE `type_snetwork` (
  `id_typesnetwork` int(11) NOT NULL,
  `typesnetwork_code` varchar(50) NOT NULL,
  `typesnetwork_name` varchar(50) NOT NULL
) ;

--
-- Dumping data for table `type_snetwork`
--

INSERT INTO `type_snetwork` (`id_typesnetwork`, `typesnetwork_code`, `typesnetwork_name`) VALUES
(1, 'FACEBOOK', 'Facebook'),
(2, 'TWITTER', 'Twitter'),
(3, 'INSTAGRAM', 'Instagram'),
(4, 'GOOGLEPLUS', 'Google +');

-- --------------------------------------------------------

--
-- Table structure for table `type_telephone`
--

CREATE TABLE `type_telephone` (
  `id_typetelephone` int(11) NOT NULL,
  `typetel_code` varchar(20) NOT NULL,
  `typetel_name` varchar(20) NOT NULL
) ;

--
-- Dumping data for table `type_telephone`
--

INSERT INTO `type_telephone` (`id_typetelephone`, `typetel_code`, `typetel_name`) VALUES
(1, 'CELPHONE', 'celphone');

-- --------------------------------------------------------

--
-- Table structure for table `type_user`
--

CREATE TABLE `type_user` (
  `id_typeuser` int(11) NOT NULL,
  `typeuser_code` varchar(50) NOT NULL,
  `typeuser_name` varchar(50) NOT NULL
) ;

--
-- Dumping data for table `type_user`
--

INSERT INTO `type_user` (`id_typeuser`, `typeuser_code`, `typeuser_name`) VALUES
(1, 'RECORDER', 'Recorder'),
(2, 'READER', 'Reader');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `id_sperson` int(11) NOT NULL,
  `id_typeuser` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `active_user` int(11) NOT NULL
) ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `id_sperson`, `id_typeuser`, `username`, `password`, `active_user`) VALUES
(1, 1, 1, 'maoknox', '$2y$12$WvBnf6JgfKfncrdEFZGjuuFxVhZWSVyy8Ui7sD2VRaLcLgOjGjVs2', 1),
(2, 2, 2, 'mauricio.vargas', '$2y$12$WvBnf6JgfKfncrdEFZGjuuFxVhZWSVyy8Ui7sD2VRaLcLgOjGjVs2', 2),
(3, 3, 1, 'rodrigo.velez', 'Nevulos$4', 1),
(4, 4, 1, 'marcel.quintino', 'Nevulos$4', 2);

-- --------------------------------------------------------

--
-- Table structure for table `web`
--

CREATE TABLE `web` (
  `id_web` int(11) NOT NULL,
  `id_company` int(11) DEFAULT NULL,
  `web` text NOT NULL
) ;

--
-- Dumping data for table `web`
--

INSERT INTO `web` (`id_web`, `id_company`, `web`) VALUES
(1, 24, 'http://www.asdf.com'),
(3, 26, 'http://www.asdf.com'),
(4, 27, 'http://www.asdf.com'),
(5, 28, 'http://www.asdf.com'),
(7, 30, 'http://www.test9.com'),
(8, 31, ''),
(9, 3, 'www.test111.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id_city`),
  ADD KEY `fk_country_city` (`id_state`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id_company`),
  ADD KEY `fk_city_company` (`id_city`);

--
-- Indexes for table `company_tcompany`
--
ALTER TABLE `company_tcompany`
  ADD PRIMARY KEY (`id_company`,`id_typecompany`),
  ADD KEY `fk_company_tcompany2` (`id_typecompany`);

--
-- Indexes for table `continent`
--
ALTER TABLE `continent`
  ADD PRIMARY KEY (`id_continent`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id_country`),
  ADD KEY `fk_continent_country` (`id_continent`);

--
-- Indexes for table `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`id_email`),
  ADD KEY `fk_relationship_5` (`id_company`);

--
-- Indexes for table `observation`
--
ALTER TABLE `observation`
  ADD PRIMARY KEY (`id_observation`),
  ADD KEY `fk_company_observation` (`id_company`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id_sperson`),
  ADD UNIQUE KEY `person_id` (`person_id`);

--
-- Indexes for table `register_company`
--
ALTER TABLE `register_company`
  ADD PRIMARY KEY (`id_user`,`id_company`),
  ADD KEY `fk_register_company2` (`id_company`);

--
-- Indexes for table `social_network`
--
ALTER TABLE `social_network`
  ADD PRIMARY KEY (`id_snetwork`),
  ADD KEY `fk_company_snetwork` (`id_company`),
  ADD KEY `fk_snetwork_typesnetwokr` (`id_typesnetwork`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`id_state`),
  ADD KEY `fk_country_state` (`id_country`);

--
-- Indexes for table `telephone`
--
ALTER TABLE `telephone`
  ADD PRIMARY KEY (`id_telephone`),
  ADD KEY `fk_company_telephone` (`id_company`),
  ADD KEY `fk_typetelephone_telephone` (`id_typetelephone`);

--
-- Indexes for table `type_company`
--
ALTER TABLE `type_company`
  ADD PRIMARY KEY (`id_typecompany`);

--
-- Indexes for table `type_snetwork`
--
ALTER TABLE `type_snetwork`
  ADD PRIMARY KEY (`id_typesnetwork`);

--
-- Indexes for table `type_telephone`
--
ALTER TABLE `type_telephone`
  ADD PRIMARY KEY (`id_typetelephone`);

--
-- Indexes for table `type_user`
--
ALTER TABLE `type_user`
  ADD PRIMARY KEY (`id_typeuser`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `fk_person_username` (`id_sperson`),
  ADD KEY `fk_typeuser_user` (`id_typeuser`);

--
-- Indexes for table `web`
--
ALTER TABLE `web`
  ADD PRIMARY KEY (`id_web`),
  ADD KEY `fk_company_web` (`id_company`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id_city` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id_company` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `continent`
--
ALTER TABLE `continent`
  MODIFY `id_continent` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id_country` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `email`
--
ALTER TABLE `email`
  MODIFY `id_email` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `observation`
--
ALTER TABLE `observation`
  MODIFY `id_observation` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `id_sperson` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `social_network`
--
ALTER TABLE `social_network`
  MODIFY `id_snetwork` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `id_state` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `telephone`
--
ALTER TABLE `telephone`
  MODIFY `id_telephone` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `type_company`
--
ALTER TABLE `type_company`
  MODIFY `id_typecompany` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `type_snetwork`
--
ALTER TABLE `type_snetwork`
  MODIFY `id_typesnetwork` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `type_telephone`
--
ALTER TABLE `type_telephone`
  MODIFY `id_typetelephone` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `type_user`
--
ALTER TABLE `type_user`
  MODIFY `id_typeuser` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `web`
--
ALTER TABLE `web`
  MODIFY `id_web` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `city`
--
ALTER TABLE `city`
  ADD CONSTRAINT `fk_country_city` FOREIGN KEY (`id_state`) REFERENCES `state` (`id_state`);

--
-- Constraints for table `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `fk_city_company` FOREIGN KEY (`id_city`) REFERENCES `city` (`id_city`);

--
-- Constraints for table `company_tcompany`
--
ALTER TABLE `company_tcompany`
  ADD CONSTRAINT `fk_company_tcompany` FOREIGN KEY (`id_company`) REFERENCES `company` (`id_company`),
  ADD CONSTRAINT `fk_company_tcompany2` FOREIGN KEY (`id_typecompany`) REFERENCES `type_company` (`id_typecompany`);

--
-- Constraints for table `country`
--
ALTER TABLE `country`
  ADD CONSTRAINT `fk_continent_country` FOREIGN KEY (`id_continent`) REFERENCES `continent` (`id_continent`);

--
-- Constraints for table `email`
--
ALTER TABLE `email`
  ADD CONSTRAINT `fk_relationship_5` FOREIGN KEY (`id_company`) REFERENCES `company` (`id_company`);

--
-- Constraints for table `observation`
--
ALTER TABLE `observation`
  ADD CONSTRAINT `fk_company_observation` FOREIGN KEY (`id_company`) REFERENCES `company` (`id_company`);

--
-- Constraints for table `register_company`
--
ALTER TABLE `register_company`
  ADD CONSTRAINT `fk_register_company` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `fk_register_company2` FOREIGN KEY (`id_company`) REFERENCES `company` (`id_company`);

--
-- Constraints for table `social_network`
--
ALTER TABLE `social_network`
  ADD CONSTRAINT `fk_company_snetwork` FOREIGN KEY (`id_company`) REFERENCES `company` (`id_company`),
  ADD CONSTRAINT `fk_snetwork_typesnetwokr` FOREIGN KEY (`id_typesnetwork`) REFERENCES `type_snetwork` (`id_typesnetwork`);

--
-- Constraints for table `state`
--
ALTER TABLE `state`
  ADD CONSTRAINT `fk_country_state` FOREIGN KEY (`id_country`) REFERENCES `country` (`id_country`);

--
-- Constraints for table `telephone`
--
ALTER TABLE `telephone`
  ADD CONSTRAINT `fk_company_telephone` FOREIGN KEY (`id_company`) REFERENCES `company` (`id_company`),
  ADD CONSTRAINT `fk_typetelephone_telephone` FOREIGN KEY (`id_typetelephone`) REFERENCES `type_telephone` (`id_typetelephone`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_person_username` FOREIGN KEY (`id_sperson`) REFERENCES `person` (`id_sperson`),
  ADD CONSTRAINT `fk_typeuser_user` FOREIGN KEY (`id_typeuser`) REFERENCES `type_user` (`id_typeuser`);

--
-- Constraints for table `web`
--
ALTER TABLE `web`
  ADD CONSTRAINT `fk_company_web` FOREIGN KEY (`id_company`) REFERENCES `company` (`id_company`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
