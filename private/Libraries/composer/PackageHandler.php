<?php
namespace CAG\Composer;

use Composer\Script\Event as ScriptEvent;
use Composer\Installer\PackageEvent;
use Composer\Installer\InstallerEvent;
use Helhum\Typo3Console\Exception;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

/*
 * https://getcomposer.org/doc/articles/scripts.md
 */
class PackageHandler
{

    private static  $version;

    private static  $package;

    private static  $composer_event;

    private static  $filesystem;

    private static $config;
    /**
     * @param Event $event
     * @internal
     * @throws Exception
     */
    public static function init($e){
        //self::verifyAutoloadInfoInLibraries();
        self::setComposerEvent($e);
        self::setPackage($e->getComposer()->getPackage());
        self::setVersion(substr($e->getComposer()->getPackage()->getVersion(),0,5));
        self::setConfig($e->getComposer()->getConfig());
    }
    public static  function setComposerEvent($composer_event){
        self::$composer_event = $composer_event;

    }
    public static  function getComposerEvent(){
        return self::$composer_event;
    }
    public static  function setPackage($package){
        self::$package = $package;

    }
    public static  function getPackage(){
        return self::$package;
    }
    public static  function setConfig($config){
        self::$config = $config;

    }
    public static function getConfig(){
        return self::$config;
    }
    private function getVersion(){
        return self::version;
    }
    /**
     * @param ScriptEvent $event
     * @internal
     * @throws Exception
     */
    public static function setVersion($version = null)
    {
       // if($version !== null)$version = self::$composer_event->getArguments()[0];
        if (!preg_match('/\d+\.\d+\.\d+/', $version)) {
            throw new Exception('No valid version number provided!', 1468672604);
        }
        self::$version = $version;

        $extEmConfFile = __DIR__ . '/../../../Resources/Private/ExtensionArtifacts/ext_emconf.php';
        $content = file_get_contents($extEmConfFile);
        $content = preg_replace('/(\'version\' => )\'\d+\.\d+\.\d+/', '$1\'' . $version, $content);
//        file_put_contents($extEmConfFile, $content);


    }

    /**
      * @param InstallerEvent $event
      * @internal
      * @throws Exception
      */
    public static function dependsSolve(InstallerEvent $event)
    {
        // make cache toasty
//        var_dump($event->getComposer()->getConfig()->get('web-root'));
//        exit;
    }
    /**
      * @param ScriptEvent $event
      * @internal
      * @throws Exception
      */
    public static function preUpdate(ScriptEvent $event)
    {
        $cag = self::init($event);
        // do stuff

        if (file_exists($folder = dirname(__DIR__ . '/../' . $event->getComposer()->getConfig()->get('web-root'))) &&
            !file_exists(dirname(__DIR__ . '/../' . $event->getComposer()->getConfig()->get('web-dir')))) {
            try {
                $fileSystem = new Filesystem();

                try {
//                    $bkp = $folder . '_' . random_int(0, 1000);
//                    echo 'backuped old Packages  ' . $bkp . PHP_EOL;
//                    $fileSystem->rename($folder, $bkp);
                    symlink( $folder,dirname(__DIR__ . '/../' . $event->getComposer()->getConfig()->get('web-dir')));

                } catch (IOExceptionInterface $exception) {
                    echo "An error occurred while creating your directory at " . $exception->getPath();
                }
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            echo 'linked web-root to Version ' . self::$version . PHP_EOL;


        }
    }
    /**
      * @param ScriptEvent $event
      * @internal
      * @throws Exception
      */
    public static function prePackageInstall(ScriptEvent $event)
    {
        $cag = self::init($event);
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');

        if($event->getComposer()->getPackage()->getName() != "thomasruta/tests")return;
        //require $vendorDir . '/autoload.php';


    }
    /**
      * @param ScriptEvent $event
      * @internal
      * @throws Exception
      */
    public static function prePackageUpdate(ScriptEvent $event)
    {
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        require $vendorDir . '/autoload.php';

        if($event->getComposer()->getPackage()->getName() != "thomasruta/tests")return;
        /*
         * dir to copy
         */
       // var_dump($event->getComposer()->getConfig()->get('web-root'));
        $repos = $event->getComposer()->getConfig()->getRepositories();
        $package_version = substr($event->getComposer()->getPackage()->getVersion(),0,5);
        $dirto = substr( $event->getComposer()->getConfig()->getRepositories()[1]["url"],2,strlen($event->getComposer()->getConfig()->getRepositories()[1]["url"])-4);
        //some_function_from_an_autoloaded_file();
//        if (file_exists( $folder = dirname(__DIR__ . '/../'.$dirto))) {
//            //move dir and add syslink
//            try {
//                $fileSystem = new Filesystem();
//
//                try {
//                    $bkp = dirname(__DIR__ . '/../'.$dirto).'_'.random_int(0, 1000) ;
//                    echo 'backuped old Packages  '.$bkp . PHP_EOL;
//                    $fileSystem->rename($folder, $bkp);
//                } catch (IOExceptionInterface $exception) {
//                    echo "An error occurred while creating your directory at ".$exception->getPath();
//                }
//            } catch (FileException $e) {
//                // ... handle exception if something happens during file upload
//            }
//            symlink(dirname(__DIR__ ). '/../'. $dirto. '_'.$package_version,dirname(__DIR__ ). '/../'. $dirto);
//
//            echo 'linked Packages to Version '.$package_version . PHP_EOL;
//
//        } else if ($package_version) {
//            echo 'linked Packages to Version '.$package_version . PHP_EOL;
//
//            symlink(dirname(__DIR__ ). '/../'. $dirto. '_'.$package_version,dirname(__DIR__ ). '/../'. $dirto);
//
//        } else  {
//            echo 'Unable to find Packages' . PHP_EOL;
//            exit(1);
//        }
    }

    /**
 * @param ScriptEvent $event
 * @internal
 * @throws Exception
 */
    public static function postUpdate(ScriptEvent $event)
    {
        $composer = $event->getComposer();
        // do stuff
    }

    /**
      * @param ScriptEvent $event
      * @internal
      * @throws Exception
      */
    public static function postAutoloadDump(ScriptEvent $event)
    {

    }
    /**
      * @param ScriptEvent $event
      * @internal
      * @throws Exception
      */
    public static function postPackageUpdate(ScriptEvent $event)
    {

    }
    /**
      * @param InstallerEvent $event
      * @internal
      * @throws Exception
      */
    public static function postPackageInstall(InstallerEvent $event)
    {
        $installedPackage = $event->getOperation()->getPackage();
        // do stuff

    }



    public static function verifyAutoloadInfoInLibraries()
    {
        $main = json_decode(file_get_contents('composer.json'), true)['autoload'];
        $lib = json_decode(file_get_contents('Libraries/composer.json'), true)['autoload'];
        if (count($main) !== count($lib)) {
            throw new Exception('Count of autoload definition mismatch');
        }
        if (count($main['psr-4']) !== count($lib['psr-4'])) {
            throw new Exception('Count of psr-4 definition mismatch');
        }
        foreach ($main['psr-4'] as $prefix => $paths) {
            if (
                count($paths) !== count($lib['psr-4'][$prefix])
                || empty($lib['psr-4'][$prefix])
            ) {
                throw new Exception('Count of psr-4 paths mismatch');
            }
            foreach ($paths as $index => $path) {
                if ('../' . $path !== $lib['psr-4'][$prefix][$index]) {
                    throw new Exception('Different psr-4 paths defined');
                }
            }
        }
    }
}
