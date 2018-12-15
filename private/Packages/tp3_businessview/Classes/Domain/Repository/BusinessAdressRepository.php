<?php

/*
 * This file is part of the web-tp3/tp3businessview.
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

/**
 * The repository for Iplogs
 */
class BusinessAdressRepository extends \TYPO3\TtAddress\Domain\Repository\AddressRepository
{

// Order by BE sorting
    protected $defaultOrderings = [
        'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    ];

    public function initializeObject()
    {
//        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
//        // go for $defaultQuerySettings = $this->createQuery()->getQuerySettings(); if you want to make use of the TS persistence.storagePid with defaultQuerySettings(), see #51529 for details
//
//
//            $querySettings->setRespectStoragePage(false);
//
//        // ;
//        // $querySettings->setOrderings($this->defaultOrderings);
//        $querySettings->setIgnoreEnableFields(false);
//        $this->setDefaultQuerySettings($querySettings);
    }
    /**
     *
     *
     * @param array $uids
     * @return array
     */
    public function findByPid($pid = 0)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('pid', $pid),
            $query->logicalAnd(
                $query->equals('hidden', 0),
                $query->equals('deleted', 0)
            )
        );
        return $query->execute();
    }
    /**
     *
     *
     * @param int $uid
     * @return array
     */
    public function findByUidArray($uid)
    {
//        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
//        $querySettings->setRespectStoragePage(false);
//        $this->setDefaultQuerySettings($querySettings);
        $query = $this->createQuery();
        $query->matching(
            $query->equals('uid', $uid),
            $query->logicalAnd(
                $query->equals('hidden', 0),
                $query->equals('deleted', 0)
            )
        );
        return $query->execute(true);
    }
    /**
     *
     *
     * @param int $uid
     * @return \Tp3\Tp3Businessview\Domain\Model\BusinessAdress
     */
    public function findByUid($uid)
    {
//       $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
//        $querySettings->setRespectStoragePage(false);
//        $this->setDefaultQuerySettings($querySettings);

        $query = $this->createQuery();
        $query->matching(
            $query->equals('uid', $uid),
            $query->logicalAnd(
                $query->equals('hidden', 0),
                $query->equals('deleted', 0)
            )
        );
        return $query->execute();
    }
    /**
     *
     *
     * @param array $uids
     * @return array
     */
    public function findByList($uids)
    {
//        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
//        $querySettings->setRespectStoragePage(false);
//        $this->setDefaultQuerySettings($querySettings);

        $query = $this->createQuery();
        $query->matching(
            $query->in('uid', $uids),
            $query->logicalAnd(
                $query->equals('hidden', 0),
                $query->equals('deleted', 0)
            )
        );
//        $queryParser = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbQueryParser::class);
//        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($queryParser->convertQueryToDoctrineQueryBuilder($query)->getSQL());
//        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($queryParser->convertQueryToDoctrineQueryBuilder($query)->getParameters());
        return $query->execute(true);
    }
}
