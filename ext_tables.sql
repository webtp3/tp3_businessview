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
	pano_animation int(11) DEFAULT '0' NOT NULL,
	social_gallery varchar(255) DEFAULT '' NOT NULL,
	pano_options int(11) DEFAULT '0' NOT NULL,
	contact int(11) unsigned DEFAULT '0',
	app int(11) unsigned DEFAULT '0',
	panoramas int(11) unsigned DEFAULT '0',

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

);

#
# Table structure for table 'tx_tp3businessview_domain_model_businessapp'
#
CREATE TABLE tx_tp3businessview_domain_model_businessapp (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	businessview_id varchar(255) DEFAULT '' NOT NULL,
	google_maps_java_script_api_key varchar(255) DEFAULT '' NOT NULL,
	businessview_canvas_selector varchar(255) DEFAULT '' NOT NULL,

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
# Table structure for table 'tx_tp3businessview_domain_model_panoramas'
#
CREATE TABLE tx_tp3businessview_domain_model_panoramas (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	pano_id varchar(255) DEFAULT '' NOT NULL,
	heading varchar(255) DEFAULT '' NOT NULL,
	pitch varchar(255) DEFAULT '' NOT NULL,
	zoom varchar(255) DEFAULT '' NOT NULL,

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
