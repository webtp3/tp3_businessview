<?php
namespace Tp3\Tp3Businessview\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Thomas Ruta <support@r-p-it.de>
 */
class Tp3BusinessViewTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getCreatedByReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getCreatedBy()
        );

    }

    /**
     * @test
     */
    public function setCreatedByForStringSetsCreatedBy()
    {
        $this->subject->setCreatedBy('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'createdBy',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getNameReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getName()
        );

    }

    /**
     * @test
     */
    public function setNameForStringSetsName()
    {
        $this->subject->setName('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'name',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getExternalLinksReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getExternalLinks()
        );

    }

    /**
     * @test
     */
    public function setExternalLinksForStringSetsExternalLinks()
    {
        $this->subject->setExternalLinks('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'externalLinks',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getGalleryReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getGallery()
        );

    }

    /**
     * @test
     */
    public function setGalleryForStringSetsGallery()
    {
        $this->subject->setGallery('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'gallery',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getIntroReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getIntro()
        );

    }

    /**
     * @test
     */
    public function setIntroForStringSetsIntro()
    {
        $this->subject->setIntro('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'intro',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getPanoAnimationReturnsInitialValueForInt()
    {
    }

    /**
     * @test
     */
    public function setPanoAnimationForIntSetsPanoAnimation()
    {
    }

    /**
     * @test
     */
    public function getSocialGalleryReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getSocialGallery()
        );

    }

    /**
     * @test
     */
    public function setSocialGalleryForStringSetsSocialGallery()
    {
        $this->subject->setSocialGallery('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'socialGallery',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getPanoOptionsReturnsInitialValueForInt()
    {
    }

    /**
     * @test
     */
    public function setPanoOptionsForIntSetsPanoOptions()
    {
    }

    /**
     * @test
     */
    public function getContactReturnsInitialValueForBusinessAdress()
    {
        self::assertEquals(
            null,
            $this->subject->getContact()
        );

    }

    /**
     * @test
     */
    public function setContactForBusinessAdressSetsContact()
    {
        $contactFixture = new \Tp3\Tp3Businessview\Domain\Model\BusinessAdress();
        $this->subject->setContact($contactFixture);

        self::assertAttributeEquals(
            $contactFixture,
            'contact',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getAppReturnsInitialValueForBusinessApp()
    {
        self::assertEquals(
            null,
            $this->subject->getApp()
        );

    }

    /**
     * @test
     */
    public function setAppForBusinessAppSetsApp()
    {
        $appFixture = new \Tp3\Tp3Businessview\Domain\Model\BusinessApp();
        $this->subject->setApp($appFixture);

        self::assertAttributeEquals(
            $appFixture,
            'app',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getPanoramasReturnsInitialValueForPanoramas()
    {
        self::assertEquals(
            null,
            $this->subject->getPanoramas()
        );

    }

    /**
     * @test
     */
    public function setPanoramasForPanoramasSetsPanoramas()
    {
        $panoramasFixture = new \Tp3\Tp3Businessview\Domain\Model\Panoramas();
        $this->subject->setPanoramas($panoramasFixture);

        self::assertAttributeEquals(
            $panoramasFixture,
            'panoramas',
            $this->subject
        );

    }
}
