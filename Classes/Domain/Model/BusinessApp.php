<?php
namespace Tp3\Tp3Businessview\Domain\Model;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Thomas Ruta <support@r-p-it.de>, tp3
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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
 * BusinessApp
 */
class BusinessApp extends \TYPO3\CMS\Extbase\DomainObject\AbstractValueObject {

	/**
	 * BusinessView ID
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $businessviewId = '';

	/**
	 * google maps api key
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $googleMapsJavaScriptApiKey = '';

	/**
	 * Jquery Selector
	 *
	 * @var string
	 */
	protected $businessviewCanvasSelector = '';

	/**
	 * Returns the businessviewId
	 *
	 * @return string $businessviewId
	 */
	public function getBusinessviewId() {
		return $this->businessviewId;
	}

	/**
	 * Sets the businessviewId
	 *
	 * @param string $businessviewId
	 * @return void
	 */
	public function setBusinessviewId($businessviewId) {
		$this->businessviewId = $businessviewId;
	}

	/**
	 * Returns the googleMapsJavaScriptApiKey
	 *
	 * @return string $googleMapsJavaScriptApiKey
	 */
	public function getGoogleMapsJavaScriptApiKey() {
		return $this->googleMapsJavaScriptApiKey;
	}

	/**
	 * Sets the googleMapsJavaScriptApiKey
	 *
	 * @param string $googleMapsJavaScriptApiKey
	 * @return void
	 */
	public function setGoogleMapsJavaScriptApiKey($googleMapsJavaScriptApiKey) {
		$this->googleMapsJavaScriptApiKey = $googleMapsJavaScriptApiKey;
	}

	/**
	 * Returns the businessviewCanvasSelector
	 *
	 * @return string $businessviewCanvasSelector
	 */
	public function getBusinessviewCanvasSelector() {
		return $this->businessviewCanvasSelector;
	}

	/**
	 * Sets the businessviewCanvasSelector
	 *
	 * @param string $businessviewCanvasSelector
	 * @return void
	 */
	public function setBusinessviewCanvasSelector($businessviewCanvasSelector) {
		$this->businessviewCanvasSelector = $businessviewCanvasSelector;
	}

}