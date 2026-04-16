<?php

/*
 * This file is part of the package web-tp3/tp3-businessview.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die();
$_EXTKEY = 'tp3_businessview';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Tp3Businessview',
    'Tp3businessview',
    [
        \Tp3\Tp3Businessview\Backend\JsonResponseHandler::class => 'index,read,update,create, dispatch',

        \Tp3\Tp3Businessview\Controller\Tp3BusinessViewController::class => 'list,show,new,update,edit',
        \Tp3\Tp3Businessview\Controller\PanoramasController::class => 'index,new,edit,create,update,delete',
        \Tp3\Tp3Businessview\Controller\BusinessAdressController::class => 'index,new,edit,create,update,delete',
    ],
    // non-cacheable actions
    [
        \Tp3\Tp3Businessview\Backend\JsonResponseHandler::class => 'update,create,dispatch',

        \Tp3\Tp3Businessview\Controller\Tp3BusinessViewController::class => 'createpano,create',
        \Tp3\Tp3Businessview\Controller\PanoramasController::class => 'create',
        \Tp3\Tp3Businessview\Controller\BusinessAdressController::class => 'create',
    ]
);

// wizards

// Icons

if (class_exists(\Tp3\Tp3Businessview\Frontend\PageRenderer\Tp3PageRenderer::class)) {
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess'][] = \Tp3\Tp3Businessview\Frontend\PageRenderer\Tp3PageRenderer::class . '->render';
}
