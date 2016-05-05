-- phpMyAdmin SQL Dump
-- version 4.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 05, 2016 at 08:13 AM
-- Server version: 5.7.11
-- PHP Version: 5.5.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `rewards`
--

-- --------------------------------------------------------

--
-- Table structure for table `acc_device`
--

CREATE TABLE `acc_device` (
  `id` int(11) NOT NULL,
  `registration_token` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `last_active` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `acc_device`
--

INSERT INTO `acc_device` (`id`, `registration_token`, `is_active`, `last_active`) VALUES
  (1, 'asdasdsad123213', 1, '2016-03-18 08:54:22');

-- --------------------------------------------------------

--
-- Table structure for table `acc_role`
--

CREATE TABLE `acc_role` (
  `id` int(11) NOT NULL,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acc_role`
--

INSERT INTO `acc_role` (`id`, `name`, `is_active`) VALUES
  (1, 'CONSUMER', 1),
  (2, 'MODERATOR', 1),
  (3, 'SUPPLIER', 1);

-- --------------------------------------------------------

--
-- Table structure for table `acc_user`
--

CREATE TABLE `acc_user` (
  `id` int(11) NOT NULL,
  `email` varchar(256) DEFAULT NULL,
  `password` varbinary(256) NOT NULL,
  `mobile` bigint(20) DEFAULT NULL,
  `is_verified` varchar(4) NOT NULL DEFAULT '00',
  `is_active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acc_user`
--

INSERT INTO `acc_user` (`id`, `email`, `password`, `mobile`, `is_verified`, `is_active`) VALUES
  (1, NULL, 0x243279243133244974456636587357494d5055684e552f4b5a75377775687330545878552f4b35753658776b6a6f595544734e32415a724c447a6157, 9943387705, '00', 1),
  (4, NULL, 0x24327924313324504b596d5331362f4749533636304658336c66382f2e317371676a78714c454f47515449575455427943656853784e467951593436, 9943387701, '00', 1),
  (5, NULL, 0x243279243133245243664934473542787431595a6e6a63467a59684c4f534a674e796a71655468795569334f375065696a516b2e7232716776656365, 9943387702, '00', 1),
  (6, NULL, 0x2432792431332468745563776f486a345a742e31557a6b4d485448597559652f514b59474d6f467a6f627130746c674a7079426f552f4e4e4d795532, 9943387704, '00', 1),
  (7, NULL, 0x243279243133243271584d6c6b5a374a7930776576747564682e4b4a65553049705562302e324c6a53314e454845415448346a2f6438655055724f43, 9943387707, '00', 1),
  (8, NULL, 0x24327924313324467453636d7041316141386147443377556a4a794f4f6535636747726853644151666670314d6e664d507370706d5832642f44532e, 9943387703, '00', 1),
  (9, '9943387703', 0x24327924313324476b5077387a745a465665384e5179303442323469653051784f7651355751524c672e506342735359664b516857614c456f494f65, NULL, '00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `acc_user_device`
--

CREATE TABLE `acc_user_device` (
  `id` int(11) NOT NULL,
  `session_id` bigint(11) NOT NULL,
  `device_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `acc_user_device_info`
--

CREATE TABLE `acc_user_device_info` (
  `device_id` int(11) NOT NULL,
  `label` varchar(100) NOT NULL,
  `value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `acc_user_key`
--

CREATE TABLE `acc_user_key` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `type` enum('RESET') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `acc_user_key`
--

INSERT INTO `acc_user_key` (`id`, `user_id`, `token`, `is_active`, `type`) VALUES
  (1, 8, 'QRXNlG2Ppa5mS0Uq8V7kAkzgPTBh2kyn', 1, 'RESET');

-- --------------------------------------------------------

--
-- Table structure for table `acc_user_otp`
--

CREATE TABLE `acc_user_otp` (
  `id` int(11) NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `otp` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('RESET','REGISTER') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'REGISTER',
  `is_active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `acc_user_otp`
--

INSERT INTO `acc_user_otp` (`id`, `mobile`, `otp`, `type`, `is_active`) VALUES
  (9, 9943387703, '515311', 'REGISTER', 1),
  (10, 9943387703, '359499', 'RESET', 0),
  (11, 9943387703, '593797', 'RESET', 1);

-- --------------------------------------------------------

--
-- Table structure for table `acc_user_profile`
--

CREATE TABLE `acc_user_profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `acc_user_profile`
--

INSERT INTO `acc_user_profile` (`id`, `user_id`, `first_name`, `last_name`, `date_of_birth`, `gender_id`, `city_id`) VALUES
  (1, 8, 'karthick', 'loganathan', '1987-10-14', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `acc_user_role`
--

CREATE TABLE `acc_user_role` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acc_user_role`
--

INSERT INTO `acc_user_role` (`user_id`, `role_id`, `is_active`) VALUES
  (4, 1, 1),
  (5, 1, 1),
  (6, 1, 1),
  (7, 1, 1),
  (8, 1, 1),
  (9, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `acc_user_session`
--

CREATE TABLE `acc_user_session` (
  `id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `auth_key` varchar(256) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acc_user_session`
--

INSERT INTO `acc_user_session` (`id`, `user_id`, `auth_key`, `is_active`) VALUES
  (35, 1, 'ebkeuSvTU426xMnxjqSpkcjqx8Gk7h1x', 1),
  (38, 4, 'cCSrBzfvsqFdfYQU112gdwLpdv5_Sk9U', 1),
  (39, 4, 'GePHpS5QzMW1aLhIgMQfRzs3Y8-GDVgm', 1),
  (40, 4, 'XRf436yP7N3ujv1UtIi3i5b6mKNt_GLF', 1),
  (41, 4, 'dokrycQRufCIPgN3v4C_KM4SinFQsnLX', 1),
  (42, 4, 'UHMJG_yef23zVbH5NHnXiwUXIQsueJaw', 1),
  (43, 4, 'pNpUbcnfh277NKT0-_4GTkOquxlpl1CJ', 1),
  (44, 5, '2qxnbySDNLZqD6cCuNp60TZHddEL1sXX', 1),
  (45, 6, '6dLymkc_7vjkuDREY1SuVSuFVEMBNQET', 1),
  (46, 7, 'f86XOVxU2Pb5VuNJkYGlCYGrsM6At_9X', 1),
  (47, 8, 'jg2-Tuvu5guHO_d9PJDaHrxZqTh0IjZs', 1),
  (48, 8, '1SCt75Xd7v1KzIxNCriDZ7_O9DJfT79p', 1),
  (49, 8, 'vPNjkDIzFiERWLxRS8M8iAe45-ogPhEh', 1),
  (50, 9, 'BREQVHqFCmatj53OVabfX-KbvIqrYjVk', 1),
  (51, 8, 'U7awjkrGfBtdHQPfFJZWC5Puw0TN0vTc', 1);

-- --------------------------------------------------------

--
-- Table structure for table `conf_location`
--

CREATE TABLE `conf_location` (
  `id` int(11) NOT NULL,
  `value` varchar(100) NOT NULL,
  `type` enum('CITY','STATE','COUNTRY','AREA') NOT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `conf_location`
--

INSERT INTO `conf_location` (`id`, `value`, `type`, `parent_id`) VALUES
  (1, 'india', 'COUNTRY', NULL),
  (2, 'karnataka', 'STATE', 1),
  (3, 'bangalore', 'CITY', 2),
  (4, 'indira nagar\n', 'AREA', 3),
  (5, 'koramangala\n', 'AREA', 3),
  (6, 'commercial street', 'AREA', 3),
  (7, 'Brigade Road', 'AREA', 3),
  (8, 'MG Road', 'AREA', 3);

-- --------------------------------------------------------

--
-- Table structure for table `conf_option`
--

CREATE TABLE `conf_option` (
  `id` int(11) NOT NULL,
  `value` varchar(256) NOT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `conf_option`
--

INSERT INTO `conf_option` (`id`, `value`, `type`) VALUES
  (1, 'male', 'GENDER'),
  (2, 'female', 'GENDER'),
  (3, 'men', 'CATALOG_GENDER'),
  (4, 'women', 'CATALOG_GENDER'),
  (5, 'unisex', 'CATALOG_GENDER');

-- --------------------------------------------------------

--
-- Table structure for table `conf_setting`
--

CREATE TABLE `conf_setting` (
  `id` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `platform` enum('ALL','WEB','MOBILE') NOT NULL DEFAULT 'ALL'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `conf_setting`
--

INSERT INTO `conf_setting` (`id`, `label`, `value`, `platform`) VALUES
  (1, 'ALGOLIA.SEARCH.API.KEY', 'f4e5a8af0bbd232be157b65457d44423', 'ALL'),
  (2, 'ALGOLIA.INVENTORY.INDEX', 'dev_cat', 'ALL'),
  (3, 'ALGOLIA.INVENTORY.SORT.STORE.PRICE.ASC', 'dev_cat_store_price_asc', 'ALL'),
  (4, 'ALGOLIA.INVENTORY.SORT.STORE.PRICE.DESC', 'dev_cat_store_price_desc', 'ALL'),
  (5, 'ALGOLIA.INVENTORY.SORT.STORE.RATING.ASC', 'dev_cat_store_rating_asc\n', 'ALL'),
  (6, 'ALGOLIA.INVENTORY.SORT.STORE.RATING.DESC', 'dev_cat_store_rating_desc\n', 'ALL'),
  (7, 'ALGOLIA.INVENTORY.SORT.PRODUCT.RATING.ASC', 'dev_cat_product_rating_asc\n', 'ALL'),
  (8, 'ALGOLIA.INVENTORY.SORT.PRODUCT.RATING.DESC', 'dev_cat_product_rating_desc\n', 'ALL'),
  (9, 'HEADER.LOCATION.LATITUDE', 'Location-latitude', 'ALL'),
  (10, 'HEADER.LOCATION.LONGITUDE', 'Location-longitude', 'ALL'),
  (11, 'HEADER.LOCATION.SPEED', 'Location-speed', 'ALL'),
  (12, 'HEADER.LOCATION.HEADING', 'Location-heading', 'ALL'),
  (13, 'HEADER.LOCATION.PROVIDER', 'Location-provider', 'ALL'),
  (14, 'HEADER.LOCATION.ACCURACY', 'Location-accuracy', 'ALL'),
  (15, 'HEADER.LOCATION.TIME', 'Location-time', 'ALL'),
  (16, 'HEADER.LOCATION.RADIUS', 'Location-radius', 'ALL'),
  (17, 'ACCOUNT.VERIFY.MOBILE', 'true', 'WEB'),
  (18, 'PREFERENCE.LOCATION.RADIUS.MIN', '2000', 'ALL'),
  (19, 'PREFERENCE.LOCATION.RADIUS.DEFAULT', '15000', 'ALL'),
  (20, 'PREFERENCE.LOCATION.RADIUS.MAX', '50000', 'ALL'),
  (21, 'PREFERENCE.INVENTORY.RADIUS.MAX', '50000', 'ALL'),
  (22, 'EXOTEL.TENANT', 'shopsup', 'WEB'),
  (23, 'EXOTEL.TOKEN', '3ba1f82e1dcd35c431f5d82a0f56bc82e351bb7b', 'WEB'),
  (24, 'EXOTEL.SERVICE.TYPE', 'oneway', 'WEB'),
  (25, 'GLOBAL.API.LEVEL', '1', 'ALL'),
  (26, 'GLOBAL.DEFAULT.LATITUDE', '12.971429', 'ALL'),
  (27, 'GLOBAL.DEFAULT.LONGITUDE', '77.5840793', 'ALL');

-- --------------------------------------------------------

--
-- Table structure for table `notify_sms_log`
--

CREATE TABLE `notify_sms_log` (
  `id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `type` int(1) NOT NULL,
  `number` text NOT NULL,
  `provider_id` int(11) DEFAULT NULL,
  `response` text NOT NULL,
  `status` int(1) NOT NULL,
  `created_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notify_sms_providers`
--

CREATE TABLE `notify_sms_providers` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `single_api` varchar(255) NOT NULL,
  `multiple_api` varchar(255) NOT NULL,
  `login_param` varchar(20) NOT NULL,
  `login_value` varchar(30) NOT NULL,
  `sender_id_param` varchar(20) NOT NULL,
  `sender_id_value` varchar(20) NOT NULL,
  `password_param` varchar(20) NOT NULL,
  `password_value` varchar(20) NOT NULL,
  `message_param` varchar(20) NOT NULL,
  `single_mobile_param` varchar(20) NOT NULL,
  `multiple_mobile_param` varchar(20) NOT NULL,
  `country_code_required` int(1) NOT NULL,
  `multiple_separator` varchar(1) NOT NULL,
  `sent` double DEFAULT NULL,
  `status` int(1) NOT NULL,
  `created_time` timestamp NULL DEFAULT NULL,
  `updated_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notify_sms_providers`
--

INSERT INTO `notify_sms_providers` (`id`, `name`, `single_api`, `multiple_api`, `login_param`, `login_value`, `sender_id_param`, `sender_id_value`, `password_param`, `password_value`, `message_param`, `single_mobile_param`, `multiple_mobile_param`, `country_code_required`, `multiple_separator`, `sent`, `status`, `created_time`, `updated_time`) VALUES
  (1, 'Online SMS', 'http://onlinesms.in/api/sendValidSMSdataUrl.php', 'http://onlinesms.in/api/sendValidBulkSMSdataUrl.php', 'login', '9943387703', 'senderid', 'OPTINS', 'pword', 'zyjehygar', 'msg', 'mobnum', 'mobnum', 0, ',', 121, 1, NULL, '2016-03-23 16:29:14'),
  (2, 'Value First', 'http://203.212.70.200/smpp/sendsms', 'http://203.212.70.200/smpp/sendsms', 'username', 'shpsup', 'from', 'SHPSUP', 'password', '(()!)*Ad', 'text', 'to', 'mobnum', 0, ',', 44, 0, NULL, '2016-03-07 10:12:10');

-- --------------------------------------------------------

--
-- Table structure for table `notify_sms_templates`
--

CREATE TABLE `notify_sms_templates` (
  `id` int(11) NOT NULL,
  `scenario` varchar(100) NOT NULL,
  `template` text NOT NULL,
  `created_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notify_sms_templates`
--

INSERT INTO `notify_sms_templates` (`id`, `scenario`, `template`, `created_time`) VALUES
  (1, 'USER.MOBILE.VERIFICATION', 'Please use code {code} to verify your mobile number on Shopsup', NULL),
  (2, 'USER.PASSWORD.RESET', 'Please use code {code} to reset your password on Shopsup', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acc_device`
--
ALTER TABLE `acc_device`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `acc_role`
--
ALTER TABLE `acc_role`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `acc_user`
--
ALTER TABLE `acc_user`
ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `email` (`email`),
ADD UNIQUE KEY `mobile` (`mobile`);

--
-- Indexes for table `acc_user_device`
--
ALTER TABLE `acc_user_device`
ADD PRIMARY KEY (`id`),
ADD KEY `session_id` (`session_id`),
ADD KEY `session_id_2` (`session_id`),
ADD KEY `device_id` (`device_id`);

--
-- Indexes for table `acc_user_device_info`
--
ALTER TABLE `acc_user_device_info`
ADD PRIMARY KEY (`device_id`,`label`);

--
-- Indexes for table `acc_user_key`
--
ALTER TABLE `acc_user_key`
ADD PRIMARY KEY (`id`),
ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `acc_user_otp`
--
ALTER TABLE `acc_user_otp`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `acc_user_profile`
--
ALTER TABLE `acc_user_profile`
ADD PRIMARY KEY (`id`,`user_id`),
ADD KEY `fk_user_profile_user_idx` (`user_id`),
ADD KEY `fk_acc_user_profile_mst_location1_idx` (`city_id`),
ADD KEY `gender` (`gender_id`),
ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `acc_user_role`
--
ALTER TABLE `acc_user_role`
ADD PRIMARY KEY (`user_id`,`role_id`),
ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `acc_user_session`
--
ALTER TABLE `acc_user_session`
ADD PRIMARY KEY (`id`),
ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `conf_location`
--
ALTER TABLE `conf_location`
ADD PRIMARY KEY (`id`),
ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `conf_option`
--
ALTER TABLE `conf_option`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notify_sms_log`
--
ALTER TABLE `notify_sms_log`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notify_sms_providers`
--
ALTER TABLE `notify_sms_providers`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notify_sms_templates`
--
ALTER TABLE `notify_sms_templates`
ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acc_device`
--
ALTER TABLE `acc_device`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `acc_role`
--
ALTER TABLE `acc_role`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `acc_user`
--
ALTER TABLE `acc_user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `acc_user_device`
--
ALTER TABLE `acc_user_device`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `acc_user_key`
--
ALTER TABLE `acc_user_key`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `acc_user_otp`
--
ALTER TABLE `acc_user_otp`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `acc_user_profile`
--
ALTER TABLE `acc_user_profile`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `acc_user_session`
--
ALTER TABLE `acc_user_session`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT for table `conf_location`
--
ALTER TABLE `conf_location`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `conf_option`
--
ALTER TABLE `conf_option`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `notify_sms_log`
--
ALTER TABLE `notify_sms_log`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notify_sms_providers`
--
ALTER TABLE `notify_sms_providers`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `notify_sms_templates`
--
ALTER TABLE `notify_sms_templates`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `acc_user_device`
--
ALTER TABLE `acc_user_device`
ADD CONSTRAINT `acc_user_device_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `acc_user_session` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `acc_user_device_ibfk_2` FOREIGN KEY (`device_id`) REFERENCES `acc_user_device` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `acc_user_device_info`
--
ALTER TABLE `acc_user_device_info`
ADD CONSTRAINT `acc_user_device_info_ibfk_1` FOREIGN KEY (`device_id`) REFERENCES `acc_user_device` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `acc_user_key`
--
ALTER TABLE `acc_user_key`
ADD CONSTRAINT `acc_user_key_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `acc_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `acc_user_profile`
--
ALTER TABLE `acc_user_profile`
ADD CONSTRAINT `acc_user_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `acc_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `acc_user_profile_ibfk_2` FOREIGN KEY (`gender_id`) REFERENCES `conf_option` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `acc_user_profile_ibfk_3` FOREIGN KEY (`city_id`) REFERENCES `conf_location` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `acc_user_role`
--
ALTER TABLE `acc_user_role`
ADD CONSTRAINT `acc_user_role_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `acc_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `acc_user_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `acc_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `acc_user_session`
--
ALTER TABLE `acc_user_session`
ADD CONSTRAINT `acc_user_session_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `acc_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `conf_location`
--
ALTER TABLE `conf_location`
ADD CONSTRAINT `conf_location_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `conf_option` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
