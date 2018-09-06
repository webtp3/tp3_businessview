# rp dev


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
/usr/bin/php7.1 vendor/phpunit/phpunit/phpunit  --configuration vendor/typo3/testing-framework/Resources/Core/Build/UnitTests.xml  --teamcity --log-junit UnitTests.log
/usr/bin/php7.2 vendor/phpunit/phpunit/phpunit  --configuration vendor/typo3/testing-framework/Resources/Core/Build/UnitTests.xml  --teamcity --log-junit UnitTests.log
 php vendor/phpunit/phpunit/phpunit --configuration web/typo3conf/ext/cag_tests/Resources/Ext/Build/UnitTestsDeprecated.xml  --teamcity --log-junit  UnitTestsDeprecated.log 
 php vendor/phpunit/phpunit/phpunit --configuration web/typo3conf/ext/cag_tests/Resources/Ext/Build/FunctionalTests.xml  --teamcity --log-junit  FunctionalTests.log
 mkdir -p web/typo3temp/var/tests
 java -jar vendor/se/selenium-server-standalone/bin/selenium-server-standalone.jar -host 0.0.0.0
 bin/chromedriver --url-base=/wd/hub >/dev/null 2>&1 &
 php -S 0.0.0.0:8000 >/dev/null 2>&1 &
 sleep 3;
 typo3DatabaseName='typo3' typo3DatabaseHost='db' typo3DatabaseUsername='root' typo3DatabasePassword='my-secret-pw' vendor/codeception/codeception/codecept run Acceptance -c web/typo3conf/ext/cag_tests/Resources/Ext/Build/AcceptanceTests.yml

```

#####cleanup after broken tests

    TRUNCATE `be_groups`;
    TRUNCATE `be_sessions`;
    TRUNCATE `be_users`;
    TRUNCATE `sys_category`;
    TRUNCATE TABLE `tx_extensionmanager_domain_model_extension`


## finally
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
    
    
    set typo3DatabaseName=typo3tester55  
    set typo3DatabaseHost=192.168.178.250
    set typo3DatabaseUsername=tester
    set typo3DatabasePassword=XrILG1MwrFrCKa2dpWuE
    ./bin/codecept run Acceptance -c vendor/typo3/testing-framework/Resources/Core/Build/AcceptanceTests.yml Backend/Extensionmanager:checkIfUploadFormAppears


