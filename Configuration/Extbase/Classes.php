<?php
declare(strict_types = 1);

/*
 * This file is part of the web-tp3/tp3businessview.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

return [

    \Tp3\Tp3Businessview\Domain\Model\BusinessAdress::class => [
        'tableName' => 'tt_address',
        'recordType' => \Tp3\Tp3Businessview\Domain\Model\BusinessAdress::class,
        'properties' => [
            'uid_foreign' => [
                'fieldName' => 'tp3businessview'
            ],
            'cid' => [
                'fieldName' => 'cid'
            ],
        ],
    ],
    \Tp3\Tp3Businessview\Domain\Model\File::class => [
        'tableName' => 'sys_file',
        'recordType' => \Tp3\Tp3Businessview\Domain\Model\File::class,

    ],
];
