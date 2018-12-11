<?php
namespace Tp3\Tp3Openhours\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Thomas Ruta <email@thomasruta.de>
 */
class OpenHourControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Tp3\Tp3Openhours\Controller\OpenHourController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Tp3\Tp3Openhours\Controller\OpenHourController::class)
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
    public function listActionFetchesAllOpenHoursFromRepositoryAndAssignsThemToView()
    {

        $allOpenHours = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $openHourRepository = $this->getMockBuilder(\Tp3\Tp3Openhours\Domain\Repository\OpenHourRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $openHourRepository->expects(self::once())->method('findAll')->will(self::returnValue($allOpenHours));
        $this->inject($this->subject, 'openHourRepository', $openHourRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('openHours', $allOpenHours);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenOpenHourToView()
    {
        $openHour = new \Tp3\Tp3Openhours\Domain\Model\OpenHour();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('openHour', $openHour);

        $this->subject->showAction($openHour);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenOpenHourToOpenHourRepository()
    {
        $openHour = new \Tp3\Tp3Openhours\Domain\Model\OpenHour();

        $openHourRepository = $this->getMockBuilder(\Tp3\Tp3Openhours\Domain\Repository\OpenHourRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $openHourRepository->expects(self::once())->method('add')->with($openHour);
        $this->inject($this->subject, 'openHourRepository', $openHourRepository);

        $this->subject->createAction($openHour);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenOpenHourToView()
    {
        $openHour = new \Tp3\Tp3Openhours\Domain\Model\OpenHour();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('openHour', $openHour);

        $this->subject->editAction($openHour);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenOpenHourInOpenHourRepository()
    {
        $openHour = new \Tp3\Tp3Openhours\Domain\Model\OpenHour();

        $openHourRepository = $this->getMockBuilder(\Tp3\Tp3Openhours\Domain\Repository\OpenHourRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $openHourRepository->expects(self::once())->method('update')->with($openHour);
        $this->inject($this->subject, 'openHourRepository', $openHourRepository);

        $this->subject->updateAction($openHour);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenOpenHourFromOpenHourRepository()
    {
        $openHour = new \Tp3\Tp3Openhours\Domain\Model\OpenHour();

        $openHourRepository = $this->getMockBuilder(\Tp3\Tp3Openhours\Domain\Repository\OpenHourRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $openHourRepository->expects(self::once())->method('remove')->with($openHour);
        $this->inject($this->subject, 'openHourRepository', $openHourRepository);

        $this->subject->deleteAction($openHour);
    }
}
