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
class TtAddressTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Tp3\Tp3Openhours\Domain\Model\TtAddress
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Tp3\Tp3Openhours\Domain\Model\TtAddress();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getOpenHoursReturnsInitialValueForOpenHour()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getOpenHours()
        );
    }

    /**
     * @test
     */
    public function setOpenHoursForObjectStorageContainingOpenHourSetsOpenHours()
    {
        $openHour = new \Tp3\Tp3Openhours\Domain\Model\OpenHour();
        $objectStorageHoldingExactlyOneOpenHours = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneOpenHours->attach($openHour);
        $this->subject->setOpenHours($objectStorageHoldingExactlyOneOpenHours);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneOpenHours,
            'openHours',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addOpenHourToObjectStorageHoldingOpenHours()
    {
        $openHour = new \Tp3\Tp3Openhours\Domain\Model\OpenHour();
        $openHoursObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $openHoursObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($openHour));
        $this->inject($this->subject, 'openHours', $openHoursObjectStorageMock);

        $this->subject->addOpenHour($openHour);
    }

    /**
     * @test
     */
    public function removeOpenHourFromObjectStorageHoldingOpenHours()
    {
        $openHour = new \Tp3\Tp3Openhours\Domain\Model\OpenHour();
        $openHoursObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $openHoursObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($openHour));
        $this->inject($this->subject, 'openHours', $openHoursObjectStorageMock);

        $this->subject->removeOpenHour($openHour);
    }
}
