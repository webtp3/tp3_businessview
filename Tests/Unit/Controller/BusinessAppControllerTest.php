<?php
namespace Tp3\Tp3Businessview\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Thomas Ruta <support@r-p-it.de>
 */
class BusinessAppControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Tp3\Tp3Businessview\Controller\BusinessAppController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Tp3\Tp3Businessview\Controller\BusinessAppController::class)
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
    public function listActionFetchesAllBusinessAppsFromRepositoryAndAssignsThemToView()
    {

        $allBusinessApps = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $businessAppRepository = $this->getMockBuilder(\::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $businessAppRepository->expects(self::once())->method('findAll')->will(self::returnValue($allBusinessApps));
        $this->inject($this->subject, 'businessAppRepository', $businessAppRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('businessApps', $allBusinessApps);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenBusinessAppToView()
    {
        $businessApp = new \Tp3\Tp3Businessview\Domain\Model\BusinessApp();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('businessApp', $businessApp);

        $this->subject->showAction($businessApp);
    }
}
