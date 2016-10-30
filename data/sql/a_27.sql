-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2016 at 05:41 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `a_27`
--
-- --------------------------------------------------------

--
-- Table structure for table `allocation_categories`
--

CREATE TABLE IF NOT EXISTS `allocation_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `display_name` varchar(64) NOT NULL,
  `symbol` varchar(1) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3;

--
-- Dumping data for table `allocation_categories`
--

INSERT INTO `allocation_categories` (`id`, `name`, `display_name`, `symbol`, `description`, `note`) VALUES
(1, 'property-investment-allocation', 'Property Investment Allocation', '$', 'Money an investor has invested which has been allocated to an assigned property.', 'This amount will be returned to the investor at point of cash-out (sale of assigned property)'),
(2, 'property-profit-share', 'Property Profit Share', '%', 'An investors entitled percentage of an assigned property.', 'Optionally paid out in yearly dividends and or at time of cash-out (sale of assigned property).');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE IF NOT EXISTS `expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `rate_id` int(11) NOT NULL,
  `amount` decimal(9,2) NOT NULL,
  `date_filed` date DEFAULT NULL,
  `date_from` date DEFAULT NULL,
  `date_to` date DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `property_id` (`property_id`,`category_id`,`rate_id`),
  KEY `rate_id` (`rate_id`),
  KEY `category_id` (`category_id`),
  KEY `author_id` (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `extra`
--

CREATE TABLE `extra` (
  `id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `extra`
--

INSERT INTO `extra` (`id`, `type_id`, `name`) VALUES
(1, 2, 'Garbage'),
(2, 2, 'Water'),
(3, 2, 'Sewage'),
(4, 3, 'Screened Porch'),
(5, 3, 'Dishwasher'),
(6, 3, 'Microwave'),
(7, 3, 'Range/Oven'),
(8, 3, 'Refrigerator'),
(9, 3, 'Washer/Dryer Hookups'),
(10, 3, 'Washer/Dryer'),
(11, 3, 'Water Front'),
(12, 3, 'Fireplace'),
(13, 1, 'Pool'),
(14, 1, 'Hot Tub/Spa'),
(15, 1, 'Tennis Courts'),
(16, 1, 'Fitness Center'),
(17, 1, 'Clubhouse'),
(18, 1, 'Car Wash Station');

-- --------------------------------------------------------

--
-- Table structure for table `extra_type`
--

CREATE TABLE `extra_type` (
  `id` int(11) NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `extra_type`
--

INSERT INTO `extra_type` (`id`, `name`) VALUES
(1, 'Amenity'),
(2, 'Include'),
(3, 'Feature');

-- --------------------------------------------------------

--
-- Table structure for table `financial_categories`
--

CREATE TABLE IF NOT EXISTS `financial_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `display_name` varchar(64) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `excl_cash_flow` tinyint(1) NOT NULL DEFAULT '0',
  `excl_all` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22;

--
-- Dumping data for table `financial_categories`
--

INSERT INTO `financial_categories` (`id`, `name`, `display_name`, `description`, `note`, `excl_cash_flow`, `excl_all`) VALUES
(1, 'legal', 'Legal', 'Any and all legal expenses', NULL, 0, 0),
(2, 'office-supplies', 'Office Supplies', 'Any supplies used to conduct business', NULL, 0, 0),
(3, 'license-permits', 'License & Permit', 'Any and all expenses due to license and permit', NULL, 0, 0),
(4, 'rent', 'Rent', 'Rent (income)', NULL, 0, 0),
(5, 'purchase', 'Purchase', 'Anything included with the properties initial purchase', NULL, 1, 0),
(6, 'hoa', 'HOA', 'Any and all HOA expenses', NULL, 0, 0),
(7, 'repair-materials', 'Repair Materials', 'Any and all material expenses for repairs and maintenance', NULL, 0, 0),
(8, 'repair-labor', 'Repair Labor', 'Labor for repairs and maintenance', NULL, 0, 0),
(9, 'bank-fee', 'Bank Fee', 'Any and all bank fee expenses', NULL, 0, 0),
(10, 'taxes', 'Taxes', 'Any and all tax expenses', NULL, 0, 0),
(11, 'bad-debt', 'Bad Debt', 'Any and all bad debts', NULL, 0, 0),
(12, 'improvement-labor', 'Improvement Labor', 'Any and all labor expense for property improvements', NULL, 0, 0),
(13, 'improvement-materials', 'Improvement Materials', 'Any and all material expenses for property improvement', NULL, 0, 0),
(14, 'advertising', 'Advertising', 'Any and all expenses for advertising', '', 0, 0),
(15, 'utility', 'Utility', 'Any and all utility expenses', NULL, 0, 0),
(16, 'property_asset', 'Zestimate®', 'Property Asset (income)', NULL, 1, 0),
(17, 'gas', 'Gas', 'Any and all travel related expenses', NULL, 0, 0),
(18, 'deposit', 'Deposit', 'All rental property deposits', '', 1, 1),
(19, 'fee', 'Fee', 'Any and all fees collected (income)', NULL, 0, 0),
(20, 'technology', 'Technology', 'Any and all expenses for technology', NULL, 0, 0),
(21, 'capital-gain', 'Capital Gain', 'Used for reporting quarterly capital gains from the stock market.', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `incomes`
--

CREATE TABLE IF NOT EXISTS `incomes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `rate_id` int(11) NOT NULL,
  `amount` decimal(9,2) NOT NULL,
  `date_filed` date DEFAULT NULL,
  `date_from` date DEFAULT NULL,
  `date_to` date DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `property_id` (`property_id`,`category_id`,`rate_id`),
  KEY `rate_id` (`rate_id`),
  KEY `category_id` (`category_id`),
  KEY `author_id` (`author_id`),
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `investor_allocations`
--

CREATE TABLE IF NOT EXISTS `investor_allocations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `allocation` float(9,2) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `property_category_investor_allocation` (`category_id`,`property_id`),
  KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`),
  KEY `property_id` (`property_id`),
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_2DEDCC6FFEDE5A6` (`permission_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=51;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `permission_name`) VALUES
(38, 'add_allocation'),
(39, 'add_allocation_category'),
(11, 'add_expense'),
(12, 'add_financial_category'),
(10, 'add_income'),
(49, 'add_investor'),
(13, 'add_permission'),
(44, 'add_person'),
(25, 'add_property'),
(17, 'add_role'),
(29, 'add_tenant'),
(22, 'add_user'),
(37, 'delete_allocation'),
(41, 'delete_allocation_category'),
(3, 'delete_expense'),
(6, 'delete_financial_category'),
(9, 'delete_income'),
(16, 'delete_permission'),
(47, 'delete_person'),
(28, 'delete_property'),
(20, 'delete_role'),
(32, 'delete_tenant'),
(24, 'delete_user'),
(36, 'edit_allocation'),
(40, 'edit_allocation_category'),
(2, 'edit_expense'),
(5, 'edit_financial_category'),
(8, 'edit_income'),
(50, 'edit_investor'),
(14, 'edit_permission'),
(45, 'edit_person'),
(26, 'edit_property'),
(18, 'edit_role'),
(31, 'edit_tenant'),
(23, 'edit_user'),
(34, 'financial_report'),
(33, 'financial_summary'),
(35, 'view_allocation'),
(42, 'view_allocation_category'),
(1, 'view_expense'),
(4, 'view_financial_category'),
(7, 'view_income'),
(43, 'view_investment'),
(48, 'view_investor'),
(15, 'view_permission'),
(46, 'view_person'),
(27, 'view_property'),
(19, 'view_role'),
(30, 'view_tenant'),
(21, 'view_user');

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE IF NOT EXISTS `properties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zpid` varchar(32) DEFAULT NULL,
  `status_id` int(1) DEFAULT '0',
  `name` varchar(64) NOT NULL,
  `street_address` varchar(128) NOT NULL,
  `unit` varchar(8) DEFAULT NULL,
  `city` varchar(64) NOT NULL,
  `state` char(2) NOT NULL,
  `zip` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `zpid` (`zpid`),
  KEY `status_id` (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `properties_description`
--

CREATE TABLE IF NOT EXISTS `properties_description` (
  `property_id` int(11) NOT NULL,
  `summary` varchar(1024) DEFAULT NULL,
  `notes` varchar(512) DEFAULT NULL,
  UNIQUE KEY `property_id` (`property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `properties_images`
--

CREATE TABLE IF NOT EXISTS `properties_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` varchar(64) DEFAULT NULL,
  `file` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `properties_id` (`property_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `properties_info`
--

CREATE TABLE IF NOT EXISTS `properties_info` (
  `property_id` int(11) NOT NULL,
  `sqft` int(4) NOT NULL DEFAULT '0',
  `bedrooms` int(1) NOT NULL DEFAULT '0',
  `bathrooms` decimal(3,2) NOT NULL DEFAULT '0.00',
  `property_taxes` decimal(6,2) NOT NULL DEFAULT '0.00',
  `hoa_fees` decimal(6,2) NOT NULL DEFAULT '0.00',
  `year_built` int(4) NOT NULL,
  PRIMARY KEY (`property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `property_extras`
--

CREATE TABLE IF NOT EXISTS `property_extras` (
  `property_id` int(11) NOT NULL,
  `extra_id` int(11) NOT NULL,
  UNIQUE KEY `property_extra` (`property_id`, `extra_id`),
  KEY `property_id` (`property_id`),
  KEY `extra_id` (`extra_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rates`
--

CREATE TABLE IF NOT EXISTS `rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  `monthly` decimal(7,4) NOT NULL,
  `quarterly` decimal(7,4) NOT NULL,
  `semi_annual` decimal(7,4) NOT NULL,
  `annual` decimal(7,4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6;

--
-- Dumping data for table `rates`
--

INSERT INTO `rates` (`id`, `name`, `monthly`, `quarterly`, `semi_annual`, `annual`) VALUES
(1, 'Monthly', '1.0000', '3.0000', '6.0000', '12.0000'),
(2, 'Quarterly', '0.3333', '1.0000', '2.0000', '4.0000'),
(3, 'Semi-Annual', '0.1667', '0.5000', '1.0000', '2.0000'),
(4, 'Annual', '0.0833', '0.2500', '0.5000', '1.0000'),
(5, 'One Time', '1.0000', '1.0000', '1.0000', '1.0000');

-- --------------------------------------------------------

--
-- Table structure for table `rental_listings`
--

CREATE TABLE IF NOT EXISTS `rental_listings` (
  `property_id` int(11) NOT NULL,
  `rent` decimal(6,2) NOT NULL DEFAULT '0.00',
  `deposit` decimal(6,2) NOT NULL DEFAULT '0.00',
  `available` date NOT NULL,
  `contact_name` varchar(32) NOT NULL,
  `contact_number` varchar(32) NOT NULL,
  `summary` varchar(512) DEFAULT NULL,
  `notes` varchar(256) DEFAULT NULL,
  `cta_button` varchar(32) DEFAULT NULL,
  `cta_title` varchar(32) DEFAULT NULL,
  `cta_message` varchar(256) DEFAULT NULL,
  `cta_footer` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(48) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B63E2EC7E09C0C92` (`role_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=25;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`) VALUES
(15, 'account'),
(10, 'account_admin'),
(8, 'admin'),
(6, 'agent'),
(7, 'agent_admin'),
(23, 'demo'),
(24, 'demo_admin'),
(1, 'guest'),
(5, 'investor'),
(22, 'investor_admin'),
(3, 'landlord'),
(4, 'landlord_admin'),
(9, 'super_admin'),
(21, 'tenant');

-- --------------------------------------------------------

--
-- Table structure for table `role_permission`
--

CREATE TABLE IF NOT EXISTS `role_permission` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `IDX_6F7DF886D60322AC` (`role_id`),
  KEY `IDX_6F7DF886FED90CCA` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_permission`
--

INSERT INTO `role_permission` (`role_id`, `permission_id`) VALUES
(3, 29),
(3, 30),
(4, 31),
(4, 32),
(5, 43),
(6, 10),
(6, 11),
(6, 26),
(6, 27),
(7, 26),
(7, 27),
(8, 25),
(8, 28),
(9, 13),
(9, 14),
(9, 15),
(9, 16),
(9, 17),
(9, 18),
(9, 19),
(9, 20),
(9, 21),
(9, 22),
(9, 23),
(9, 24),
(10, 2),
(10, 3),
(10, 5),
(10, 6),
(10, 8),
(10, 9),
(10, 10),
(10, 11),
(10, 12),
(15, 1),
(15, 4),
(15, 7),
(15, 33),
(15, 34),
(22, 29),
(22, 35),
(22, 36),
(22, 37),
(22, 38),
(22, 39),
(22, 40),
(22, 41),
(22, 42),
(22, 48),
(22, 49),
(22, 50),
(23, 44),
(23, 46),
(24, 45),
(24, 47);

-- --------------------------------------------------------

--
-- Table structure for table `role_role`
--

CREATE TABLE IF NOT EXISTS `role_role` (
  `parent_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  PRIMARY KEY (`parent_id`,`child_id`),
  KEY `IDX_E9D6F8FE727ACA70` (`parent_id`),
  KEY `IDX_E9D6F8FEDD62C21B` (`child_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_role`
--

INSERT INTO `role_role` (`parent_id`, `child_id`) VALUES
(3, 1),
(4, 3),
(5, 15),
(6, 15),
(7, 10),
(8, 7),
(9, 8),
(10, 15),
(15, 1),
(21, 1),
(22, 5),
(23, 1),
(24, 23);

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

CREATE TABLE `tenants` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `first_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `middle_initial` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `birth_date` date NOT NULL,
  `code` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `state` smallint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `IDX_2DE8C6A3A76ED395` (`user_id`),
  KEY `IDX_2DE8C6A3D60322AC` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `fk_expenses_category_id` FOREIGN KEY (`category_id`) REFERENCES `financial_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_expenses_property_id` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_expenses_author_id` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `fk_expenses_rate_id` FOREIGN KEY (`rate_id`) REFERENCES `rates` (`id`);

--
-- Constraints for table `extra`
--
ALTER TABLE `extra`
  ADD CONSTRAINT `extra_type` FOREIGN KEY (`type_id`) REFERENCES `extra_type` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `incomes`
--
ALTER TABLE `incomes`
  ADD CONSTRAINT `fk_incomes_property_id` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_incomes_author_id` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `fk_incomes_category_id` FOREIGN KEY (`category_id`) REFERENCES `financial_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_incomes_rate_id` FOREIGN KEY (`rate_id`) REFERENCES `rates` (`id`);

--
-- Constraints for table `investors`
--
ALTER TABLE `investors`
  ADD CONSTRAINT `fk_investors_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `investor_allocations`
--
ALTER TABLE `investor_allocations`
  ADD CONSTRAINT `fk_investor_allocations_category_id` FOREIGN KEY (`category_id`) REFERENCES `allocation_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_investor_allocations_property_id` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_investor_allocations_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `properties_images`
--
ALTER TABLE `properties_images`
  ADD CONSTRAINT `fk_properties_images_property_id` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `properties_info`
--
ALTER TABLE `properties_info`
  ADD CONSTRAINT `properties_info_property_id` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `property_extras`
--
ALTER TABLE `property_extras`
  ADD CONSTRAINT `extra_extra` FOREIGN KEY (`extra_id`) REFERENCES `extra` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `extra_property` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rental_listings`
--
ALTER TABLE `rental_listings`
  ADD CONSTRAINT `fk_rental_listings_property_id` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD CONSTRAINT `fk_role_permission_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_role_permission_permission_id` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_role`
--
ALTER TABLE `role_role`
  ADD CONSTRAINT `fk_role_role_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_role_child_id` FOREIGN KEY (`child_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `fk_user_role_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_role_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tenants`
--
ALTER TABLE `tenants`
  ADD CONSTRAINT `fk_tenants_author_id` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION,

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;