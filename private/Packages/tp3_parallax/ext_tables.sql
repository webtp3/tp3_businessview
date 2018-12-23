#
# Table structure for table 'sys_file_collection'
#
CREATE TABLE sys_file_collection (

	parallax_page int(11) DEFAULT '0' NOT NULL,
	parallax_content text,

);
#
# Table structure for table 'pages'
#
CREATE TABLE pages (

	page_parallax int(11) DEFAULT '0' NOT NULL,

);
#
# Table structure for table 'pages_language_overlay'
#
CREATE TABLE pages_language_overlay (
	page_parallax varchar(11) DEFAULT '0' NOT NULL,

);
#
# Table structure for table 'tx_tp3_parallax_mm'
#
CREATE TABLE tx_tp3_parallax_mm (
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
# Table structure for table 'tx_tp3parallax_domain_model_collections'
#
CREATE TABLE tx_tp3parallax_domain_model_collections (

	uid int(11) NULL,
	pid int(11) DEFAULT '0' NOT NULL,

	parallaxsection int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted smallint(5) unsigned DEFAULT '0' NOT NULL,
	hidden smallint(5) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state smallint(6) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,
	l10n_state text,



);
-- PRIMARY KEY (uid),
-- 	KEY parent (pid),
-- 	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
-- 	KEY language (l10n_parent,sys_language_uid)
