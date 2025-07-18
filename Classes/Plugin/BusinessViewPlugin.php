<?php

/*
 * This file is part of the package web-tp3/tp3-businessview.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3Businessview\Plugin;

/***
 *
 * This file is part of the "tp3 social" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 Thomas Ruta <email@thomasruta.de>, R&P IT Consulting GmbH
 *
 ***/

/**
 * BusinessViewPlugin
  */
class BusinessViewPlugin extends \TYPO3\CMS\Frontend\Plugin\AbstractPlugin
{
    public $prefixId      = 'tx_tp3businessview_tp3businessview';		// Same as class name
    public $extKey        = 'tp3_businessview';	// The extension key.
    public $pi_checkCHash = true;

    /**
     *
     * @var layout;
     */
    public $layout;

    /**
     * action translate
     *
     * @return string
     */
    private function gettranslation($key)
    {
        \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($key, $this->extKey);
    }
    /**
     *
     * @var \TYPO3\CMS\Core\Page\PageRenderer;
     */
    public $pageRenderer = null;
    /**
     *
     * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
     */
    public $cObjRenderer = null;

    /**
     *
     * content Object
     */
    public $cObj;
    /**
     *
     *
     */
    public $settings;

    /**
     * The main method of the PlugIn
     *
     * @param	string		$content: The PlugIn content
     * @param	array		$conf: The PlugIn configuration
     * @return	The content that is displayed on the website
     */
    public function main($cObj = '', $conf = '')
    {
        $this->conf = $conf;
        $this->cObj = $cObj;
        $this->pi_setPiVarDefaults();
        $this->pi_initPIflexForm();
        $this->ffConf = [];

        $this->ffConf['panoramas'] = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'panoramas');
        $this->ffConf['selector'] = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'selector');
        //fallback to output in plugin position
        if ($this->ffConf['selector'] == '') {
            $this->ffConf['selector'] = '#tp3businessview-businessview-canvas';
        }
        return $this->ffConf;
    }
}
