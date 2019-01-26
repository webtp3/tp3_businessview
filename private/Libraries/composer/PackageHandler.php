<?php
namespace CAG\Composer;

use Composer\Script\Event as ScriptEvent;
use Composer\Installer\PackageEvent;
use Composer\Installer\InstallerEvent;
use Helhum\Typo3Console\Exception;

/*
 * https://getcomposer.org/doc/articles/scripts.md
 */
class PackageHandler
{
    /*
    * @param ScriptEvent $event
    * @internal
    * @throws Exception
    */
    public static function postUpdate(ScriptEvent $event)
    {
        $composer = $event->getComposer();
        // do stuff
    }
    /*
    * @param ScriptEvent $event
    * @internal
    * @throws Exception
    */
    public static function preUpdate(ScriptEvent $event)
    {
        $composer = $event->getComposer();
        // do stuff
    }
    /*
      * @param ScriptEvent $event
      * @internal
      * @throws Exception
      */
    public static function postAutoloadDump(ScriptEvent $event)
    {
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        require $vendorDir . '/autoload.php';

        //some_function_from_an_autoloaded_file();
    }
    /*
      * @param ScriptEvent $event
      * @internal
      * @throws Exception
      */
    public static function prePackageInstall(ScriptEvent $event)
    {
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        require $vendorDir . '/autoload.php';

        //some_function_from_an_autoloaded_file();
    }
    /*
      * @param ScriptEvent $event
      * @internal
      * @throws Exception
      */
    public static function prePackageUpdate(ScriptEvent $event)
    {
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        require $vendorDir . '/autoload.php';

        //some_function_from_an_autoloaded_file();
    }
    /*
      * @param ScriptEvent $event
      * @internal
      * @throws Exception
      */
    public static function postPackageUpdate(ScriptEvent $event)
    {
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        require $vendorDir . '/autoload.php';

        //some_function_from_an_autoloaded_file();
    }
    /*
      * @param ScriptEvent $event
      * @internal
      * @throws Exception
      */
    public static function postPackageInstall(InstallerEvent $event)
    {
        $installedPackage = $event->getOperation()->getPackage();
        // do stuff
    }
    /*
      * @param ScriptEvent $event
      * @internal
      * @throws Exception
      */
    public static function dependsSolve(InstallerEvent $event)
    {
        // make cache toasty
    }
}
