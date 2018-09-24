<?php
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
class Tp3Adress extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
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
     * Returns the boolean state of microdataAdress
     *
     * @return bool
     */
    public function isMicrodataAdress()
    {
        return $this->microdataAdress;
    }
}
