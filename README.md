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
tp3/docker
TYPO3 docker testing image - This image is part of an automated testing enviroment. Webservice can be linked to MySQL. More about the automated testing https://bitbucket.org/web-tp3/tp3_installer


Usage (standalone)

This image needs an external MySQL server or linked MySQL container. To create a MySQL container:

    docker run -d -e MYSQL_ROOT_PASSWORD="my-secret-pw" --name db -p 3306:3306 webtp3/tp3sql
    
To run TYPO3 by linking to the database created above:



after you need to transfer the Code into the container

          docker -t yourtest build .
          docker run -d -e MYSQL_ROOT_PASSWORD="my-secret-pw" --name db -p 3306:3306 webtp3/tp3sql
          docker run -d  --rm -it -v $PWD:/build --link db:db -e DB_PASS="my-secret-pw" -p 80:80 --name typo3 yourtest


          # start composer install
           docker exec typo3 composer config  repositories.local path 'Packages/*' -d  /var/www/html/web/tmp/
          docker exec typo3 composer --dev install -d  /var/www/html/

          # start typo3 install from env
          docker exec typo3 bash /var/www/cgi-bin/run-typo3.sh
          # start testing
          docker exec typo3 php vendor/phpunit/phpunit/phpunit --configuration web/typo3conf/ext/cag_tests/Tests/Build/UnitTests.xml --teamcity
          docker exec typo3 php vendor/phpunit/phpunit/phpunit --configuration web/typo3conf/ext/cag_tests/Tests/Build/UnitTestsDeprecated.xml --teamcity
          docker exec typo3 php vendor/phpunit/phpunit/phpunit --configuration web/typo3conf/ext/cag_tests/Tests/Build/FunctionalTests.xml --teamcity
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


### Local Setup ###

Install TYPO3 and all composer based extensions / components and local private packages:

```bash
 composer config repositories.local path 'Packages/*'
 #(if you want to install interactive)
 composer req typo3-console/composer-typo3-auto-install 
 #(else just install)
 composer --dev  install
```


#### install starts ###

using the typo3-console/composer-typo3-auto-install will take the configuration from the folder config an promt for database and Admin User settings.
you can use cli to install typo3 or the interactive process or run it via cli



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
more about the docker containers used

https://bitbucket.org/web-tp3/docker

https://hub.docker.com/r/webtp3/docker/tags/

there is one with typo3 installed already webtp3/docker:8-latest or webtp3/docker:18.4-stable with php 7.2 based on ubuntu 18.4