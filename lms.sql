-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2025 at 03:38 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lms`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `message` varchar(500) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_floated` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `message`, `created_at`, `is_floated`) VALUES
(33, '🕒 Library timings updated! Open 8 AM to 8 PM, Sunday closed. 🛑', '2025-06-07 17:35:35', 0),
(34, '📖 Manage your issued books and fines easily with our new system! 💻', '2025-06-07 17:36:04', 1),
(35, '📚 View your issued books and detailed history anytime, all in one place.', '2025-06-07 17:36:39', 0),
(36, '🧑‍🎓 Manage student profiles with ease—add, edit, or view details seamlessly.', '2025-06-07 17:36:55', 0),
(37, '⚙️ Secure and efficient backend powered by PHP and SQL for reliable library operations.', '2025-06-07 17:37:07', 1),
(39, '🚀 This amazing platform is created by Satyam Gaikwad! 🎉', '2025-06-08 06:17:09', 0),
(41, 'new announcement', '2025-06-08 13:53:39', 1);

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `accession_number` char(4) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`accession_number`, `title`, `author`, `publisher`, `price`) VALUES
('0002', 'MFC prog.from the ground up 2nd Edition', 'Schildt', 'TMH', 385.00),
('0003', 'Funds of database system. 4th E', 'Elmasri', 'PEARSON EDU', 375.00),
('0004', 'Oracle9i the complete ref.wb / CD', 'Loney', 'TMH', 455.00),
('0005', 'Programming with C 2nd E', 'Gottfried', 'TMH Publisher', 265.00),
('0006', 'Programming in C#', 'Balagurusamy', 'TMH', 195.00),
('0007', 'ASP.NET & VB. Net web Programming', 'Crouch', 'PEARSON EDU', 450.00),
('0008', 'Upgrading & Troubleshooting networks the complete ref.', 'Zacker', 'TMH', 525.00),
('0009', 'Java Network Programming', 'Harold', 'SPD', 500.00),
('0010', 'Understanding Pointers in C 3rd E', 'Kanetkar', 'BPB', 210.00),
('0011', 'Test your C++ Skills', 'Kanetkar', 'BPB', 180.00),
('0012', 'Test your C Skills', 'Kanetkar', 'BPB', 165.00),
('0013', 'A Programmer’sGuide to Java certification 2nd E w/cd', 'Mughal', 'PEARSON EDU', 550.00),
('0014', 'Discrete mathematical Structures with application to computer science', 'Tremblay', 'TMH', 250.00),
('0015', 'Understanding the Lunix Kernel 2ndE', 'Bovet', 'SPD', 500.00),
('0016', 'JSP 2.0 the complete ref.', 'Hanna', 'TMH', 495.00),
('0017', 'Java 2 the complete ref. 5th E', 'Schildt', 'TMH', 395.00),
('0018', 'Programming MS.visual C++ 5th E w/cd', 'Kruglinski', 'WP PUBLISHER', 650.00),
('0019', 'Programming Windows with MFC 2nd E w/cd', 'Prosise', 'WP PUBLISHER', 750.00),
('0020', 'Programming windows 5th E w/CD', 'Petzold', 'WP PUBLISHER', 725.00),
('0021', 'Compilers', 'Aho', 'PEARSON EDU', 399.00),
('0022', 'Linex Kernel Developer 2nd E', 'Love', 'PEARSON EDU', 295.00),
('0023', 'Linex device drivers 3rd E', 'Corbet', 'SPD', 450.00),
('0024', 'MCSA/MCSE MS  Implementing Internet Security & acceleration server 2004 w/CD', 'Reimer', 'PHI', 795.00),
('0025', 'MCSA/MCSE MS  Managing & Maintaining a MS  winds server 2003 environment w/CD', 'Holme', 'PHI', 695.00),
('0026', 'Upgrading your certificate to MS.windows server 2003 w/CD', 'Holme', 'PHI', 895.00),
('0027', 'MCSE Planning, Implementing & maintaining a MS windows server 2003 and active directory infrastructure w/CD', 'Spealman', 'PHI', 695.00),
('0028', 'MCSE designing a MS  windows server 2003 active directory & network infrastructure w/cd', 'Glenn', 'PHI', 595.00),
('0029', 'MCSE Designing security for MS   windows server 2003 network w/CD', 'Bragg', 'PHI', 695.00),
('0030', 'MCSA/MCSE implementing & administering security in a MS  windows server’ 03 network w/cd', 'Northrup', 'SPD', 695.00),
('0031', 'Network security tools', 'Dhanjani', 'PEARSON EDU', 350.00),
('0032', 'CCNP 4. Network troubleshooting lab companion', 'PE  CNAP', 'PEARSON EDU', 199.00),
('0033', 'Computer networks & Internets w/cd 4th E', 'Comer', 'PEARSON EDU', 325.00),
('0034', 'C++Primer 3rd E', 'Lippman', 'PEARSON EDU', 450.00),
('0035', 'Advance unix a programmer’s guide', 'Prata', 'BPB', 225.00),
('0036', 'The C Puzzle book', 'Feuer', 'PEARSON EDU', 125.00),
('0037', 'The design of the unix operation system', 'Bach', 'PEARSON EDU', 195.00),
('0038', 'Writing TSR’s through C', 'Kanetkar', 'BPB', 225.00),
('0039', 'C Projects w/d', 'Kanetkar', 'BPB', 300.00),
('0040', 'Linux kernel programme 3rd E w/CD', 'Beck', 'PEARSON EDU', 395.00),
('0041', 'Unix system administration h/bk 3rd E', 'Nemeth', 'PEARSON EDU', 495.00),
('0042', 'Network Programme for MS. Windows w/CD', 'Jones', 'S CHAND& GROUP', 600.00),
('0043', 'Quantitative aptitude', 'Aggarwal', 'ORIENT PAPER BACKS', 315.00),
('0044', 'Puzzles to puzzle you', 'Devi Shakuntala', 'TMH', 55.00),
('0045', 'Elements of Discrete Mathematics', 'Liu', 'TMH', 250.00),
('0046', 'Digital Signal Processing (3rd edition)', 'Sanjit .K. Mitra', 'TMH', 250.00),
('0047', 'Artificial Intelligence A Modern Approach(2nd edition)', 'Stuart Russel. Peter Norving', 'EEE', 350.00),
('0048', 'Operating Systems (2nd edition)', 'Achyut  S Godbole', 'TMH', 250.00),
('0049', 'Database system concepts', 'Abraham Silberchatz, Henry .F. Korth, S. Sudarshan', 'MGH', 510.00),
('0050', 'Programming and Customizing 8051 Microcontroller', 'Mykepredko', 'TMH', 300.00),
('0051', 'Digital Logic and computer device', 'M.Moris Mano', 'PHI', 250.00),
('0052', 'Advance MS DOS Programming', 'Ray duncan', 'BPB', 390.00),
('0053', 'Elements Of Theory Of Computation', 'Harry R Lewis & Christos H Papadimitriou', 'PHI', 250.00),
('0054', 'Object Oriented and Classical Software Engineering (5th edition)', 'Stephen.R. Schach', 'TMH', 275.00),
('0055', 'Java and Object oriented Paradigm', 'Debasish Jana', 'EEE', 280.00),
('0056', 'Compiler Design', 'Santanu Chattopadhyay', 'EEE', 300.00),
('0057', 'Software Engineering', 'DavidGustafson', 'TMH', 175.00),
('0058', 'Mobile Computing', 'Asoke. K. Talukder, Roopa R .Yavagal', 'TMH', 350.00),
('0059', 'Microcontrollers[Theory and Applications]', 'Ajay Deshmukh', 'TMH', 250.00),
('0060', 'Introduction To Languages And The Theory Of Computation', 'John C Martin', 'TMH', 250.00),
('0061', 'Modern digital Electronics', 'R.P.Jain', 'TMH', 350.00),
('0062', 'Operating System Concepts (6th edition)', 'Silberschatz,Galvin,Gagne', 'John Wiley & Sons. INC', 250.00),
('0063', 'System Programming & Operating System(2nd Revised Edition)', 'D M Dhamdhere', 'TMH', 350.00),
('0064', 'Essay Scorer', 'IMS', 'IMS', 99.00),
('0065', 'The personal Interview. The art of facing Interviews', 'IMS', 'IMS', 100.00),
('0066', 'The New GK power pack', 'IMS', 'IMS', 100.00),
('0067', 'The GD path finder', 'IMS', 'IMS', 100.00),
('0068', 'Advance edge mastering MBA career', 'IMS', 'IMS', 150.00),
('0069', 'Quantitative skill Builder', 'IMS', 'IMS', 150.00),
('0070', 'Project Management', 'Scott Berkun', 'O’Reilly', 200.00),
('0071', 'UNIX Concepts & Applications', 'Sumitabha', 'TMH', 400.00),
('0072', 'Data Structures', 'G A V Pai', 'TMH', 350.00),
('0073', 'Digital Signal Processing', 'Sanjit K. Mitra', 'TMH', 200.00),
('0074', 'Software Engineering 6thEdition', 'Roger S Pressman', 'MGH', 600.00),
('0075', 'Programming Languages _Principles and Paradigms', 'Allan Tucker, Robert Noonan', 'TMH', 275.00),
('0076', 'Fundementals  of Algorithms', 'Giles Brassard/Paul Brately', 'PHI', 225.00),
('0077', 'Internetworking With TCP/IP- vol –1', 'Douglas . E. Comer', 'PHI', 250.00),
('0078', 'Unix Network Programming', 'W.Richard Stevens', 'PHI', 250.00),
('0079', 'Teach Yourself Programming with JDBC', 'Ashton Hobbs', 'Techmedia', 275.00),
('0080', 'The Intel Microprocessor', 'Barry. B. Bray', 'Pearson Wducation', 350.00),
('0081', 'Systems Programming', 'John. J. Donovan', 'TMH', 250.00),
('0082', 'Computer Graphics', 'Steven Harrington', 'MGH', 250.00),
('0083', 'Understanding the Linux Kernel', 'Daniel .P.Bovet', 'O’Reilly', 500.00),
('0084', 'Lex and Yacc', 'John .R.Levine, Tony Mason', 'O’Reilly', 225.00),
('0085', 'Computer Graphics', 'Donald Hearn', 'PHI', 425.00),
('0086', 'Operating Systems Incorporating Unix and Windows', 'Colin Ritchie', 'BPB', 120.00),
('0087', 'MicroComputer Systems: The 8086/8088 family,Architecture, Programming and Design', 'Yu-Chang, Glen A. Gibbson', 'PHI', 195.00),
('0088', 'Artificial Intelligence', 'Elaine Rich, Kevin Knight', 'TMH', 325.00),
('0089', 'Computer Networks and Internet', 'Douglas E Comer', 'Pearson Education', 325.00),
('0090', 'Understanding Unix', 'K.Srirengan', 'PHI', 125.00),
('0091', 'C Under Dos Test', 'Riku Ravik, Anup Jalan, Soham Desai', 'BPB', 95.00),
('0092', 'Unix Concepts and Applications', 'Sumithaba Das', 'TMH', 225.00),
('0093', 'Object Oriented Programming In Turbo C++', 'Robert Lafore', 'Galgotia', 325.00),
('0094', 'VB.NET  Language In a Nut Shell', 'Steven Roman, Ron Petrusha, Paul Lonmax', 'O’Reilly', 350.00),
('0095', 'Object Oriented Programming With C++', 'E. BalaguruSwami', 'TMH', 225.00),
('0096', 'Developing ASP Component', 'Shelly Powers', 'O’Reilly', 500.00),
('0097', 'Thinking In Java', 'Bruce Eckel', 'Pearson Education', 300.00),
('0098', 'Design Methods and Analysis of Algorithms', 'S.K. Basu', 'PHI', 250.00),
('0099', 'J2EE Architecture', 'BV Kumar, Sangeeta, B Subramanya', 'TMH', 380.00),
('0100', 'J2EE Architecture', 'BV Kumar, Sangeeta, B Subramanya', 'TMH', 380.00);

-- --------------------------------------------------------

--
-- Table structure for table `issued_books`
--

CREATE TABLE `issued_books` (
  `s_no` int(11) NOT NULL,
  `accession_number` char(4) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `library_card_no` varchar(20) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `issue_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `fine` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `issued_books`
--

INSERT INTO `issued_books` (`s_no`, `accession_number`, `title`, `author`, `library_card_no`, `status`, `issue_date`, `due_date`, `return_date`, `fine`) VALUES
(33, '0002', 'MFC prog.from the ground up 2nd E', 'Schildt', 'MIT2', 0, '2025-06-07', '2025-06-14', '2025-06-07', 0),
(34, '0004', 'Oracle9i the complete ref.w/CD', 'Loney', 'MIT3', 0, '2025-06-07', '2025-06-14', '2025-06-07', 0),
(35, '0003', 'Funds of database system. 4th E', 'Elmasri', 'MIT3', 0, '2025-05-25', '2025-06-03', '2025-06-07', 6),
(36, '0009', 'Java Network Programming', 'Harold', 'MIT9', 1, '2025-06-07', '2025-06-14', NULL, 0),
(37, '0010', 'Understanding Pointers in C 3rd E', 'Kanetkar', 'MIT2', 0, '2025-06-07', '2025-06-11', '2025-06-07', 0),
(38, '0002', 'MFC prog.from the ground up 2nd E', 'Schildt', 'MIT2', 0, '2025-06-07', '2025-06-14', '2025-06-07', 0),
(39, '0002', 'MFC prog.from the ground up 2nd E', 'Schildt', 'MIT2', 1, '2025-06-07', '2025-06-14', NULL, 0),
(40, '0012', 'Test your C Skills', 'Kanetkar', 'MIT3', 0, '2025-06-07', '2025-06-14', '2025-06-08', 0),
(41, '0019', 'Programming Windows with MFC 2nd E w/cd', 'Prosise', 'MIT3', 0, '2025-06-07', '2025-06-14', '2025-06-08', 0),
(42, '0007', 'ASP.NET & VB. Net web Programming', 'Crouch', 'MIT1', 1, '2025-06-07', '2025-06-14', NULL, 0),
(43, '0006', 'Programming in C#', 'Balagurusamy', 'MIT3', 1, '2025-06-08', '2025-06-15', NULL, 0),
(44, '0010', 'Understanding Pointers in C 3rd E', 'Kanetkar', 'MIT3', 1, '2025-05-08', '2025-05-27', NULL, 0),
(45, '0047', 'Artificial Intelligence A Modern Approach(2nd edition)', 'Stuart Russel. Peter Norving', 'MIT3', 1, '2025-06-08', '2025-06-10', NULL, 0),
(46, '0088', 'Artificial Intelligence', 'Elaine Rich, Kevin Knight', 'MIT3', 1, '2025-06-08', '2025-06-15', NULL, 0),
(47, '0016', 'JSP 2.0 the complete ref.', 'Hanna', 'MIT3', 0, '2025-05-21', '2025-05-30', '2025-06-08', 19);

-- --------------------------------------------------------

--
-- Table structure for table `staff_accounts`
--

CREATE TABLE `staff_accounts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff') NOT NULL DEFAULT 'staff',
  `phone` varchar(15) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_accounts`
--

INSERT INTO `staff_accounts` (`id`, `name`, `email`, `password`, `role`, `phone`, `department`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', 'admin123', 'admin', '214748364707', 'Technical Department MIT', '2025-06-06 02:35:57', '2025-06-08 09:35:19'),
(5, 'Staff Member', 'staff.member@example.com', '12345', 'staff', '9000000000', 'Chemical Engineering', '2025-06-08 13:23:50', '2025-06-08 13:51:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `address` varchar(250) NOT NULL,
  `library_card_no` varchar(50) DEFAULT NULL,
  `fine_amount` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `mobile`, `address`, `library_card_no`, `fine_amount`, `created_at`, `updated_at`) VALUES
(1, 'Satyam Gaikwad', '202301040097@mitaoe.ac.in', 'sat123', 9876543201, 'Crystal Heights, Dehu Phata, Alandi, Pune', 'MIT1', 0.00, '2025-06-07 17:17:09', '2025-06-08 09:53:03'),
(3, 'Anjali Deshmukh', 'anjali.deshmukh@example.com', 'anjali123', 9876543203, 'Dianosour Garden, Green Valley, Pune', 'MIT3', 0.00, '2025-06-07 17:17:09', '2025-06-08 13:51:19'),
(4, 'Rohan Sharma', 'rohan.sharma@example.com', 'rohan123', 9876543204, 'Silver Oak, Viman Nagar, Pune', 'MIT4', 0.00, '2025-06-07 17:17:09', '2025-06-07 17:17:09'),
(5, 'Sneha Kulkarni', 'sneha.kulkarni@example.com', 'sneha123', 9876543205, 'Lake View, Hadapsar, Pune', 'MIT5', 0.00, '2025-06-07 17:17:09', '2025-06-08 09:58:12'),
(6, 'Aditya More', 'aditya.more@example.com', 'aditya123', 9876543206, 'Hilltop Residency, Wagholi, Pune', 'MIT6', 0.00, '2025-06-07 17:17:09', '2025-06-07 17:17:09'),
(7, 'Priya Singh', 'priya.singh@example.com', 'priya123', 9876543207, 'Rainbow Heights, Kharadi, Pune', 'MIT7', 0.00, '2025-06-07 17:17:09', '2025-06-07 17:17:09'),
(8, 'Manish Jadhav', 'manish.jadhav@example.com', 'manish123', 9876543208, 'Sunset Boulevard, Pimpri, Pune', 'MIT8', 0.00, '2025-06-07 17:17:09', '2025-06-07 17:17:09'),
(9, 'Kavita Patil', 'kavita.patil@example.com', 'kavita123', 9876543209, 'Maple Residency, Chinchwad, Pune', 'MIT9', 0.00, '2025-06-07 17:17:09', '2025-06-07 17:17:09'),
(10, 'Vikram Joshi', 'vikram.joshi@example.com', 'vikram123', 9876543210, 'Cedar Apartments, Hinjewadi, Pune', 'MIT10', 0.00, '2025-06-07 17:17:09', '2025-06-07 17:17:09'),
(11, 'Deepa Nair', 'deepa.nair@example.com', 'deepa123', 9876543211, 'Ocean View, Baner, Pune', 'MIT11', 0.00, '2025-06-07 17:17:09', '2025-06-07 17:17:09'),
(12, 'Rahul Kulkarni', 'rahul.kulkarni@example.com', 'rahul123', 9876543212, 'Mountain View, Kothrud, Pune', 'MIT12', 0.00, '2025-06-07 17:17:09', '2025-06-07 17:17:09'),
(13, 'Sheetal Gokhale', 'sheetal.gokhale@example.com', 'sheetal123', 9876543213, 'City Center, Viman Nagar, Pune', 'MIT13', 0.00, '2025-06-07 17:17:09', '2025-06-07 17:17:09'),
(14, 'Siddharth Desai', 'siddharth.desai@example.com', 'siddharth123', 9876543214, 'Palm Residency, Hadapsar, Pune', 'MIT14', 0.00, '2025-06-07 17:17:09', '2025-06-07 17:17:09'),
(15, 'Neha Reddy', 'neha.reddy@example.com', 'neha123', 9876543215, 'Sunrise Apartments, Wagholi, Pune', 'MIT15', 0.00, '2025-06-07 17:17:09', '2025-06-07 17:17:09'),
(16, 'Kiran Patil', 'kiran.patil@example.com', 'kiran123', 9876543216, 'Blue Sky Residency, Dehu Phata, Pune', 'MIT16', 0.00, '2025-06-07 17:17:09', '2025-06-07 17:17:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`accession_number`);

--
-- Indexes for table `issued_books`
--
ALTER TABLE `issued_books`
  ADD PRIMARY KEY (`s_no`),
  ADD KEY `accession_number` (`accession_number`);

--
-- Indexes for table `staff_accounts`
--
ALTER TABLE `staff_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_email` (`email`),
  ADD UNIQUE KEY `library_card_no` (`library_card_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `issued_books`
--
ALTER TABLE `issued_books`
  MODIFY `s_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `staff_accounts`
--
ALTER TABLE `staff_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `issued_books`
--
ALTER TABLE `issued_books`
  ADD CONSTRAINT `issued_books_ibfk_1` FOREIGN KEY (`accession_number`) REFERENCES `books` (`accession_number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
