<?php
namespace Deployer;

use Symfony\Component\Console;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Yaml\Yaml;

if(!class_exists(\Composer\Autoload\ClassLoader::class)) require dirname(__DIR__).'/private/Build/vendor/autoload.php';

require 'Build/vendor/deployer/deployer/recipe/typo3.php';
$input = 'dev';//$_SERVER["argv"][1] ? $_SERVER["argv"][1] : "dev";
$yaml = Yaml::parse(file_get_contents(dirname(__DIR__ ). '/private/config/servers.yaml'));
//$yamlString = Yaml::dump($yaml);

inventory(dirname(__DIR__ ). '/private/config/servers.yaml');
//if(InputArgument::OPTIONAL)argument('stage', InputArgument::OPTIONAL, 'Run tasks only on this host or stage.');
//if(InputArgument::VALUE_OPTIONAL)option('tag', null, InputOption::VALUE_OPTIONAL, 'Tag to deploy.');
// Project name
//set('application', $yaml[$input]['deploy_path']);
set('deploy_path', $yaml[$input]['deploy_path']);
set('typo3_webroot', $yaml[$input]['typo3_webroot']);

// user
set('http_user', $yaml[$input]['user']);
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
    run('cd {{deploy_path}}');
    run('/usr/bin/composer -v -d {{deploy_path}}  install');
    run('/usr/bin/composer  -d {{deploy_path}} CAG_test:core-tests');
})->local();

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
 * Deploy start, prepare deploy directory
 */
task('deploy:start', function ()
{
    cd('~');
    run("if [ ! -d {{deploy_path}} ]; then mkdir -p {{deploy_path}}; fi");
    cd('{{deploy_path}}');
})->setPrivate();


/**
 * Main TYPO3 task
 */
task('deploy', [
    'deploy:info',
    'deploy:start',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
])->desc('Deploy your project');
after('deploy', 'success');

/**
 * Shared directories
 */
set('shared_dirs', [
    '{{typo3_webroot}}/fileadmin',
    '{{typo3_webroot}}/typo3temp',
    '{{typo3_webroot}}/uploads'
]);

/**
 * Shared files
 */
set('shared_files', [
    '{{typo3_webroot}}/.htaccess'
]);

/**
 * Writeable directories
 */
set('writable_dirs', [
    '{{typo3_webroot}}/fileadmin',
    '{{typo3_webroot}}/typo3temp',
    '{{typo3_webroot}}/typo3conf',
    '{{typo3_webroot}}/uploads'
]);


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


