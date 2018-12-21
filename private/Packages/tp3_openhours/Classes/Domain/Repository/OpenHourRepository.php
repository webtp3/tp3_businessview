<?php

/*
 * This file is part of the web-tp3/tp3openhours.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3Openhours\Domain\Repository;

/***
 *
 * This file is part of the "tt_address OpenHours" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Thomas Ruta &lt;email@thomasruta.de>, tp3
 *
 ***/

/**
 * The repository for OpenHours
 */
class OpenHourRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * @var array
     */
    protected $defaultOrderings = [
        'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    ];

    public function initializeObject()
    {
        /** @var $querySettings \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings */
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        // go for $defaultQuerySettings = $this->createQuery()->getQuerySettings(); if you want to make use of the TS persistence.storagePid with defaultQuerySettings(), see #51529 for details
        $querySettings->setRespectStoragePage(true);

        // $querySettings->setOrderings($this->defaultOrderings);
        $querySettings->setIgnoreEnableFields(false);
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     *
     *
     * @param int $uid
     * @return \Tp3\Tp3Openhours\Domain\Model\OpenHour
     */
    public function findByAddress($uid)
    {
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $querySettings->setRespectStoragePage(false);

        $this->setDefaultQuerySettings($querySettings);
        $query = $this->createQuery();
        $query->matching(
            $query->equals('ttaddress', $uid),
            $query->logicalAnd(
                $query->equals('hidden', 0),
                $query->equals('deleted', 0)
            )
        );
        return $query->execute();
    }
}
