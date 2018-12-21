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
    public function getParallaxPageReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getParallaxPage()
        );
    }

    /**
     * @test
     */
    public function setParallaxPageForIntSetsParallaxPage()
    {
        $this->subject->setParallaxPage(12);

        self::assertAttributeEquals(
            12,
            'parallaxPage',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getParallaxContentReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getParallaxContent()
        );
    }

    /**
     * @test
     */
    public function setParallaxContentForStringSetsParallaxContent()
    {
        $this->subject->setParallaxContent('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'parallaxContent',
            $this->subject
        );
    }
}
