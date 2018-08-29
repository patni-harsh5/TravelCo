-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 07, 2018 at 04:09 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `survey_db_2018`
--
CREATE DATABASE IF NOT EXISTS `survey_db_2018` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `survey_db_2018`;

-- --------------------------------------------------------

--
-- Table structure for table `airbus`
--

CREATE TABLE `airbus` (
  `airbus_id` int(6) NOT NULL,
  `capacity_eco` int(3) NOT NULL,
  `capacity_first` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `airbus`
--

INSERT INTO `airbus` (`airbus_id`, `capacity_eco`, `capacity_first`) VALUES
(737, 144, 16),
(757, 179, 20),
(767, 175, 36);

-- --------------------------------------------------------

--
-- Table structure for table `airlines`
--

CREATE TABLE `airlines` (
  `airline_id` int(10) NOT NULL,
  `airline_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `airlines`
--

INSERT INTO `airlines` (`airline_id`, `airline_name`) VALUES
(1, 'Delta'),
(2, 'United'),
(3, 'Southwest'),
(4, 'Frontier');

-- --------------------------------------------------------

--
-- Table structure for table `airport_detail`
--

CREATE TABLE `airport_detail` (
  `airport_id` varchar(3) NOT NULL,
  `city` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `airport_detail`
--

INSERT INTO `airport_detail` (`airport_id`, `city`, `name`) VALUES
('AUS', 'Austin', 'Austin Bergstrom International'),
('HNL', 'Honolulu', 'Daniel K. Inouye International'),
('IAD', 'Washington D.C.', 'Washington Dulles International'),
('IAH', 'Houston', 'Bush Intercontinental'),
('JFK', 'New York', 'John F. Kennedy International '),
('LAS', 'Las Vegas', 'McCarran International'),
('LAX', 'Los Angeles', 'Los Angeles International'),
('LHR', 'London', 'London Heathrow'),
('MDW', 'Chicago', 'Midway International'),
('PDX', 'Portland', 'Portland International'),
('PIT', 'Pittsburgh', 'Pittsburgh International'),
('TPA', 'Tampa', 'Tampa International');

-- --------------------------------------------------------

--
-- Table structure for table `cabin_type`
--

CREATE TABLE `cabin_type` (
  `cabin_type_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cabin_type`
--

INSERT INTO `cabin_type` (`cabin_type_id`) VALUES
('economy'),
('first');

-- --------------------------------------------------------

--
-- Table structure for table `creditcard`
--

CREATE TABLE `creditcard` (
  `creditcard` varchar(19) NOT NULL,
  `creditcard_type` varchar(20) NOT NULL,
  `CVC` int(3) NOT NULL,
  `Exp_date` varchar(5) NOT NULL,
  `user_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `creditcard`
--

INSERT INTO `creditcard` (`creditcard`, `creditcard_type`, `CVC`, `Exp_date`, `user_id`) VALUES
('0000-0000-0000-0000', 'visa', 111, '02/25', 'estewart'),
('4102356212365498', 'Mastercard', 123, '10/22', 'JKFen'),
('5987066145623215', 'Visa', 321, '09/21', 'z_l24');

-- --------------------------------------------------------

--
-- Table structure for table `deals`
--

CREATE TABLE `deals` (
  `deal_id` int(10) NOT NULL,
  `hotel_avail_id` int(10) DEFAULT NULL,
  `dept_flight_id` int(10) DEFAULT NULL,
  `return_flight_id` int(10) NOT NULL,
  `deal_price` int(6) NOT NULL,
  `deal_mileage` int(11) NOT NULL,
  `begin_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `dept_airport` varchar(3) DEFAULT NULL,
  `arr_airport` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deals`
--

INSERT INTO `deals` (`deal_id`, `hotel_avail_id`, `dept_flight_id`, `return_flight_id`, `deal_price`, `deal_mileage`, `begin_date`, `end_date`, `dept_airport`, `arr_airport`) VALUES
(1, 1, 7, 15, 941, 17500, '2018-09-02', '2018-09-07', 'LAS', 'AUS'),
(2, 3, 6, 7, 546, 17500, '2018-08-30', '2018-09-02', 'AUS', 'LAS'),
(3, 5, 2, 22, 2415, 17500, '2018-09-21', '2018-10-01', 'LAX', 'HNL'),
(4, 6, 13, 17, 4200, 24500, '2018-11-01', '2018-11-16', 'AUS', 'LHR'),
(5, 4, 6, 7, 560, 17500, '2018-08-30', '2018-09-02', 'AUS', 'LAS'),
(6, 7, 7, 15, 1029, 17500, '2018-09-02', '2018-09-07', 'LAS', 'AUS'),
(7, 5, 5, 18, 4060, 17500, '2018-10-19', '2018-10-29', 'IAH', 'HNL');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(10) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `comments` text,
  `rating` int(2) NOT NULL,
  `trips_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `user_id`, `comments`, `rating`, `trips_id`) VALUES
(1, 'estewart', 'This website is awesome!', 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `flights`
--

CREATE TABLE `flights` (
  `flight_id` int(10) NOT NULL,
  `flight_no` int(10) NOT NULL,
  `airbus_id` int(10) NOT NULL,
  `route_desc` text NOT NULL,
  `dept_date` date NOT NULL,
  `arrival_date` date DEFAULT NULL,
  `dept_time` time NOT NULL,
  `arrival_time` time DEFAULT NULL,
  `journey_hr` int(6) NOT NULL,
  `cabin_type` varchar(10) NOT NULL,
  `fare_dollars` int(10) NOT NULL,
  `fare_mileage` int(10) NOT NULL,
  `dept_airport` varchar(3) NOT NULL,
  `arr_airport` varchar(3) NOT NULL,
  `distance` int(6) NOT NULL,
  `airline_id` int(10) NOT NULL,
  `flight_status_id` varchar(20) DEFAULT NULL,
  `remaining_seats` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `flights`
--

INSERT INTO `flights` (`flight_id`, `flight_no`, `airbus_id`, `route_desc`, `dept_date`, `arrival_date`, `dept_time`, `arrival_time`, `journey_hr`, `cabin_type`, `fare_dollars`, `fare_mileage`, `dept_airport`, `arr_airport`, `distance`, `airline_id`, `flight_status_id`, `remaining_seats`) VALUES
(1 , 251, 737, 'Austin to Houston.', '2018-08-23', '2018-08-23', '07:00:00', '08:00:00', 1, 'economy', 250, 25000, 'AUS', 'IAH', 200, 1, 'delayed', 10),
(2 , 554, 757, 'Los Angeles to Honolulu. ', '2018-09-21', '2018-09-21', '12:00:00', '16:00:00', 4, 'economy', 600, 25000, 'LAX', 'HNL', 2500, 2, 'on time', 19),
(3 , 554, 757, 'Los Angeles to Honolulu. ', '2018-09-21', '2018-09-21', '12:00:00', '16:00:00', 4, 'first', 1200, 25000, 'LAX', 'HNL', 2500, 2, 'on time', 10),
(4 , 655, 767, 'Houston to Honolulu.', '2018-10-19', '2018-10-19', '10:00:00', '17:00:00', 7, 'economy', 500, 25000, 'IAH', 'HNL', 3895, 2, 'on time', 23),
(5 , 655, 767, 'Houston to Honolulu.', '2018-10-19', '2018-10-19', '10:00:00', '17:00:00', 7, 'first', 1800, 25000, 'IAH', 'HNL', 3895, 2, 'on time', 10),
(6 , 234, 737, 'Austin to Las Vegas.', '2018-08-30', '2018-08-31', '23:00:00', '01:00:00', 2, 'economy', 250, 25000, 'AUS', 'LAS', 1400, 4, 'on time', 31),
(7 , 236, 737, 'Las Vegas to Austin.', '2018-09-02', '2018-09-02', '15:06:00', '17:06:00', 2, 'economy', 250, 25000, 'LAS', 'AUS', 1400, 4, 'on time', 22),
(8 , 330, 737, 'Las Vegas to Austin.', '2018-09-02', '2018-09-02', '15:06:00', '17:06:00', 2, 'economy', 250, 25000, 'LAS', 'AUS', 1400, 3, 'on time', 22),
(9 , 661, 767, 'Houston to Honolulu.', '2018-10-19', '2018-10-20', '19:00:00', '05:00:00', 10, 'economy', 600, 25000, 'IAH', 'HNL', 3895, 2, 'on time', 18),
(10 , 666, 767, 'Houston to Honolulu.', '2018-12-07', '2018-12-07', '09:00:00', '16:00:00', 7, 'economy', 800, 25000, 'IAH', 'HNL', 3895, 2, 'on time', 19),
(11 , 231, 737, 'Las Vegas to Austin.', '2018-10-01', '2018-10-01', '11:06:00', '13:06:00', 2, 'economy', 250, 25000, 'LAS', 'AUS', 1400, 1, 'on time', 14),
(12 , 228, 737, 'Las Vegas to Austin.', '2018-11-12', '2018-11-12', '23:30:00', '01:30:00', 2, 'economy', 220, 25000, 'LAS', 'AUS', 1400, 4, 'on time', 23),
(13 , 229, 767, 'Austin to London.', '2018-11-01', '2018-11-02', '15:15:00', '01:15:00', 10, 'economy', 1000, 50000, 'AUS', 'LHR', 4900, 1, 'on time', 32),
(14 , 333, 737, 'Las Vegas to Austin.', '2018-09-02', '2018-09-02', '17:06:00', '19:06:00', 2, 'economy', 240, 25000, 'LAS', 'AUS', 2800, 4, 'on time', 26),
(15 , 334, 737, 'Austin to Las Vegas', '2018-09-07', '2018-09-07', '11:06:00', '13:06:00', 2, 'economy', 220, 25000, 'AUS', 'LAS', 1400, 4, 'on time', 28),
(16 , 298, 737, 'Las Vegas to Austin', '2018-09-11', '2018-09-11', '05:00:00', '07:00:00', 2, 'economy', 230, 25000, 'LAS', 'AUS', 1400, 4, 'on time', 17),
(17, 230, 767, 'London to Austin.', '2018-11-14', '2018-11-14', '05:15:00', '15:15:00', 10, 'economy', 1000, 50000, 'LHR', 'AUS', 4900, 1, 'on time', 11),
(18, 659, 767, 'Honolulu to Houston', '2018-10-29', '2018-10-29', '10:00:00', '17:00:00', 7, 'first', 1800, 25000, 'HNL', 'IAH', 3895, 2, 'on time', 10),
(19, 659, 767, 'Honolulu to Houston', '2018-10-29', '2018-10-29', '10:00:00', '17:00:00', 7, 'economy', 850, 25000, 'HNL', 'IAH', 3895, 2, 'on time', 26),
(20, 400, 737, 'Austin to Las Vegas.', '2018-08-30', '2018-08-30', '09:00:00', '11:00:00', 2, 'economy', 260, 25000, 'AUS', 'LAS', 1400, 3, 'on time', 26),
(21, 525, 757, 'Honolulu to Las Angeles.', '2018-09-29', '2018-09-29', '14:00:00', '18:00:00', 4, 'first', 1200, 25000, 'LAX', 'HNL', 2500, 2, 'on time', 10),
(22, 525, 757, 'Honolulu to Las Angeles.', '2018-09-29', '2018-09-29', '14:00:00', '18:00:00', 4, 'economy', 600, 25000, 'LAX', 'HNL', 2500, 2, 'on time', 11);

-- --------------------------------------------------------

--
-- Table structure for table `flight_booking`
--

CREATE TABLE `flight_booking` (
  `fbook_id` int(10) NOT NULL,
  `dept_flight_id` int(5) NOT NULL,
  `return_flight_id` int(10),
  `trans_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `flight_booking`
--

INSERT INTO `flight_booking` (`fbook_id`, `dept_flight_id`, `return_flight_id`, `trans_id`) VALUES
(1, 2, 21, 1),
(2, 6, 7, 2),
(3, 8, 17, 3),
(4, 3, 20, 4);

-- --------------------------------------------------------

--
-- Table structure for table `flight_status`
--

CREATE TABLE `flight_status` (
  `flight_status_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `flight_status`
--

INSERT INTO `flight_status` (`flight_status_id`) VALUES
('arrived'),
('canceled'),
('delayed'),
('in flight'),
('on time');

-- --------------------------------------------------------

--
-- Table structure for table `flight_transacations`
--

CREATE TABLE `flight_transacations` (
  `trans_id` int(10) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `creditcard` varchar(19) NOT NULL,
  `amount` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `flight_transacations`
--

INSERT INTO `flight_transacations` (`trans_id`, `user_id`, `creditcard`, `amount`) VALUES
(1, 'estewart', '0000-0000-0000-0000', 600),
(2, 'JKFen', '4102356212365498', 386),
(3, 'z_l24', '5987066145623215', 278),
(4, 'JKFen', '4102356212365498', 502);

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `hotel_id` int(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `address` varchar(50) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `capacity` int(5) NOT NULL,
  `star` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`hotel_id`, `name`, `address`, `phone`, `capacity`, `star`) VALUES
(1, 'Holiday Inn', 'Austin, TX', '512-123-4567', 500, 3),
(2, 'Hilton', 'Houston, TX', '713-724-5555', 600, 3),
(3, 'Mandalay Bay', 'Las Vegas, NV', '702-565-9871', 1000, 4),
(4, 'MGM Grand', 'Las Vegas, NV', '702-336-2541', 1200, 5),
(5, 'Motel 6', 'Tampa, FL', '813-623-6987', 250, 2),
(6, 'W', 'Los Angeles, CA', '213-952-6541', 450, 4),
(7, 'Best Western', 'Honolulu, HI', '965-321-5422', 550, 3),
(8, 'Marriott of London', 'London, England', '442071231234', 450, 4);

-- --------------------------------------------------------

--
-- Table structure for table `hotel_availibility`
--

CREATE TABLE `hotel_availibility` (
  `hotel_avail_id` int(10) NOT NULL,
  `hotel_id` int(10) NOT NULL,
  `room_id` varchar(10) NOT NULL,
  `price` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hotel_availibility`
--

INSERT INTO `hotel_availibility` (`hotel_avail_id`, `hotel_id`, `room_id`, `price`) VALUES
(1, 1, '2-Queen', 175),
(2, 2, '1-King', 150),
(3, 3, '2-Full', 140),
(4, 4, '1-Queen', 150),
(5, 7, '1-Queen', 225),
(6, 8, '1-King', 250),
(7, 7, '1-King', 250);

-- --------------------------------------------------------

--
-- Table structure for table `hotel_bookings`
--

CREATE TABLE `hotel_bookings` (
  `hbook_id` int(10) NOT NULL,
  `htrans_id` int(10) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `hotel_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hotel_bookings`
--

INSERT INTO `hotel_bookings` (`hbook_id`, `htrans_id`, `check_in`, `check_out`, `hotel_id`) VALUES
(1, 1, '2018-09-21', '2018-09-29', 1),
(2, 3, '2018-10-01', '2018-10-04', 1),
(3, 4, '2018-09-21', '2018-10-01', 7);

-- --------------------------------------------------------

--
-- Table structure for table `hotel_transactions`
--

CREATE TABLE `hotel_transactions` (
  `htrans_id` int(10) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `creditcard` varchar(19) NOT NULL,
  `amount` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hotel_transactions`
--

INSERT INTO `hotel_transactions` (`htrans_id`, `user_id`, `creditcard`, `amount`) VALUES
(1, 'estewart', '0000-0000-0000-0000', 200),
(2, 'z_l24', '5987066145623215', 222),
(3, 'JKFen', '4102356212365498', 193),
(4, 'JKFen', '4102356212365498', 412);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`) VALUES
('1-King'),
('1-Queen'),
('2-Full'),
('2-Queen');

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `trips_id` int(10) NOT NULL,
  `hbook_id` int(10) DEFAULT NULL,
  `fbook_id` int(10) DEFAULT NULL,
  `user_id` varchar(10) NOT NULL,
  `num_travelers` int(11) DEFAULT NULL,
  `feedback_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`trips_id`, `hbook_id`, `fbook_id`, `user_id`, `num_travelers`, `feedback_id`) VALUES
(1, 1, 1, 'estewart', 2, 1),
(2, 2, 2, 'JKFen', 1, NULL),
(3, 3, 4, 'JKFen', 1, NULL),
(4, NULL, 3, 'z_l24', 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `fname` text NOT NULL,
  `mname` text,
  `lname` text NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `password` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `address` varchar(50) NOT NULL,
  `mileage` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`fname`, `mname`, `lname`, `user_id`, `password`, `email`, `phone`, `address`, `mileage`) VALUES
('Ethan', 'M', 'Stewart', 'estewart', 'password', 'estewart08@gmail.com', '512-999-9999', '123 Main St Austin, TX', 0),
('John', 'J', 'Doe', 'JJDoe', 'password', 'JJdoe@gmail.com', '123456789012', '169 Bourbon St  New Orleans, LA 12345', 750),
('Jane', 'K', 'Fennedy', 'JKFen', 'password', 'jFen@gmail.com', '987654321098', '333 Walstreet NYC, NY 56789', 9000),
('Test2', '', 'test2', 'usertest2', 'password', 'test2@test.com', '9999999999', '123 Main St Austin, TX', 0),
('Zachary', 'P', 'Languell', 'z_l24', 'password', 'z_l24@txstate.edu', '555555555555', '123 Fake Street San Marcos, TX 78666', 3500);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `airbus`
--
ALTER TABLE `airbus`
  ADD PRIMARY KEY (`airbus_id`);

--
-- Indexes for table `airlines`
--
ALTER TABLE `airlines`
  ADD PRIMARY KEY (`airline_id`);

--
-- Indexes for table `airport_detail`
--
ALTER TABLE `airport_detail`
  ADD PRIMARY KEY (`airport_id`);

--
-- Indexes for table `cabin_type`
--
ALTER TABLE `cabin_type`
  ADD PRIMARY KEY (`cabin_type_id`);

--
-- Indexes for table `creditcard`
--
ALTER TABLE `creditcard`
  ADD PRIMARY KEY (`creditcard`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `deals`
--
ALTER TABLE `deals`
  ADD PRIMARY KEY (`deal_id`),
  ADD KEY `hotel_avail_id` (`hotel_avail_id`),
  ADD KEY `arr_airport` (`arr_airport`),
  ADD KEY `dept_airpot` (`dept_airport`),
  ADD KEY `flight_id` (`dept_flight_id`),
  ADD KEY `return_flight_id` (`return_flight_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `trips_id` (`trips_id`);

--
-- Indexes for table `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`flight_id`),
  ADD KEY `cabin_type` (`cabin_type`),
  ADD KEY `depart_airport` (`dept_airport`),
  ADD KEY `arr_airport` (`arr_airport`),
  ADD KEY `airline_id` (`airline_id`),
  ADD KEY `airbus_id` (`airbus_id`),
  ADD KEY `flight_status_id` (`flight_status_id`);

--
-- Indexes for table `flight_booking`
--
ALTER TABLE `flight_booking`
  ADD PRIMARY KEY (`fbook_id`),
  ADD KEY `flight_id` (`dept_flight_id`),
  ADD KEY `trans_id` (`trans_id`),
  ADD KEY `return_flight_id` (`return_flight_id`);

--
-- Indexes for table `flight_status`
--
ALTER TABLE `flight_status`
  ADD PRIMARY KEY (`flight_status_id`);

--
-- Indexes for table `flight_transacations`
--
ALTER TABLE `flight_transacations`
  ADD PRIMARY KEY (`trans_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `creditcard` (`creditcard`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`hotel_id`);

--
-- Indexes for table `hotel_availibility`
--
ALTER TABLE `hotel_availibility`
  ADD PRIMARY KEY (`hotel_avail_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `hotel_bookings`
--
ALTER TABLE `hotel_bookings`
  ADD PRIMARY KEY (`hbook_id`),
  ADD KEY `htrans_id` (`htrans_id`);

--
-- Indexes for table `hotel_transactions`
--
ALTER TABLE `hotel_transactions`
  ADD PRIMARY KEY (`htrans_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`trips_id`),
  ADD KEY `hbook_id` (`hbook_id`),
  ADD KEY `fbook_id` (`fbook_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `feedback_id` (`feedback_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `airlines`
--
ALTER TABLE `airlines`
  MODIFY `airline_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `deals`
--
ALTER TABLE `deals`
  MODIFY `deal_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `flights`
--
ALTER TABLE `flights`
  MODIFY `flight_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `flight_booking`
--
ALTER TABLE `flight_booking`
  MODIFY `fbook_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `flight_transacations`
--
ALTER TABLE `flight_transacations`
  MODIFY `trans_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `hotel_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `hotel_availibility`
--
ALTER TABLE `hotel_availibility`
  MODIFY `hotel_avail_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `hotel_bookings`
--
ALTER TABLE `hotel_bookings`
  MODIFY `hbook_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hotel_transactions`
--
ALTER TABLE `hotel_transactions`
  MODIFY `htrans_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `trips_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `creditcard`
--
ALTER TABLE `creditcard`
  ADD CONSTRAINT `creditcard_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `deals`
--
ALTER TABLE `deals`
  ADD CONSTRAINT `deals_ibfk_1` FOREIGN KEY (`arr_airport`) REFERENCES `airport_detail` (`airport_id`),
  ADD CONSTRAINT `deals_ibfk_2` FOREIGN KEY (`dept_airport`) REFERENCES `airport_detail` (`airport_id`),
  ADD CONSTRAINT `deals_ibfk_3` FOREIGN KEY (`dept_flight_id`) REFERENCES `flights` (`flight_id`),
  ADD CONSTRAINT `deals_ibfk_4` FOREIGN KEY (`hotel_avail_id`) REFERENCES `hotel_availibility` (`hotel_avail_id`),
  ADD CONSTRAINT `deals_ibfk_5` FOREIGN KEY (`return_flight_id`) REFERENCES `flights` (`flight_id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`trips_id`) REFERENCES `trips` (`trips_id`);

--
-- Constraints for table `flights`
--
ALTER TABLE `flights`
  ADD CONSTRAINT `flights_ibfk_1` FOREIGN KEY (`cabin_type`) REFERENCES `cabin_type` (`cabin_type_id`),
  ADD CONSTRAINT `flights_ibfk_2` FOREIGN KEY (`dept_airport`) REFERENCES `airport_detail` (`airport_id`),
  ADD CONSTRAINT `flights_ibfk_3` FOREIGN KEY (`arr_airport`) REFERENCES `airport_detail` (`airport_id`),
  ADD CONSTRAINT `flights_ibfk_4` FOREIGN KEY (`airline_id`) REFERENCES `airlines` (`airline_id`),
  ADD CONSTRAINT `flights_ibfk_5` FOREIGN KEY (`airbus_id`) REFERENCES `airbus` (`airbus_id`),
  ADD CONSTRAINT `flights_ibfk_6` FOREIGN KEY (`flight_status_id`) REFERENCES `flight_status` (`flight_status_id`);

--
-- Constraints for table `flight_booking`
--
ALTER TABLE `flight_booking`
  ADD CONSTRAINT `flight_booking_ibfk_1` FOREIGN KEY (`dept_flight_id`) REFERENCES `flights` (`flight_id`),
  ADD CONSTRAINT `flight_booking_ibfk_2` FOREIGN KEY (`trans_id`) REFERENCES `flight_transacations` (`trans_id`),
  ADD CONSTRAINT `flight_booking_ibfk_3` FOREIGN KEY (`return_flight_id`) REFERENCES `flights` (`flight_id`);

--
-- Constraints for table `flight_transacations`
--
ALTER TABLE `flight_transacations`
  ADD CONSTRAINT `flight_transacations_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `flight_transacations_ibfk_3` FOREIGN KEY (`creditcard`) REFERENCES `creditcard` (`creditcard`);

--
-- Constraints for table `hotel_availibility`
--
ALTER TABLE `hotel_availibility`
  ADD CONSTRAINT `hotel_availibility_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`);

--
-- Constraints for table `hotel_bookings`
--
ALTER TABLE `hotel_bookings`
  ADD CONSTRAINT `hotel_bookings_ibfk_1` FOREIGN KEY (`htrans_id`) REFERENCES `hotel_transactions` (`htrans_id`);

--
-- Constraints for table `hotel_transactions`
--
ALTER TABLE `hotel_transactions`
  ADD CONSTRAINT `hotel_transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `trips`
--
ALTER TABLE `trips`
  ADD CONSTRAINT `trips_ibfk_1` FOREIGN KEY (`fbook_id`) REFERENCES `flight_booking` (`fbook_id`),
  ADD CONSTRAINT `trips_ibfk_2` FOREIGN KEY (`hbook_id`) REFERENCES `hotel_bookings` (`hbook_id`),
  ADD CONSTRAINT `trips_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `trips_ibfk_4` FOREIGN KEY (`feedback_id`) REFERENCES `feedback` (`feedback_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
