<?php

/*
 * This file is part of the web-tp3/tp3businessview.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3Businessview\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 */
class PanoramasTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Tp3\Tp3Businessview\Domain\Model\Panoramas
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Tp3\Tp3Businessview\Domain\Model\Panoramas();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getPanoIdReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getPanoId()
        );
    }

    /**
     * @test
     */
    public function setPanoIdForStringSetsPanoId()
    {
        $this->subject->setPanoId('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'panoId',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getHeadingReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getHeading()
        );
    }

    /**
     * @test
     */
    public function setHeadingForStringSetsHeading()
    {
        $this->subject->setHeading('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'heading',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getPitchReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getPitch()
        );
    }

    /**
     * @test
     */
    public function setPitchForStringSetsPitch()
    {
        $this->subject->setPitch('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'pitch',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getZoomReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getZoom()
        );
    }

    /**
     * @test
     */
    public function setZoomForStringSetsZoom()
    {
        $this->subject->setZoom('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'zoom',
            $this->subject
        );
    }
}
