<?php
namespace Tp3\Tp3Openhours\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Thomas Ruta <email@thomasruta.de>
 */
class TtAddressControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Tp3\Tp3Openhours\Controller\TtAddressController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Tp3\Tp3Openhours\Controller\TtAddressController::class)
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
    public function listActionFetchesAllTtAddressesFromRepositoryAndAssignsThemToView()
    {

        $allTtAddresses = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $ttAddressRepository = $this->getMockBuilder(\::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $ttAddressRepository->expects(self::once())->method('findAll')->will(self::returnValue($allTtAddresses));
        $this->inject($this->subject, 'ttAddressRepository', $ttAddressRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('ttAddresses', $allTtAddresses);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenTtAddressToView()
    {
        $ttAddress = new \Tp3\Tp3Openhours\Domain\Model\TtAddress();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('ttAddress', $ttAddress);

        $this->subject->showAction($ttAddress);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenTtAddressToTtAddressRepository()
    {
        $ttAddress = new \Tp3\Tp3Openhours\Domain\Model\TtAddress();

        $ttAddressRepository = $this->getMockBuilder(\::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $ttAddressRepository->expects(self::once())->method('add')->with($ttAddress);
        $this->inject($this->subject, 'ttAddressRepository', $ttAddressRepository);

        $this->subject->createAction($ttAddress);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenTtAddressToView()
    {
        $ttAddress = new \Tp3\Tp3Openhours\Domain\Model\TtAddress();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('ttAddress', $ttAddress);

        $this->subject->editAction($ttAddress);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenTtAddressInTtAddressRepository()
    {
        $ttAddress = new \Tp3\Tp3Openhours\Domain\Model\TtAddress();

        $ttAddressRepository = $this->getMockBuilder(\::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $ttAddressRepository->expects(self::once())->method('update')->with($ttAddress);
        $this->inject($this->subject, 'ttAddressRepository', $ttAddressRepository);

        $this->subject->updateAction($ttAddress);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenTtAddressFromTtAddressRepository()
    {
        $ttAddress = new \Tp3\Tp3Openhours\Domain\Model\TtAddress();

        $ttAddressRepository = $this->getMockBuilder(\::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $ttAddressRepository->expects(self::once())->method('remove')->with($ttAddress);
        $this->inject($this->subject, 'ttAddressRepository', $ttAddressRepository);

        $this->subject->deleteAction($ttAddress);
    }
}
