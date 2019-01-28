<?php

/*
 * This file is part of the web-tp3/tp3mods.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3mods\Domain\Repository;

/***
 *
 * This file is part of the "tp3 Mods" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Thomas Ruta <email@thomasruta.de>, tp3
 *
 ***/
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * The repository for Tp3Adresses
 */
class Tp3AdressRepository extends Repository
{
    // Order by BE sorting
    protected $defaultOrderings = [
        'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    ];

    public function initializeObject()
    {
        /** @var $querySettings \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings */
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        // go for $defaultQuerySettings = $this->createQuery()->getQuerySettings(); if you want to make use of the TS persistence.storagePid with defaultQuerySettings(), see #51529 for details
        $querySettings->setRespectStoragePage(false);
        // $querySettings->setStoragePageIds(array($this->conf["persistence"]["storagePid"]));
        // $querySettings->setOrderings($this->defaultOrderings);
        $querySettings->setIgnoreEnableFields(false);
        $this->setDefaultQuerySettings($querySettings);
    }
    /**
     *
     *
     * @param int $uid
     * @return \Tp3\Tp3mods\Domain\Model\Tp3Adress
     */
    public function findByUid($uid)
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
        return $query->execute()->getFirst();
    }
    /**
     *
     *
     * @param array $uids
     * @return \Tp3\Tp3mods\Domain\Model\Tp3Adress
     */
    public function findByRootline($uids)
    {
//        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
//        $querySettings->setRespectStoragePage(false);

        $query = $this->createQuery();
        $query->matching(
            $query->in('uid', $uids),
            $query->logicalAnd(
                $query->equals('hidden', 0),
                $query->equals('deleted', 0)
            )
        );
        return $query->execute();
    }
}
