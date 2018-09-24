<?php
namespace Tp3\Tp3mods\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Thomas Ruta <email@thomasruta.de>
 */
class Tp3AdressTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Tp3\Tp3mods\Domain\Model\Tp3Adress
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Tp3\Tp3mods\Domain\Model\Tp3Adress();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getMicrodataAdressReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getMicrodataAdress()
        );
    }

    /**
     * @test
     */
    public function setMicrodataAdressForBoolSetsMicrodataAdress()
    {
        $this->subject->setMicrodataAdress(true);

        self::assertAttributeEquals(
            true,
            'microdataAdress',
            $this->subject
        );
    }
}
