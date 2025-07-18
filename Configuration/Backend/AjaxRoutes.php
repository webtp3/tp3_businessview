<?php

/*
 * This file is part of the package web-tp3/tp3-businessview.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

return [
     'tp3businessview_tp3businessview' => [
         'path' => '/tp3Businessview/sort',
         'target' => \Tp3\Tp3Businessview\Backend\Tp3Ajax::class . '::sortAction'
     ],
   /*tp3businessview_tp3businessview' => [
         'path' => '/tp3Businessview/new',
         'target' => \Tp3\Tp3Businessview\Controller\Tp3BusinessViewController::class . '::newAction'
     ]*/
];
