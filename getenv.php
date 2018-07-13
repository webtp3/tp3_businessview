<?php

// include composer's autoload file to make .env available in $_ENV
require __DIR__ . '/../vendor/autoload.php';

# output some basic info about host - needs to be set in .env file
echo 'HOST_TITLE: ' . $_ENV['HOST_TITLE']; 
echo "\n";
echo 'CONTEXT: ' . $_ENV['TYPO3_CONTEXT'];

