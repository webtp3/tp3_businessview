<?php

/*
 * This file is part of the package web-tp3/tp3-businessview.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3Businessview\Domain\Repository;

/***
 *
 * This file is part of the "tp3_businessview" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 Thomas Ruta <email@thomasruta.de>, R&P IT Consulting GmbH
 *
 ***/
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

class Tp3BusinessViewRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    // Order by BE sorting
    protected $defaultOrderings = [
        'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    ];

    public function initializeObject(): void
    {
        /** @var $querySettings \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings */
        $querySettings = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        // go for $defaultQuerySettings = $this->createQuery()->getQuerySettings(); if you want to make use of the TS persistence.storagePid with defaultQuerySettings(), see #51529 for details

        $querySettings->setRespectStoragePage(false);

        // ;
        // $querySettings->setOrderings($this->defaultOrderings);
        $querySettings->setIgnoreEnableFields(false);
        $this->setDefaultQuerySettings($querySettings);
    }
    /**
     *
    /**
     * @param int $uid
     * @return QueryResultInterface|\Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView[]
     */
    public function findByUid($uid, bool $asArray = false): QueryResultInterface|array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('uid', $uid),
            $query->logicalAnd(
                $query->equals('hidden', 0),
                $query->equals('deleted', 0)
            )
        );

        return $asArray ? $query->execute()->toArray() : $query->execute();
    }

    /**
     * @param int $pid
     * @return QueryResultInterface|\Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView[]
     */
    public function findByPid(int $pid, bool $asArray = false): QueryResultInterface|array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('pid', $pid),
            $query->logicalAnd(
                $query->equals('hidden', 0),
                $query->equals('deleted', 0)
            )
        );

        return $asArray ? $query->execute()->toArray() : $query->execute();
    }

    /**
     * @param int $uid
     * @return QueryResultInterface|\Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView[]
     */
    public function findByPanoramas(int $uid, bool $asArray = false): QueryResultInterface|array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('panoramas.uid', $uid),
            $query->logicalAnd(
                $query->equals('hidden', 0),
                $query->equals('deleted', 0)
            )
        );

        return $asArray ? $query->execute()->toArray() : $query->execute();
    }
}
