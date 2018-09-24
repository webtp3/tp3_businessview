<?php
namespace Tp3\Tp3mods\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Thomas Ruta <email@thomasruta.de>
 */
class Tp3AdressControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Tp3\Tp3mods\Controller\Tp3AdressController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Tp3\Tp3mods\Controller\Tp3AdressController::class)
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
    public function listActionFetchesAllTp3AdressesFromRepositoryAndAssignsThemToView()
    {

        $allTp3Adresses = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $tp3AdressRepository = $this->getMockBuilder(\Tp3\Tp3mods\Domain\Repository\Tp3AdressRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $tp3AdressRepository->expects(self::once())->method('findAll')->will(self::returnValue($allTp3Adresses));
        $this->inject($this->subject, 'tp3AdressRepository', $tp3AdressRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('tp3Adresses', $allTp3Adresses);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenTp3AdressToView()
    {
        $tp3Adress = new \Tp3\Tp3mods\Domain\Model\Tp3Adress();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('tp3Adress', $tp3Adress);

        $this->subject->showAction($tp3Adress);
    }
}
