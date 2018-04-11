#
# Table structure for table 'tx_tp3businessview_domain_model_tp3businessview'
#
CREATE TABLE tx_tp3businessview_domain_model_tp3businessview (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	created_by varchar(255) DEFAULT '' NOT NULL,
	name varchar(255) DEFAULT '' NOT NULL,
	external_links varchar(255) DEFAULT '' NOT NULL,
	gallery varchar(255) DEFAULT '' NOT NULL,
	intro varchar(255) DEFAULT '' NOT NULL,
	pano_animation varchar(255)   DEFAULT '0' NOT NULL,
	social_gallery varchar(255) DEFAULT '' NOT NULL,
	pano_options varchar(255) DEFAULT '' NOT NULL,
	contact int(11) unsigned DEFAULT '0' NOT NULL,
	app int(11) unsigned DEFAULT '0' NOT NULL,
	panoramas int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tt_address'
#
CREATE TABLE tt_address (

	tp3businessview int(11) unsigned DEFAULT '0' NOT NULL,
	googleplus varchar(255) DEFAULT '' NOT NULL,
	cid varchar(255) DEFAULT '' NOT NULL,

);


#
# Table structure for table 'tx_tp3businessview_domain_model_panoramas'
#
CREATE TABLE tx_tp3businessview_domain_model_panoramas (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	pano_id varchar(255) DEFAULT '' NOT NULL,
	heading varchar(255) DEFAULT '' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,

	pitch varchar(255) DEFAULT '' NOT NULL,
	zoom varchar(255) DEFAULT '' NOT NULL,
	position varchar(255) DEFAULT '' NOT NULL,
	tp3businessviews int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tt_address'
#
CREATE TABLE tt_address (

	tp3businessview int(11) unsigned DEFAULT '0' NOT NULL,
  tx_extbase_type varchar(255) DEFAULT '' NOT NULL,
  tx_cal_controller_latitude tinytext DEFAULT  '0'  NOT NULL,
	tx_cal_controller_longitude tinytext DEFAULT  '0' NOT NULL,
);

#
# Table structure for table 'pages'
#
CREATE TABLE pages (
	tx_tp3businessview_onpage tinyint(4) DEFAULT '0' NOT NULL,
	tx_tp3businessview_panorama int(11) DEFAULT NULL,
	tx_tp3businessview_injetionpoint varchar(255) DEFAULT '' NOT NULL,
);

CREATE TABLE `tx_tp3businessview_domain_model_panoramas_mm` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `uid_local` int(11) NOT NULL,
  `uid_foreign` int(11) NOT NULL,
  `sorting` int(11) DEFAULT NULL,
  `sorting_foreign` int(11) DEFAULT NULL,
  `tablenames` varchar(100) NOT NULL DEFAULT '',
  `pid` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`uid`),
  KEY `sorting` (`uid_local`,`sorting`),
  KEY `sorting_foreign` (`uid_foreign`),
  KEY `item` (`pid`,`uid_local`)
);