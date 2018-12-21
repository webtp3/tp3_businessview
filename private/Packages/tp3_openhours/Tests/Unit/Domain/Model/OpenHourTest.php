<?php

/*
 * This file is part of the web-tp3/tp3openhours.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3Openhours\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 */
class OpenHourTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Tp3\Tp3Openhours\Domain\Model\OpenHour
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Tp3\Tp3Openhours\Domain\Model\OpenHour();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getDayReturnsInitialValueForInt()
    {
    }

    /**
     * @test
     */
    public function setDayForIntSetsDay()
    {
    }

    /**
     * @test
     */
    public function getOpenTimeReturnsInitialValueForInt()
    {
    }

    /**
     * @test
     */
    public function setOpenTimeForIntSetsOpenTime()
    {
    }

    /**
     * @test
     */
    public function getCloseTimeReturnsInitialValueForInt()
    {
    }

    /**
     * @test
     */
    public function setCloseTimeForIntSetsCloseTime()
    {
    }
}
