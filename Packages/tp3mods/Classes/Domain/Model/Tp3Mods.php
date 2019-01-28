<?php

/*
 * This file is part of the web-tp3/tp3mods.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3mods\Domain\Model;

use phpDocumentor\Reflection\Types\Integer;

/***
 *
 * This file is part of the "tp3 Mods" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 Thomas Ruta <email@thomasruta.de>, R&amp;P IT Consulting GmbH
 *
 ***/

/**
 * Tp3Mods
 */
class Tp3Mods extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * Repository of Microdara
     *
     * @var string
     */
    protected $microdata = '';

    /**
     * Repository of config
     *
     * @var string
     */
    protected $konfiguration = '';

    /**
     * snippetType
     *
     * @var string
     */
    protected $snippetType = '';

    /**
     * mainEntry
     *
     * @var string
     */
    protected $mainEntry = '';

    /**
     * aggregateRating
     *
     * @var bool
     */
    protected $aggregateRating = false;

    /**
     * address
     *
     * @var \Tp3\Tp3mods\Domain\Model\Tp3Adress
     */

    protected $address = '';

    /**
     * login_page
     *
     * @var integer
     */
    protected $loginPage = '';

    /**
     * Returns the loginPage
     *
     * @return integer $loginPage
     */
    public function getLoginPage ()
    {
        return $this->loginPage;
    }

    /**
     * Sets the loginPage
     *
     * @param Integer $loginPage
     * @return void
     */
    public function setLoginPage($loginPage)
    {
        $this->loginPage = $loginPage;
    }
    /**
     * search_page
     *
     * @var integer
     */
    protected $searchPage = '';

    /**
     * Returns the searchPage
     *
     * @return integer $searchPage
     */
    public function getSearchPage ()
    {
        return $this->searchPage;
    }

    /**
     * Sets the searchPage
     *
     * @param Integer $searchPage
     * @return void
     */
    public function setSearchPage($searchPage)
    {
        $this->searchPage = $searchPage;
    }
    /**
     * newsPage
     *
     * @var integer
     */
    protected $newsPage = '';

    /**
     * Returns the newsPage
     *
     * @return integer $newsPage
     */
    public function getNewsPage ()
    {
        return $this->newsPage;
    }

    /**
     * Sets the loginPage
     *
     * @param Integer $newsPage
     * @return void
     */
    public function setNewsPage($newsPage)
    {
        $this->newsPage = $newsPage;
    }

    /**
     * privacy_page
     *
     * @var integer
     */
    protected $privacyPage = '';

    /**
     * Returns the privacyPage
     *
     * @return integer $privacyPage
     */
    public function getPrivacyPage()
    {
        return $this->PrivacyPage;
    }

    /**
     * Sets the privacyPage
     *
     * @param integer $privacyPage
     * @return void
     */
    public function setPrivacyPage($privacyPage)
    {
        $this->privacyPage = $privacyPage;
    }

    /**
     * terms_page
     *
     * @var integer
     */
    protected $termsPage = '';

    /**
     * Returns the address
     *
     * @return integer $termsPage
     */
    public function getTermsPage()
    {
        return $this->termsPage;
    }

    /**
     * Sets the address
     *
     * @param interger $termsPage
     * @return void
     */
    public function setTermsPage($termsPage)
    {
        $this->termsPage = $termsPage;
    }

    /**
     * $error_page
     *
     * @var integer
     */
    protected $errorPage = '';

    /**
     * Returns the errorPage
     *
     * @return integer $errorPage
     */
    public function getErrorPage()
    {
        return $this->errorPage;
    }

    /**
     * Sets the errorPage
     *
     * @param integer $errorPage
     * @return void
     */
    public function setErrorPage($errorPage)
    {
        $this->errorPage = $errorPage;
    }

    /**
     * address
     *
     * @var integer
     */
    protected $profilePage = '';

    /**
     * Returns the profilePage
     *
     * @return \Tp3\Tp3mods\Domain\Model\Tp3Adress $profilePage
     */
    public function getProfilePage()
    {
        return $this->profilePage;
    }

    /**
     * Sets the profilePage
     *
     * @param integer $profilePage
     * @return void
     */
    public function setProfilePage($profilePage)
    {
        $this->profilePage = $profilePage;
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
    }

    /**
     * Returns the microdata
     *
     * @return string $microdata
     */
    public function getMicrodata()
    {
        return $this->microdata;
    }

    /**
     * Sets the microdata
     *
     * @param string $microdata
     * @return void
     */
    public function setMicrodata($microdata)
    {
        $this->microdata = $microdata;
    }

    /**
     * Returns the konfiguration
     *
     * @return string $konfiguration
     */
    public function getKonfiguration()
    {
        return $this->konfiguration;
    }

    /**
     * Sets the konfiguration
     *
     * @param string $konfiguration
     * @return void
     */
    public function setKonfiguration($konfiguration)
    {
        $this->konfiguration = $konfiguration;
    }

    /**
     * Returns the snippetType
     *
     * @return string $snippetType
     */
    public function getSnippetType()
    {
        return $this->snippetType;
    }

    /**
     * Sets the snippetType
     *
     * @param string $snippetType
     * @return void
     */
    public function setSnippetType($snippetType)
    {
        $this->snippetType = $snippetType;
    }

    /**
     * Returns the mainEntry
     *
     * @return string $mainEntry
     */
    public function getMainEntry()
    {
        return $this->mainEntry;
    }

    /**
     * Sets the mainEntry
     *
     * @param string $mainEntry
     * @return void
     */
    public function setMainEntry($mainEntry)
    {
        $this->mainEntry = $mainEntry;
    }

    /**
     * Returns the aggregateRating
     *
     * @return bool $aggregateRating
     */
    public function getAggregateRating()
    {
        return $this->aggregateRating;
    }

    /**
     * Sets the aggregateRating
     *
     * @param bool $aggregateRating
     * @return void
     */
    public function setAggregateRating($aggregateRating)
    {
        $this->aggregateRating = $aggregateRating;
    }

    /**
     * Returns the boolean state of aggregateRating
     *
     * @return bool
     */
    public function isAggregateRating()
    {
        return $this->aggregateRating;
    }

    /**
     * Returns the address
     *
     * @return \Tp3\Tp3mods\Domain\Model\Tp3Adress $address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Sets the address
     *
     * @param \Tp3\Tp3mods\Domain\Model\Tp3Adress $address
     * @return void
     */
    public function setAddress(\Tp3\Tp3mods\Domain\Model\Tp3Adress $address)
    {
        $this->address = $address;
    }
}
