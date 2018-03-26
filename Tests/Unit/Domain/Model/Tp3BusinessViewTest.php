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
 * Test case for class \Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Thomas Ruta <support@r-p-it.de>
 */
class Tp3BusinessViewTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	/**
	 * @var \Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = new \Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView();
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getCreatedByReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getCreatedBy()
		);
	}

	/**
	 * @test
	 */
	public function setCreatedByForStringSetsCreatedBy() {
		$this->subject->setCreatedBy('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'createdBy',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getNameReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getName()
		);
	}

	/**
	 * @test
	 */
	public function setNameForStringSetsName() {
		$this->subject->setName('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'name',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getExternalLinksReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getExternalLinks()
		);
	}

	/**
	 * @test
	 */
	public function setExternalLinksForStringSetsExternalLinks() {
		$this->subject->setExternalLinks('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'externalLinks',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getGalleryReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getGallery()
		);
	}

	/**
	 * @test
	 */
	public function setGalleryForStringSetsGallery() {
		$this->subject->setGallery('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'gallery',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getIntroReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getIntro()
		);
	}

	/**
	 * @test
	 */
	public function setIntroForStringSetsIntro() {
		$this->subject->setIntro('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'intro',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getPanoAnimationReturnsInitialValueForInteger() {
		$this->assertSame(
			0,
			$this->subject->getPanoAnimation()
		);
	}

	/**
	 * @test
	 */
	public function setPanoAnimationForIntegerSetsPanoAnimation() {
		$this->subject->setPanoAnimation(12);

		$this->assertAttributeEquals(
			12,
			'panoAnimation',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getSocialGalleryReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getSocialGallery()
		);
	}

	/**
	 * @test
	 */
	public function setSocialGalleryForStringSetsSocialGallery() {
		$this->subject->setSocialGallery('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'socialGallery',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getPanoOptionsReturnsInitialValueForInteger() {
		$this->assertSame(
			0,
			$this->subject->getPanoOptions()
		);
	}

	/**
	 * @test
	 */
	public function setPanoOptionsForIntegerSetsPanoOptions() {
		$this->subject->setPanoOptions(12);

		$this->assertAttributeEquals(
			12,
			'panoOptions',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getContactReturnsInitialValueForBusinessAdress() {
		$this->assertEquals(
			NULL,
			$this->subject->getContact()
		);
	}

	/**
	 * @test
	 */
	public function setContactForBusinessAdressSetsContact() {
		$contactFixture = new \Tp3\Tp3Businessview\Domain\Model\BusinessAdress();
		$this->subject->setContact($contactFixture);

		$this->assertAttributeEquals(
			$contactFixture,
			'contact',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getAppReturnsInitialValueForBusinessApp() {
		$this->assertEquals(
			NULL,
			$this->subject->getApp()
		);
	}

	/**
	 * @test
	 */
	public function setAppForBusinessAppSetsApp() {
		$appFixture = new \Tp3\Tp3Businessview\Domain\Model\BusinessApp();
		$this->subject->setApp($appFixture);

		$this->assertAttributeEquals(
			$appFixture,
			'app',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getPanoramasReturnsInitialValueForPanoramas() {
		$this->assertEquals(
			NULL,
			$this->subject->getPanoramas()
		);
	}

	/**
	 * @test
	 */
	public function setPanoramasForPanoramasSetsPanoramas() {
		$panoramasFixture = new \Tp3\Tp3Businessview\Domain\Model\Panoramas();
		$this->subject->setPanoramas($panoramasFixture);

		$this->assertAttributeEquals(
			$panoramasFixture,
			'panoramas',
			$this->subject
		);
	}
}
