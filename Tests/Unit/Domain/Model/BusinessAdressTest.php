<?php
namespace Tp3\Tp3Businessview\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Thomas Ruta <support@r-p-it.de>
 */
class BusinessAdressTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Tp3\Tp3Businessview\Domain\Model\BusinessAdress
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Tp3\Tp3Businessview\Domain\Model\BusinessAdress();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getCidReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getCid()
        );

    }

    /**
     * @test
     */
    public function setCidForStringSetsCid()
    {
        $this->subject->setCid('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'cid',
            $this->subject
        );

    }
}
