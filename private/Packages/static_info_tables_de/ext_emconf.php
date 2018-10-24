<?php
/**
 * Extension Manager configuration file for ext "static_info_tables_de"
 */
$EM_CONF[$_EXTKEY] = array(
	'title' => 'Static Info Tables (de)',
	'description' => 'German (de) language pack for the Static Info Tables providing localized names for countries, currencies and so on.',
	'category' => 'misc',
	'version' => '6.5.2',
	'state' => 'stable',
	'uploadfolder' => 0,
	'createDirs' => '',
	'clearCacheOnLoad' => 0,
	'author' => 'Thomas Ruta',
	'author_email' => 'email@thomasruta.de',
	'author_company' => 'R&P IT Consulting GmbH',
    array (
        'depends' =>
            array (
                'typo3' => '6.2.0-8.7.99',
                'static_info_tables' => '6.3.1-6.99.99',
            ),
        'conflicts' =>
            array (
            ),
        'suggests' =>
            array (
            ),
    ),
    'clearcacheonload' => false,
);