-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2024 at 10:35 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dairyfarm_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblbreeding_cycles`
--

CREATE TABLE `tblbreeding_cycles` (
  `cycle_id` int(10) UNSIGNED NOT NULL,
  `cow_id` int(10) UNSIGNED NOT NULL,
  `breeding_date` date DEFAULT NULL,
  `method_of_insemination` varchar(100) DEFAULT NULL,
  `expected_calving_date` date DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblbreeding_cycles`
--

INSERT INTO `tblbreeding_cycles` (`cycle_id`, `cow_id`, `breeding_date`, `method_of_insemination`, `expected_calving_date`, `status`, `created_at`) VALUES
(7, 2, '2024-11-28', 'Thawing Semen', '2025-07-07', 'Pregnant', '2024-11-28 00:26:04');

-- --------------------------------------------------------

--
-- Table structure for table `tblcows`
--

CREATE TABLE `tblcows` (
  `cow_id` int(10) UNSIGNED NOT NULL,
  `cow_name` varchar(255) NOT NULL,
  `breed` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `health_status` varchar(255) NOT NULL DEFAULT 'Healthy',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcows`
--

INSERT INTO `tblcows` (`cow_id`, `cow_name`, `breed`, `date_of_birth`, `gender`, `health_status`, `created_at`) VALUES
(1, '', 'Holstein', '0000-00-00', 'Male', 'Healthy', '2024-11-26 08:30:12'),
(2, '', 'Jersey', '0000-00-00', 'Male', 'Healthy', '2024-11-26 08:39:56'),
(3, '', 'Ayrshire', '0000-00-00', 'Male', 'Healthy', '2024-11-26 08:39:57'),
(4, '', 'Guernsey', '0000-00-00', 'Male', 'Healthy', '2024-11-26 08:39:57'),
(5, '', 'Brangus', '0000-00-00', 'Male', 'Healthy', '2024-11-26 08:39:58'),
(6, '', 'Freshian', '0000-00-00', 'Male', 'Healthy', '2024-11-26 08:39:58'),
(7, '', 'African', '0000-00-00', 'Male', 'Healthy', '2024-11-26 08:39:58');

-- --------------------------------------------------------

--
-- Table structure for table `tblfeeds`
--

CREATE TABLE `tblfeeds` (
  `feed_id` int(10) UNSIGNED NOT NULL,
  `feed_type` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `price_per_unit` decimal(10,2) DEFAULT NULL,
  `feed_schedule` varchar(50) NOT NULL,
  `animal_group` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `feed_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblfeeds`
--

INSERT INTO `tblfeeds` (`feed_id`, `feed_type`, `quantity`, `unit`, `price_per_unit`, `feed_schedule`, `animal_group`, `created_at`, `date_added`, `feed_name`) VALUES
(3, '', 100, 'kg', 15.50, '', NULL, '2024-11-25 22:51:15', '2024-11-26 01:51:15', 'Hay'),
(4, 'rehhgzx', 23, NULL, NULL, '', NULL, '2024-11-26 04:42:14', '2024-11-26 07:42:14', 'Molases'),
(6, 'Can', 4, '30liters', 50.00, '', NULL, '2024-11-26 04:52:30', '2024-11-26 07:52:30', 'Molases'),
(7, 'Plant', 100, '50Kgs', 80.00, '', NULL, '2024-11-26 05:27:57', '2024-11-26 08:27:57', 'Silages');

-- --------------------------------------------------------

--
-- Table structure for table `tblhealth_records`
--

CREATE TABLE `tblhealth_records` (
  `record_id` int(11) NOT NULL,
  `cow_id` int(10) UNSIGNED NOT NULL,
  `health_issue` varchar(255) NOT NULL,
  `treatment` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblhealth_records`
--

INSERT INTO `tblhealth_records` (`record_id`, `cow_id`, `health_issue`, `treatment`, `date`) VALUES
(3, 10, 'Eye Discharge', 'Vaccination', '2024-11-25'),
(4, 20, 'Thin ', 'Antibiotics', '2024-11-28');

-- --------------------------------------------------------

--
-- Table structure for table `tblherd`
--

CREATE TABLE `tblherd` (
  `herd_id` int(10) UNSIGNED NOT NULL,
  `cow_id` int(10) UNSIGNED NOT NULL,
  `breed` varchar(100) NOT NULL,
  `health_status` varchar(100) NOT NULL,
  `milk_produced_today` decimal(10,2) DEFAULT NULL,
  `collection_date` datetime NOT NULL,
  `last_breeding_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblherd`
--

INSERT INTO `tblherd` (`herd_id`, `cow_id`, `breed`, `health_status`, `milk_produced_today`, `collection_date`, `last_breeding_date`) VALUES
(13, 7, 'Freshian', 'Good', 30.00, '2024-11-27 23:27:00', NULL),
(14, 9, 'African', 'Good', 25.00, '2024-11-27 21:32:00', NULL),
(15, 8, 'Beefalo', 'Fairly', 12.00, '2024-11-27 22:31:00', NULL),
(17, 2, 'Jersey', 'Good', 10.00, '2024-11-27 22:43:00', NULL),
(18, 3, 'Freshian', 'Good', 30.00, '2024-11-27 22:57:00', NULL),
(19, 1, 'Jersey', 'Good', 20.00, '2024-11-27 23:04:00', NULL),
(20, 18, 'African', 'Good', 20.00, '2024-11-28 00:19:00', NULL),
(21, 20, 'Kamban', 'Good', 13.00, '2024-11-28 00:21:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblinvoices`
--

CREATE TABLE `tblinvoices` (
  `invoice_id` int(11) NOT NULL,
  `invoice_number` varchar(100) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `invoice_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblmilk_collection`
--

CREATE TABLE `tblmilk_collection` (
  `collection_id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `cow_id` int(10) UNSIGNED NOT NULL,
  `milk_collected` decimal(10,2) NOT NULL,
  `collection_date` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblmilk_sales`
--

CREATE TABLE `tblmilk_sales` (
  `sale_id` int(10) UNSIGNED NOT NULL,
  `cow_id` int(10) UNSIGNED NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `sale_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblmilk_sales`
--

INSERT INTO `tblmilk_sales` (`sale_id`, `cow_id`, `quantity`, `sale_date`, `amount`) VALUES
(1, 2, 50.00, '2024-11-26', 500.00),
(3, 4, 5.00, '2024-11-25', 250.00);

-- --------------------------------------------------------

--
-- Table structure for table `tblnewborns`
--

CREATE TABLE `tblnewborns` (
  `newborn_id` int(10) UNSIGNED NOT NULL,
  `mother_cow_id` int(10) UNSIGNED NOT NULL,
  `birth_date` date NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `weight` float NOT NULL,
  `health_status` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblnewborns`
--

INSERT INTO `tblnewborns` (`newborn_id`, `mother_cow_id`, `birth_date`, `gender`, `weight`, `health_status`, `created_at`) VALUES
(1, 5, '2024-11-25', 'Male', 5, 'Good', '2024-11-26 10:09:38'),
(2, 6, '2024-11-27', 'Female', 3, 'Good', '2024-11-26 10:34:50');

-- --------------------------------------------------------

--
-- Table structure for table `tblproducts`
--

CREATE TABLE `tblproducts` (
  `product_id` int(10) UNSIGNED NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `stock_level` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblproducts`
--

INSERT INTO `tblproducts` (`product_id`, `product_name`, `product_price`, `created_at`, `stock_level`) VALUES
(1, 'Cow 1', 500.00, '2024-11-25 09:06:03', 0),
(2, 'Cow 2', 550.00, '2024-11-25 09:13:54', 0),
(3, 'Cow 3', 600.00, '2024-11-25 09:13:54', 0),
(4, 'Cow 4', 450.00, '2024-11-25 09:13:54', 0),
(5, 'Cow 5', 700.00, '2024-11-25 09:13:54', 0),
(6, 'Cow 6', 650.00, '2024-11-25 09:13:54', 0),
(7, 'Cow 7', 530.00, '2024-11-25 09:13:54', 0),
(8, 'Cow 8', 590.00, '2024-11-25 09:13:54', 0),
(9, 'Cow 9', 480.00, '2024-11-25 09:13:54', 0),
(10, 'Cow 10', 620.00, '2024-11-25 09:13:54', 0),
(11, 'Cow 11', 610.00, '2024-11-25 09:13:54', 0),
(12, 'Cow 12', 575.00, '2024-11-25 09:13:54', 0),
(13, 'Cow 13', 560.00, '2024-11-25 09:13:54', 0),
(14, 'Cow 14', 680.00, '2024-11-25 09:13:54', 0),
(15, 'Cow 15', 490.00, '2024-11-25 09:13:54', 0),
(16, 'Cow 16', 540.00, '2024-11-25 09:13:54', 0),
(17, 'Cow 17', 650.00, '2024-11-25 09:13:54', 0),
(18, 'Cow 18', 500.00, '2024-11-25 09:13:54', 0),
(19, 'Cow 19', 590.00, '2024-11-25 09:13:54', 0),
(20, 'Cow 20', 730.00, '2024-11-25 09:13:54', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblreports`
--

CREATE TABLE `tblreports` (
  `report_id` int(11) NOT NULL,
  `report_type` varchar(100) DEFAULT NULL,
  `report_data` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblreproductive_cycles`
--

CREATE TABLE `tblreproductive_cycles` (
  `cycle_id` int(10) UNSIGNED NOT NULL,
  `cow_id` int(10) UNSIGNED NOT NULL,
  `cycle_start_date` date NOT NULL,
  `pregnancy_status` enum('Not Pregnant','Pregnant','Calved') NOT NULL,
  `expected_due_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblreproductive_cycles`
--

INSERT INTO `tblreproductive_cycles` (`cycle_id`, `cow_id`, `cycle_start_date`, `pregnancy_status`, `expected_due_date`, `notes`, `created_at`) VALUES
(5, 1, '2024-11-25', 'Calved', '2024-12-01', 'Nice Progress\r\n', '2024-11-26 08:31:12'),
(7, 3, '2024-11-26', 'Not Pregnant', '2025-07-05', 'Waiting', '2024-11-26 10:01:16');

-- --------------------------------------------------------

--
-- Table structure for table `tblsales`
--

CREATE TABLE `tblsales` (
  `sale_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `sale_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblsales`
--

INSERT INTO `tblsales` (`sale_id`, `product_id`, `quantity`, `sale_date`, `amount`) VALUES
(1, 8, 100, '2024-11-25', 1000.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbltreatment_history`
--

CREATE TABLE `tbltreatment_history` (
  `treatment_id` int(10) UNSIGNED NOT NULL,
  `cow_id` int(10) UNSIGNED NOT NULL,
  `treatment_type` varchar(100) NOT NULL,
  `treatment_description` text DEFAULT NULL,
  `treatment_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbltreatment_history`
--

INSERT INTO `tbltreatment_history` (`treatment_id`, `cow_id`, `treatment_type`, `treatment_description`, `treatment_date`, `created_at`) VALUES
(6, 20, 'Draxxin', 'Positive', '2024-11-28', '2024-11-27 19:30:26');

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','veterinarian','employee') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`user_id`, `username`, `password`, `role`, `created_at`, `email`) VALUES
(0, 'Gracie', '$2y$10$NzUAazVQhGYlq8WZ2htVWeZNeTrovpyO3d5CjHxi2LkReKIoERGtG', 'admin', '2024-11-25 18:02:02', ''),
(1, 'admin', 'admin', 'admin', '2024-11-25 07:21:52', ''),
(2, 'veterinarian', 'password', 'veterinarian', '2024-11-25 07:21:52', ''),
(3, 'employee', 'password', 'employee', '2024-11-25 07:21:52', '');

-- --------------------------------------------------------

--
-- Table structure for table `tblusers_temp`
--

CREATE TABLE `tblusers_temp` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','employee','veterinarian') NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblusers_temp`
--

INSERT INTO `tblusers_temp` (`user_id`, `username`, `password`, `role`, `created_at`) VALUES
(2, 'Mike', '$2y$10$7qgqiwIAbuxyPH5I.Hk4rOdHgmyIfFVlIwLS5u5vOOeiH9.7.LTca', 'veterinarian', '2024-11-25 22:18:10'),
(3, 'Pancras', '$2y$10$WAldnEUDwKoxvQHHLuadmeJpNZDu.KZlHppcWXp4eERO4lJcPoGae', 'employee', '2024-11-25 23:11:02'),
(4, 'testuser', '$2y$10$eImiTXuWVxfM37uY4JANj.eFe57w/qSt/pt.NJgA1o5PiHe0uYQ4u', 'admin', '2024-11-25 23:27:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblbreeding_cycles`
--
ALTER TABLE `tblbreeding_cycles`
  ADD PRIMARY KEY (`cycle_id`),
  ADD KEY `cow_id` (`cow_id`);

--
-- Indexes for table `tblcows`
--
ALTER TABLE `tblcows`
  ADD PRIMARY KEY (`cow_id`);

--
-- Indexes for table `tblfeeds`
--
ALTER TABLE `tblfeeds`
  ADD PRIMARY KEY (`feed_id`);

--
-- Indexes for table `tblhealth_records`
--
ALTER TABLE `tblhealth_records`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `cow_id` (`cow_id`);

--
-- Indexes for table `tblherd`
--
ALTER TABLE `tblherd`
  ADD PRIMARY KEY (`herd_id`),
  ADD KEY `cow_id` (`cow_id`);

--
-- Indexes for table `tblinvoices`
--
ALTER TABLE `tblinvoices`
  ADD PRIMARY KEY (`invoice_id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `tblmilk_collection`
--
ALTER TABLE `tblmilk_collection`
  ADD PRIMARY KEY (`collection_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `cow_id` (`cow_id`);

--
-- Indexes for table `tblmilk_sales`
--
ALTER TABLE `tblmilk_sales`
  ADD PRIMARY KEY (`sale_id`),
  ADD KEY `cow_id` (`cow_id`);

--
-- Indexes for table `tblnewborns`
--
ALTER TABLE `tblnewborns`
  ADD PRIMARY KEY (`newborn_id`),
  ADD KEY `mother_cow_id` (`mother_cow_id`);

--
-- Indexes for table `tblproducts`
--
ALTER TABLE `tblproducts`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `tblreports`
--
ALTER TABLE `tblreports`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `tblreproductive_cycles`
--
ALTER TABLE `tblreproductive_cycles`
  ADD PRIMARY KEY (`cycle_id`),
  ADD KEY `fk_cow_id` (`cow_id`);

--
-- Indexes for table `tblsales`
--
ALTER TABLE `tblsales`
  ADD PRIMARY KEY (`sale_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `tbltreatment_history`
--
ALTER TABLE `tbltreatment_history`
  ADD PRIMARY KEY (`treatment_id`),
  ADD KEY `cow_id` (`cow_id`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tblusers_temp`
--
ALTER TABLE `tblusers_temp`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblbreeding_cycles`
--
ALTER TABLE `tblbreeding_cycles`
  MODIFY `cycle_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblcows`
--
ALTER TABLE `tblcows`
  MODIFY `cow_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblfeeds`
--
ALTER TABLE `tblfeeds`
  MODIFY `feed_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblhealth_records`
--
ALTER TABLE `tblhealth_records`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblherd`
--
ALTER TABLE `tblherd`
  MODIFY `herd_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tblinvoices`
--
ALTER TABLE `tblinvoices`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblmilk_collection`
--
ALTER TABLE `tblmilk_collection`
  MODIFY `collection_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblmilk_sales`
--
ALTER TABLE `tblmilk_sales`
  MODIFY `sale_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblnewborns`
--
ALTER TABLE `tblnewborns`
  MODIFY `newborn_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblproducts`
--
ALTER TABLE `tblproducts`
  MODIFY `product_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tblreports`
--
ALTER TABLE `tblreports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblreproductive_cycles`
--
ALTER TABLE `tblreproductive_cycles`
  MODIFY `cycle_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblsales`
--
ALTER TABLE `tblsales`
  MODIFY `sale_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbltreatment_history`
--
ALTER TABLE `tbltreatment_history`
  MODIFY `treatment_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblusers_temp`
--
ALTER TABLE `tblusers_temp`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblbreeding_cycles`
--
ALTER TABLE `tblbreeding_cycles`
  ADD CONSTRAINT `tblbreeding_cycles_ibfk_1` FOREIGN KEY (`cow_id`) REFERENCES `tblherd` (`cow_id`) ON DELETE CASCADE;

--
-- Constraints for table `tblhealth_records`
--
ALTER TABLE `tblhealth_records`
  ADD CONSTRAINT `tblhealth_records_ibfk_1` FOREIGN KEY (`cow_id`) REFERENCES `tblproducts` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `tblherd`
--
ALTER TABLE `tblherd`
  ADD CONSTRAINT `tblherd_ibfk_1` FOREIGN KEY (`cow_id`) REFERENCES `tblproducts` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `tblmilk_collection`
--
ALTER TABLE `tblmilk_collection`
  ADD CONSTRAINT `tblmilk_collection_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `tblusers` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tblmilk_collection_ibfk_2` FOREIGN KEY (`cow_id`) REFERENCES `tblherd` (`cow_id`) ON DELETE CASCADE;

--
-- Constraints for table `tblmilk_sales`
--
ALTER TABLE `tblmilk_sales`
  ADD CONSTRAINT `tblmilk_sales_ibfk_1` FOREIGN KEY (`cow_id`) REFERENCES `tblcows` (`cow_id`);

--
-- Constraints for table `tblnewborns`
--
ALTER TABLE `tblnewborns`
  ADD CONSTRAINT `tblnewborns_ibfk_1` FOREIGN KEY (`mother_cow_id`) REFERENCES `tblcows` (`cow_id`) ON DELETE CASCADE;

--
-- Constraints for table `tblreproductive_cycles`
--
ALTER TABLE `tblreproductive_cycles`
  ADD CONSTRAINT `fk_cow_id` FOREIGN KEY (`cow_id`) REFERENCES `tblcows` (`cow_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tblreproductive_cycles_ibfk_1` FOREIGN KEY (`cow_id`) REFERENCES `tblcows` (`cow_id`) ON DELETE CASCADE;

--
-- Constraints for table `tblsales`
--
ALTER TABLE `tblsales`
  ADD CONSTRAINT `tblsales_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `tblproducts` (`product_id`);

--
-- Constraints for table `tbltreatment_history`
--
ALTER TABLE `tbltreatment_history`
  ADD CONSTRAINT `tbltreatment_history_ibfk_1` FOREIGN KEY (`cow_id`) REFERENCES `tblherd` (`cow_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
