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
 * OpenHour
 */
class OpenHour extends \TYPO3\CMS\Extbase\DomainObject\AbstractValueObject
{

    /**
     * DayArray
     *
     * @var array
     */
    protected $DayArray =  ['', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa', 'So', 'Mo-Fr', 'Sa-So', '24x7'];

    /**
     * MicroDayArray
     *
     * @var array
     */
    protected $MicroDayArray =  ['', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su', 'Mo-Fr', 'Sa-Su', 'all day'];
    /*
        ['Mo'=> 1],
        ['Di'=> 2],
        ['Mi'=> 3],
        ['Do'=> 4],
        ['Fr'=> 5],
        ['Sa'=> 6],
        ['So'=> 7],
        ['Mo-Fr'=> 8],
        ['Sa-So'=> 9],*/

    /**
     * Day of OpenHours
     *
     * @var int
     * @validate NotEmpty
     */
    protected $day = 0;

    /**
     * openTime
     *
     * @var int
     * @validate NotEmpty
     */
    protected $openTime = 0;

    /**
     * closeTime
     *
     * @var int
     */
    protected $closeTime = 0;
    /**
     * Returns the day
     *
     * @return int $day
     */
    public function getDayNames()
    {
        $timestamp = strtotime('next Sunday');
        $days = [];
        for ($i = 0; $i < 7; $i++) {
            $days[] = strftime('%A', $timestamp);
            $timestamp = strtotime('+1 day', $timestamp);
        }
        $this->DayArray = array_merge($this->DayArray, $days);
    }
    /**
     * Returns the day
     *
     * @return int $day
     */
    public function getDay()
    {
        return $this->day;
    }
    /**
     * Returns the dayname
     *
     * @return string
     */
    public function getDayName()
    {
        return $this->DayArray[$this->day];
    }

    /**
     * Sets the day
     *
     * @param int $day
     * @return void
     */
    public function setDay($day)
    {
        $this->day = $day;
    }
    /**
     * Returns the dayname
     *
     * @return string
     */
    public function getMicroDayName()
    {
        return $this->MicroDayArray[$this->day];
    }


    /**
     * Returns the openTime
     *
     * @return int $openTime
     */
    public function getOpenTime()
    {
        return $this->openTime;
    }

    /**
     * Sets the openTime
     *
     * @param int $openTime
     * @return void
     */
    public function setOpenTime(int $openTime)
    {
        $this->openTime = $openTime;
    }

    /**
     * Returns the closeTime
     *
     * @return int $closeTime
     */
    public function getCloseTime()
    {
        return $this->closeTime;
    }

    /**
     * Sets the closeTime
     *
     * @param int $closeTime
     * @return void
     */
    public function setCloseTime(int $closeTime)
    {
        $this->closeTime = $closeTime;
    }
}
