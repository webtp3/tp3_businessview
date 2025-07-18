<?php

/*
 * This file is part of the package web-tp3/tp3-businessview.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3Businessview\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 */
class BusinessAppTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Tp3\Tp3Businessview\Domain\Model\BusinessApp
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Tp3\Tp3Businessview\Domain\Model\BusinessApp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getBusinessviewIdReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getBusinessviewId()
        );
    }

    /**
     * @test
     */
    public function setBusinessviewIdForStringSetsBusinessviewId()
    {
        $this->subject->setBusinessviewId('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'businessviewId',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getGoogleMapsJavaScriptApiKeyReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getGoogleMapsJavaScriptApiKey()
        );
    }

    /**
     * @test
     */
    public function setGoogleMapsJavaScriptApiKeyForStringSetsGoogleMapsJavaScriptApiKey()
    {
        $this->subject->setGoogleMapsJavaScriptApiKey('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'googleMapsJavaScriptApiKey',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getBusinessviewCanvasSelectorReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getBusinessviewCanvasSelector()
        );
    }

    /**
     * @test
     */
    public function setBusinessviewCanvasSelectorForStringSetsBusinessviewCanvasSelector()
    {
        $this->subject->setBusinessviewCanvasSelector('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'businessviewCanvasSelector',
            $this->subject
        );
    }
}
