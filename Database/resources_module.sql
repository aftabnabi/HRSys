-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 21, 2011 at 09:52 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `resources_module`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE IF NOT EXISTS `candidates` (
  `candidates_id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_name` varchar(45) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `zip` varchar(45) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `sourcing_request_id` int(11) NOT NULL,
  `candidate_status_id` int(11) NOT NULL,
  PRIMARY KEY (`candidates_id`),
  KEY `fk_candidates_jobs1` (`sourcing_request_id`),
  KEY `fk_candidates_candidate_status1` (`candidate_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `candidates`
--


-- --------------------------------------------------------

--
-- Table structure for table `candidate_status`
--

CREATE TABLE IF NOT EXISTS `candidate_status` (
  `candidate_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`candidate_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `candidate_status`
--


-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`company_id`, `company_name`) VALUES
(1, 'Mobilink');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(45) DEFAULT NULL,
  `division_id` int(11) NOT NULL,
  `total_head_count` int(11) DEFAULT NULL,
  `existing_head_count` int(11) DEFAULT NULL,
  `open_head_count` int(11) DEFAULT NULL,
  `sourcing_request_count` int(11) DEFAULT NULL,
  `hiring_request_count` int(11) DEFAULT NULL,
  `appointment_letter_issued_count` int(11) DEFAULT NULL,
  `candidate_accepted_count` int(11) DEFAULT NULL,
  `candidate_joined_count` int(11) DEFAULT NULL,
  PRIMARY KEY (`department_id`),
  KEY `fk_departments_divisions1` (`division_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department_name`, `division_id`, `total_head_count`, `existing_head_count`, `open_head_count`, `sourcing_request_count`, `hiring_request_count`, `appointment_letter_issued_count`, `candidate_accepted_count`, `candidate_joined_count`) VALUES
(1, 'IT Department', 2, 10, 3, 6, 4, 0, 0, 0, 0),
(2, 'HR Department', 1, 10, 2, 0, 2, 0, 0, 0, 0),
(3, 'STRATEGIC BUSINESS DEPARTMENT', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'BUSINESS COMMUNICATIONS DEPARTMENT', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'PROJECT MANAGEMENT DEPARTMENT', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'OPERATIONS & CUSTOMER CARE DEPARTMENT', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'CREATIVITY & CONTENT MANAGEMENT DEPARTMENT', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'FINANCE & ACCOUNTING DEPARTMENT', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'ADMINISTRATION & HR DEPARTMENT', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'INSIDE SALES', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'OUTSIDE SALES', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'BUSINESS SALES', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'MARKETING', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE IF NOT EXISTS `divisions` (
  `division_id` int(11) NOT NULL AUTO_INCREMENT,
  `division_name` varchar(45) DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  PRIMARY KEY (`division_id`),
  KEY `fk_divisions_company1` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`division_id`, `division_name`, `company_id`) VALUES
(1, 'BUSINESS', 1),
(2, 'I.T', 1),
(3, 'SALES', 1),
(4, 'FINANCE', 1),
(5, 'TECHNICAL', 1);

-- --------------------------------------------------------

--
-- Table structure for table `email_notifications`
--

CREATE TABLE IF NOT EXISTS `email_notifications` (
  `email_notification_id` int(11) NOT NULL AUTO_INCREMENT,
  `dispatch` tinyint(1) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `content` varchar(4000) DEFAULT NULL,
  `requestedby_id` int(11) NOT NULL,
  `approvedby_id` int(11) NOT NULL,
  PRIMARY KEY (`email_notification_id`),
  KEY `fk_email_notifications_users1` (`requestedby_id`),
  KEY `fk_email_notifications_users2` (`approvedby_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `email_notifications`
--

INSERT INTO `email_notifications` (`email_notification_id`, `dispatch`, `subject`, `content`, `requestedby_id`, `approvedby_id`) VALUES
(1, 1, 'blah', 'blah', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sourcing_forms`
--

CREATE TABLE IF NOT EXISTS `sourcing_forms` (
  `sourcing_form_id` int(11) NOT NULL AUTO_INCREMENT,
  `sourcing_request_id` int(11) NOT NULL,
  `requestby` varchar(45) DEFAULT NULL,
  `requestby_id` int(10) unsigned DEFAULT NULL,
  `approvedby` varchar(45) DEFAULT NULL,
  `dated` date DEFAULT NULL,
  `division_id` int(10) unsigned DEFAULT NULL,
  `department_id` int(45) unsigned DEFAULT NULL,
  `timerequired` varchar(45) DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `jobtitle` varchar(45) DEFAULT NULL,
  `grade` varchar(45) DEFAULT NULL,
  `academic` varchar(45) DEFAULT NULL,
  `specialization` varchar(45) DEFAULT NULL,
  `salary` varchar(45) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `reportsto` varchar(45) DEFAULT NULL,
  `experienceyears` varchar(45) DEFAULT NULL,
  `location` varchar(45) DEFAULT NULL,
  `jobdescription` varchar(45) DEFAULT NULL,
  `essential_skills` varchar(45) DEFAULT NULL,
  `desirable_skills` varchar(45) DEFAULT NULL,
  `proficiency` varchar(45) DEFAULT NULL,
  `otherdetails` varchar(45) DEFAULT NULL,
  `personality` varchar(45) DEFAULT NULL,
  `technical` varchar(45) DEFAULT NULL,
  `general` varchar(45) DEFAULT NULL,
  `existing_db` varchar(45) DEFAULT NULL,
  `company_posting` varchar(45) DEFAULT NULL,
  `other_posting` varchar(45) DEFAULT NULL,
  `newspaper_posting` varchar(45) DEFAULT NULL,
  `emp_referrals` varchar(45) DEFAULT NULL,
  `headhunters` varchar(45) DEFAULT NULL,
  `internal_posting` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`sourcing_form_id`),
  KEY `fk_sourcing_forms_sourcing_requests1` (`sourcing_request_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=98 ;

--
-- Dumping data for table `sourcing_forms`
--

INSERT INTO `sourcing_forms` (`sourcing_form_id`, `sourcing_request_id`, `requestby`, `requestby_id`, `approvedby`, `dated`, `division_id`, `department_id`, `timerequired`, `gender`, `jobtitle`, `grade`, `academic`, `specialization`, `salary`, `age`, `reportsto`, `experienceyears`, `location`, `jobdescription`, `essential_skills`, `desirable_skills`, `proficiency`, `otherdetails`, `personality`, `technical`, `general`, `existing_db`, `company_posting`, `other_posting`, `newspaper_posting`, `emp_referrals`, `headhunters`, `internal_posting`) VALUES
(71, 76, 'linemanager', 1, '', '2011-01-10', 2, 1, '4', 'm', 'designer', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(72, 77, 'linemanager', 1, '', '2011-01-10', 2, 1, '8', 'm', 'Programmar', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(73, 78, 'linemanager', 1, '', '2011-01-12', 1, 1, '4', 'm', 'sales representative', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(74, 79, 'hradmin', 1, '', '2011-01-21', 2, 2, '5', 'm', 'designer', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(75, 80, 'linemanager', 1, '', '2011-01-10', 2, 1, '', 'm', 'Programmar', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(76, 81, 'linemanager', 1, '', '2011-01-10', 2, 1, '', 'm', 'Web Developer', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(80, 85, 'linemanager', 1, '', '2011-01-11', 2, 1, '', 'm', 'Reporter', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(93, 98, 'linemanager', 1, '', '2011-01-12', 2, 1, '', 'm', 'Technical Assistant', '20', 'MSC', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(94, 99, 'linemanager', 1, '', '2011-01-12', 2, 1, '5', 'f', 'Female Receptionist', '12', 'F.A', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(95, 100, 'linemanager', 1, '', '2011-01-12', 2, 1, '', 'm', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(96, 101, 'linemanager', 1, '', '2011-01-12', 2, 1, '', 'm', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(97, 108, 'linemanager', 1, '', '2011-01-07', 2, 1, '', 'm', 'ceo', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', ';', '', '', ' ', ' ', ' ');

-- --------------------------------------------------------

--
-- Table structure for table `sourcing_requests`
--

CREATE TABLE IF NOT EXISTS `sourcing_requests` (
  `sourcing_request_id` int(11) NOT NULL AUTO_INCREMENT,
  `sourcing_request_title` varchar(45) DEFAULT NULL,
  `department_id` int(11) NOT NULL,
  `sourcing_request_status_id` int(11) NOT NULL,
  `comments` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`sourcing_request_id`),
  KEY `fk_jobs_departments1` (`department_id`),
  KEY `fk_sourcing_requests_sourcing_request_status1` (`sourcing_request_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=109 ;

--
-- Dumping data for table `sourcing_requests`
--

INSERT INTO `sourcing_requests` (`sourcing_request_id`, `sourcing_request_title`, `department_id`, `sourcing_request_status_id`, `comments`) VALUES
(76, 'designer', 1, 8, 'Your request has been rejected because there were no open positions that matched the criteria you specified. It has been put in a pending state for future consideration. When a position becomes available with your specified criteria, your request will be '),
(77, 'Programmar', 1, 8, 'Your request has been rejected because there were no open positions that matched the criteria you specified. It has been put in a pending state for future consideration. When a position becomes available with your specified criteria, your request will be '),
(78, 'sales representative', 1, 8, 'Your request has been rejected because there were no open positions that matched the criteria you specified. It has been put in a pending state for future consideration. When a position becomes available with your specified criteria, your request will be '),
(79, 'designer', 2, 8, '.Your request has been rejected because there were no open positions that matched the criteria you specified. It has been put in a pending state for future consideration. When a position becomes available with your specified criteria, your request will be'),
(80, 'Programmar', 1, 8, 'Your request has been rejected because there were no open positions that matched the criteria you specified. It has been put in a pending state for future consideration. When a position becomes available with your specified criteria, your request will be '),
(81, 'Web Developer', 1, 8, 'Your request has been rejected because there were no open positions that matched the criteria you specified. It has been put in a pending state for future consideration. When a position becomes available with your specified criteria, your request will be '),
(85, 'Reporter', 1, 8, 'Your request has been rejected because there were no open positions that matched the criteria you specified. It has been put in a pending state for future consideration. When a position becomes available with your specified criteria, your request will be '),
(98, 'Technical Assistant', 1, 8, 'Your request has been rejected because there were no open positions that matched the criteria you specified. It has been put in a pending state for future consideration. When a position becomes available with your specified criteria, your request will be '),
(99, 'Female Receptionist', 1, 9, '.Your request has been rejected because there were no open positions that matched the criteria you specified..'),
(100, '', 1, 8, 'Your request has been rejected because there were no open positions that matched the criteria you specified. It has been put in a pending state for future consideration. When a position becomes available with your specified criteria, your request will be '),
(101, '', 1, 8, 'Your request has been rejected because there were no open positions that matched the criteria you specified. It has been put in a pending state for future consideration. When a position becomes available with your specified criteria, your request will be '),
(102, '', 1, 1, 'This Request has been sent to HR for validation.'),
(103, 'ddddd', 1, 1, 'This Request has been sent to HR for validation.'),
(104, 'ddddd', 1, 1, 'This Request has been sent to HR for validation.'),
(105, '77', 1, 1, 'This Request has been sent to HR for validation.'),
(106, '', 1, 1, 'This Request has been sent to HR for validation.'),
(107, '', 1, 1, 'This Request has been sent to HR for validation.'),
(108, 'ceo', 1, 8, 'Your request has been rejected because there were no open positions that matched the criteria you specified. It has been put in a pending state for future consideration. When a position becomes available with your specified criteria, your request will be ');

-- --------------------------------------------------------

--
-- Table structure for table `sourcing_request_status`
--

CREATE TABLE IF NOT EXISTS `sourcing_request_status` (
  `sourcing_request_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `sourcing_request_status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`sourcing_request_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `sourcing_request_status`
--

INSERT INTO `sourcing_request_status` (`sourcing_request_status_id`, `sourcing_request_status`) VALUES
(1, 'Awaiting HR Validation'),
(2, 'Sourcing in Progress'),
(3, 'Hiring In Progress'),
(4, 'Appointment Letter Issued'),
(5, 'Candidate Accepted'),
(6, 'Candidate Joined'),
(7, 'Candidate Rejected'),
(8, 'Rejected with Pending'),
(9, 'Rejected Permanently'),
(10, 'Candidate Declined');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `users_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(45) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `user_roles_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `email_id` varchar(255) NOT NULL,
  PRIMARY KEY (`users_id`),
  KEY `fk_users_user_roles1` (`user_roles_id`),
  KEY `fk_users_departments1` (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`users_id`, `user_name`, `password`, `user_roles_id`, `department_id`, `first_name`, `last_name`, `email_id`) VALUES
(1, 'linemanager', '1171e9d2c70fc392f959a07d779b039e', 1, 1, 'Asif', 'Aslam', 'aftab.pucit@gmail.com'),
(2, 'hradmin', '1171e9d2c70fc392f959a07d779b039e', 2, 2, 'Jawwad', 'Amjad', 'aftab@dot5ive.com');

-- --------------------------------------------------------

--
-- Table structure for table `user_permissions`
--

CREATE TABLE IF NOT EXISTS `user_permissions` (
  `user_permissions_id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_name` varchar(45) DEFAULT NULL,
  `permission_desc` varchar(45) DEFAULT NULL,
  `user_roles_id` int(11) NOT NULL,
  PRIMARY KEY (`user_permissions_id`),
  KEY `fk_user_permissions_user_roles` (`user_roles_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `user_permissions`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE IF NOT EXISTS `user_roles` (
  `user_roles_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`user_roles_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`user_roles_id`, `role_name`) VALUES
(1, 'Line Manager'),
(2, 'HR Admin');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `candidates`
--
ALTER TABLE `candidates`
  ADD CONSTRAINT `fk_candidates_candidate_status1` FOREIGN KEY (`candidate_status_id`) REFERENCES `candidate_status` (`candidate_status_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_candidates_jobs1` FOREIGN KEY (`sourcing_request_id`) REFERENCES `sourcing_requests` (`sourcing_request_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `fk_departments_divisions1` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`division_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `divisions`
--
ALTER TABLE `divisions`
  ADD CONSTRAINT `fk_divisions_company1` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `email_notifications`
--
ALTER TABLE `email_notifications`
  ADD CONSTRAINT `fk_email_notifications_users1` FOREIGN KEY (`requestedby_id`) REFERENCES `users` (`users_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_email_notifications_users2` FOREIGN KEY (`approvedby_id`) REFERENCES `users` (`users_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sourcing_forms`
--
ALTER TABLE `sourcing_forms`
  ADD CONSTRAINT `fk_sourcing_forms_jobs1` FOREIGN KEY (`sourcing_request_id`) REFERENCES `sourcing_requests` (`sourcing_request_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sourcing_requests`
--
ALTER TABLE `sourcing_requests`
  ADD CONSTRAINT `fk_jobs_departments1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sourcing_requests_sourcing_request_status1` FOREIGN KEY (`sourcing_request_status_id`) REFERENCES `sourcing_request_status` (`sourcing_request_status_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_departments1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_user_roles1` FOREIGN KEY (`user_roles_id`) REFERENCES `user_roles` (`user_roles_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD CONSTRAINT `fk_user_permissions_user_roles` FOREIGN KEY (`user_roles_id`) REFERENCES `user_roles` (`user_roles_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
