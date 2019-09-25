<?php

/*
 * This file is part of the web-tp3/tp3_jobs.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3Jobs\Domain\Repository;

/***
 *
 * This file is part of the "tp3 Jobs" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Thomas Ruta <email@thomasruta.de>, tp3
 *
 ***/

/**
 * The repository for JobOffers
 */
class JobOfferRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /***
    * Returns all objects of this repository.
    *
    * @return QueryResultInterface|array
    *
    */
    public function findOffers($pid = [2038])
    {
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $querySettings->setRespectStoragePage(true);
        $querySettings->setStoragePageIds([$pid]);
        $this->setDefaultQuerySettings($querySettings);
        //$queryResult = $this->findAll();
        //return $queryResult;*/
        $query = $this->createQuery();
        $query->matching(
                //$query->equals('ref', $customStoragePid),
                $query->logicalAnd(
                    $query->equals('hidden', 0),
                    $query->equals('deleted', 0)
                )
            );
        //$query->setOrderings($this->orderByField('uid', $uidArray));
        return $query->execute();
    }
    /***
     * Returns the job of the repository.
     *
     * @param $uid
     * @return QueryResultInterface|array
     *
     */
    public function findJob($uid)
    {
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $querySettings->setRespectStoragePage(true);
        //$querySettings->setStoragePageIds(array($customStoragePid));
        $this->setDefaultQuerySettings($querySettings);
        //$queryResult = $this->findAll();
        //return $queryResult;*/
        $query = $this->createQuery();
        $query->matching(
            $query->equals('uid', (int) $uid),
            $query->logicalAnd(
                $query->equals('hidden', 0),
                $query->equals('deleted', 0)
            )
        );
        //$query->setOrderings($this->orderByField('uid', $uidArray));
        return $query->execute();
    }
}
