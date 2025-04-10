-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 09, 2025 at 12:14 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `st_alphonsus_school`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `pupil_id` int(11) NOT NULL,
  `attendance_date` date NOT NULL,
  `session` varchar(50) DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `pupil_id`, `attendance_date`, `session`, `status`, `notes`) VALUES
(1, 1, '2023-09-15', 'Morning', 'Present', 'Active in class'),
(2, 2, '2023-09-15', 'Morning', 'Absent', 'Reported sick'),
(3, 3, '2023-09-15', 'Morning', 'Late', '30 min late'),
(4, 4, '2023-09-15', 'Morning', 'Present', 'No issues'),
(5, 5, '2023-09-15', 'Morning', 'Absent', 'Family emergency'),
(6, 6, '2023-09-15', 'Morning', 'Present', 'Paying attention'),
(7, 7, '2023-09-15', 'Morning', 'Late', 'Traffic delay'),
(8, 8, '2023-09-15', 'Morning', 'Present', 'Enthusiastic learner'),
(9, 9, '2023-09-15', 'Morning', 'Absent', 'Medical appointment'),
(10, 10, '2023-09-15', 'Morning', 'Present', 'Doing well'),
(11, 11, '2023-09-15', 'Morning', 'Late', 'Missed bus'),
(12, 12, '2023-09-15', 'Morning', 'Present', 'Attentive'),
(13, 13, '2023-09-15', 'Morning', 'Absent', 'Unwell'),
(14, 14, '2023-09-15', 'Morning', 'Present', 'Good progress'),
(15, 15, '2023-09-15', 'Morning', 'Late', 'Overslept'),
(16, 16, '2023-09-15', 'Morning', 'Present', 'Performing well'),
(17, 17, '2023-09-15', 'Morning', 'Absent', 'Family event'),
(18, 18, '2023-09-15', 'Morning', 'Present', 'Engaged'),
(19, 19, '2023-09-15', 'Morning', 'Late', 'Car trouble'),
(20, 20, '2023-09-15', 'Morning', 'Present', 'Positive attitude'),
(21, 21, '2024-04-01', 'Morning', 'Present', 'On time'),
(22, 21, '2024-04-01', 'Afternoon', 'Present', 'Participated well');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL,
  `class_name` varchar(50) NOT NULL,
  `year_group` int(11) NOT NULL,
  `capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`class_id`, `class_name`, `year_group`, `capacity`) VALUES
(1, 'Reception Year', 0, 25),
(2, 'Year One', 1, 30),
(3, 'Year Two', 2, 28),
(4, 'Year Three', 3, 26),
(5, 'Year Four', 4, 29),
(6, 'Year Five', 5, 27),
(7, 'Year Six', 6, 24),
(8, 'Year Three B', 3, 25);

-- --------------------------------------------------------

--
-- Table structure for table `dinner_account`
--

CREATE TABLE `dinner_account` (
  `account_id` int(11) NOT NULL,
  `pupil_id` int(11) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `meal_preference` varchar(50) DEFAULT NULL,
  `free_school_meals` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dinner_account`
--

INSERT INTO `dinner_account` (`account_id`, `pupil_id`, `balance`, `meal_preference`, `free_school_meals`) VALUES
(1, 1, 50.00, 'Vegetarian', 0),
(2, 2, 75.50, 'Halal', 0),
(3, 3, 30.25, 'Standard', 1),
(4, 4, 60.75, 'Vegetarian', 0),
(5, 5, 45.00, 'Standard', 0),
(6, 6, 55.50, 'Halal', 0),
(7, 7, 40.25, 'Standard', 1),
(8, 8, 65.00, 'Vegetarian', 0),
(9, 9, 35.75, 'Standard', 0),
(10, 10, 70.00, 'Halal', 0),
(11, 11, 50.50, 'Standard', 0),
(12, 12, 45.25, 'Vegetarian', 0),
(13, 13, 60.00, 'Standard', 1),
(14, 14, 55.75, 'Halal', 0),
(15, 15, 40.00, 'Standard', 0),
(16, 16, 65.50, 'Vegetarian', 0),
(17, 17, 35.25, 'Standard', 0),
(18, 18, 70.75, 'Halal', 0),
(19, 19, 50.00, 'Standard', 1),
(20, 20, 45.50, 'Vegetarian', 0),
(21, 21, 45.50, 'Vegetarian', 0);

-- --------------------------------------------------------

--
-- Table structure for table `dinner_payment`
--

CREATE TABLE `dinner_payment` (
  `payment_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `payment_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `term` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dinner_payment`
--

INSERT INTO `dinner_payment` (`payment_id`, `account_id`, `payment_date`, `amount`, `payment_method`, `term`) VALUES
(1, 1, '2023-09-15', 25.00, 'Bank Transfer', 'Autumn Term'),
(2, 2, '2023-09-16', 30.50, 'Online Payment', 'Autumn Term'),
(3, 3, '2023-09-14', 15.25, 'Cash', 'Autumn Term'),
(4, 4, '2023-09-17', 40.75, 'Bank Transfer', 'Autumn Term'),
(5, 5, '2023-09-15', 22.50, 'Online Payment', 'Autumn Term'),
(6, 6, '2023-09-16', 35.50, 'Cash', 'Autumn Term'),
(7, 7, '2023-09-14', 20.25, 'Bank Transfer', 'Autumn Term'),
(8, 8, '2023-09-17', 45.00, 'Online Payment', 'Autumn Term'),
(9, 9, '2023-09-15', 17.75, 'Cash', 'Autumn Term'),
(10, 10, '2023-09-16', 50.00, 'Bank Transfer', 'Autumn Term'),
(11, 11, '2023-09-14', 25.50, 'Online Payment', 'Autumn Term'),
(12, 12, '2023-09-17', 22.25, 'Cash', 'Autumn Term'),
(13, 13, '2023-09-15', 30.00, 'Bank Transfer', 'Autumn Term'),
(14, 14, '2023-09-16', 35.50, 'Online Payment', 'Autumn Term'),
(15, 15, '2023-09-14', 20.75, 'Cash', 'Autumn Term'),
(16, 16, '2023-09-17', 45.25, 'Bank Transfer', 'Autumn Term'),
(17, 17, '2023-09-15', 25.00, 'Online Payment', 'Autumn Term'),
(18, 18, '2023-09-16', 40.00, 'Cash', 'Autumn Term'),
(19, 19, '2023-09-14', 30.50, 'Bank Transfer', 'Autumn Term'),
(20, 20, '2023-09-17', 35.75, 'Online Payment', 'Autumn Term'),
(21, 21, '2024-03-15', 20.00, 'Bank Transfer', 'Spring Term');

-- --------------------------------------------------------

--
-- Table structure for table `library_book`
--

CREATE TABLE `library_book` (
  `book_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(100) NOT NULL,
  `isbn` varchar(50) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `available` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `library_book`
--

INSERT INTO `library_book` (`book_id`, `title`, `author`, `isbn`, `category`, `available`) VALUES
(1, 'The Chocolate Touch', 'Patrick Skene Catling', '978-0688160760', 'Children\'s Fiction', 1),
(2, 'Matilda', 'Roald Dahl', '978-0142410356', 'Children\'s Fiction', 1),
(3, 'The Magic Tree House', 'Mary Pope Osborne', '978-0375868368', 'Adventure', 1),
(4, 'Charlotte\'s Web', 'E.B. White', '978-0062658753', 'Classic', 1),
(5, 'Harry Potter and the Philosopher\'s Stone', 'J.K. Rowling', '978-0747532743', 'Fantasy', 1),
(6, 'The BFG', 'Roald Dahl', '978-0142410387', 'Children\'s Fiction', 1),
(7, 'Wonder', 'R.J. Palacio', '978-0375869020', 'Contemporary', 1),
(8, 'Diary of a Wimpy Kid', 'Jeff Kinney', '978-0141324906', 'Humor', 1),
(9, 'The Wild Robot', 'Peter Brown', '978-0316381994', 'Science Fiction', 1),
(10, 'Holes', 'Louis Sachar', '978-0374300130', 'Adventure', 1);

-- --------------------------------------------------------

--
-- Table structure for table `library_loan`
--

CREATE TABLE `library_loan` (
  `loan_id` int(11) NOT NULL,
  `pupil_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `borrow_date` date NOT NULL,
  `due_date` date NOT NULL,
  `return_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `library_loan`
--

INSERT INTO `library_loan` (`loan_id`, `pupil_id`, `book_id`, `borrow_date`, `due_date`, `return_date`) VALUES
(1, 1, 1, '2023-09-10', '2023-09-24', NULL),
(2, 2, 2, '2023-09-11', '2023-09-25', NULL),
(3, 3, 3, '2023-09-12', '2023-09-26', NULL),
(4, 4, 4, '2023-09-13', '2023-09-27', NULL),
(5, 5, 5, '2023-09-14', '2023-09-28', NULL),
(6, 6, 6, '2023-09-15', '2023-09-29', NULL),
(7, 7, 7, '2023-09-16', '2023-09-30', NULL),
(8, 8, 8, '2023-09-17', '2023-10-01', NULL),
(9, 9, 9, '2023-09-18', '2023-10-02', NULL),
(10, 10, 10, '2023-09-19', '2023-10-03', NULL),
(11, 21, 3, '2024-03-20', '2024-04-03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `parent_guardian`
--

CREATE TABLE `parent_guardian` (
  `parent_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `relationship_to_pupil` varchar(50) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `postcode` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `primary_contact` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parent_guardian`
--

INSERT INTO `parent_guardian` (`parent_id`, `first_name`, `last_name`, `relationship_to_pupil`, `address`, `postcode`, `email`, `phone_number`, `primary_contact`) VALUES
(1, 'Sarah', 'Thompson', 'Mother', 'Margherita Manor', 'M1 2AB', 'sarah.thompson@email.com', '07911 123456', 1),
(2, 'David', 'Thompson', 'Father', 'Margherita Manor', 'M1 2AB', 'david.thompson@email.com', '07911 654321', 0),
(3, 'Mai', 'Nguyen', 'Mother', 'California Roll Close', 'M1 3CD', 'mai.nguyen@email.com', '07922 234567', 1),
(4, 'Liam', 'Nguyen', 'Father', 'California Roll Close', 'M1 3CD', 'liam.nguyen@email.com', '07922 765432', 0),
(5, 'Anna', 'Kowalski', 'Mother', 'Waffle Wonderland', 'M2 4EF', 'anna.kowalski@email.com', '07933 345678', 1),
(6, 'Thomas', 'Kowalski', 'Father', 'Waffle Wonderland', 'M2 4EF', 'thomas.kowalski@email.com', '07933 876543', 0),
(7, 'Elena', 'Ramirez', 'Mother', 'Kebab Kingdom Court', 'M2 5GH', 'elena.ramirez@email.com', '07944 456789', 1),
(8, 'Carlos', 'Ramirez', 'Father', 'Kebab Kingdom Court', 'M2 5GH', 'carlos.ramirez@email.com', '07944 987654', 0),
(9, 'Yuki', 'Suzuki', 'Mother', 'Risotto Royal Estate', 'M3 6JK', 'yuki.suzuki@email.com', '07955 567890', 1),
(10, 'Hiroshi', 'Suzuki', 'Father', 'Risotto Royal Estate', 'M3 6JK', 'hiroshi.suzuki@email.com', '07955 098765', 0),
(11, 'Sophie', 'Müller', 'Mother', 'Strudel Street House', 'M3 7LM', 'sophie.muller@email.com', '07966 678901', 1),
(12, 'Klaus', 'Müller', 'Father', 'Strudel Street House', 'M3 7LM', 'klaus.muller@email.com', '07966 210987', 0),
(13, 'Maria', 'Petrov', 'Mother', 'Tempura Towers', 'M4 8NP', 'maria.petrov@email.com', '07977 789012', 1),
(14, 'Ivan', 'Petrov', 'Father', 'Tempura Towers', 'M4 8NP', 'ivan.petrov@email.com', '07977 321098', 0),
(15, 'Ingrid', 'Andersen', 'Mother', 'Paella Palace', 'M4 9QR', 'ingrid.andersen@email.com', '07988 890123', 1),
(16, 'Erik', 'Andersen', 'Father', 'Paella Palace', 'M4 9QR', 'erik.andersen@email.com', '07988 432109', 0),
(17, 'Akiko', 'Nakamura', 'Mother', 'Smoothie Sanctuary', 'M5 1ST', 'akiko.nakamura@email.com', '07999 901234', 1),
(18, 'Kenji', 'Nakamura', 'Father', 'Smoothie Sanctuary', 'M5 1ST', 'kenji.nakamura@email.com', '07999 543210', 0),
(19, 'Elena', 'Gomez', 'Mother', 'Baguette Boulevard Residence', 'M5 2UV', 'elena.gomez@email.com', '07910 012345', 1),
(20, 'Miguel', 'Gomez', 'Father', 'Baguette Boulevard Residence', 'M5 2UV', 'miguel.gomez@email.com', '07910 654321', 0),
(21, 'Sarah', 'Grey', 'Mother', '67 Shamrock Road', 'M12 5CC', 'sarah.grey@email.com', '07700 987654', 1);

-- --------------------------------------------------------

--
-- Table structure for table `parent_user`
--

CREATE TABLE `parent_user` (
  `user_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parent_user`
--

INSERT INTO `parent_user` (`user_id`, `parent_id`, `username`, `password_hash`, `email`, `role`, `last_login`, `is_active`) VALUES
(1, 1, 'sarah.thompson', '$2y$10$randomparenthash1', 'sarah.thompson@email.com', 'Parent', NULL, 1),
(2, 2, 'david.thompson', '$2y$10$randomparenthash2', 'david.thompson@email.com', 'Parent', NULL, 1),
(3, 3, 'mai.nguyen', '$2y$10$randomparenthash3', 'mai.nguyen@email.com', 'Parent', NULL, 1),
(4, 4, 'liam.nguyen', '$2y$10$randomparenthash4', 'liam.nguyen@email.com', 'Parent', NULL, 1),
(5, 5, 'anna.kowalski', '$2y$10$randomparenthash5', 'anna.kowalski@email.com', 'Parent', NULL, 1),
(6, 6, 'thomas.kowalski', '$2y$10$randomparenthash6', 'thomas.kowalski@email.com', 'Parent', NULL, 1),
(7, 7, 'elena.ramirez', '$2y$10$randomparenthash7', 'elena.ramirez@email.com', 'Parent', NULL, 1),
(8, 8, 'carlos.ramirez', '$2y$10$randomparenthash8', 'carlos.ramirez@email.com', 'Parent', NULL, 1),
(9, 9, 'yuki.suzuki', '$2y$10$randomparenthash9', 'yuki.suzuki@email.com', 'Parent', NULL, 1),
(10, 10, 'hiroshi.suzuki', '$2y$10$randomparenthash10', 'hiroshi.suzuki@email.com', 'Parent', NULL, 1),
(11, 11, 'sophie.muller', '$2y$10$randomparenthash11', 'sophie.muller@email.com', 'Parent', NULL, 1),
(12, 12, 'klaus.muller', '$2y$10$randomparenthash12', 'klaus.muller@email.com', 'Parent', NULL, 1),
(13, 13, 'maria.petrov', '$2y$10$randomparenthash13', 'maria.petrov@email.com', 'Parent', NULL, 1),
(14, 14, 'ivan.petrov', '$2y$10$randomparenthash14', 'ivan.petrov@email.com', 'Parent', NULL, 1),
(15, 15, 'ingrid.andersen', '$2y$10$randomparenthash15', 'ingrid.andersen@email.com', 'Parent', NULL, 1),
(16, 16, 'erik.andersen', '$2y$10$randomparenthash16', 'erik.andersen@email.com', 'Parent', NULL, 1),
(17, 17, 'akiko.nakamura', '$2y$10$randomparenthash17', 'akiko.nakamura@email.com', 'Parent', NULL, 1),
(18, 18, 'kenji.nakamura', '$2y$10$randomparenthash18', 'kenji.nakamura@email.com', 'Parent', NULL, 1),
(19, 19, 'elena.gomez', '$2y$10$randomparenthash19', 'elena.gomez@email.com', 'Parent', NULL, 1),
(20, 20, 'miguel.gomez', '$2y$10$randomparenthash20', 'miguel.gomez@email.com', 'Parent', NULL, 1),
(21, 21, 'sarah.grey', 'test123', 'sarah.grey@email.com', 'Parent', '2025-04-08 09:21:43', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pupil`
--

CREATE TABLE `pupil` (
  `pupil_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `postcode` varchar(20) NOT NULL,
  `medical_info` text DEFAULT NULL,
  `enrollment_date` date NOT NULL,
  `gender` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pupil`
--

INSERT INTO `pupil` (`pupil_id`, `class_id`, `first_name`, `last_name`, `date_of_birth`, `address`, `postcode`, `medical_info`, `enrollment_date`, `gender`) VALUES
(1, 1, 'Lily', 'Thompson', '2018-06-12', 'Pepperoni Plaza', 'M1 2AB', 'Mild peanut allergy', '2023-09-01', 'Female'),
(2, 1, 'Oliver', 'Nguyen', '2018-09-23', 'Noodle Nest Lane', 'M1 3CD', 'Asthma, carries inhaler', '2023-09-01', 'Male'),
(3, 2, 'Emma', 'Kowalski', '2017-03-15', 'Waffle Wonder Road', 'M2 4EF', 'No known medical conditions', '2023-09-01', 'Female'),
(4, 2, 'Ethan', 'Ramirez', '2017-07-08', 'Kebab Kingdom Street', 'M2 5GH', 'Wears glasses', '2023-09-01', 'Male'),
(5, 3, 'Isabella', 'Suzuki', '2016-11-20', 'Risotto Retreat', 'M3 6JK', 'Lactose intolerant', '2023-09-01', 'Female'),
(6, 3, 'Noah', 'Müller', '2016-05-14', 'Strudel Street', 'M3 7LM', 'No known medical conditions', '2023-09-01', 'Male'),
(7, 4, 'Sophia', 'Petrov', '2015-08-30', 'Tempura Terrace', 'M4 8NP', 'Epilepsy, managed with medication', '2023-09-01', 'Female'),
(8, 4, 'Lucas', 'Andersen', '2015-02-17', 'Paella Path', 'M4 9QR', 'Wears hearing aid', '2023-09-01', 'Male'),
(9, 5, 'Ava', 'Nakamura', '2014-12-05', 'Smoothie Square', 'M5 1ST', 'Diabetes, insulin dependent', '2023-09-01', 'Female'),
(10, 5, 'Mason', 'Gomez', '2014-06-22', 'Baguette Boulevard', 'M5 2UV', 'No known medical conditions', '2023-09-01', 'Male'),
(11, 6, 'Mia', 'Hoffmann', '2013-09-11', 'Ramen Road', 'M6 3WX', 'Severe bee sting allergy', '2023-09-01', 'Female'),
(12, 6, 'Alexander', 'Kim', '2013-03-28', 'Chorizo Close', 'M6 4YZ', 'Wears glasses', '2023-09-01', 'Male'),
(13, 7, 'Charlotte', 'Rossi', '2012-07-16', 'Croissant Crescent', 'M7 5AB', 'No known medical conditions', '2023-09-01', 'Female'),
(14, 7, 'Benjamin', 'Larsson', '2012-01-09', 'Sashimi Street', 'M7 6CD', 'Mild asthma', '2023-09-01', 'Male'),
(15, 1, 'Grace', 'Martinez', '2018-04-03', 'Tiramisu Terrace', 'M1 7EF', 'No known medical conditions', '2023-09-01', 'Female'),
(16, 2, 'Leo', 'Ivanov', '2017-10-19', 'Falafel Lane', 'M2 8GH', 'Requires EpiPen', '2023-09-01', 'Male'),
(17, 3, 'Zoe', 'Wang', '2016-08-07', 'Gelato Grove', 'M3 9JK', 'Wears glasses', '2023-09-01', 'Female'),
(18, 4, 'Jack', 'Singh', '2015-05-26', 'Pho Passage', 'M4 1LM', 'No known medical conditions', '2023-09-01', 'Male'),
(19, 5, 'Aria', 'Garcia', '2014-11-14', 'Cannoli Court', 'M5 2NP', 'Mild food allergies', '2023-09-01', 'Female'),
(20, 6, 'Ryan', 'Dubois', '2013-07-02', 'Mochi Meadows', 'M6 3QR', 'Uses an inhaler', '2023-09-01', 'Male'),
(21, 8, 'Cillian', 'Grey', '2017-04-22', '67 Shamrock Road', 'M12 5CC', 'Mild nut allergy', '2023-09-01', 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `pupil_parent`
--

CREATE TABLE `pupil_parent` (
  `pupil_parent_id` int(11) NOT NULL,
  `pupil_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pupil_parent`
--

INSERT INTO `pupil_parent` (`pupil_parent_id`, `pupil_id`, `parent_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 3),
(4, 2, 4),
(5, 3, 5),
(6, 3, 6),
(7, 4, 7),
(8, 4, 8),
(9, 5, 9),
(10, 5, 10),
(11, 6, 11),
(12, 6, 12),
(13, 7, 13),
(14, 7, 14),
(15, 8, 15),
(16, 8, 16),
(17, 9, 17),
(18, 9, 18),
(19, 10, 19),
(20, 10, 20),
(21, 21, 21);

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE `salary` (
  `salary_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `annual_amount` decimal(10,2) NOT NULL,
  `pay_scale` varchar(50) DEFAULT NULL,
  `effective_from` date NOT NULL,
  `effective_to` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salary`
--

INSERT INTO `salary` (`salary_id`, `teacher_id`, `annual_amount`, `pay_scale`, `effective_from`, `effective_to`) VALUES
(1, 1, 35000.00, 'Main Pay Scale', '2023-09-01', NULL),
(2, 2, 42000.00, 'Upper Pay Scale', '2023-09-01', NULL),
(3, 3, 38000.00, 'Main Pay Scale', '2023-09-01', NULL),
(4, 4, 36000.00, 'Main Pay Scale', '2023-09-01', NULL),
(5, 5, 33000.00, 'Main Pay Scale', '2023-09-01', NULL),
(6, 6, 45000.00, 'Leadership Scale', '2023-09-01', NULL),
(7, 7, 37000.00, 'Main Pay Scale', '2023-09-01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `teacher_id` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `postcode` varchar(20) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `employment_start_date` date NOT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `background_check_date` date NOT NULL,
  `annual_salary` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacher_id`, `class_id`, `first_name`, `last_name`, `address`, `postcode`, `phone_number`, `email`, `date_of_birth`, `employment_start_date`, `specialization`, `background_check_date`, `annual_salary`) VALUES
(1, 1, 'Emily', 'Hartwell', 'Pizza Slice Lane', 'M1 2AB', '07700 900123', 'emily.hartwell@stalphonsus.edu', '1985-03-15', '2015-09-01', 'Early Years Education', '2023-08-15', 45000.00),
(2, 2, 'Michael', 'Rodriguez', 'Burger King Road', 'M2 3CD', '07700 900456', 'michael.rodriguez@stalphonsus.edu', '1979-11-22', '2012-09-01', 'Primary Mathematics', '2023-08-15', 52000.00),
(3, 3, 'Sophie', 'Chen', 'Sushi Roll Street', 'M3 4EF', '07700 900789', 'sophie.chen@stalphonsus.edu', '1988-07-10', '2018-09-01', 'Science Specialist', '2023-08-15', 48000.00),
(4, 4, 'David', 'Okonkwo', 'Taco Avenue', 'M4 5GH', '07700 901234', 'david.okonkwo@stalphonsus.edu', '1982-05-18', '2016-09-01', 'Physical Education', '2023-08-15', 37000.00),
(5, 5, 'Amelia', 'Patel', 'Curry House Close', 'M5 6JK', '07700 901567', 'amelia.patel@stalphonsus.edu', '1990-01-25', '2020-09-01', 'Art and Design', '2023-08-15', 33000.00),
(6, 6, 'James', 'McKenzie', 'Pasta Palazzo Drive', 'M6 7LM', '07700 901890', 'james.mckenzie@stalphonsus.edu', '1975-09-05', '2010-09-01', 'English Literature', '2023-08-15', 49000.00),
(7, 7, 'Olivia', 'Fernandez', 'Dim Sum Court', 'M7 8NP', '07700 902123', 'olivia.fernandez@stalphonsus.edu', '1986-12-30', '2017-09-01', 'Music Education', '2023-08-15', 37000.00),
(8, 8, 'John', 'Willis', '123 Main Street', 'M10 1AA', '07700 123456', 'john.willis@stalphonsus.edu', '1980-05-15', '2020-09-01', 'Computer Science', '2023-08-15', 38000.00);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_user`
--

CREATE TABLE `teacher_user` (
  `user_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_user`
--

INSERT INTO `teacher_user` (`user_id`, `teacher_id`, `username`, `password_hash`, `email`, `role`, `last_login`, `is_active`) VALUES
(1, 1, 'emily.h', '$2y$10$randomhashvalue1', 'emily.hartwell@stalphonsus.edu', 'Class Teacher', '2025-04-08 00:34:36', 1),
(2, 2, 'michael.r', '$2y$10$randomhashvalue2', 'michael.rodriguez@stalphonsus.edu', 'Mathematics Coordinator', NULL, 1),
(3, 3, 'sophie.c', '$2y$10$randomhashvalue3', 'sophie.chen@stalphonsus.edu', 'Science Lead', NULL, 1),
(4, 4, 'david.o', '$2y$10$randomhashvalue4', 'david.okonkwo@stalphonsus.edu', 'PE Instructor', NULL, 1),
(5, 5, 'amelia.p', '$2y$10$randomhashvalue5', 'amelia.patel@stalphonsus.edu', 'Art Teacher', NULL, 1),
(6, 6, 'james.m', '$2y$10$randomhashvalue6', 'james.mckenzie@stalphonsus.edu', 'English Lead', NULL, 1),
(7, 7, 'olivia.f', '$2y$10$randomhashvalue7', 'olivia.fernandez@stalphonsus.edu', 'Music Instructor', NULL, 1),
(8, 8, 'john.willis', 'test123', 'john.willis@stalphonsus.edu', 'IT Teacher', '2025-04-08 10:07:53', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `pupil_id` (`pupil_id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `dinner_account`
--
ALTER TABLE `dinner_account`
  ADD PRIMARY KEY (`account_id`),
  ADD KEY `pupil_id` (`pupil_id`);

--
-- Indexes for table `dinner_payment`
--
ALTER TABLE `dinner_payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `library_book`
--
ALTER TABLE `library_book`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `library_loan`
--
ALTER TABLE `library_loan`
  ADD PRIMARY KEY (`loan_id`),
  ADD KEY `pupil_id` (`pupil_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `parent_guardian`
--
ALTER TABLE `parent_guardian`
  ADD PRIMARY KEY (`parent_id`);

--
-- Indexes for table `parent_user`
--
ALTER TABLE `parent_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `parent_id` (`parent_id`);

--
-- Indexes for table `pupil`
--
ALTER TABLE `pupil`
  ADD PRIMARY KEY (`pupil_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `pupil_parent`
--
ALTER TABLE `pupil_parent`
  ADD PRIMARY KEY (`pupil_parent_id`),
  ADD KEY `pupil_id` (`pupil_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`salary_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacher_id`),
  ADD UNIQUE KEY `class_id` (`class_id`);

--
-- Indexes for table `teacher_user`
--
ALTER TABLE `teacher_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `teacher_id` (`teacher_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `dinner_account`
--
ALTER TABLE `dinner_account`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `dinner_payment`
--
ALTER TABLE `dinner_payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `library_book`
--
ALTER TABLE `library_book`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `library_loan`
--
ALTER TABLE `library_loan`
  MODIFY `loan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `parent_guardian`
--
ALTER TABLE `parent_guardian`
  MODIFY `parent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `parent_user`
--
ALTER TABLE `parent_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `pupil`
--
ALTER TABLE `pupil`
  MODIFY `pupil_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `pupil_parent`
--
ALTER TABLE `pupil_parent`
  MODIFY `pupil_parent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `salary`
--
ALTER TABLE `salary`
  MODIFY `salary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `teacher_user`
--
ALTER TABLE `teacher_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`pupil_id`) REFERENCES `pupil` (`pupil_id`);

--
-- Constraints for table `dinner_account`
--
ALTER TABLE `dinner_account`
  ADD CONSTRAINT `dinner_account_ibfk_1` FOREIGN KEY (`pupil_id`) REFERENCES `pupil` (`pupil_id`);

--
-- Constraints for table `dinner_payment`
--
ALTER TABLE `dinner_payment`
  ADD CONSTRAINT `dinner_payment_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `dinner_account` (`account_id`);

--
-- Constraints for table `library_loan`
--
ALTER TABLE `library_loan`
  ADD CONSTRAINT `library_loan_ibfk_1` FOREIGN KEY (`pupil_id`) REFERENCES `pupil` (`pupil_id`),
  ADD CONSTRAINT `library_loan_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `library_book` (`book_id`);

--
-- Constraints for table `parent_user`
--
ALTER TABLE `parent_user`
  ADD CONSTRAINT `parent_user_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `parent_guardian` (`parent_id`);

--
-- Constraints for table `pupil`
--
ALTER TABLE `pupil`
  ADD CONSTRAINT `pupil_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`);

--
-- Constraints for table `pupil_parent`
--
ALTER TABLE `pupil_parent`
  ADD CONSTRAINT `pupil_parent_ibfk_1` FOREIGN KEY (`pupil_id`) REFERENCES `pupil` (`pupil_id`),
  ADD CONSTRAINT `pupil_parent_ibfk_2` FOREIGN KEY (`parent_id`) REFERENCES `parent_guardian` (`parent_id`);

--
-- Constraints for table `salary`
--
ALTER TABLE `salary`
  ADD CONSTRAINT `salary_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`);

--
-- Constraints for table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `teacher_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`);

--
-- Constraints for table `teacher_user`
--
ALTER TABLE `teacher_user`
  ADD CONSTRAINT `teacher_user_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
