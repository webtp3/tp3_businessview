# tp3_tests

This is an installer for typo3 dev environment with unit, functional and acceptance  testing and developer tools
```bash
git clone git@bitbucket.org:thomasruta/tp3_tests.git mynewproject_www
cd mynewproject_www
rm -rf .git 
git init
```
## How do I get set up? ###

Make sure, your PHP (Web & CLI) is 7.x and that you have `composer`
installed in your (local) environment.

### Local Setup ###

Install TYPO3 and all composer based extensions / components and local private packages:

```bash
 composer config repositories.local path 'Packages/*'
 #(if you want to install interactive)
 composer req typo3-console/composer-typo3-auto-install 
 #(else just install)
 composer --dev  install
```
you can user cli to install typo3 or the interactive Process
```bash
    php vendor/bin/typo3cms install:setup --force \
    --database-user-name root --database-user-password 8ungRP! \
    --database-host-name localhost --database-port 3306 \
    --database-socket /var/run/mysqld/mysqld.sock \
    --use-existing-database y \
    --database-name tp3_tests \
    --admin-user-name tp3min \
    --admin-password Init1111 \
    --site-name tp3Testing \
    --non-interactive true ;
```
    
#### install starts ###

    ➤ Set up database connection
    User name for database server (default: ""): root
    User password for database server (default: ""):
    Host name of database server (default: "127.0.0.1"):
    TCP Port of database server (default: "3306"):
    Unix Socket to connect to (default: ""): /var/run/mysqld/mysqld.sock

After the installation is finisched you can start Testing

```bash
  # start testing
 php vendor/phpunit/phpunit/phpunit --configuration web/typo3conf/ext/cag_tests/Tests/Build/UnitTests.xml --teamcity
 php vendor/phpunit/phpunit/phpunit --configuration web/typo3conf/ext/cag_tests/Tests/Build/UnitTestsDeprecated.xml --teamcity
 php vendor/phpunit/phpunit/phpunit --configuration web/typo3conf/ext/cag_tests/Tests/Build/FunctionalTests.xml --teamcity
 mkdir -p web/typo3temp/var/tests
 ./bin/chromedriver --url-base=/wd/hub >/dev/null 2>&1 &
 php -S 0.0.0.0:8000 >/dev/null 2>&1 &
 sleep 3;
 typo3DatabaseName='typo3' typo3DatabaseHost='DB' typo3DatabaseUsername='root' typo3DatabasePassword='my-secret-pw' vendor/codeception/codeception/codecept run Acceptance -c web/typo3conf/ext/cag_tests/Tests/Build/AcceptanceTests.yml

```
This image needs an external MySQL server or linked MySQL container. To create a MySQL container:

    docker run -d -e MYSQL_ROOT_PASSWORD="my-secret-pw" --name db -p 3306:3306 webtp3/tp3sql

To run TYPO3 by linking to the database created above:

    docker run -d --rm -it -v $PWD:/build --link db:db -e DB_PASS="my-secret-pw" -p 80:80 --name typo3 webtp3/docker:16.4-stable


Finally, activate the core extension set:

```bash
$ TYPO3_CONTEXT='Development' php 'vendor/bin/typo3cms' 'extension:setupactive'
```

### Basic Template Extension / Frontend Build Toolchain ###

To get the **frontend toolchain** (see `package.json`, `build/frontend`)
running, please also get `EXT:tmpl` from CAG's bitbucket repo, where all resources
usually are stored (scss, js sources, fonts, icons, etc.).

Then, npm install should do most of the job to get set up initially:

```bash
$ npm install
```

https://bitbucket.org/web-tp3/docker