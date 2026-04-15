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
class Tp3BusinessViewTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView
     */
    protected ?\Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $subject = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = new \Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getCreatedByReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getCreatedBy()
        );
    }

    /**
     * @test
     */
    public function setCreatedByForStringSetsCreatedBy(): void
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
    public function getNameReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getName()
        );
    }

    /**
     * @test
     */
    public function setNameForStringSetsName(): void
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
    public function getExternalLinksReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getExternalLinks()
        );
    }

    /**
     * @test
     */
    public function setExternalLinksForStringSetsExternalLinks(): void
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
    public function getGalleryReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getGallery()
        );
    }

    /**
     * @test
     */
    public function setGalleryForStringSetsGallery(): void
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
    public function getIntroReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getIntro()
        );
    }

    /**
     * @test
     */
    public function setIntroForStringSetsIntro(): void
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
    public function getSocialGalleryReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getSocialGallery()
        );
    }

    /**
     * @test
     */
    public function setSocialGalleryForStringSetsSocialGallery(): void
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
    public function getContactReturnsInitialValueForBusinessAdress(): void
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
    public function setContactForObjectStorageContainingBusinessAdressSetsContact(): void
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
    public function addContactToObjectStorageHoldingContact(): void
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
    public function removeContactFromObjectStorageHoldingContact(): void
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
    public function getAppReturnsInitialValueForBusinessApp(): void
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
    public function setAppForObjectStorageContainingBusinessAppSetsApp(): void
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
    public function addAppToObjectStorageHoldingApp(): void
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
    public function removeAppFromObjectStorageHoldingApp(): void
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
    public function getPanoramasReturnsInitialValueForPanoramas(): void
    {
        self::assertEquals(
            null,
            $this->subject->getPanoramas()
        );
    }

    /**
     * @test
     */
    public function setPanoramasForPanoramasSetsPanoramas(): void
    {
        $panoramasFixture = new \Tp3\Tp3Businessview\Domain\Model\Panoramas();
        $this->subject->addPanoramas($panoramasFixture);

        self::assertAttributeEquals(
            $panoramasFixture,
            'panoramas',
            $this->subject
        );
    }
}
