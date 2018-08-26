<?php
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

    /**
     * action edit
     * 
     * @param \Tp3\Tp3mods\Domain\Model\Tp3Mods $tp3Mods
     * @ignorevalidation $tp3Mods
     * @return void
     */
    public function editAction(\Tp3\Tp3mods\Domain\Model\Tp3Mods $tp3Mods)
    {
        $this->view->assign('tp3Mods', $tp3Mods);
    }

    /**
     * action update
     * 
     * @param \Tp3\Tp3mods\Domain\Model\Tp3Mods $tp3Mods
     * @return void
     */
    public function updateAction(\Tp3\Tp3mods\Domain\Model\Tp3Mods $tp3Mods)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->tp3ModsRepository->update($tp3Mods);
        $this->redirect('list');
    }
}
