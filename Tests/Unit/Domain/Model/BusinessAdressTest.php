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
class BusinessAdressTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Tp3\Tp3Businessview\Domain\Model\BusinessAdress
     */
    protected ?\Tp3\Tp3Businessview\Domain\Model\BusinessAdress $subject = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = new \Tp3\Tp3Businessview\Domain\Model\BusinessAdress();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getCidReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getCid()
        );
    }

    /**
     * @test
     */
    public function setCidForStringSetsCid(): void
    {
        $this->subject->setCid('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'cid',
            $this->subject
        );
    }
}
