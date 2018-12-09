<?php

/**
 * Definitions for routes provided by EXT:tp3_businessview
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
