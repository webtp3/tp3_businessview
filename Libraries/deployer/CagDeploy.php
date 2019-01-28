<?php
namespace CAG\Deployer;
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 *
 */
//if(!class_exists(\Composer\Autoload\ClassLoader::class)) require dirname(__DIR__).'/private/Build/vendor/autoload.php';

use Deployer\Deployer;
use Symfony\Component\Yaml\Yaml;

class CagDeploy {
    static public $repository = 'git@bitbucket.org:web-tp3/tp3_installer.git';
    static public $keep_releases = '4';
    static public $shared_dirs = ['Build','config','bin', 'Libraries'];
    static public $shared_files = ['composer.json'];
    static public $writable_dirs = ['../tmp/','_temp'];
    static public $writable_use_sudo = false;

/*
 *
     * Set parameters

 */
//require 'recipe/common.php';

//set('ssh_type', 'ext-ssh2');
        /**
         * CagDeploy constructor
         *
         */
    public function __construct()
    {



    }



    /**
     * CagDeploy constructor
     *
     */
    public static function deploy($deploy_path = '.')
    {
        require __DIR__ . '/../../Build/vendor/deployer/deployer/recipe/typo3.php';
        $yaml = Yaml::parse(file_get_contents(__DIR__ . '/../../config/servers.yaml'));
        $yamlString = Yaml::dump($yaml);
        Deployer::set('repository', self::$repository);
        Deployer::set('keep_releases',  self::$keep_releases);
        Deployer::set('shared_dirs',  self::$shared_dirs);
        Deployer::set('shared_files',  self::$shared_files);
        Deployer::set('writable_dirs',  self::$writable_dirs);
        Deployer::set('writable_use_sudo',  self::$writable_use_sudo); // Using sudo in writable commands?
        /**
         * Deploy start, prepare deploy directory
         */
    Deployer::task('deploy:start', function ()
    {
        cd('~');
        run("if [ ! -d {{deploy_path}} ]; then mkdir -p {{deploy_path}}; fi");
        cd('{{deploy_path}}');
    })->setPrivate();

        /**
         * Deploy configure
         */
    desc('Make configure files for your stage');
    Deployer::task('deploy:configure', function ()
    {
        /**
         * Paser value for template compiler
         *
         * @param array $matches
         * @return string
         */
        $paser = function ($matches) {
            if (isset($matches[1])) {
                $value = get($matches[1]);
                if (is_null($value) || is_bool($value) || is_array($value)) {
                    $value = var_export($value, true);
                }
            } else {
                $value = $matches[0];
            }
            return $value;
        };

        /**
         * Template compiler
         *
         * @param string $contents
         * @return string
         */
        $compiler = function ($contents) use ($paser) {
            $contents = preg_replace_callback('/\{\{\s*([\w\.]+)\s*\}\}/', $paser, $contents);

            return $contents;
        };

        $finder = new \Symfony\Component\Finder\Finder();
        $iterator = $finder
            ->files()
            ->name('*.tpl')
            ->in(__DIR__ . '/../../config');
        $tmpDir = sys_get_temp_dir();
        /* @var $file \Symfony\Component\Finder\SplFileInfo */
        foreach ($iterator as $file) {
            $success = false;
            // Make tmp file
            $tmpFile = tempnam($tmpDir, 'tmp');
            if (!empty($tmpFile)) {
                try {
                    $contents = $compiler($file->getContents());
                    $target = preg_replace('/\.tpl$/', '', $file->getRelativePathname());
                    // Put contents and upload tmp file to server
                    if (file_put_contents($tmpFile, $contents) > 0) {
                        //run('mkdir -p {{deploy_path}}/shared/' . dirname($target));
                        upload($tmpFile, '{{deploy_path}}/shared/' . $target);
                        $success = true;
                    }
                } catch (\Exception $e) {
                    //throw new $e;
                    $success = false;
                }
                // Delete tmp file
                unlink($tmpFile);
            }
            if ($success) {
                writeln(sprintf("<info>✔</info> %s", $file->getRelativePathname()));
            } else {
                writeln(sprintf("<fg=red>✘</fg=red> %s", $file->getRelativePathname()));
            }
        }
    });

        /**
         * Main task
         */
    Deployer::task('deploy', ['deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',])->desc('Deploy your project');

    before('deploy:configure', 'deploy:start');
    after('deploy:failed', 'deploy:unlock');
    after('deploy:shared', 'deploy:writable');
    before('deploy', 'deploy:start');
    after('deploy', 'success');

        /**
         * Load stage and list server
         */
    //foreach (glob(__DIR__ . '/stage/*.php') as $filename) {
    //    include $filename;
    //}
    serverList(__DIR__ . '/../../config/servers.yml');
    }


}
