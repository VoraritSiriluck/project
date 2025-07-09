-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2025 at 04:26 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clean-system-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `clean_report`
--

CREATE TABLE `clean_report` (
  `id` int(10) NOT NULL,
  `reporter_name` varchar(100) NOT NULL,
  `reporter_fullname` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `report_date` date NOT NULL,
  `room` varchar(100) NOT NULL,
  `cleaner` enum('นางสาววาสนา มุสิกรัตน์','นางสาวอินทุอร รัตนบุญโณ','คนอื่น') DEFAULT NULL,
  `detail` text NOT NULL,
  `image_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `clean_report`
--

INSERT INTO `clean_report` (`id`, `reporter_name`, `reporter_fullname`, `position`, `report_date`, `room`, `cleaner`, `detail`, `image_name`) VALUES
(37, 'krittiya.du', 'กฤติยา ดำมุณี', 'ฝ่ายการบริหารและการจัดการ', '2025-06-17', 'ห้องช่าง', NULL, 'zqawxsecdrvftbgynhumjik,o', '213533395720250623_082818.png'),
(38, 'datchanee.s', 'ดรรชนี สองประสม', 'ฝ่ายบริการเครื่องมือวิจัยทางวิทยาศาสตร์', '2025-06-23', 'ห้องประชุม', NULL, 'sadfghjklk;lp\';', '149283613820250623_083415.png'),
(39, 'wirachai.s', 'วิระชัย สมัย', 'ฝ่ายการบริหารและการจัดการ', '2025-06-23', 'ห้องช่าง', NULL, 'ไผหำปกดแเ', '193929192120250623_111911.png'),
(40, 'kotchanipha.c', 'กชนิภา จันทร์สืบ', 'ฝ่ายบริการเครื่องมือวิจัยทางวิทยาศาสตร์', '2025-06-27', 'ห้องช่าง', NULL, 'x4c5rv6tb7yn8umi,o.p[/]', '31349811620250627_035834.jpg'),
(41, 'jinwara.s', 'จินต์วรา สุวรรณมณี', 'ฝ่ายบริการเครื่องมือวิจัยทางวิทยาศาสตร์', '2025-06-23', 'ห้องช่าง', NULL, 'asdfghjkl;', '6693547820250627_053221.jpg'),
(42, 'apinya.j', 'อภิญญา ศุกลรัตน์', 'ฝ่ายซ่อมบำรุงรักษาและพัฒนาเครื่องมือ', '2025-06-27', 'ห้องช่าง', NULL, 'aZsxdtcfyvgbhjnklm;,', '146904722020250627_053242.jpg'),
(43, 'pimpimon.p', 'พิมพ์พิมล พฤกษ์ภัทรานนต์', 'ฝ่ายการบริหารและการจัดการ', '2025-06-25', 'ห้องช่าง', NULL, 'awserdtfuygiuhij\'', '136043141620250627_053318.jpg'),
(44, 'akkarapong.s', 'อัครพงษ์ แซ่จอง', 'ฝ่ายซ่อมบำรุงรักษาและพัฒนาเครื่องมือ', '2025-06-18', 'ห้องช่าง', NULL, 'zqawxsecdrvftbgynhumji,o.pl', '214429807720250627_081138.png'),
(45, 'pimpimon.p', 'พิมพ์พิมล พฤกษ์ภัทรานนต์', 'ฝ่ายบริการเครื่องมือวิจัยทางวิทยาศาสตร์', '2025-06-18', 'ห้องน้ำ', NULL, 'wzexrcvtbynumi,o.p', '154985285320250627_081228.png'),
(46, 'jinwara.s', 'จินต์วรา สุวรรณมณี', 'ฝ่ายบริการเครื่องมือวิจัยทางวิทยาศาสตร์', '2025-06-27', 'ห้องประชุม', NULL, 'zwxecrvtbynumi,op.', '169425184220250627_081327.png'),
(47, 'jinwara.s', 'จินต์วรา สุวรรณมณี', 'ฝ่ายซ่อมบำรุงรักษาและพัฒนาเครื่องมือ', '2025-06-27', 'ห้องประชุม', NULL, 'wqerxtcfygvubi', '190125882120250627_081403.jpg'),
(48, 'patswut.s', 'พรรษวุฒิ สาระวิโรจน์', 'ฝ่ายบริการเครื่องมือวิจัยทางวิทยาศาสตร์', '2025-06-25', 'ห้องประชุม', NULL, 'wzxcvubinkm', '150493881520250627_082739.jpg'),
(49, 'kotchanipha.c', 'กชนิภา จันทร์สืบ', 'ฝ่ายการบริหารและการจัดการ', '2025-07-01', 'ห้องน้ำ', NULL, 'awesxrctvybn;ml\',;\'', '177049030320250701_043236.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `id` int(100) NOT NULL,
  `room_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `room_name`) VALUES
(0, 'อื่นๆ'),
(1, 'ห้องประชุม'),
(2, 'ห้องน้ำ'),
(4, 'ห้องช่าง');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(4, 'lonely', '$2y$10$GIghIGbD821N9nPlDAjF7u68BRDQsjLzWz/tLl4/8iIG6xK7P0esm'),
(5, 'admin', '$2y$10$fxGYpkvpdUcfbUf2Vqni3emy7NZdutrhBBLDVXj46TefHsKigwv6C'),
(6, 'really', '$2y$10$ZYHwtISUiJ4VRP1ljAJVB.9hZ9NcklMITy5PHyX5pW2.gOydLK70u');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clean_report`
--
ALTER TABLE `clean_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clean_report`
--
ALTER TABLE `clean_report`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
