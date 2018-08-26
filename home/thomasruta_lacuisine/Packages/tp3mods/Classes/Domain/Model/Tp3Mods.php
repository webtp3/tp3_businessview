<?php
namespace Tp3\Tp3mods\Domain\Model;

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
class Tp3Mods extends \TYPO3\CMS\Extbase\DomainObject\AbstractValueObject
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
     * address
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<>
     * @cascade remove
     */
    protected $address = null;

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
        $this->address = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
     * Adds a
     * 
     * @param $addres
     * @return void
     */
    public function addAddres($addres)
    {
        $this->address->attach($addres);
    }

    /**
     * Removes a
     * 
     * @param $addresToRemove The  to be removed
     * @return void
     */
    public function removeAddres($addresToRemove)
    {
        $this->address->detach($addresToRemove);
    }

    /**
     * Returns the address
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<> $address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Sets the address
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<> $address
     * @return void
     */
    public function setAddress(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $address)
    {
        $this->address = $address;
    }
}
