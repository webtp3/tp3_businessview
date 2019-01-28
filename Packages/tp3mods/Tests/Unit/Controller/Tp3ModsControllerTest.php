<?php

/*
 * This file is part of the web-tp3/tp3mods.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3mods\Tests\Unit\Controller;

/**
 * Test case.
 *
 */
class Tp3ModsControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Tp3\Tp3mods\Controller\Tp3ModsController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Tp3\Tp3mods\Controller\Tp3ModsController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllTp3ModssFromRepositoryAndAssignsThemToView()
    {
        $allTp3Modss = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $tp3ModsRepository = $this->getMockBuilder(\Tp3\Tp3mods\Domain\Model\Tp3Mods::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $tp3ModsRepository->expects(self::once())->method('findAll')->will(self::returnValue($allTp3Modss));
        $this->inject($this->subject, 'tp3ModsRepository', $tp3ModsRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('tp3Modss', $allTp3Modss);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenTp3ModsToView()
    {
        $tp3Mods = new \Tp3\Tp3mods\Domain\Model\Tp3Mods();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('tp3Mods', $tp3Mods);

        $this->subject->showAction($tp3Mods);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenTp3ModsToView()
    {
        $tp3Mods = new \Tp3\Tp3mods\Domain\Model\Tp3Mods();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('tp3Mods', $tp3Mods);

        $this->subject->editAction($tp3Mods);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenTp3ModsInTp3ModsRepository()
    {
        $tp3Mods = new \Tp3\Tp3mods\Domain\Model\Tp3Mods();

        $tp3ModsRepository = $this->getMockBuilder(Tp3Mods::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $tp3ModsRepository->expects(self::once())->method('update')->with($tp3Mods);
        $this->inject($this->subject, 'tp3ModsRepository', $tp3ModsRepository);

        $this->subject->updateAction($tp3Mods);
    }
}
