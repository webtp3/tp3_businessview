<?php
namespace Tp3\Tp3Parallax\Controller;

/***
 *
 * This file is part of the "tp3 Parallax" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Thomas Ruta <email@thomasruta.de>, tp3
 *
 ***/

/**
 * SectionController
 */
class SectionController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $sections = $this->sectionRepository->findAll();
        $this->view->assign('sections', $sections);
    }

    /**
     * action show
     *
     * @param \Tp3\Tp3Parallax\Domain\Model\Section $section
     * @return void
     */
    public function showAction(\Tp3\Tp3Parallax\Domain\Model\Section $section)
    {
        $this->view->assign('section', $section);
    }
}
