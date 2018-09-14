<?php

// include composer's autoload file to make .env available in $_ENV
require __DIR__ . '/private/Build/vendor/autoload.php';

# output some basic info about host - needs to be set in .env file
echo 'HOST_TITLE: ' . $_ENV['HOST_TITLE']; 
echo "\n";
echo 'DB_HOST: ' . $_ENV['TYPO3__DB__Connections__Default__host'];
echo 'DB_NAME: ' . $_ENV['TYPO3__DB__Connections__Default__dbname'];
echo 'DB_USER: ' . $_ENV['TYPO3__DB__Connections__Default__user'];
echo 'DB_PASS: ' . $_ENV['TYPO3__DB__Connections__Default__password'];