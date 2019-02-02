<?php
declare(strict_types=1);
namespace Deployer;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Yaml\Yaml;

if (!class_exists(\Composer\Autoload\ClassLoader::class)) {
    require dirname(__DIR__) . '/Build/vendor/autoload.php';
}
var_dump(dirname(__DIR__ ));
require './Build/vendor/deployer/deployer/recipe/typo3.php';
inventory('./config/servers.yaml');
$input_ = new \Symfony\Component\Console\Input\ArgvInput();
$input = 'dev';//$_SERVER["argv"][1] ? $_SERVER["argv"][1] : "dev";
$yaml = Yaml::parse(file_get_contents('./config/servers.yaml'));
//$yamlString = Yaml::dump($yaml);

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
set('composer_options', 'install --no-dev  -v -d {{deploy_path}}releases/{{release_name}}');
//set('composer_options', 'install --verbose --prefer-dist --no-progress --no-interaction --optimize-autoloader');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', $yaml[$input]['git_tty']);
set('keep_releases',  $yaml[$input]['keep_releases']);

// Shared files/dirs between deploys 
add('shared_files', $yaml[$input]['shared_files']);
add('shared_dirs', $yaml[$input]['shared_dirs']);

// Writable dirs by web server 
add('writable_dirs', $yaml[$input]['writable_dirs']);

foreach ($yaml as $key => $y) {
    host($key)
        ->user($y['user'])
        ->port($y['port'] > 1 ? $y['port'] : 22)
        ->configFile($y['configFile'])
        ->hostname($y['hostname'].'.deployer.tp3.de')
        ->forwardAgent($y['forwardAgent'])
        ->multiplexing($y['multiplexing'])
        ->addSshOption('UserKnownHostsFile', '/dev/null')
        ->set('deploy_path', $y['deploy_path'])
        ->addSshOption('StrictHostKeyChecking', 'no')
        ->set('typo3_webroot', $y['typo3_webroot'])
       // ->stage('dev')
// user
    ->set('http_user', $y['user'])
// Project repository
    ->set('repository', $y['repository'])
    ->set('composer_options', 'install --verbose --prefer-dist --no-progress --no-interaction --optimize-autoloader ')
    ->set('deploy_path', $y['deploy_path'])
    ->set('typo3_webroot', $y['typo3_webroot'])

// user
    ->set('http_user', $y['user'])
// Project repository
    ->set('repository', $y['repository'])
//->set('composer_options', 'install --verbose --prefer-dist --no-progress --no-interaction --optimize-autoloader');

// [Optional] Allocate tty for git clone. Default value is false.
    ->set('git_tty', $y['git_tty'])
    ->set('keep_releases',  $y['keep_releases'])

// Shared files/dirs between deploys
    ->add('shared_files', $y['shared_files'])
    ->add('shared_dirs', $y['shared_dirs'])

// Writable dirs by web server
    ->add('writable_dirs', $y['writable_dirs']);
    if ($y['identityFile'] != '') {
        host($y['hostname'])
            ->identityFile($y['identityFile']);
    }
}

//
//// Hosts
host($yaml[$input]['hostname'])
    ->user($yaml[$input]['user'])
    ->hostname($yaml[$input]['hostname'])
    ->port($yaml[$input]['port'] > 1 ? $yaml[$input]['port'] : 22)
    ->configFile($yaml[$input]['configFile'])
    ->identityFile($yaml[$input]['identityFile'])
    ->forwardAgent($yaml[$input]['forwardAgent'])
    ->multiplexing($yaml[$input]['multiplexing'])

    ->addSshOption('UserKnownHostsFile', '/dev/null')
    ->addSshOption('StrictHostKeyChecking', 'no');
// Tasks
desc('Build composer Package');
task('deploy:build', function () {
    run('cd {{deploy_path}}releases/{{release_name}}');
    //run('/usr/bin/php /usr/bin/composer  -v -d {{deploy_path}}releases/{{release_name}}');
   // run('/usr/bin/php /usr/bin/composer CAG_test:core-tests');
});

//// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
task('deploy:start', function () {
    cd('~');
    run('if [ ! -d {{deploy_path}} ]; then mkdir -p {{deploy_path}}; fi');
    cd('{{deploy_path}}');
})->setPrivate();

/**
 * Deploy configure
 */
desc('Make configure files for your stage');
task('deploy:configure', function () {
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
});

/**
 * Deploy start, prepare deploy directory
 */
task('deploy:start', function () {
    cd('~');
    run('if [ ! -d {{deploy_path}} ]; then mkdir -p {{deploy_path}}; fi');
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
    'deploy:build',
    'deploy:unlock',
    'cleanup',
])->desc('Deploy your project');
after('deploy', 'success');

//desc('Creating symlink to release');
//task('deploy:symlink', function () {
//    if (get('use_atomic_symlink')) {
//        run('mv -T {{deploy_path}}/release {{deploy_path}}/current');
//    } else {
//        // Atomic symlink does not supported.
//        // Will use simple≤ two steps switch.
//
//        run('cd {{deploy_path}} && {{bin/symlink}} {{release_path}} current'); // Atomic override symlink.
//        run('cd {{deploy_path}} && rm release'); // Remove release link.
//    }
//    run('cd {{deploy_path}}releases/{{release_name}} && mv web web.bak && {{bin/symlink}} {{typo3_webroot}} web');
//});
/**
 * Shared directories
 */
set('shared_dirs', [
    '{{typo3_webroot}}/fileadmin',
    '{{typo3_webroot}}/typo3temp',
    '{{typo3_webroot}}/uploads',
]);

/**
 * Shared files
 */
set('shared_files', [
    '{{typo3_webroot}}/.htaccess',
]);

/**
 * Writeable directories
 */
set('writable_dirs', [
    '{{typo3_webroot}}/fileadmin',
    '{{typo3_webroot}}/typo3temp',
    '{{typo3_webroot}}/typo3conf',
    '{{typo3_webroot}}/uploads',
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
