# phpMyAdmin SQL Dump
# version 2.5.5
# http://www.phpmyadmin.net
#
# Host: localhost
# Generation Time: Feb 23, 2004 at 07:42 PM
# Server version: 4.0.4
# PHP Version: 4.2.3
# 
# Database : `nlb3-test`
# 

# --------------------------------------------------------

#
# Table structure for table `nlb3_articles`
#

CREATE TABLE `nlb3_articles` (
  `article_id` int(11) NOT NULL auto_increment,
  `author_id` int(11) NOT NULL default '0',
  `subject` varchar(255) NOT NULL default '',
  `date` bigint(10) NOT NULL default '0',
  `body` text NOT NULL,
  PRIMARY KEY  (`article_id`)
) TYPE=MyISAM AUTO_INCREMENT=0;

# --------------------------------------------------------

#
# Table structure for table `nlb3_avatars`
#

CREATE TABLE `nlb3_avatars` (
  `avatar_id` int(11) NOT NULL auto_increment,
  `owner_id` int(11) NOT NULL default '0',
  `file` varchar(255) NOT NULL default '',
  `isCustom` tinyint(1) NOT NULL default '0',
  `type` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`avatar_id`)
) TYPE=MyISAM AUTO_INCREMENT=0 ;

# --------------------------------------------------------

#
# Table structure for table `nlb3_banned`
#

CREATE TABLE `nlb3_banned` (
  `banned_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '0',
  `ip` varchar(15) NOT NULL default '',
  `reason` varchar(255) NOT NULL default '',
  `expires` bigint(10) NOT NULL default '0',
  PRIMARY KEY  (`banned_id`)
) TYPE=MyISAM COMMENT='Banned users & IP Addresses' AUTO_INCREMENT=0;

# --------------------------------------------------------

#
# Table structure for table `nlb3_blogs`
#

CREATE TABLE `nlb3_blogs` (
  `blog_id` int(11) NOT NULL auto_increment,
  `author_id` int(11) NOT NULL default '0',
  `date` bigint(10) NOT NULL default '0',
  `subject` varchar(250) default NULL,
  `body` text NOT NULL,
  `custom` varchar(250) default NULL,
  `mood` varchar(250) default NULL,
  `comments` int(11) NOT NULL default '0',
  `html` tinyint(1) NOT NULL default '1',
  `smiles` tinyint(1) NOT NULL default '1',
  `bb` tinyint(4) NOT NULL default '1',
  `access` tinyint(1) NOT NULL default '1',
  `views` int(11) NOT NULL default '0',
  PRIMARY KEY  (`blog_id`,`blog_id`),
  KEY `blogid` (`blog_id`)
) TYPE=MyISAM AUTO_INCREMENT=0 ;

# --------------------------------------------------------

#
# Table structure for table `nlb3_comments`
#

CREATE TABLE `nlb3_comments` (
  `comment_id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `author_id` int(11) NOT NULL default '0',
  `date` bigint(10) NOT NULL default '0',
  `body` text NOT NULL,
  `ip` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`comment_id`)
) TYPE=MyISAM AUTO_INCREMENT=0 ;

# --------------------------------------------------------

#
# Table structure for table `nlb3_config`
#

CREATE TABLE `nlb3_config` (
  `config_id` int(11) NOT NULL auto_increment,
  `name` varchar(200) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`config_id`)
) TYPE=MyISAM AUTO_INCREMENT=0 ;

# --------------------------------------------------------

#
# Table structure for table `nlb3_friends`
#

CREATE TABLE `nlb3_friends` (
  `owner_id` int(11) NOT NULL default '0',
  `friend_id` int(11) NOT NULL default '0',
  `date` bigint(10) NOT NULL default '0'
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `nlb3_smiles`
#

CREATE TABLE `nlb3_smiles` (
  `smile_id` int(11) NOT NULL auto_increment,
  `code` char(100) NOT NULL default '',
  `image` char(255) NOT NULL default '',
  `desc` char(255) NOT NULL default '',
  PRIMARY KEY  (`smile_id`)
) TYPE=MyISAM AUTO_INCREMENT=0 ;

# --------------------------------------------------------

#
# Table structure for table `nlb3_template_cache`
#

CREATE TABLE `nlb3_template_cache` (
  `owner_id` int(11) NOT NULL default '0',
  `blog` text NOT NULL,
  `blog_updated` bigint(10) NOT NULL default '0',
  `friends` text NOT NULL,
  `friends_updated` bigint(10) NOT NULL default '0',
  `profile` text NOT NULL,
  `profile_updated` varchar(10) NOT NULL default '',
  PRIMARY KEY  (`owner_id`)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `nlb3_template_source`
#

CREATE TABLE `nlb3_template_source` (
  `owner_id` int(11) NOT NULL default '0',
  `blog` text NOT NULL,
  `blog_updated` bigint(10) NOT NULL default '0',
  `friends` text NOT NULL,
  `friends_updated` bigint(10) NOT NULL default '0',
  `profile` text NOT NULL,
  `profile_updated` bigint(10) NOT NULL default '0',
  PRIMARY KEY  (`owner_id`)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `nlb3_users`
#

CREATE TABLE `nlb3_users` (
  `user_id` int(11) NOT NULL auto_increment,
  `username` varchar(30) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `access` varchar(255) NOT NULL default '',
  `registered` bigint(10) NOT NULL default '0',
  `last_login` bigint(10) NOT NULL default '0',
  `ip` varchar(15) NOT NULL default '0',
  `blog_count` int(11) NOT NULL default '0',
  `timezone` int(11) NOT NULL default '0',
  `bio` text,
  `custom` varchar(255) default NULL,
  `date_format` varchar(20) NOT NULL default '',
  `birthday` bigint(10) default NULL,
  `perpage` int(11) NOT NULL default '0',
  `gender` int(11) default '0',
  `valid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`user_id`)
) TYPE=MyISAM AUTO_INCREMENT=0;

# --------------------------------------------------------

#
# Table structure for table `nlb3_validate`
#

CREATE TABLE `nlb3_validate` (
  `validate_id` int(11) NOT NULL auto_increment,
  `owner_id` int(11) NOT NULL default '0',
  `code` varchar(32) NOT NULL default '',
  `date` bigint(10) NOT NULL default '0',
  PRIMARY KEY  (`validate_id`)
) TYPE=MyISAM AUTO_INCREMENT=0;


#
# Dumping data for table `nlb3_articles`
#

INSERT INTO `nlb3_articles` VALUES (1, 1, 'About NewLife Blogger', 1074035272, 'The NewLife Blogging system is a free, open source, multi-user blogging system that allows large community websites to offer blogs to their members.\r\n\r\nCreated by <a href="http://www.sevengraff.com">Sevengraff</a>. &copy; copyright 2004. Released under the terms of the GPL Liscense.');
INSERT INTO `nlb3_articles` VALUES (2, 1, 'Credits', 1075153537, 'People who have contributed to the NewLife Blogging System 3.0:\r\n\r\n<li> Jon (KNK) [Hosting] </li>\r\n<li> Franck Marcia [ETS] </li>\r\n<li> PEAR [validate email] </li>\r\n<li> FusionPHP Team [BB Code] </li>\r\n<li> OSWD.org [designs] </li>\r\n<li> Neotzc [NewLife webmaster] </li>\r\n<li> Erik Bosrup [OverLib Tooltip] </li>\r\n<li> Forum helpers at sevengraff.com </li>\r\n\r\nThank you to everyone who has helped make NLB the best!');

#
# Dumping data for table `nlb3_config`
#

INSERT INTO `nlb3_config` VALUES (1, 'validate_email', 'false');
INSERT INTO `nlb3_config` VALUES (2, 'lang', 'en');
INSERT INTO `nlb3_config` VALUES (3, 'site_name', 'NewLife Blogger');
INSERT INTO `nlb3_config` VALUES (4, 'news_date_format', 'M jS, Y g:i a');
INSERT INTO `nlb3_config` VALUES (5, 'news_per_page', '6');
INSERT INTO `nlb3_config` VALUES (6, 'login_time', '1');
INSERT INTO `nlb3_config` VALUES (7, 'art_date_view', 'M jS, Y g:i a');
INSERT INTO `nlb3_config` VALUES (8, 'art_date_list', 'M jS, Y g:i a');
INSERT INTO `nlb3_config` VALUES (9, 'memlist_per_page', '20');
INSERT INTO `nlb3_config` VALUES (10, 'memlist_date_format', 'M jS, Y');
INSERT INTO `nlb3_config` VALUES (11, 'server_timezone', '0');
INSERT INTO `nlb3_config` VALUES (12, 'recent_blog_num', '20');
INSERT INTO `nlb3_config` VALUES (13, 'recent_blog_date', 'M jS, Y g:i a');
INSERT INTO `nlb3_config` VALUES (14, 'default_date_format', 'M jS, Y g:i a');
INSERT INTO `nlb3_config` VALUES (15, 'default_access', 'blog:comment:av_use:av_up:friends:tpl_change:tpl_custom');
INSERT INTO `nlb3_config` VALUES (16, 'outter_template_source', '{mask:main}\r\n\r\n{safe: {USER_TEMPLATE} }\r\n\r\n<div align="center" style="background-color: #dddddd;">\r\n<a href="http://www.sevengraff.com" target="_blank">NewLife Blogger 3.0 by Sevengraff</a></div>\r\n\r\n{/mask}');
INSERT INTO `nlb3_config` VALUES (17, 'outter_template_source_time', '1077586007');
INSERT INTO `nlb3_config` VALUES (18, 'outter_template_cache', 'ETSa:1:{s:4:"main";a:3:{s:4:"2:15";s:4:"\r\n\r\n";s:11:"67108864:21";a:3:{s:4:"2:22";s:1:" ";s:19:"4:36:USER_TEMPLATE:";s:0:"";s:4:"2:38";s:1:" ";}s:5:"2:199";s:160:"\r\n\r\n<div align="center" style="background-color: #dddddd;">\r\n<a href="http://www.sevengraff.com" target="_blank">NewLife Blogger 3.0 by Sevengraff</a></div>\r\n\r\n";}}');
INSERT INTO `nlb3_config` VALUES (19, 'outter_template_cache_time', '1077586010');
INSERT INTO `nlb3_config` VALUES (20, 'home_text', 'NewLife Blogger');
INSERT INTO `nlb3_config` VALUES (21, 'mail_type', 'none');
INSERT INTO `nlb3_config` VALUES (22, 'smtp_username', '');
INSERT INTO `nlb3_config` VALUES (23, 'smtp_password', '');
INSERT INTO `nlb3_config` VALUES (24, 'smtp_host', '');
INSERT INTO `nlb3_config` VALUES (25, 'mail_from', 'admin@domain.com');
INSERT INTO `nlb3_config` VALUES (26, 'sendmail_path', '/usr/sbin/sendmail');
INSERT INTO `nlb3_config` VALUES (27, 'comment_date_format', 'F dS, Y');
INSERT INTO `nlb3_config` VALUES (28, 'avatar_size', '10');
INSERT INTO `nlb3_config` VALUES (29, 'avatar_width', '80');
INSERT INTO `nlb3_config` VALUES (30, 'avatar_height', '80');
INSERT INTO `nlb3_config` VALUES (31, 'avatar_types', 'gif,jpg,jpeg,png');
INSERT INTO `nlb3_config` VALUES (32, 'moods', 'accomplished\naggravated\namused\nangry\nanimated\nannoyed\nanxious\napathetic\nartistic\nawake\nbitchy\nblah\nblank\nbored\nbouncy\nbusy\ncalm\ncheerful\nchipper\ncold\ncomplacent\nconfused\ncontemplative\ncontent\ncranky\ncrappy\ncrazy\ncreative\ncrushed\ncurious\ncynical\ndepressed\ndetermined\ndevious\ndirty\ndisappointed\ndiscontent\ndistressed\nditsy\ndorky\ndrained\ndrunk\necstatic\nembarrassed\nenergetic\nenraged\nenthralled\nenvious\nexcited\nexhausted\nflirty\nfrustrated\nfull\ngeeky\ngiddy\ngiggly\ngloomy\ngood\ngrateful\ngroggy\ngrumpy\nguilty\nhappy\nhigh\nhopeful\nhorny\nhot\nhungry\nhyper\nimpressed\nindescribable\nindifferent\ninfuriated\nintimidated\nirate\nirritated\njealous\njubilant\nlazy\nlethargic\nlistless\nlonely\nloved\nmelancholy\nmellow\nmischievous\nmoody\nmorose\nnaughty\nnauseated\nnerdy\nnervous\nnostalgic\nnumb\nokay\noptimistic\npeaceful\npensive\npessimistic\npissed off\npleased\npredatory\nproductive\nquixotic\nrecumbent\nrefreshed\nrejected\nrejuvenated\nrelaxed\nrelieved\nrestless\nrushed\nsad\nsatisfied\nscared\nshocked\nsick\nsilly\nsleepy\nsore\nstressed\nsurprised\nsympathetic\nthankful\nthirsty\nthoughtful\ntired\ntouched\nuncomfortable\nweird\nworking\nworried');


#
# Dumping data for table `nlb3_smiles`
#

INSERT INTO `nlb3_smiles` VALUES (1, '>:(', 'angry.gif', 'Angry!');
INSERT INTO `nlb3_smiles` VALUES (2, 'B)', 'cool.gif', 'Cool');
INSERT INTO `nlb3_smiles` VALUES (3, ':cry', 'cry.gif', 'Cry');
INSERT INTO `nlb3_smiles` VALUES (4, ':o', 'eep.gif', 'eep!');
INSERT INTO `nlb3_smiles` VALUES (5, ':D', 'grin.gif', 'Grin');
INSERT INTO `nlb3_smiles` VALUES (6, ':)', 'happy.gif', 'happy');
INSERT INTO `nlb3_smiles` VALUES (7, ':(', 'sad.gif', 'sad');
INSERT INTO `nlb3_smiles` VALUES (8, ':p', 'tounge.gif', 'tounge');
INSERT INTO `nlb3_smiles` VALUES (9, ';)', 'wink.gif', 'wink');

