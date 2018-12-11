<?php
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
 * TtAddressController
 */
class TtAddressController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {
        $ttAddresses = $this->ttAddressRepository->findAll();
        $this->view->assign('ttAddresses', $ttAddresses);
    }

    /**
     * action show
     * 
     * @param \Tp3\Tp3Openhours\Domain\Model\TtAddress $ttAddress
     * @return void
     */
    public function showAction(\Tp3\Tp3Openhours\Domain\Model\TtAddress $ttAddress)
    {
        $this->view->assign('ttAddress', $ttAddress);
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
     * @param \Tp3\Tp3Openhours\Domain\Model\TtAddress $newTtAddress
     * @return void
     */
    public function createAction(\Tp3\Tp3Openhours\Domain\Model\TtAddress $newTtAddress)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->ttAddressRepository->add($newTtAddress);
        $this->redirect('list');
    }

    /**
     * action edit
     * 
     * @param \Tp3\Tp3Openhours\Domain\Model\TtAddress $ttAddress
     * @ignorevalidation $ttAddress
     * @return void
     */
    public function editAction(\Tp3\Tp3Openhours\Domain\Model\TtAddress $ttAddress)
    {
        $this->view->assign('ttAddress', $ttAddress);
    }

    /**
     * action update
     * 
     * @param \Tp3\Tp3Openhours\Domain\Model\TtAddress $ttAddress
     * @return void
     */
    public function updateAction(\Tp3\Tp3Openhours\Domain\Model\TtAddress $ttAddress)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->ttAddressRepository->update($ttAddress);
        $this->redirect('list');
    }

    /**
     * action delete
     * 
     * @param \Tp3\Tp3Openhours\Domain\Model\TtAddress $ttAddress
     * @return void
     */
    public function deleteAction(\Tp3\Tp3Openhours\Domain\Model\TtAddress $ttAddress)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->ttAddressRepository->remove($ttAddress);
        $this->redirect('list');
    }
}
