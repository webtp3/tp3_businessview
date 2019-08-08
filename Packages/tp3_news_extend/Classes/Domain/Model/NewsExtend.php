<?php

/*
 * This file is part of the web-tp3/tp3_news_extend.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3NewsExtend\Domain\Model;

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

class NewsExtend extends \GeorgRinger\News\Domain\Model\News {

    //--- html5video ---//

    /**
     * @var \HVP\Html5videoplayer\Domain\Model\Video
     */
    protected $html5video;

    /**
     * Getter for html5video
     *
     * @return \HVP\Html5videoplayer\Domain\Model\Video
     */
    public function getHtml5video() {
        return $this->html5video;
    }

    /**
     * Setter for html5video
     *
     * @param \HVP\Html5videoplayer\Domain\Model\Video $html5video
     * @return void
     */
    public function setHtml5video($html5video) {
        $this->html5video = $html5video;
    }
}
?>
