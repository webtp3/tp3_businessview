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
 * Tp3BusinessView
 */
class Tp3BusinessView extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * propertiesArray
     *
     */
    protected string $propertiesArray = '';
    /**
     * createdBy
     *
     * @var string
     */
    protected string $createdBy = '';

    /**
     * name
     *
     * @var string
     */
    protected string $name = '';

    /**
     * externalLinks
     *
     * @var string
     */
    protected string $externalLinks = '';

    /**
     * gallery
     *
     * @var string
     */
    protected string $gallery = '';

    /**
     * intro
     *
     * @var string
     */
    protected string $intro = '';

    /**
     * panoAnimation
     *
     * @var string
     */
    protected ?string $panoAnimation = null;

    /**
     * socialGallery
     *
     * @var bool
     */
    protected string|bool $socialGallery = '';

    /**
     * panoOptions
     *
     * @var string
     */
    protected ?string $panoOptions = null;

    /**
     * contact
     *
     * @var \Tp3\Tp3Businessview\Domain\Model\BusinessAdress
     */
    protected ?BusinessAdress $contact = null;

    /**
     * panoramas
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Tp3\Tp3Businessview\Domain\Model\Panoramas>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected ?ObjectStorage $panoramas = null;

    /**
     * sorting
     *
     * @var string $sorting
     */
    protected string $sorting;
    /**
     * description
     *
     * @var string $description
     */
    protected string $description;
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
     * Getter for sorting
     *
     * @return string sorting
     */
    public function getSorting(): string
    {
        return $this->sorting;
    }

    /**
     * Setter for description
     *
     * @param string $description
     * @return void
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Getter for description
     *
     * @return string description
     */
    public function getDescription(): string
    {
        return $this->description;
    }
    /**
     * Returns the createdBy
     *
     * @return string $createdBy
     */
    public function getCreatedBy(): string
    {
        return $this->createdBy;
    }

    /**
     * Sets the createdBy
     *
     * @param string $createdBy
     * @return void
     */
    public function setCreatedBy(string $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Returns the externalLinks
     *
     * @return string $externalLinks
     */
    public function getExternalLinks(): string
    {
        return $this->externalLinks;
    }

    /**
     * Sets the externalLinks
     *
     * @param string $externalLinks
     * @return void
     */
    public function setExternalLinks(string $externalLinks): void
    {
        $this->externalLinks = $externalLinks;
    }

    /**
     * Returns the gallery
     *
     * @return string $gallery
     */
    public function getGallery(): string
    {
        return $this->gallery;
    }

    /**
     * Sets the gallery
     *
     * @param string $gallery
     * @return void
     */
    public function setGallery(string $gallery): void
    {
        $this->gallery = $gallery;
    }

    /**
     * Returns the intro
     *
     * @return string $intro
     */
    public function getIntro(): string
    {
        return $this->intro;
    }

    /**
     * Sets the intro
     *
     * @param string $intro
     * @return void
     */
    public function setIntro(string $intro): void
    {
        $this->intro = $intro;
    }

    /**
     * Returns the panoAnimation
     *
     * @return string $panoAnimation
     */
    public function getPanoAnimation(): ?string
    {
        return $this->panoAnimation;
    }

    /**
     * Sets the panoAnimation
     *
     * @param string $panoAnimation
     * @return void
     */
    public function setPanoAnimation(string $panoAnimation): void
    {
        $this->panoAnimation = $panoAnimation;
    }

    /**
     * Returns the socialGallery
     *
     * @return string $socialGallery
     */
    public function getSocialGallery(): bool|string
    {
        return $this->socialGallery;
    }

    /**
     * Sets the socialGallery
     *
     * @param string $socialGallery
     * @return void
     */
    public function setSocialGallery(string $socialGallery): void
    {
        $this->socialGallery = $socialGallery;
    }

    /**
     * Returns the panoOptions
     *
     * @return string $panoOptions
     */
    public function getPanoOptions(): ?string
    {
        return $this->panoOptions;
    }

    /**
     * Sets the panoOptions
     *
     * @param string $panoOptions
     * @return void
     */
    public function setPanoOptions(string $panoOptions): void
    {
        $this->panoOptions = $panoOptions;
    }

    /**
     * Returns the panoramas
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Tp3\DiTime\Domain\Model\TimeTable>
     */
    public function getPanoramas(): ?ObjectStorage
    {
        if ($this->panoramas instanceof \Tp3\Tp3Businessview\Domain\Model\Panoramas) {
            return [$this->panoramas];
        } else {
            return $this->panoramas;
        }
    }

    /**
     * Sets the panoramas
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Tp3\Tp3Businessview\Domain\Model\Panoramae> $panoramas
     * @return void
     */
    public function setPanoramas($panoramas): void
    {
        if ($panoramas instanceof \Tp3\Tp3Businessview\Domain\Model\Panoramas) {
            $this->panoramas[] = $panoramas;
        } else {
            $this->panoramas = $panoramas;
        }
    }

    /**
     * Removes a panoramas
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Tp3\Tp3Businessview\Domain\Model\Panoramas> $panoramas The BusinessAdress to be removed
     * @return void
     */
    public function removePanoramas(\Tp3\Tp3Businessview\Domain\Model\Panoramas $panoramas): void
    {
        $this->panoramas->detach($panoramas);
    }
    /**
     * Adds a panoramas
     *
     * @param \Tp3\Tp3Businessview\Domain\Model\Panoramas $panoramas
     * @return void
     */
    public function addPanoramas(\Tp3\Tp3Businessview\Domain\Model\Panoramas $panoramas): void
    {
        $this->panoramas->attach($panoramas);
    }

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
    protected function initStorageObjects(): void
    {
        $this->panoramas =  $this->panoramas ??  new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the contact
     *
     * @return \Tp3\Tp3Businessview\Domain\Model\BusinessAdress $contact
     */
    public function getContact(): ?BusinessAdress
    {
        return $this->contact;
    }

    /**
     * Sets the contact
     *
     * @param \Tp3\Tp3Businessview\Domain\Model\BusinessAdress $contact
     * @return void
     */
    public function setContact(\Tp3\Tp3Businessview\Domain\Model\BusinessAdress $contact): void
    {
        $this->contact = $contact;
    }

    /**
     * @return array
     */
    public function getPropertiesArray(): array
    {
        $panoOptions =    ['addressControl' => false,
            'disableDefaultUI' => false,
            'panControl' => true,
            'scaleControl' => false,
            'scrollwheel' => false,
            'zoomControl' => false,
            'fullScreen' => false
        ];
        if ($this->getPanoOptions() != null) {
            $option_values = explode(',', $this->getPanoOptions());

            // $panoOptions = $option_values;
            for ($i=0;count($option_values)>$i;$i++) {
                $panoOptions[$option_values[$i]] = true;
            }
            unset($option_values);
        }
        if ($this->getPanoAnimation() != null) {
            $option_values = explode(',', $this->getPanoAnimation());
            $panoAnimation = ['jumps'=>false, 'rotation'=>false];
            for ($i=0;count($option_values)>$i;$i++) {
                $panoAnimation[$option_values[$i]] = true;
            }
            unset($option_values);
        }

        return [

            'createdBy' => $this->getCreatedBy(),
            'name' => $this->getName(),
            'externalLinks' => $this->getExternalLinks(),
            'gallery' => $this->getGallery(),
            'intro' => $this->getIntro(),
            'panoAnimation' => $panoAnimation,
            'socialGallery' => $this->getSocialGallery(),
            'panoOptions' =>   $panoOptions,

        ];
    }
}
