<?php

/*
 * This file is part of the package web-tp3/tp3-businessview.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

return [
    'tp3businessview_tp3businessview_sort' => [
        'path' => '/tp3Businessview/sort',
        'target' => \Tp3\Tp3Businessview\Backend\JsonResponseHandler::class . '::sortAction',
        'packageName' => 'tp3_businessview',
        'controller' => 'JsonResponseHandler',
        'action' => 'sort',
        'access' => 'admin',
    ],
    'tp3businessview_json' => [
        'path' => '/tp3Businessview/json',
        'target' => \Tp3\Tp3Businessview\Backend\JsonResponseHandler::class . '::indexAction',
        'packageName' => 'tp3_businessview',
        'controller' => 'JsonResponseHandler',
        'action' => 'index',
        'access' => 'admin',
    ],
    'tp3businessview_dispatch' => [
        'path' => '/tp3Businessview/dispatch',
        'target' => \Tp3\Tp3Businessview\Backend\JsonResponseHandler::class . '::dispatchAction',
        'packageName' => 'tp3_businessview',
        'controller' => 'JsonResponseHandler',
        'action' => 'dispatch',
        'access' => 'admin',
    ],
];
