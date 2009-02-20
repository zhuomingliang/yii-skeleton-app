-- --------------------------------------------------------
-- Please run!
-- Creates table structures and fake users (for testing)
-- Also creates an admin account (login with:     username: admin    password: admin)
--
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
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


--
-- Table structure for table `parsecache`
-- You need this if you plan on using the ParseCacheBehavior
--

CREATE TABLE IF NOT EXISTS `parsecache` (
  `table` varchar(20) NOT NULL,
  `id` int(11) NOT NULL,
  `column` varchar(20) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`table`,`id`,`column`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;