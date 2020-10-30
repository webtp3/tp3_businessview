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
 * Panoramas
 */
class Panoramas extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * uid
     * @var int
     */
    public $uid = '';

    /**
     * propertiesArray
     * @var array
     */
    protected $propertiesArray = [];
    /**
     * pid
     * @var int
     */
    public $pid = '';

    /**
     * panoId
     *
     * @var string
     */
    protected $panoId = '';

    /**
     * heading
     *
     * @var string
     */
    protected $heading = '';

    /**
     * title
     *
     * @var string
     */
    protected $title = '';

    /**
     * pitch
     *
     * @var string
     */
    protected $pitch = '';

    /**
     * zoom
     *
     * @var string
     */
    protected $zoom = '';
    /**
     * position
     *
     * @var string
     */
    protected $position = '';

    /**
     * contact
     *
     * @var \Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView
     */
    protected $tp3businessviews = null;
    /**
     * sorting
     *
     * @var string $sorting
     */
    protected $sorting;

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->tp3businessviews = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the position
     *
     * @return string $position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Sets the position
     *
     * @param string $position
     * @return void
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }
    /**
     * Returns the panoId
     *
     * @return string $panoId
     */
    public function getPanoId()
    {
        return $this->panoId;
    }
    /**
     * Returns the uid
     *
     * @return int $uid
     */
    public function getUid() : ?int
    {
        return $this->uid;
    }
    /**
     * sets the uid
     *
     * @param int $uid
     */
    public function setUid(int $uid) : void
    {
        $this->uid = $uid;
    }

    /**
     * Returns the pid
     *
     * @return int $pid
     */
    public function getPid() : ?int
    {
        return $this->pid;
    }
    /**
     * sets the pid
     *
     * @param int $pid
     */
    public function setPid(int $pid) : void
    {
         $this->pid = $pid;
    }

    /**
     * Sets the panoId
     *
     * @param string $panoId
     * @return void
     */
    public function setPanoId($panoId)
    {
        $this->panoId = $panoId;
    }

    /**
     * Returns the heading
     *
     * @return string $heading
     */
    public function getHeading()
    {
        return $this->heading;
    }

    /**
     * Sets the heading
     *
     * @param string $heading
     * @return void
     */
    public function setHeading($heading)
    {
        $this->heading = $heading;
    }

    /**
     * Returns the pitch
     *
     * @return string $pitch
     */
    public function getPitch()
    {
        return $this->pitch;
    }

    /**
     * Sets the pitch
     *
     * @param string $pitch
     * @return void
     */
    public function setPitch($pitch)
    {
        $this->pitch = $pitch;
    }

    /**
     * Returns the zoom
     *
     * @return string $zoom
     */
    public function getZoom()
    {
        return $this->zoom;
    }

    /**
     * Sets the zoom
     *
     * @param string $zoom
     * @return void
     */
    public function setZoom($zoom)
    {
        $this->zoom = $zoom;
    }
    /**
     * @return array
     */
    public function getPropertiesArray()
    {
        return $this->_getCleanProperties();
    }

    /**
     * Returns the tp3businessviews
     *
     * @return \Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $tp3businessview
     */
    public function getTp3Businessviews()
    {
        return $this->tp3businessviews;
    }

    /**
     * Sets the contact
     *
     * @param \Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $tp3businessviews
     * @return void
     */
    public function setTp3Businessviews(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $tp3businessviews)
    {
        $this->tp3businessviews = $tp3businessviews;
    }

    /**
     * Adds a Tp3Businessview
     *
     * @param \Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $tp3businessviews
     * @return void
     */
    public function addTp3Businessviews(\Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $tp3businessviews)
    {
        $this->tp3businessviews->attach($tp3businessviews);
    }

    /**
     * Removes a BusinessAdress
     *
     * @param \Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $tp3businessviewsToRemove The Tp3Businessview to be removed
     * @return void
     */
    public function removeTp3Businessviews(\Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $tp3businessviewsToRemove)
    {
        $this->tp3businessviews->detach($tp3businessviewsToRemove);
    }
}
