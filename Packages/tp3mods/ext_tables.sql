#
# Table structure for table 'tx_tp3mods_domain_model_tp3mods'
#
CREATE TABLE tx_tp3mods_domain_model_tp3mods (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	microdata text,
	konfiguration text,
	snippet_type text,
	main_entry text,
	aggregate_rating varchar(255)  DEFAULT '0' NOT NULL,
	address int(11)  DEFAULT '0',
	sorting int(11) DEFAULT '0' NOT NULL,
	tstamp int(11)  DEFAULT '0' NOT NULL,
	crdate int(11)  DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted smallint(5)  DEFAULT '0' NOT NULL,
	hidden smallint(5)  DEFAULT '0' NOT NULL,
	starttime int(11)  DEFAULT '0' NOT NULL,
	endtime int(11)  DEFAULT '0' NOT NULL,
  pages int(11)  DEFAULT '0' NOT NULL,
  login_page int(11)  DEFAULT '0' NOT NULL,
  privacy_page int(11)  DEFAULT '0' NOT NULL,
  terms_page int(11)  DEFAULT '0' NOT NULL,
	error_page int(11)  DEFAULT '0' NOT NULL,
	profile_page int(11)  DEFAULT '0' NOT NULL,
	news_page int(11)  DEFAULT '0' NOT NULL,
	search_page int(11)  DEFAULT '0' NOT NULL,
	PRIMARY KEY (uid),
	KEY parent (pid),
  KEY ref (pages)
);


#
# Table structure for table 'tx_tp3mods_domain_model_mm'
#
CREATE TABLE tx_tp3mods_domain_model_mm (
  uid int(11) NOT NULL auto_increment,
  pid int(11) DEFAULT '0' NOT NULL,
  uid_local int(11) DEFAULT '0' NOT NULL,
	uid_foreign int(11) DEFAULT '0' NOT NULL,
	tablenames varchar(255) DEFAULT '' NOT NULL,
	fieldname varchar(255) DEFAULT '' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	sorting_foreign int(11) DEFAULT '0' NOT NULL,
	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY uid_local_foreign (uid_local,uid_foreign),
	KEY uid_foreign_tablefield (uid_foreign,tablenames(40),fieldname(3),sorting_foreign)
);

#
# Table structure for table 'tt_address'
#
CREATE TABLE tt_address (
  microdata_adress text,
  tx_cal_controller_latitude tinytext DEFAULT  '0'  NOT NULL,
	tx_cal_controller_longitude tinytext DEFAULT  '0' NOT NULL
);

#
# Table structure for table 'pages'
#
CREATE TABLE pages (
  tp3parallax int(2) DEFAULT '1' NOT NULL,
  tp3microdata int(11) DEFAULT NULL

);
#
# Table structure for table 'pages_language_overlay'
#
CREATE TABLE pages_language_overlay (
	tp3parallax int(2) DEFAULT '1' NOT NULL,
  tp3microdata int(11) DEFAULT NULL
);
#
# Table structure for table 'sys_file_reference'
#
CREATE TABLE sys_file_reference (

	speed varchar(255) DEFAULT '' NOT NULL,
  parallax int(2) DEFAULT '1' NOT NULL
);
