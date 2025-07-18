<?php
declare(strict_types = 1);

/*
 * This file is part of the package web-tp3/tp3-businessview.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

if (class_exists(\Tp3\Tp3Businessview\Domain\Model\BusinessAdress::class)) {
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
            'properties' => [
                'uid_foreign' => [
                    'fieldName' => 'file'
                ],

            ],

        ],
    ];
} else {
    return [

    ];
}
