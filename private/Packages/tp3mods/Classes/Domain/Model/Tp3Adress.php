<?php

/*
 * This file is part of the web-tp3/tp3mods.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3mods\Domain\Model;

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

/**
 * Tp3Adress
 */
class Tp3Adress extends \TYPO3\TtAddress\Domain\Model\Address
{ /**
 * cid
 *
 * @var string
 */
    protected $cid = '';

    /**
     * googleplus
     *
     * @var string
     */
    protected $googleplus = '';

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
     * microdataAdress
     *
     * @var bool
     */
    protected $microdataAdress = false;

    /**
     * Returns the microdataAdress
     *
     * @return bool $microdataAdress
     */
    public function getMicrodataAdress()
    {
        return $this->microdataAdress;
    }

    /**
     * Sets the microdataAdress
     *
     * @param bool $microdataAdress
     * @return void
     */
    public function setMicrodataAdress($microdataAdress)
    {
        $this->microdataAdress = $microdataAdress;
    }
    /**
     * Returns the microdataAdress
     *
     * @return bool $microdataAdress
     */
    public function getSocialProfiles()
    {
        $profiles =[];
        if ($this->getGoogleplus() != '') {
            array_push($profiles, '"https://plus.google.com/' . $this->getGoogleplus() . '"');
        }
        if ($this->getTwitter() != '') {
            array_push($profiles, '"https://twitter.com/' . $this->getTwitter() . '"');
        }
        if ($this->getLinkedIn() != '') {
            array_push($profiles, '"https://linkedin.com/in/' . $this->getLinkedIn() . '"');
        }
        if ($this->getFacebook() != '') {
            array_push($profiles, '"https://www.facebook.com/' . $this->getFacebook() . '"');
        }
        return $profiles;
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
     * Returns the googleplus
     *
     * @return string $googleplus
     */
    public function getGoogleplus()
    {
        return $this->googleplus;
    }

    /**
     * Sets the googleplus
     *
     * @param string $googleplus
     * @return void
     */
    public function setGoogleplus($googleplus)
    {
        $this->googleplus = $googleplus;
    }
    /**
     * @return array
     */
    public function getPropertiesArray()
    {
        return $this->_getCleanProperties();
    }

    /**
     * Returns the boolean state of microdataAdress
     *
     * @return bool
     */
    public function isMicrodataAdress()
    {
        return $this->microdataAdress;
    }
}
