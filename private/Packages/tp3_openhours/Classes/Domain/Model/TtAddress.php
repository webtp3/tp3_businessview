<?php

/*
 * This file is part of the web-tp3/tp3openhours.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3Openhours\Domain\Model;

/***
 *
 * This file is part of the "tt_address OpenHours" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Thomas Ruta &lt;email@thomasruta.de>, tp3
 *
 ***/

/**
 * TtAddress
 */
class TtAddress extends \TYPO3\TtAddress\Domain\Model\Address
{
    /**
     * openHours
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Tp3\Tp3Openhours\Domain\Model\OpenHour>
     * @cascade remove
     */
    protected $openHours = null;

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
        $this->openHours = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Adds a OpenHour
     *
     * @param \Tp3\Tp3Openhours\Domain\Model\OpenHour $openHour
     * @return void
     */
    public function addOpenHour(\Tp3\Tp3Openhours\Domain\Model\OpenHour $openHour)
    {
        $this->openHours->attach($openHour);
    }

    /**
     * Removes a OpenHour
     *
     * @param \Tp3\Tp3Openhours\Domain\Model\OpenHour $openHourToRemove The OpenHour to be removed
     * @return void
     */
    public function removeOpenHour(\Tp3\Tp3Openhours\Domain\Model\OpenHour $openHourToRemove)
    {
        $this->openHours->detach($openHourToRemove);
    }

    /**
     * Returns the openHours
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Tp3\Tp3Openhours\Domain\Model\OpenHour> $openHours
     */
    public function getOpenHours()
    {
        return $this->openHours;
    }

    /**
     * Sets the openHours
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Tp3\Tp3Openhours\Domain\Model\OpenHour> $openHours
     * @return void
     */
    public function setOpenHours(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $openHours)
    {
        $this->openHours = $openHours;
    }
}
