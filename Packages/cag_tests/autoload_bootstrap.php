<?php
if (!getenv('TYPO3_PATH_COMPOSER_ROOT')) {
    putenv('TYPO3_PATH_COMPOSER_ROOT=' . '{$base-dir}');
    $_ENV['TYPO3_PATH_COMPOSER_ROOT'] = '{$base-dir}';
}
if (!getenv('TYPO3_PATH_APP')) {
    putenv('TYPO3_PATH_APP=' . '{$app-dir}');
    $_ENV['TYPO3_PATH_APP'] = '{$app-dir}';
}
if (!getenv('TYPO3_PATH_ROOT')) {
    putenv('TYPO3_PATH_ROOT=' . '{$root-dir}');
    $_ENV['TYPO3_PATH_ROOT'] = '{$root-dir}';
}
if (!getenv('TYPO3_PATH_WEB')) {
    putenv('TYPO3_PATH_WEB=' . '{$web-dir}');
    $_ENV['TYPO3_PATH_WEB'] = '{$web-dir}';
}
if (!getenv('CAG_TESTS')) {
    putenv('CAG_TESTS=' . dirname(dirname(__DIR__)).'web/typo3conf/cag_tests/');
    $_ENV['CAG_TESTS'] = dirname(dirname(__DIR__)).'web/typo3conf/cag_tests/';
}
// '{$composer-mode}'