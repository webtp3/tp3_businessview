<?php

declare(strict_types=1);

/*
 * This file is part of the package web-tp3/tp3-businessview.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

return [
    'web_tp3businessviewmodule' => [
        'parent' => 'web',
        'position' => ['after' => 'list'],
        'access' => 'user,group',
        'iconIdentifier' => 'module-web_list',
        'labels' => 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_tp3businessviewdesigner.xlf',
        'routes' => [
            '_default' => [
                'target' => \Tp3\Tp3Businessview\Controller\ModuleController::class . '::indexAction',
            ],
        ],
    ],
];
