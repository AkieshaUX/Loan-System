-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 08, 2025 at 03:10 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `plms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int NOT NULL,
  `admin_user` varchar(100) DEFAULT NULL,
  `admin_pass` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_user`, `admin_pass`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `beneficiary`
--

CREATE TABLE `beneficiary` (
  `beneficiary_id` int NOT NULL,
  `member_id` int DEFAULT NULL,
  `bname` varchar(100) DEFAULT NULL,
  `bgender` varchar(10) DEFAULT NULL,
  `bcontact` varchar(11) DEFAULT NULL,
  `bdate` date NOT NULL,
  `baddress` varchar(200) DEFAULT NULL,
  `brelation` varchar(20) DEFAULT NULL,
  `bprofile` varchar(200) DEFAULT NULL,
  `bvalidID` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `funding`
--

CREATE TABLE `funding` (
  `funding_id` int NOT NULL,
  `share_id` int DEFAULT NULL,
  `amount` decimal(40,2) DEFAULT NULL,
  `date` date NOT NULL,
  `withdraw` decimal(40,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE `loan` (
  `loan_id` int NOT NULL,
  `member_id` int DEFAULT NULL,
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `amount` decimal(40,2) DEFAULT NULL,
  `tenure` int DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `interest` int DEFAULT NULL,
  `totalinterest` decimal(40,2) DEFAULT NULL,
  `monthlyinterest` decimal(40,2) DEFAULT NULL,
  `totalpayment` decimal(40,2) DEFAULT NULL,
  `monthlypayment` decimal(40,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `member_id` int NOT NULL,
  `reference` varchar(20) DEFAULT NULL,
  `mname` varchar(100) DEFAULT NULL,
  `mgender` varchar(10) DEFAULT NULL,
  `mcontact` varchar(11) DEFAULT NULL,
  `mbdate` date NOT NULL,
  `maddress` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `mprofile` varchar(200) DEFAULT NULL,
  `mvalidID` varchar(200) DEFAULT NULL,
  `started` date NOT NULL,
  `mstatus` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `monthly_payment`
--

CREATE TABLE `monthly_payment` (
  `monthly_payment_id` int NOT NULL,
  `loan_id` int NOT NULL,
  `member_id` int NOT NULL,
  `reference_payment` varchar(10) DEFAULT NULL,
  `amount` decimal(40,2) NOT NULL,
  `purpose` varchar(100) NOT NULL,
  `loanstarted` varchar(255) NOT NULL,
  `duedate` date NOT NULL,
  `datepayment` date DEFAULT NULL,
  `tenure` int NOT NULL,
  `interest` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `totalinterest` decimal(11,2) NOT NULL,
  `monthlyinterest` decimal(40,2) DEFAULT NULL,
  `totalpayment` decimal(40,2) NOT NULL,
  `monthlypayment` decimal(40,2) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orderproduct`
--

CREATE TABLE `orderproduct` (
  `order_id` int NOT NULL,
  `productsupply_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `orderproductno` varchar(100) DEFAULT NULL,
  `ordername` varchar(100) DEFAULT NULL,
  `orderquantity` int DEFAULT NULL,
  `orderamount` float(11,2) DEFAULT NULL,
  `minuscoast` float(11,2) DEFAULT NULL,
  `totalincome` float(11,2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `withdraw_income` float(11,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_history`
--

CREATE TABLE `payment_history` (
  `payment_history_id` int NOT NULL,
  `loan_id` int NOT NULL,
  `member_id` int NOT NULL,
  `reference_payment` varchar(10) DEFAULT NULL,
  `amount` decimal(40,2) NOT NULL,
  `purpose` varchar(100) NOT NULL,
  `loanstarted` varchar(255) NOT NULL,
  `duedate` date NOT NULL,
  `datepayment` date DEFAULT NULL,
  `tenure` int NOT NULL,
  `interest` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `totalinterest` decimal(11,2) NOT NULL,
  `monthlyinterest` decimal(40,2) DEFAULT NULL,
  `totalpayment` decimal(40,2) NOT NULL,
  `monthlypayment` decimal(40,2) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int NOT NULL,
  `productsupply_id` int DEFAULT NULL,
  `quantitytotal` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `price` float(11,2) DEFAULT NULL,
  `coast` float(11,2) DEFAULT NULL,
  `productdate` date DEFAULT NULL,
  `pID` varchar(50) DEFAULT NULL,
  `product_status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `productsupply`
--

CREATE TABLE `productsupply` (
  `productsupply_id` int NOT NULL,
  `productname` varchar(50) DEFAULT NULL,
  `productsupply_status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `savings`
--

CREATE TABLE `savings` (
  `savings_id` int NOT NULL,
  `interestearned` decimal(40,2) DEFAULT NULL,
  `generalfunds` decimal(40,2) DEFAULT NULL,
  `gfwithdraw` decimal(40,2) DEFAULT NULL,
  `capital` decimal(40,2) DEFAULT NULL,
  `capitalwithdraw` decimal(40,2) DEFAULT NULL,
  `profit` decimal(40,2) DEFAULT NULL,
  `profitwithdraw` decimal(40,2) DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `share`
--

CREATE TABLE `share` (
  `share_id` int NOT NULL,
  `invoice_number` varchar(50) DEFAULT NULL,
  `member_id` int DEFAULT NULL,
  `mshare` decimal(40,2) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdraw`
--

CREATE TABLE `withdraw` (
  `withdraw_id` int NOT NULL,
  `loan_id` int DEFAULT NULL,
  `member_id` int DEFAULT NULL,
  `admin` varchar(10) DEFAULT NULL,
  `amount` decimal(40,2) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `beneficiary`
--
ALTER TABLE `beneficiary`
  ADD PRIMARY KEY (`beneficiary_id`);

--
-- Indexes for table `funding`
--
ALTER TABLE `funding`
  ADD PRIMARY KEY (`funding_id`);

--
-- Indexes for table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`loan_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `monthly_payment`
--
ALTER TABLE `monthly_payment`
  ADD PRIMARY KEY (`monthly_payment_id`);

--
-- Indexes for table `orderproduct`
--
ALTER TABLE `orderproduct`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD PRIMARY KEY (`payment_history_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `productsupply`
--
ALTER TABLE `productsupply`
  ADD PRIMARY KEY (`productsupply_id`);

--
-- Indexes for table `savings`
--
ALTER TABLE `savings`
  ADD PRIMARY KEY (`savings_id`);

--
-- Indexes for table `share`
--
ALTER TABLE `share`
  ADD PRIMARY KEY (`share_id`);

--
-- Indexes for table `withdraw`
--
ALTER TABLE `withdraw`
  ADD PRIMARY KEY (`withdraw_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `beneficiary`
--
ALTER TABLE `beneficiary`
  MODIFY `beneficiary_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `funding`
--
ALTER TABLE `funding`
  MODIFY `funding_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan`
--
ALTER TABLE `loan`
  MODIFY `loan_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `monthly_payment`
--
ALTER TABLE `monthly_payment`
  MODIFY `monthly_payment_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orderproduct`
--
ALTER TABLE `orderproduct`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_history`
--
ALTER TABLE `payment_history`
  MODIFY `payment_history_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `productsupply`
--
ALTER TABLE `productsupply`
  MODIFY `productsupply_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `savings`
--
ALTER TABLE `savings`
  MODIFY `savings_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `share`
--
ALTER TABLE `share`
  MODIFY `share_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdraw`
--
ALTER TABLE `withdraw`
  MODIFY `withdraw_id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
