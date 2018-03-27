<?php
namespace Tp3\Tp3Businessview\Controller;

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

/***
 *
 * This file is part of the "BusinsessView" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Thomas Ruta <support@r-p-it.de>, tp3
 *
 ***/

/**
 * Tp3BusinessViewController
 */
class Tp3BusinessViewController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * action display
     * 
     * @return void
     */
    public function displayAction()
    {

    }

    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {
        $tp3BusinessViews = $this->tp3BusinessViewRepository->findAll();
        $this->view->assign('tp3BusinessViews', $tp3BusinessViews);
    }
    /**
     * action index
     *
     * @return void
     */
    public function indexAction()
    {
        /*GeneralUtility::makeInstance(PageRenderer::class)
            ->addRequireJsConfiguration([
                'paths' => [
                    'custom-lib' => '/typo3conf/ext/tp3_businessview/Resources/Public/JavaScript/tp3_app.js',
                ],
                'shim' => [
                    'custom-lib' => ['jquery'],
                ],
            ]);*/
       // $tp3BusinessViews = $this->tp3BusinessViewRepository->findAll();
        $tp3BusinessViews = [
            "apis" => ["jquery","maps"],
            "js" => ["Tp3App.js"],
        ];
        $this->view->assign('tp3BusinessViews', $tp3BusinessViews);
    }

    /**
     * action show
     * 
     * @param \Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $tp3BusinessView
     * @return void
     */
    public function showAction(\Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $tp3BusinessView)
    {
        $this->view->assign('tp3BusinessView', $tp3BusinessView);
    }
}
