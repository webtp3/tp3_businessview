<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "tp3_businessview"
 *
 * Auto generated by Extension Builder 2018-03-27
 *
 * Manual updates:
 * Only the data in the array - anything else is removed by next write.
 * "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = [
    'title' => 'tp3 BusinessView',
    'description' => 'google businessview für typo3 - 360° Panorama Designer für Ihren virtuellen Rundgang',
    'category' => 'plugin',
    'author' => 'Thomas Ruta',
    'author_email' => 'support@r-p-it.de',
    'state' => 'beta',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '0.3.7',
    'constraints' =>
        array (
            'depends' =>
                array (
                    'typo3' => '8.7.0-9.9.99',
                    'tt_address' => '*',
                ),
            'conflicts' =>
                array (

                ),
            'suggests' =>
                array (
                    'tp3_openhours' => '*',
                ),
        ),
    'autoload' =>
        array (
            'psr-4' =>
                array (
                    'Tp3\\Tp3Businessview\\' => 'Classes',
                ),
        ),
    'clearcacheonload' => false,
    'author_company' => 'tp3',
];
