<?php
namespace Tp3\Tp3mods\Tests\Unit\Domain\Model;
use Tp3\Tp3mods\Domain\Model\Tp3Mods;

/**
 * Test case.
 *
 * @author Thomas Ruta <email@thomasruta.de>
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
    public function getAddressReturnsInitialValueFor()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getAddress()
        );

    }

    /**
     * @test
     */
    public function setAddressForObjectStorageContainingSetsAddress()
    {
        $addres = new (Tp3Mods::class);
        $objectStorageHoldingExactlyOneAddress = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneAddress->attach($addres);
        $this->subject->setAddress($objectStorageHoldingExactlyOneAddress);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneAddress,
            'address',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function addAddresToObjectStorageHoldingAddress()
    {
        $addres = new (Tp3Mods::class);
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
        $addres = new (Tp3Mods::class);
        $addressObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $addressObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($addres));
        $this->inject($this->subject, 'address', $addressObjectStorageMock);

        $this->subject->removeAddres($addres);

    }
}
