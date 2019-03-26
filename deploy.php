<?php
declare(strict_types=1);
namespace Deployer;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Yaml\Yaml;

if (!class_exists(\Composer\Autoload\ClassLoader::class)) {
    require dirname(__DIR__) . '/build/vendor/autoload.php';
}
/*
 *  load config
 */
require $_ENV["TYPO3_PATH_COMPOSER_ROOT"] .'/Build/vendor/deployer/deployer/recipe/typo3.php';

/*
 * for static config just uncomment
 */
//inventory('./config/servers.yaml');
//$input_ = new \Symfony\Component\Console\Input\ArgvInput();
$input = 'dev';//$_SERVER["argv"][1] ? $_SERVER["argv"][1] : "dev";

/*
 * or config is loaded wit symfony
 */

$yaml = Yaml::parse(file_get_contents($_ENV["TYPO3_PATH_COMPOSER_ROOT"] . '/config/servers.yaml'));

//$yamlString = Yaml::dump($yaml);
//#todo input param via cli
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
    host($y['hostname'])
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
        ->stage($y['stage'])
        ->roles('app')
        // ->stage('dev')
// user
        ->set('http_user', $y['user'])
// Project repository
        ->set('repository', $y['repository'])
        ->set('composer_options', 'install --verbose --prefer-dist --no-progress --no-interaction --no-dev --optimize-autoloader ')
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
    ->stage($yaml[$input]['stage'])
    ->addSshOption('UserKnownHostsFile', '~/.ssh/known_hosts')
    ->addSshOption('StrictHostKeyChecking', 'no');

// Tasks
desc('Build Package path setup');
task(
/**
 * Setup typo3_webroot in composer.json config
 *
 *  {{deploy_path}}{{typo3_webroot}}/index.php
ln -s {{deploy_path}}{{typo3_webroot}}/shared/.htaccess
ln -s {{deploy_path}}{{typo3_webroot}}/shared/uploads
ln -s {{deploy_path}}{{typo3_webroot}}/shared/fileadmin
ln -s {{deploy_path}}{{typo3_webroot}}/shared/typo3temp

 *
ln -s  {{deploy_path}}{{typo3_webroot}}/index.php
ln -s {{deploy_path}}{{typo3_webroot}}/current/web/typo3
ln -s {{deploy_path}}{{typo3_webroot}}/current/web/typo3conf

 */
    'deploy:build', function () {
    //  run('cd {{deploy_path}}releases/{{release_name}}');

    cd('{{deploy_path}}{{typo3_webroot}}');
    // put htaccess to shared #todo shared files
    run('if [ ! -f .htaccess ]; then mv .htaccess {{deploy_path}}shared; ln -s {{deploy_path}}shared/.htaccess; fi');
    //clean webroot
    run('if [ -d typo3 ]; then rm {{deploy_path}}{{typo3_webroot}}/typo3 -rf; fi');
    run('if [ -f index.php ]; then rm  {{deploy_path}}{{typo3_webroot}}/index.php; fi');
    run('if [ -d typo3conf ]; then rm  {{deploy_path}}{{typo3_webroot}}/typo3conf; fi');
    run('if [ -d typo3temp ]; then rm  {{deploy_path}}{{typo3_webroot}}/typo3temp; fi');
    run('if [ -d fileadmin ]; then rm  {{deploy_path}}{{typo3_webroot}}/fileadmin; fi');
    run('if [ -d uploads ]; then rm {{deploy_path}}{{typo3_webroot}}/uploads; fi');

    run('if [ -L index.php ]; then rm {{deploy_path}}{{typo3_webroot}}/index.php; fi');
    run('if [ -L typo3 ]; then rm {{deploy_path}}{{typo3_webroot}}/typo3; fi');
    run('if [ -L typo3conf ]; then rm  {{deploy_path}}{{typo3_webroot}}/typo3conf; fi');
    run('if [ -L typo3temp ]; then rm  {{deploy_path}}{{typo3_webroot}}/typo3temp; fi');
    run('if [ -L fileadmin ]; then rm  {{deploy_path}}{{typo3_webroot}}/fileadmin; fi');
    run('if [ -L uploads ]; then rm {{deploy_path}}{{typo3_webroot}}/uploads; fi');

    //symlink webroot to current
    run('if [ ! -d typo3 ]; then ln -s {{deploy_path}}/current/web/typo3; ln -s {{deploy_path}}current/web/index.php; fi');
    run('if [ ! -d typo3conf ]; then ln -s {{deploy_path}}current/web/typo3conf; fi');
    run('if [ ! -d typo3temp ]; then ln -s {{deploy_path}}current/web/typo3temp; fi');
    run('if [ ! -d fileadmin ]; then ln -s {{deploy_path}}current/web/fileadmin; fi');
    run('if [ ! -d uploads ]; then ln -s {{deploy_path}}current/web/uploads; fi');
   // run('chown -R www-data {{deploy_path}}shared/var/log/');
//    run('if [ ! -d {{deploy_path}}/shared ]; then mkdir -p {{deploy_path}}/shared && cd shared/ && ln -s ../config/local.settings.yaml; fi');
//    cd('{{deploy_path}}');
//    run('if [ ! -d {{deploy_path}}/web ]; then mkdir -p {{deploy_path}}/web && mv {{deploy_path}}/../web/* ./ cd {{deploy_path}}/../web/ && ln -s ../private/web/index.php &&  ln -s ../private/web/fileadmin/ &&  ln -s ../private/web/typo3 &&  ln -s ../private/web/typo3conf && ln -s ../private/web/typo3temp && ln -s ../private/web/uploads && rm {{deploy_path}}/web/typo3conf/ext/*;  fi');
//    run('cp -R  config/keys ~/config/');


});


desc('test smoking');
/**
 * Little Tests example -  if things are running
 */
task('deploy:tests', function () {
    //  run('cd {{deploy_path}}releases/{{release_name}}');

    cd('{{deploy_path}}releases/{{release_name}}');

    /*
     * #todo run build acceptance ext. tests
     */
  //  run('mkdir -p var/tests');
    run('bin/chromedriver --url-base=/wd/hub > /dev/null 2>&1 &');
    //no need for server -> external!
//    run('php -S 0.0.0.0:8000 >/devclass_name: AcceptanceTester /null 2>&1 &');
//    run('sleep 3');
// start the test
    run('typo3DatabaseName=\''.getenv('typo3DatabaseName').'\' typo3DatabaseHost=\''.getenv('typo3DatabaseHost').'\' typo3DatabaseUsername=\''.getenv('typo3DatabaseUsername').'\' typo3DatabasePassword=\''.getenv('typo3DatabasePassword').'\'  \
    bin/codecept run Acceptance -c Tests/Build/AcceptanceTests.yml');
});


desc('test smoking');
/**
 * Little Tests example -  if things are running
 */
task('deploy:smoke', function () {
    //  run('cd {{deploy_path}}releases/{{release_name}}');

    cd('{{deploy_path}}releases/{{release_name}}');

    /*
     * #todo run build & tests
     */
    run('/usr/bin/php /usr/bin/composer cag-smoke');
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
    run('if [ ! -d {{deploy_path}}/shared/web/ ]; then mkdir -p {{deploy_path}}shared/web; fi');

})->setPrivate();

/**
 * Main TYPO3 task
 * #todo setup deployment flow
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
    //'deploy:smoke',
    'deploy:unlock',
   // 'deploy:tests',
    'cleanup',
])->desc('Deploy your project');
after('deploy', 'success');

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

