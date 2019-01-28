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
 * CollectionsController
 */
class CollectionsController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * collectionsRepository
     *
     * @var \Tp3\Tp3Parallax\Domain\Repository\CollectionsRepository
     * @inject
     */
    protected $collectionsRepository = null;

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $collections = $this->collectionsRepository->findAll();
        $this->view->assign('collections', $collections);
    }

    /**
     * action show
     *
     * @param \Tp3\Tp3Parallax\Domain\Model\Collections $collections
     * @return void
     */
    public function showAction(\Tp3\Tp3Parallax\Domain\Model\Collections $collections)
    {
        $this->view->assign('collections', $collections);
    }
}
