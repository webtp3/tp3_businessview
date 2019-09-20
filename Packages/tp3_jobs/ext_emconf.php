<?php

/*
 * This file is part of the web-tp3/tp3_jobs.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

$EM_CONF[$_EXTKEY] = [
  'title' => 'tp3 Jobs',
  'description' => 'Joboffer on tp3',
  'category' => 'fe',
  'author' => 'Thomas Ruta',
  'author_email' => 'email@thomasruta.de',
  'state' => 'beta',
  'uploadfolder' => false,
  'createDirs' => '',
  'clearCacheOnLoad' => 0,
  'version' => '1.2.5',
  'author_company' => 'tp3',
  'constraints' =>
  [
    'depends' =>
    [
      'rte_ckeditor' => '*',
      'typo3' => '8.7.0-9.9.99',
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
      'Tp3\\Tp3Jobs\\' => 'Classes',
    ],
  ],
  'clearcacheonload' => false,
];
