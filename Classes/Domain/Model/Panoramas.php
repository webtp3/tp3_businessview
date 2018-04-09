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
     * uid
     * @var integer
     */
    public $uid = '';

    /**
     * pid
     * @var integer
     */
    public $pid = '';

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
     * title
     *
     * @var string
     */
    protected $title = '';

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
     * position
     *
     * @var string
     */
    protected $position = '';

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the position
     *
     * @return string $position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Sets the position
     *
     * @param string $position
     * @return void
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }
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
     * Returns the uid
     *
     * @return string $uid
     */
    public function getUid()
    {
        return $this->uid;
    }
    /**
     * sets the uid
     *
     * @param string $uid
     */
    public function SetUid($uid)
    {
        return $this->uid = $uid;
    }

    /**
     * Returns the pid
     *
     * @return string $pid
     */
    public function getPid()
    {
        return $this->pid;
    }
    /**
     * sets the pid
     *
     * @param string $pid
     */
    public function SetPid($pid)
    {
        return $this->pid = $pid;
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
