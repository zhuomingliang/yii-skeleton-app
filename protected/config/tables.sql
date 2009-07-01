-- --------------------------------------------------------
-- Please run!
-- Creates table structures and needed data.
-- Also creates an admin account (login with: username: admin    password: admin)
--
-- For testing data, see other sql files
--
--
-- Table structure for table `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`id`, `name`) VALUES
(1, 'Not logged on'),
(2, 'User'),
(3, 'Admin'),
(4, 'Site Admin');


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` char(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `email_visible` tinyint(1) NOT NULL DEFAULT '0',
  `notify_comments` tinyint(1) NOT NULL DEFAULT '1',
  `notify_messages` tinyint(1) NOT NULL DEFAULT '1',
  `about` text NOT NULL,
  `aboutParsed` text NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT '2',
  `email_confirmed` char(21) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

INSERT INTO `user` (`id`, `username`, `password`, `email`, `email_visible`, `notify_comments`, `notify_messages`, `about`, `group_id`, `email_confirmed`, `created`, `modified`) VALUES
(1, 'Admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@example.com', 1, 1, 1, 'Hello everybody.  Admin test account.', 4, NULL, '2008-07-26 01:34:53', '2009-01-18 22:43:34');
--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `contentParsed` text NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


--
-- Table structure for table `failedemail`
--

CREATE TABLE IF NOT EXISTS `failedemail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `to` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `serialize` text NOT NULL,
  `sent` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
 
--
-- Table structure for table `textedit`
--

CREATE TABLE IF NOT EXISTS `textedit` (
  `namedId` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `contentParsed` text NOT NULL,
  PRIMARY KEY (`namedId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data for table `textedit` - REQUIRED
--

INSERT INTO `textedit` (`namedId`, `content`) VALUES
('contact', 'If you have business inquires or other questions, please fill out the following form to contact us. Thank you.'),
('footer', 'Not really copyrighted, but if it was, I would write that here\n<br />\nPowered by <a href="http://www.yiiframework.com/">Yii Framework</a>.'),
('home1', '*Note:* Usually requires nightly build of Yii\n\n### Features:\n\n* User management\n     1. Login/logout\n     2. Registration\n     3. Email verification\n     4. Administrative functions\n     5. User list (using Ajax pagination)\n     6. User recovery\n* User groups\n     1. Group authorization \n* Extensions\n     1. Email\n     2. Time Helper\n     3. Logable Behavior\n     4. Parse Cache Behavior\n     5. AutoTimestampBehavior\n     6. TextEdit module\n* Extended access control (or rather simplified)\n* Contact page\n* Logging and clean urls configured \n\n### Checklist for installing:\n\n* Edit paths in `index.php` as necessary\n* Set up database in the `main.php` config file\n* Run sql in the `protected/config/tables.sql`\n* Optionally load mysql test data in `protected/config/`\n* Login as admin with `username=admin`, `password=admin`\n\n### Links\n* [Yii Forum Thread](http://www.yiiframework.com/forum/index.php/topic,799.0.html)\n* [SVN at Google code](http://code.google.com/p/yii-skeleton-app/)'),
('userRecovery', 'Forgot your username and/or password? Not to worry. Enter the email below that you used to create an account with and press "submit" and we will email your login credentials to you.');
