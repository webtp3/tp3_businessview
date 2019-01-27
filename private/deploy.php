<?php
namespace Deployer;

use Symfony\Component\Console;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Yaml\Yaml;

if(!class_exists(\Composer\Autoload\ClassLoader::class)) require dirname(__DIR__).'/private/Build/vendor/autoload.php';

require 'Build/vendor/deployer/deployer/recipe/typo3.php';
$input = 'dev';//$_SERVER["argv"][1] ? $_SERVER["argv"][1] : "dev";
$yaml = Yaml::parse(file_get_contents(dirname(__DIR__ ). '/private/config/servers.yaml'));
//$yamlString = Yaml::dump($yaml);

// Project name
set('application', $yaml[$input]['application']);

// Project repository
set('repository', $yaml[$input]['repository']);

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', $yaml[$input]['git_tty']);
set('keep_releases',  $yaml[$input]['keep_releases']);

// Shared files/dirs between deploys 
add('shared_files', $yaml[$input]['shared_files']);
add('shared_dirs', $yaml[$input]['shared_dirs']);

// Writable dirs by web server 
add('writable_dirs', $yaml[$input]['writable_dirs']);

//
//// Hosts
//foreach ($iterator as $file) {
//
//}
host( $yaml[$input]['host'])
    ->set('deploy_path', $yaml[$input]['deploy_path']);
    
// Tasks

task('build', function () {
    run('cd {{deploy_path}} && Build');
});

// [Optional] if deploy fails automatically unlock.
//after('deploy:failed', 'deploy:unlock');
task('deploy:start', function ()
{
    cd('~');
    run("if [ ! -d {{deploy_path}} ]; then mkdir -p {{deploy_path}}; fi");
    cd('{{deploy_path}}');
})->setPrivate();

/**
 * Deploy configure
 */
desc('Make configure files for your stage');
task('deploy:configure', function ()
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

//    $finder = new \Symfony\Component\Finder\Finder();
//    $iterator = $finder
//        ->files()
//        ->name('*.tpl')
//        ->in(__DIR__ . '/shared');
//    $tmpDir = sys_get_temp_dir();
//    /* @var $file \Symfony\Component\Finder\SplFileInfo */
//    foreach ($iterator as $file) {
//        $success = false;
//        // Make tmp file
//        $tmpFile = tempnam($tmpDir, 'tmp');
//        if (!empty($tmpFile)) {
//            try {
//                $contents = $compiler($file->getContents());
//                $target = preg_replace('/\.tpl$/', '', $file->getRelativePathname());
//                // Put contents and upload tmp file to server
//                if (file_put_contents($tmpFile, $contents) > 0) {
//                    //run('mkdir -p {{deploy_path}}/shared/' . dirname($target));
//                    upload($tmpFile, '{{deploy_path}}/shared/' . $target);
//                    $success = true;
//                }
//            } catch (\Exception $e) {
//                //throw new $e;
//                $success = false;
//            }
//            // Delete tmp file
//            unlink($tmpFile);
//        }
//        if ($success) {
//            writeln(sprintf("<info>✔</info> %s", $file->getRelativePathname()));
//        } else {
//            writeln(sprintf("<fg=red>✘</fg=red> %s", $file->getRelativePathname()));
//        }
//    }
});

/**
 * Main task
 */
task('deploy', ['deploy:prepare',
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
//\Symfony\Component\Config\Loader\Loader(__DIR__ . 'config/servers.yml');


