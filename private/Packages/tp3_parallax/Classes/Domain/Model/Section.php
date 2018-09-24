<?php
namespace Tp3\Tp3Parallax\Domain\Model;

/***
 *
 * This file is part of the "tp3 Parallax" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Thomas Ruta <email@thomasruta.de>, tp3
 *
 ***/

/**
 * Section
 */
class Section extends \TYPO3\CMS\Extbase\DomainObject\AbstractValueObject
{
    /**
     * transition speed
     *
     * @var int
     */
    protected $speed = 0;

    /**
     * direction
     *
     * @var int
     */
    protected $direction = 0;

    /**
     * Parallax Collection
     *
     * @var
     */
    protected $parallaxcollection = null;

    /**
     * Returns the speed
     *
     * @return int $speed
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * Sets the speed
     *
     * @param int $speed
     * @return void
     */
    public function setSpeed($speed)
    {
        $this->speed = $speed;
    }

    /**
     * Returns the direction
     *
     * @return int $direction
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * Sets the direction
     *
     * @param int $direction
     * @return void
     */
    public function setDirection($direction)
    {
        $this->direction = $direction;
    }

    /**
     * Returns the parallaxcollection
     *
     * @return  $parallaxcollection
     */
    public function getParallaxcollection()
    {
        return $this->parallaxcollection;
    }

    /**
     * Sets the parallaxcollection
     *
     * @param string $parallaxcollection
     * @return void
     */
    public function setParallaxcollection($parallaxcollection)
    {
        $this->parallaxcollection = $parallaxcollection;
    }
}
