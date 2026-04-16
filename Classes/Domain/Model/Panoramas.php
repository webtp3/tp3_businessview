<?php

/*
 * This file is part of the package web-tp3/tp3-businessview.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3Businessview\Domain\Model;

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

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
     * propertiesArray
     * @var array
     */
    protected array $propertiesArray = [];

    /**
     * panoId
     *
     * @var string
     */
    protected string $panoId = '';

    /**
     * heading
     *
     * @var string
     */
    protected string $heading = '';

    /**
     * title
     *
     * @var string
     */
    protected string $title = '';

    /**
     * pitch
     *
     * @var string
     */
    protected string $pitch = '';

    /**
     * zoom
     *
     * @var string
     */
    protected string $zoom = '';
    /**
     * position
     *
     * @var string
     */
    protected string $position = '';

    /**
     * tp3businessviews
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected ?ObjectStorage $tp3businessviews;

    /**
     * sorting
     *
     * @var string $sorting
     */
    protected string $sorting = '';

    /**
     * __construct
     */
    public function __construct()
    {
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     *
     * @return void
     */
    protected function initStorageObjects(): void
    {
        $this->tp3businessviews = $this->tp3businessviews ?? new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Setter for sorting
     *
     * @param string $sorting
     * @return void
     */
    public function setSorting(string $sorting): void
    {
        $this->sorting = $sorting;
    }

    /**
     * sets the uid
     *
     * @param string $uid
     */
    public function setUid(string $uid): void
    {
        $this->uid = $uid;
    }

    /**
     * Getter for sorting
     *
     * @return string sorting
     */
    public function getSorting(): string
    {
        return $this->sorting;
    }
    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Returns the position
     *
     * @return string $position
     */
    public function getPosition(): string
    {
        return $this->position;
    }

    /**
     * Sets the position
     *
     * @param string $position
     * @return void
     */
    public function setPosition(string $position): void
    {
        $this->position = $position;
    }
    /**
     * Returns the panoId
     *
     * @return string $panoId
     */
    public function getPanoId(): string
    {
        return $this->panoId;
    }

    /**
     * Sets the panoId
     *
     * @param string $panoId
     * @return void
     */
    public function setPanoId(string $panoId): void
    {
        $this->panoId = $panoId;
    }

    /**
     * Returns the heading
     *
     * @return string $heading
     */
    public function getHeading(): string
    {
        return $this->heading;
    }

    /**
     * Sets the heading
     *
     * @param string $heading
     * @return void
     */
    public function setHeading(string $heading): void
    {
        $this->heading = $heading;
    }

    /**
     * Returns the pitch
     *
     * @return string $pitch
     */
    public function getPitch(): string
    {
        return $this->pitch;
    }

    /**
     * Sets the pitch
     *
     * @param string $pitch
     * @return void
     */
    public function setPitch(string $pitch): void
    {
        $this->pitch = $pitch;
    }

    /**
     * Returns the zoom
     *
     * @return string $zoom
     */
    public function getZoom(): string
    {
        return $this->zoom;
    }

    /**
     * Sets the zoom
     *
     * @param string $zoom
     * @return void
     */
    public function setZoom(string $zoom): void
    {
        $this->zoom = $zoom;
    }
    /**
     * @return array
     */
    public function getPropertiesArray(): array
    {
        return $this->_getCleanProperties();
    }

    /**
     * Returns the tp3businessviews
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView>
     */
    public function getTp3Businessviews(): ?ObjectStorage
    {
        return $this->tp3businessviews;
    }

    /**
     * Sets the contact
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView> $tp3businessviews
     * @return void
     */
    public function setTp3Businessviews(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $tp3businessviews): void
    {
        $this->tp3businessviews = $tp3businessviews;
    }

    /**
     * Adds a Tp3Businessview
     *
     * @param \Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $tp3businessviews
     * @return void
     */
    public function addTp3Businessviews(\Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $tp3businessviews): void
    {
        $this->tp3businessviews->attach($tp3businessviews);
    }

    /**
     * Removes a BusinessAdress
     *
     * @param \Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $tp3businessviewsToRemove The Tp3Businessview to be removed
     * @return void
     */
    public function removeTp3Businessviews(\Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $tp3businessviewsToRemove): void
    {
        $this->tp3businessviews->detach($tp3businessviewsToRemove);
    }
}
