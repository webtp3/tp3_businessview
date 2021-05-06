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

class PanoramasRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
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

        $querySettings->setRespectStoragePage(true);

        // ;
        // $querySettings->setOrderings($this->defaultOrderings);
        $querySettings->setIgnoreEnableFields(false);
        $this->setDefaultQuerySettings($querySettings);
    }
    /**
     *
     *
     * @param int $uid
     * @return \Tp3\Tp3Businessview\Domain\Model\Panoramas
     */
    public function findByUid($uid)
    {
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
     * @return array
     */
    public function findPanoramaFromBusinessView($uid)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('tp3businessviews.uid', $uid),
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
     * @param array $uids
     * @return array
     */
    public function findByList($uids)
    {
        if (is_array($uids)) {
            $query = $this->createQuery();
            $query->matching(
                $query->in('uid', $uids),
                $query->logicalAnd(
                    $query->equals('hidden', 0),
                    $query->equals('deleted', 0)
                )
            );
            return $query->execute(true);
        }
        return false;
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
}
