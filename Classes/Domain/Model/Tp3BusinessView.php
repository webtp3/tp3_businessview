<?php
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
 * Tp3BusinessView
 */
class Tp3BusinessView extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * createdBy
     * 
     * @var string
     */
    protected $createdBy = '';

    /**
     * name
     * 
     * @var string
     */
    protected $name = '';

    /**
     * externalLinks
     * 
     * @var string
     */
    protected $externalLinks = '';

    /**
     * gallery
     * 
     * @var string
     */
    protected $gallery = '';

    /**
     * intro
     * 
     * @var string
     */
    protected $intro = '';

    /**
     * panoAnimation
     * 
     * @var int
     */
    protected $panoAnimation = 0;

    /**
     * socialGallery
     * 
     * @var string
     */
    protected $socialGallery = '';

    /**
     * panoOptions
     * 
     * @var int
     */
    protected $panoOptions = 0;

    /**
     * contact
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Tp3\Tp3Businessview\Domain\Model\BusinessAdress>
     * @cascade remove
     * @lazy
     */
    protected $contact = null;

    /**
     * app
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Tp3\Tp3Businessview\Domain\Model\BusinessApp>
     * @cascade remove
     * @lazy
     */
    protected $app = null;

    /**
     * panoramas
     * 
     * @var \Tp3\Tp3Businessview\Domain\Model\Panoramas
     * @lazy
     */
    protected $panoramas = NULL;

    /**
     * Returns the createdBy
     * 
     * @return string $createdBy
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Sets the createdBy
     * 
     * @param string $createdBy
     * @return void
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * Returns the name
     * 
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     * 
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the externalLinks
     * 
     * @return string $externalLinks
     */
    public function getExternalLinks()
    {
        return $this->externalLinks;
    }

    /**
     * Sets the externalLinks
     * 
     * @param string $externalLinks
     * @return void
     */
    public function setExternalLinks($externalLinks)
    {
        $this->externalLinks = $externalLinks;
    }

    /**
     * Returns the gallery
     * 
     * @return string $gallery
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * Sets the gallery
     * 
     * @param string $gallery
     * @return void
     */
    public function setGallery($gallery)
    {
        $this->gallery = $gallery;
    }

    /**
     * Returns the intro
     * 
     * @return string $intro
     */
    public function getIntro()
    {
        return $this->intro;
    }

    /**
     * Sets the intro
     * 
     * @param string $intro
     * @return void
     */
    public function setIntro($intro)
    {
        $this->intro = $intro;
    }

    /**
     * Returns the panoAnimation
     * 
     * @return integer $panoAnimation
     */
    public function getPanoAnimation()
    {
        return $this->panoAnimation;
    }

    /**
     * Sets the panoAnimation
     * 
     * @param integer $panoAnimation
     * @return void
     */
    public function setPanoAnimation($panoAnimation)
    {
        $this->panoAnimation = $panoAnimation;
    }

    /**
     * Returns the socialGallery
     * 
     * @return string $socialGallery
     */
    public function getSocialGallery()
    {
        return $this->socialGallery;
    }

    /**
     * Sets the socialGallery
     * 
     * @param string $socialGallery
     * @return void
     */
    public function setSocialGallery($socialGallery)
    {
        $this->socialGallery = $socialGallery;
    }

    /**
     * Returns the panoOptions
     * 
     * @return integer $panoOptions
     */
    public function getPanoOptions()
    {
        return $this->panoOptions;
    }

    /**
     * Sets the panoOptions
     * 
     * @param integer $panoOptions
     * @return void
     */
    public function setPanoOptions($panoOptions)
    {
        $this->panoOptions = $panoOptions;
    }

    /**
     * Returns the panoramas
     * 
     * @return \Tp3\Tp3Businessview\Domain\Model\Panoramas $panoramas
     */
    public function getPanoramas()
    {
        return $this->panoramas;
    }

    /**
     * Sets the panoramas
     * 
     * @param \Tp3\Tp3Businessview\Domain\Model\Panoramas $panoramas
     * @return void
     */
    public function setPanoramas(\Tp3\Tp3Businessview\Domain\Model\Panoramas $panoramas)
    {
        $this->panoramas = $panoramas;
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
    protected function initStorageObjects()
    {
        $this->contact = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->app = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Adds a BusinessAdress
     * 
     * @param \Tp3\Tp3Businessview\Domain\Model\BusinessAdress $contact
     * @return void
     */
    public function addContact(\Tp3\Tp3Businessview\Domain\Model\BusinessAdress $contact)
    {
        $this->contact->attach($contact);
    }

    /**
     * Removes a BusinessAdress
     * 
     * @param \Tp3\Tp3Businessview\Domain\Model\BusinessAdress $contactToRemove The BusinessAdress to be removed
     * @return void
     */
    public function removeContact(\Tp3\Tp3Businessview\Domain\Model\BusinessAdress $contactToRemove)
    {
        $this->contact->detach($contactToRemove);
    }

    /**
     * Returns the contact
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Tp3\Tp3Businessview\Domain\Model\BusinessAdress> $contact
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Sets the contact
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Tp3\Tp3Businessview\Domain\Model\BusinessAdress> $contact
     * @return void
     */
    public function setContact(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Adds a BusinessApp
     * 
     * @param \Tp3\Tp3Businessview\Domain\Model\BusinessApp $app
     * @return void
     */
    public function addApp(\Tp3\Tp3Businessview\Domain\Model\BusinessApp $app)
    {
        $this->app->attach($app);
    }

    /**
     * Removes a BusinessApp
     * 
     * @param \Tp3\Tp3Businessview\Domain\Model\BusinessApp $appToRemove The BusinessApp to be removed
     * @return void
     */
    public function removeApp(\Tp3\Tp3Businessview\Domain\Model\BusinessApp $appToRemove)
    {
        $this->app->detach($appToRemove);
    }

    /**
     * Returns the app
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Tp3\Tp3Businessview\Domain\Model\BusinessApp> $app
     */
    public function getApp()
    {
        return $this->app;
    }

    /**
     * Sets the app
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Tp3\Tp3Businessview\Domain\Model\BusinessApp> $app
     * @return void
     */
    public function setApp(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $app)
    {
        $this->app = $app;
    }
}
