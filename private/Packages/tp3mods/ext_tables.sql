#
# Table structure for table 'tx_tp3mods_domain_model_tp3mods'
#
CREATE TABLE tx_tp3mods_domain_model_tp3mods (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
  hidden int(1) unsigned DEFAULT '0' NOT NULL,
  deleted int(1) unsigned DEFAULT '0' NOT NULL,

	microdata text NOT NULL,
	konfiguration text NOT NULL,
	address int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,

	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),

);

#
# Table structure for table 'tt_address'
#
CREATE TABLE tt_address (

  tx_cal_controller_latitude tinytext DEFAULT  '0'  NOT NULL,
	tx_cal_controller_longitude tinytext DEFAULT  '0' NOT NULL,

);