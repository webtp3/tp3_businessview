# tp3_tests

This is an distribution installer for typo3 dev environment with unit, functional and acceptance  testing and developer tools
It carries privat packages with it. Without needing access to any privat connections.  

```bash
git clone git@bitbucket.org:thomasruta/tp3_tests.git mynewproject_www
cd mynewproject_www
rm -rf .git 
git init
```
## How do I get set up? ###

Make sure, your PHP (Web & CLI) is 7.x and that you have `composer`
installed in your (local) environment. 

or you can use docker  


### Install Setup ###

Install TYPO3 and all composer based extensions / components and local private packages:

Edit your settings of the automated install in the config/install.settings.yaml
```yaml
databaseConnect:
    type: install
    description: 'Set up database connection'
    arguments:
        databaseUserName:
            description: 'User name for database server'
            option: '--database-user-name'
            type: string
            value: tester
            default: 'root'

        databaseUserPassword:
            description: 'User password for database server'
            option: '--database-user-password'
            type: hidden
            value: XrILG1MwrFrCKa2dpWuE
            default: ''

        databaseHostName:
            description: 'Host name of database server'
            option: '--database-host-name'
            type: string
            value: 192.168.178.250
            default: '127.0.0.1'

        databasePort:
            description: 'TCP Port of database server'
            option: '--database-port'
            type: int
            value: 3306
            default: 3306

        databaseSocket:
            description: 'Unix Socket to connect to'
            option: '--database-socket'
            type: string
            value: /run/mysqld/mysqld.sock
            default: '/run/mysqld/mysqld.sock'

databaseSelect:
    type: install
    description: 'Select database'
    arguments:
        useExistingDatabase:
            description: 'Use already existing database?'
            option: '--use-existing-database'
            type: bool
            value: false
            default: false

        databaseName:
            description: 'Name of the database'
            option: '--database-name'
            type: string
            value: typo3tester5

databaseData:
    type: install
    description: 'Set up database'
    arguments:
        adminUserName:
            description: 'Username of to be created administrative user account'
            option: '--admin-user-name'
            type: string
            value: tp3min

        adminPassword:
            description: 'Password of to be created administrative user account'
            option: '--admin-password'
            type: hidden
            value: Init1111

        siteName:
            description: 'Name of the TYPO3 site'
            option: '--site-name'
            type: string
            default: 'tp3 TYPO3 testing Suite'
            value: 'tp3 TYPO3 testing Suite'
```

### Docker Setup ###
webtp3/docker
TYPO3 docker testing image - This image is part of an automated testing enviroment. Webservice can be linked to MySQL. More about the automated testing https://bitbucket.org/web-tp3/tp3_installer


Usage (standalone)

This image needs an external MySQL server or linked MySQL container. To create a MySQL container:

    docker run -d -e MYSQL_ROOT_PASSWORD="my-secret-pw" --name db -p 3306:3306 webtp3/tp3sql
    
To run TYPO3 by linking to the database created above:


after you need to transfer the Code into the container - this is happening within the build
        
         # start typo3 install from env
         # setup config/install.settings.yaml
         # match conig for env in Dockerfile
                  
          docker build -t yourtest . 
         
          docker run -d  --rm -it -v $PWD:/build --link db:db -e DB_PASS="my-secret-pw" -p 80:80  -p 2222:22 -p 443:443 -p 9000:9000   --name typo3 yourtest
          # to stop the docker service use
          # docker stop typo3
          # docker stop db
          # to remove the container
          # docker rm typo3
          # docker rm db
          
          # start composer install
           docker exec typo3 composer config  repositories.local path 'Packages/*' -d  /var/www/html/
           docker exec typo3 composer --no-scripts --dev install -d  /var/www/html/

          #automated install will fail! thats because the /var/run/mysql.sock is not available 
          #-> run-typo3.sh will fix that by linking the mysql container 
          docker exec typo3 bash /var/www/cgi-bin/run-typo3.sh

          # start testing
          docker exec typo3 ln -s  ../vendor /var/www/html/web/vendor 
          docker exec typo3 php /var/www/html/vendor/phpunit/phpunit/phpunit --configuration /var/www/html/web/typo3conf/ext/cag_tests/Tests/Build/UnitTests.xml --teamcity --log-junit UnitTests.log
          docker exec typo3 php /var/www/html/vendor/phpunit/phpunit/phpunit --configuration /var/www/html/web/typo3conf/ext/cag_tests/Tests/Build/UnitTestsDeprecated.xml --teamcity --log-junit UnitTestsDeprecated.log
          docker exec typo3 php /var/www/html/vendor/phpunit/phpunit/phpunit --configuration /var/www/html/web/typo3conf/ext/cag_tests/Tests/Build/FunctionalTests.xml --teamcity --log-junit FunctionalTests.log
          docker exec typo3 mkdir -p /var/www/html/web/typo3temp/var/tests
          docker exec typo3 /var/www/html/vendor/bin/chromedriver --url-base=/wd/hub >/dev/null 2>&1 &
          docker exec typo3 php -S 0.0.0.0:8000 >/dev/null 2>&1 &
          docker exec typo3 sleep 3;
          docker exec typo3 typo3DatabaseName='typo3' typo3DatabaseHost='db' typo3DatabaseUsername='root' typo3DatabasePassword='my-secret-pw' vendor/codeception/codeception/codecept run Acceptance -c web/typo3conf/ext/cag_tests/Tests/Build/AcceptanceTests.yml
          
          docker stop typo3
          docker stop db


or in combined usage 

    docker-compose -f docker-compose.yml up
    # with compose the name of the container is generated - migfht be something like tp3tests_typo3_1
    
or use a bitbucket Pipline for testing :-)
look at bitbucket-pipelines.yml

After the installation you use 

    docker exec typo3 rsync -urv --progress  -e ssh user@local:/yourdevpath/ /var/www/html/

to save time

###Local Setup

####prerequisites
php 7.x with the extensions:

    "ext-soap": "*",
    "ext-gd": "*",
    "ext-fileinfo": "*",
    "ext-zlib": "*",
    "ext-openssl": "*",
    "ext-zip": "*",
    "ext-mysqli": "*",
and webserver apache/nginx and a database Mysql/MariaDB.

#### install & dbinit

```bash
 composer config repositories.local path 'Packages/*'
 #(if you want to install interactive)
 composer req typo3-console/composer-typo3-auto-install 
 #(else just install)
 composer --dev  install
```


using the typo3-console/composer-typo3-auto-install will take the configuration from the folder config an promt if you take the settings from install-interaction.settings.yaml for database and Admin User settings.
you can use cli to install typo3 or the interactive process or run it via cli

    php vendor/helhum/typo3-console/typo3cms install:setup


After the installation is finished you can start Testing

```bash
# add an alias to the vendor dir & if you installed from .yaml set the .env vars 
ln -s  ../vendor web/vendor
  # start testing
 php vendor/phpunit/phpunit/phpunit  --configuration web/typo3conf/ext/cag_tests/Tests/Build/UnitTests.xml  --teamcity --log-junit UnitTests.log 
 php vendor/phpunit/phpunit/phpunit --configuration web/typo3conf/ext/cag_tests/Tests/Build/UnitTestsDeprecated.xml  --teamcity --log-junit  UnitTestsDeprecated.log 
 php vendor/phpunit/phpunit/phpunit --configuration web/typo3conf/ext/cag_tests/Tests/Build/FunctionalTests.xml  --teamcity --log-junit  FunctionalTests.log
 mkdir -p web/typo3temp/var/tests
 ./bin/chromedriver --url-base=/wd/hub >/dev/null 2>&1 &
 php -S 0.0.0.0:8000 >/dev/null 2>&1 &
 sleep 3;
 typo3DatabaseName='typo3' typo3DatabaseHost='db' typo3DatabaseUsername='root' typo3DatabasePassword='my-secret-pw' vendor/codeception/codeception/codecept run Acceptance -c web/typo3conf/ext/cag_tests/Tests/Build/AcceptanceTests.yml

```


## finaly
is should look like after the install has finished
   
    Writing lock file
    Generating autoload files
    Registered helhum/dotenv-connector
    Setting up TYPO3 Core Extension directories
    
    Setting up TYPO3
    ✔ Prepare installation
    ✔ Check environment and create folders
    ✔ Set up database connection
    ✔ Select database
    ✔ Set up database
    ✔ Set up configuration
    ✔ Set up extensions
    ➤ Set up project settings
    ✔
    Your TYPO3 installation is now ready to use.
    
    Run vendor/bin/typo3cms server:run in your project root directory, to start the PHP builtin web server.
    Generating  class alias map file
    Inserting class alias loader into main autoload.php file


the test results should look like
    
    --
    
    There was 1 failure:
    
    1) TYPO3\CMS\Backend\Tests\Unit\Configuration\TypoScript\ConditionMatching\ConditionMatcherTest::matchCallsTestConditionAndHandsOverParameters
    Failed asserting that exception of type "TYPO3\CMS\Backend\Tests\Unit\Configuration\TypoScript\ConditionMatching\Fixtures\TestConditionException" is thrown.
    
    /var/www/clients/client1/web3/web/tp3_tests/vendor/phpunit/phpunit/phpunit:53
    
    --
    
    There were 2 risky tests:
    
    1) TYPO3\CMS\Backend\Tests\Unit\Form\NodeFactoryTest::constructorThrowsNoExceptionIfResolverWithSamePriorityButDifferentNodeNameAreRegistered
    This test did not perform any assertions
    
    /var/www/clients/client1/web3/web/tp3_tests/vendor/phpunit/phpunit/phpunit:53
    
    2) TYPO3\CMS\Backend\Tests\Unit\Utility\BackendUtilityTest::getTCAtypesReturnsCorrectValuesDataProvider
    This test did not perform any assertions
    
    /var/www/clients/client1/web3/web/tp3_tests/vendor/phpunit/phpunit/phpunit:53
    
    ERRORS!
    Tests: 946, Assertions: 1586, Errors: 53, Failures: 1, Skipped: 1, Incomplete: 1, Risky: 2.
## Who do I talk to? ###
* Jochen Rieger
* Matthias Krams
* Andreas Buecking
* Thomas Ruta

Connecta AG
+49 611 3 41 09 0

https://bitbucket.org/web-tp3/docker
https://bitbucket.org/web-tp3/cag_tests

