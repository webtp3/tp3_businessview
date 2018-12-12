<?php

/*
 * This file is part of the web-tp3/tp3businessview.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3Businessview\Domain\Model;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Thomas Ruta <support@r-p-it.de>, tp3
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/***
 *
 * This file is part of the "BusinsessView" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Thomas Ruta <support@r-p-it.de>, tp3
 *
 ***/

/**
 * BusinessAdress
 */
class BusinessAdress extends \TYPO3\TtAddress\Domain\Model\Address
{

    /**
     * Tp3BusinessView
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView>
     * @cascade remove
     * @lazy
     */
    protected $tp3businessview;

    /**
     * cid
     *
     * @var string
     */
    protected $cid = '';

    /**
     * propertiesArray
     *
     */
    protected $propertiesArray = [];

    /**
     * sorting
     *
     * @var string $sorting
     */
    protected $sorting;
    /**
     * Returns the tp3businessviews
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView> $tp3businessview
     */
    public function getTp3Businessview()
    {
        return $this->tp3businessview;
    }

    /**
     * Sets the contact
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView> $tp3businessview
     * @return void
     */
    public function setTp3Businessview(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $tp3businessview)
    {
        $this->tp3businessview = $tp3businessview;
    }

    /**
     * Adds a Tp3Businessview
     *
     * @param \Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $tp3businessview
     * @return void
     */
    public function addTp3Businessview(\Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $tp3businessview)
    {
        $this->tp3businessview->attach($tp3businessview);
    }

    /**
     * Removes a BusinessAdress
     *
     * @param \Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $tp3businessviewToRemove The Tp3Businessview to be removed
     * @return void
     */
    public function removeTp3Businessview(\Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $tp3businessviewToRemove)
    {
        $this->tp3businessview->detach($tp3businessviewToRemove);
    }
    /**
     * Setter for sorting
     *
     * @param string $sorting
     * @return void
     */
    public function setSorting($sorting)
    {
        $this->sorting = $sorting;
    }

    /**
     * Getter for sorting
     *
     * @return string sorting
     */
    public function getSorting()
    {
        return $this->sorting;
    }
    /**
     * Returns the cid
     *
     * @return string $cid
     */
    public function getCid()
    {
        return $this->cid;
    }

    /**
     * Sets the cid
     *
     * @param string $cid
     * @return void
     */
    public function setCid($cid)
    {
        $this->cid = $cid;
    }

    /**
     * @return array
     */
    public function getPropertiesArray()
    {
        return $this->_getCleanProperties();
    }
}
