<?php

/*
 * This file is part of the web-tp3/tp3mods.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

$EM_CONF[$_EXTKEY] = [
    'title' => 'tp3 Mods',
    'description' => 'modifications on tp3 - incl. analytics optout',
    'category' => 'module',
    'author' => 'Thomas Ruta',
    'author_email' => 'email@thomasruta.de',
    'author_company' => 'tp3',
    'state' => 'beta',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '1.4.5',
    'author_company' => 'tp3',
    'constraints' =>
        [
            'depends' =>
                [
                    'typo3' => '8.7.0-9.9.99',
                    'bootstrap_package' => '8.0.0-9.9.99',
                ],
            'conflicts' =>
                [

                ],
            'suggests' =>
                [
                ],
        ],
    'autoload' =>
        [
            'psr-4' =>
                [
                    'Tp3\\Tp3mods\\' => 'Classes',
                    'Tp3\\Tp3mods\\ErrorHandling\\' => 'src/'
                ],
        ],

];
