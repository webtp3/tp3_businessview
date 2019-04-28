<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "bootstrap_grids"
 ***************************************************************/

$EM_CONF[$_EXTKEY] = [
	'title' => 'Grids for bootstrap',
	'description' => 'Gridelements for bootstrap v4. Column grids, tabs and accordion.',
	'category' => 'misc',
	'author' => 'Thomas Ruta',
	'author_email' => 'email@thomasruta.de',
	'author_company' => '',
	'version' => '2.1.10',
	'state' => 'stable',
	'uploadfolder' => '0',
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 1,
	'constraints' => [
		'depends' => [
			'typo3' => '8.7.0-9.5.99',
			'gridelements' => '8.0.0-9.9.99',
		],
		'conflicts' => [
		],
	],
    'autoload' => [
        'psr-4' => ['Laxap\\BootstrapGrids\\' => 'Classes']
    ],
];

?>
