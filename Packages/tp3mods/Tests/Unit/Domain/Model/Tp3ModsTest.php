<?php

/*
 * This file is part of the web-tp3/tp3mods.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3mods\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 */
class Tp3ModsTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Tp3\Tp3mods\Domain\Model\Tp3Mods
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Tp3\Tp3mods\Domain\Model\Tp3Mods();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getMicrodataReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getMicrodata()
        );
    }

    /**
     * @test
     */
    public function setMicrodataForStringSetsMicrodata()
    {
        $this->subject->setMicrodata('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'microdata',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getKonfigurationReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getKonfiguration()
        );
    }

    /**
     * @test
     */
    public function setKonfigurationForStringSetsKonfiguration()
    {
        $this->subject->setKonfiguration('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'konfiguration',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getSnippetTypeReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getSnippetType()
        );
    }

    /**
     * @test
     */
    public function setSnippetTypeForStringSetsSnippetType()
    {
        $this->subject->setSnippetType('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'snippetType',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getMainEntryReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getMainEntry()
        );
    }

    /**
     * @test
     */
    public function setMainEntryForStringSetsMainEntry()
    {
        $this->subject->setMainEntry('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'mainEntry',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getAggregateRatingReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getAggregateRating()
        );
    }

    /**
     * @test
     */
    public function setAggregateRatingForBoolSetsAggregateRating()
    {
        $this->subject->setAggregateRating(true);

        self::assertAttributeEquals(
            true,
            'aggregateRating',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getAddressReturnsInitialValueForTp3Adress()
    {
        self::assertEquals(
            null,
            $this->subject->getAddress()
        );
    }

    /**
     * @test
     */
    public function setAddressForTp3AdressSetsAddress()
    {
        $addressFixture = new \Tp3\Tp3mods\Domain\Model\Tp3Adress();
        $this->subject->setAddress($addressFixture);

        self::assertAttributeEquals(
            $addressFixture,
            'address',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addAddresToObjectStorageHoldingAddress()
    {
        $addres = new \Tp3\Tp3mods\Domain\Model\Tp3Mods();
        $addressObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $addressObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($addres));
        $this->inject($this->subject, 'address', $addressObjectStorageMock);

        $this->subject->addAddres($addres);
    }

    /**
     * @test
     */
    public function removeAddresFromObjectStorageHoldingAddress()
    {
        $addres = new \Tp3\Tp3mods\Domain\Model\Tp3Mods();
        $addressObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $addressObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($addres));
        $this->inject($this->subject, 'address', $addressObjectStorageMock);

        $this->subject->removeAddres($addres);
    }
}
