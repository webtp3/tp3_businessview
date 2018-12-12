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
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getContact()
        );
    }

    /**
     * @test
     */
    public function setContactForObjectStorageContainingBusinessAdressSetsContact()
    {
        $contact = new \Tp3\Tp3Businessview\Domain\Model\BusinessAdress();
        $objectStorageHoldingExactlyOneContact = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneContact->attach($contact);
        $this->subject->setContact($objectStorageHoldingExactlyOneContact);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneContact,
            'contact',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addContactToObjectStorageHoldingContact()
    {
        $contact = new \Tp3\Tp3Businessview\Domain\Model\BusinessAdress();
        $contactObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $contactObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($contact));
        $this->inject($this->subject, 'contact', $contactObjectStorageMock);

        $this->subject->addContact($contact);
    }

    /**
     * @test
     */
    public function removeContactFromObjectStorageHoldingContact()
    {
        $contact = new \Tp3\Tp3Businessview\Domain\Model\BusinessAdress();
        $contactObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $contactObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($contact));
        $this->inject($this->subject, 'contact', $contactObjectStorageMock);

        $this->subject->removeContact($contact);
    }

    /**
     * @test
     */
    public function getAppReturnsInitialValueForBusinessApp()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getApp()
        );
    }

    /**
     * @test
     */
    public function setAppForObjectStorageContainingBusinessAppSetsApp()
    {
        $app = new \Tp3\Tp3Businessview\Domain\Model\BusinessApp();
        $objectStorageHoldingExactlyOneApp = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneApp->attach($app);
        $this->subject->setApp($objectStorageHoldingExactlyOneApp);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneApp,
            'app',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addAppToObjectStorageHoldingApp()
    {
        $app = new \Tp3\Tp3Businessview\Domain\Model\BusinessApp();
        $appObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $appObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($app));
        $this->inject($this->subject, 'app', $appObjectStorageMock);

        $this->subject->addApp($app);
    }

    /**
     * @test
     */
    public function removeAppFromObjectStorageHoldingApp()
    {
        $app = new \Tp3\Tp3Businessview\Domain\Model\BusinessApp();
        $appObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $appObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($app));
        $this->inject($this->subject, 'app', $appObjectStorageMock);

        $this->subject->removeApp($app);
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
