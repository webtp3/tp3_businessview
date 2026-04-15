<?php

/*
 * This file is part of the package tna/sitepack.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

//if (class_exists(\Tp3\Tp3Businessview\Middleware\PageRequestMiddleware::class)) {
//    return [
//
//        'frontend' => [
//            'tp3Businessview/json' => [
//                'target' => \Tp3\Tp3Businessview\Middleware\PageRequestMiddleware::class,
//                'after' => [
//                    'typo3/cms-frontend/tsfe',
//                    'typo3/cms-frontend/authentication',
//                    'typo3/cms-frontend/backend-user-authentication',
//                    'typo3/cms-frontend/site',
//                ]
//            ],
//
//        ],
//        'backend' => [
//            'tp3Businessview/json' => [
//                'target' => \Tp3\Tp3Businessview\Middleware\PageRequestMiddleware::class,
//                'after' => [
//                    'typo3/cms-backend/authentication',
//                    'typo3/cms-backend/backend-module-validator',
//                    'typo3/cms-backend/site-resolvere',
//                ]
//            ],
//
//        ]
//    ];
//}
