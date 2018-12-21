<?php

/*
 * This file is part of the web-tp3/tp3openhours.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3Openhours\Controller;

/***
 *
 * This file is part of the "tt_address OpenHours" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Thomas Ruta &lt;email@thomasruta.de>, tp3
 *
 ***/

/**
 * OpenHourController
 */
class OpenHourController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * openHourRepository
     *
     * @var \Tp3\Tp3Openhours\Domain\Repository\OpenHourRepository
     * @inject
     */
    protected $openHourRepository = null;

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $openHours = $this->openHourRepository->findAll();
        $this->view->assign('openHours', $openHours);
    }

    /**
     * action show
     *
     * @param \Tp3\Tp3Openhours\Domain\Model\OpenHour $openHour
     * @return void
     */
    public function showAction(\Tp3\Tp3Openhours\Domain\Model\OpenHour $openHour)
    {
        $this->view->assign('openHour', $openHour);
    }

    /**
     * action new
     *
     * @return void
     */
    public function newAction()
    {
    }

    /**
     * action create
     *
     * @param \Tp3\Tp3Openhours\Domain\Model\OpenHour $newOpenHour
     * @return void
     */
    public function createAction(\Tp3\Tp3Openhours\Domain\Model\OpenHour $newOpenHour)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->openHourRepository->add($newOpenHour);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \Tp3\Tp3Openhours\Domain\Model\OpenHour $openHour
     * @ignorevalidation $openHour
     * @return void
     */
    public function editAction(\Tp3\Tp3Openhours\Domain\Model\OpenHour $openHour)
    {
        $this->view->assign('openHour', $openHour);
    }

    /**
     * action update
     *
     * @param \Tp3\Tp3Openhours\Domain\Model\OpenHour $openHour
     * @return void
     */
    public function updateAction(\Tp3\Tp3Openhours\Domain\Model\OpenHour $openHour)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->openHourRepository->update($openHour);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \Tp3\Tp3Openhours\Domain\Model\OpenHour $openHour
     * @return void
     */
    public function deleteAction(\Tp3\Tp3Openhours\Domain\Model\OpenHour $openHour)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->openHourRepository->remove($openHour);
        $this->redirect('list');
    }
}
