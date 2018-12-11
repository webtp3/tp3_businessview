#
# Table structure for table 'tt_address'
#
CREATE TABLE tt_address (

	open_hours int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_tp3openhours_domain_model_openhour'
#
CREATE TABLE tx_tp3openhours_domain_model_openhour (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	ttaddress int(11) unsigned DEFAULT '0' NOT NULL,

	day int(11) DEFAULT '0' NOT NULL,
	open_time int(11) DEFAULT '0' NOT NULL,
	close_time int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_tp3openhours_domain_model_openhour'
#
CREATE TABLE tx_tp3openhours_domain_model_openhour (

	ttaddress int(11) unsigned DEFAULT '0' NOT NULL,

);
