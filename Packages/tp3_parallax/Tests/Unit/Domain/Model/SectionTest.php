<?php
namespace Tp3\Tp3Parallax\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Thomas Ruta <email@thomasruta.de>
 */
class SectionTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Tp3\Tp3Parallax\Domain\Model\Section
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Tp3\Tp3Parallax\Domain\Model\Section();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getSpeedReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getSpeed()
        );
    }

    /**
     * @test
     */
    public function setSpeedForIntSetsSpeed()
    {
        $this->subject->setSpeed(12);

        self::assertAttributeEquals(
            12,
            'speed',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDirectionReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getDirection()
        );
    }

    /**
     * @test
     */
    public function setDirectionForIntSetsDirection()
    {
        $this->subject->setDirection(12);

        self::assertAttributeEquals(
            12,
            'direction',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getParallaxcollectionReturnsInitialValueFor()
    {
    }

    /**
     * @test
     */
    public function setParallaxcollectionForSetsParallaxcollection()
    {
    }
}
