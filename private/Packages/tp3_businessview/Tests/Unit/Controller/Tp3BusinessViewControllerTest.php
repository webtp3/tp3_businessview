<?php
namespace Tp3\Tp3Businessview\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Thomas Ruta <support@r-p-it.de>
 */
class Tp3BusinessViewControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Tp3\Tp3Businessview\Controller\Tp3BusinessViewController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Tp3\Tp3Businessview\Controller\Tp3BusinessViewController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

}
