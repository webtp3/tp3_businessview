<?php
/*
 * https://github.com/TYPO3/class-alias-loader
 * thx @helhum
 * <?php
return array(
    'Tx_About_Controller_AboutController' => \TYPO3\CMS\About\Controller\AboutController::class,
    'Tx_About_Domain_Model_Extension' => \TYPO3\CMS\About\Domain\Model\Extension::class,
    'Tx_About_Domain_Repository_ExtensionRepository' => \TYPO3\CMS\About\Domain\Repository\ExtensionRepository::class,
    'Tx_Aboutmodules_Controller_ModulesController' => \TYPO3\CMS\Aboutmodules\Controller\ModulesController::class,
);
 */

return array(
    'tx_ttaddress_pi1' => \TYPO3\TtAddress\Controller\LegacyPluginController::class,
    'Tx_Phpunit_TestCase' => \TYPO3\CMS\Core\Tests\Unit\Resource\BaseTestCase::class,
    'PHPUnit_Framework_TestCase' => \TYPO3\TestingFramework\Core\Unit\UnitTestCase::class,
    'Tx_Phpunit_Database_TestCase' => \TYPO3\TestingFramework\Core\Unit\UnitTestCase::class


);
