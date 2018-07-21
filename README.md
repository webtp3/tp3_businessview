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

### Docker Setup ###
webtp3/docker
TYPO3 docker testing image - This image is part of an automated testing enviroment. Webservice can be linked to MySQL. More about the automated testing https://bitbucket.org/web-tp3/tp3_installer


Usage (standalone)

This image needs an external MySQL server or linked MySQL container. To create a MySQL container:

    docker run -d -e MYSQL_ROOT_PASSWORD="my-secret-pw" --name db -p 3306:3306 webtp3/tp3sql
    
To run TYPO3 by linking to the database created above:


after you need to transfer the Code into the container - this is happening within the build
        
          docker build -t yourtest . 
          docker run -d  --rm -it -v $PWD:/build --link db:db -e DB_PASS="my-secret-pw" -p 80:80  -p 2222:22 -p 443:443 -p 9000:9000   --name typo3 yourtest


          # start composer install
           docker exec typo3 composer config  repositories.local path 'Packages/*' -d  /var/www/html/web/
          docker exec typo3 composer --dev install -d  /var/www/html/

          # start typo3 install from env
          docker exec typo3 bash /var/www/cgi-bin/run-typo3.sh
          # start testing
          docker exec typo3 php vendor/phpunit/phpunit/phpunit --configuration web/typo3conf/ext/cag_tests/Tests/Build/UnitTests.xml --teamcity --log-junit 
          docker exec typo3 php vendor/phpunit/phpunit/phpunit --configuration web/typo3conf/ext/cag_tests/Tests/Build/UnitTestsDeprecated.xml --teamcity --log-junit 
          docker exec typo3 php vendor/phpunit/phpunit/phpunit --configuration web/typo3conf/ext/cag_tests/Tests/Build/FunctionalTests.xml --teamcity --log-junit 
          docker exec typo3 mkdir -p web/typo3temp/var/tests
          docker exec typo3 vendor/bin/chromedriver --url-base=/wd/hub >/dev/null 2>&1 &
          docker exec typo3 php -S 0.0.0.0:8000 >/dev/null 2>&1 &
          docker exec typo3 sleep 3;
          docker exec typo3 typo3DatabaseName='typo3' typo3DatabaseHost='DB' typo3DatabaseUsername='root' typo3DatabasePassword='my-secret-pw' vendor/codeception/codeception/codecept run Acceptance -c web/typo3conf/ext/cag_tests/Tests/Build/AcceptanceTests.yml
          
          docker stop typo3
          docker stop db


or in combined usage 

    docker-compose -f docker-compose.yml up
    
or use a bitbucket Pipline for testing :-)
look at bitbucket-pipelines.yml

After the installation you use 

    docker exec typo3 rsync -urv --progress  -e ssh user@local:/yourdevpath/ /var/www/html/

to save time


### Local Setup ###

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

## install & db init###

```bash
 composer config repositories.local path 'Packages/*'
 #(if you want to install interactive)
 composer req typo3-console/composer-typo3-auto-install 
 #(else just install)
 composer --dev  install
```




using the typo3-console/composer-typo3-auto-install will take the configuration from the folder config an promt for database and Admin User settings.
you can use cli to install typo3 or the interactive process or run it via cli

####composer-typo3-auto-install

    ➤ Set up database connection
    User name for database server (default: ""): root
    User password for database server (default: ""):
    Host name of database server (default: "127.0.0.1"):
    TCP Port of database server (default: "3306"):
    Unix Socket to connect to (default: ""): /var/run/mysqld/mysqld.sock
####cli

    php vendor/helhum/typo3-console/typo3cms install:setup --no-interaction \
                --database-user-name="tester" \
                --database-host-name="192.168.178.250" \
                --database-port="3306" \
                --database-name="tester99" \
                --database-user-password="XrILG1MwrFrCKa2dpWuE" \
                --database-create=1 \
                --admin-user-name="tp3min" \
                --admin-password="Init1111" \
                --site-name="TYPO3 Testing Suite";


After the installation is finished you can start Testing

```bash
  # start testing
 php vendor/phpunit/phpunit/phpunit  --configuration web/typo3conf/ext/cag_tests/Tests/Build/UnitTests.xml --log-junit  --teamcity
 php vendor/phpunit/phpunit/phpunit --configuration web/typo3conf/ext/cag_tests/Tests/Build/UnitTestsDeprecated.xml --log-junit   --teamcity
 php vendor/phpunit/phpunit/phpunit --configuration web/typo3conf/ext/cag_tests/Tests/Build/FunctionalTests.xml --log-junit   --teamcity
 mkdir -p web/typo3temp/var/tests
 ./bin/chromedriver --url-base=/wd/hub >/dev/null 2>&1 &
 php -S 0.0.0.0:8000 >/dev/null 2>&1 &
 sleep 3;
 typo3DatabaseName='typo3' typo3DatabaseHost='DB' typo3DatabaseUsername='root' typo3DatabasePassword='my-secret-pw' vendor/codeception/codeception/codecept run Acceptance -c web/typo3conf/ext/cag_tests/Tests/Build/AcceptanceTests.yml

```
more about the docker containers used

https://bitbucket.org/web-tp3/docker

https://hub.docker.com/r/webtp3/docker/tags/

there is one with typo3 installed already webtp3/docker:8-latest or webtp3/docker:18.4-stable with php 7.2 based on ubuntu 18.4