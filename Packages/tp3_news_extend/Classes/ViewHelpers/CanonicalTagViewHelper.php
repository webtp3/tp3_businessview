<?php

/*
 * This file is part of the web-tp3/tp3_news_extend.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3NewsExtend\ViewHelpers;

/***************************************************************
 * Copyright notice
 *
 * (c) 2016 tp3 <support@tp3.de>
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

class CanonicalTagViewHelper extends AbstractViewHelper
{

    /**
     * As this ViewHelper renders HTML, the output must not be escaped.
     * Remove double encoding
     *
     * @var bool
     */
    protected $escapeOutput = false;
	/**
	 * Renders a canonical tag
	 *
	 * @param Tp3\Tp3NewsExtend\Domain\Model\NewsExtend $newsItem
	 * @param array $settings
	 * @return void
	 */
    public function render($newsItem = null, $settings = [])
    {
		if((is_object($newsItem)) && (count($settings) > 0)) {
			if($newsItem->getCategories()->count() > 1) {
				$uriBuilder = $this->controllerContext->getUriBuilder();

				$url = $uriBuilder->reset()
					->setTargetPageUid($settings['defaultDetailPid'])
                    ->setCreateAbsoluteUri(true)
                    ->setArguments([
						'tx_news_pi1[news]' => $newsItem->getUid(),
						'tx_news_pi1[controller]' => 'News',
						'tx_news_pi1[action]' => 'detail',
                        ])
					->buildFrontendUri();

				$pageRenderer = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Page\\PageRenderer');
				$pageRenderer->addMetaTag('<link rel="canonical" href="'.$url.'">');
			}
		}
	}
}
