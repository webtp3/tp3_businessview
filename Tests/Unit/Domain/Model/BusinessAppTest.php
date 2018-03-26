<?php

namespace Tp3\Tp3Businessview\Tests\Unit\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Thomas Ruta <support@r-p-it.de>, tp3
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Test case for class \Tp3\Tp3Businessview\Domain\Model\BusinessApp.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Thomas Ruta <support@r-p-it.de>
 */
class BusinessAppTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	/**
	 * @var \Tp3\Tp3Businessview\Domain\Model\BusinessApp
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = new \Tp3\Tp3Businessview\Domain\Model\BusinessApp();
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getBusinessviewIdReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getBusinessviewId()
		);
	}

	/**
	 * @test
	 */
	public function setBusinessviewIdForStringSetsBusinessviewId() {
		$this->subject->setBusinessviewId('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'businessviewId',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getGoogleMapsJavaScriptApiKeyReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getGoogleMapsJavaScriptApiKey()
		);
	}

	/**
	 * @test
	 */
	public function setGoogleMapsJavaScriptApiKeyForStringSetsGoogleMapsJavaScriptApiKey() {
		$this->subject->setGoogleMapsJavaScriptApiKey('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'googleMapsJavaScriptApiKey',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getBusinessviewCanvasSelectorReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getBusinessviewCanvasSelector()
		);
	}

	/**
	 * @test
	 */
	public function setBusinessviewCanvasSelectorForStringSetsBusinessviewCanvasSelector() {
		$this->subject->setBusinessviewCanvasSelector('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'businessviewCanvasSelector',
			$this->subject
		);
	}
}
