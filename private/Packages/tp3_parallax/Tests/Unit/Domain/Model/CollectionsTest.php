<?php
namespace Tp3\Tp3Parallax\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Thomas Ruta <email@thomasruta.de>
 */
class CollectionsTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Tp3\Tp3Parallax\Domain\Model\Collections
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Tp3\Tp3Parallax\Domain\Model\Collections();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getParallaxsectionReturnsInitialValueForSection()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getParallaxsection()
        );
    }

    /**
     * @test
     */
    public function setParallaxsectionForObjectStorageContainingSectionSetsParallaxsection()
    {
        $parallaxsection = new \Tp3\Tp3Parallax\Domain\Model\Section();
        $objectStorageHoldingExactlyOneParallaxsection = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneParallaxsection->attach($parallaxsection);
        $this->subject->setParallaxsection($objectStorageHoldingExactlyOneParallaxsection);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneParallaxsection,
            'parallaxsection',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addParallaxsectionToObjectStorageHoldingParallaxsection()
    {
        $parallaxsection = new \Tp3\Tp3Parallax\Domain\Model\Section();
        $parallaxsectionObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $parallaxsectionObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($parallaxsection));
        $this->inject($this->subject, 'parallaxsection', $parallaxsectionObjectStorageMock);

        $this->subject->addParallaxsection($parallaxsection);
    }

    /**
     * @test
     */
    public function removeParallaxsectionFromObjectStorageHoldingParallaxsection()
    {
        $parallaxsection = new \Tp3\Tp3Parallax\Domain\Model\Section();
        $parallaxsectionObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $parallaxsectionObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($parallaxsection));
        $this->inject($this->subject, 'parallaxsection', $parallaxsectionObjectStorageMock);

        $this->subject->removeParallaxsection($parallaxsection);
    }
}
