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
 * Panoramas
 */
class Panoramas extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * panoId
     *
     * @var string
     * @validate NotEmpty
     */
    protected $panoId = '';

    /**
     * heading
     *
     * @var string
     */
    protected $heading = '';

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
     * Returns the panoId
     *
     * @return string $panoId
     */
    public function getPanoId()
    {
        return $this->panoId;
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
}
