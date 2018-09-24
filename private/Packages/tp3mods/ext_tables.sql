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
	aggregate_rating smallint(5) unsigned DEFAULT '0' NOT NULL,
	address int(11) unsigned DEFAULT '0',

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted smallint(5) unsigned DEFAULT '0' NOT NULL,
	hidden smallint(5) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),

);

#
# Table structure for table 'tt_address'
#
CREATE TABLE tt_address (

	microdata_adress smallint(5) unsigned DEFAULT '0' NOT NULL,

	tx_extbase_type varchar(255) DEFAULT '' NOT NULL,

);

#
# Table structure for table 'tt_address'
#
CREATE TABLE tt_address (
	categories int(11) unsigned DEFAULT '0' NOT NULL,
);

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder