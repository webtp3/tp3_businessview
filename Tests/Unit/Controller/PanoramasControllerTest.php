<?php
namespace Tp3\Tp3Businessview\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Thomas Ruta <support@r-p-it.de>
 */
class PanoramasControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Tp3\Tp3Businessview\Controller\PanoramasController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Tp3\Tp3Businessview\Controller\PanoramasController::class)
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
    public function listActionFetchesAllPanoramassFromRepositoryAndAssignsThemToView()
    {

        $allPanoramass = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $panoramasRepository = $this->getMockBuilder(\::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $panoramasRepository->expects(self::once())->method('findAll')->will(self::returnValue($allPanoramass));
        $this->inject($this->subject, 'panoramasRepository', $panoramasRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('panoramass', $allPanoramass);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenPanoramasToView()
    {
        $panoramas = new \Tp3\Tp3Businessview\Domain\Model\Panoramas();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('panoramas', $panoramas);

        $this->subject->showAction($panoramas);
    }
}
