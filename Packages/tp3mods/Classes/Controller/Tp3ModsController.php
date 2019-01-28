<?php

/*
 * This file is part of the web-tp3/tp3mods.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3mods\Controller;

/***
 *
 * This file is part of the "tp3 Mods" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 Thomas Ruta <email@thomasruta.de>, R&amp;P IT Consulting GmbH
 *
 ***/

/**
 * Tp3ModsController
 */
class Tp3ModsController extends \Tp3\Tp3mods\Controller\Tp3AbstractController
{
    /**
     * tp3AdressRepository
     *
     * @var \Tp3\Tp3mods\Domain\Repository\Tp3AdressRepository
     * @inject
     */
    protected $tp3AdressRepository = null;

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $tp3Mods = $this->tp3ModsRepository->findAll();
        $this->view->assign('tp3Mods', $tp3Mods);
    }

    /**
     * action show
     *
     * @param \Tp3\Tp3mods\Domain\Model\Tp3Mods $tp3Mods
     * @return void
     */
    public function showAction(\Tp3\Tp3mods\Domain\Model\Tp3Mods $tp3Mods)
    {
        $this->view->assign('tp3Mods', $tp3Mods);
    }
}
