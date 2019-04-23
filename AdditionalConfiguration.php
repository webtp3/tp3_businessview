<?php

// We let the loader load context and environment specific configuration from .env
$configLoader = \Tp3\Tp3mods\Utility\ConfigLoaderFactory::buildLoader(
    $context = \TYPO3\CMS\Core\Utility\GeneralUtility::getApplicationContext()->isProduction() ? 'production' : 'development',
    $rootDir = dirname(dirname(__DIR__)),
    $fixedCacheIdentifier = getenv('CONFIGURATION_CACHE_IDENTIFIER')
);
$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive(
    $GLOBALS['TYPO3_CONF_VARS'],
    $configLoader->load()
);

/**
 * CAG: additionally, we use the classic CAG conf.d approach
 *
 * To enable your local configuration just
 * add one or more files in conf.d.
 * They will be loaded automatically.
 */
$configurationFiles = \TYPO3\CMS\Core\Utility\GeneralUtility::getFilesInDir(
    \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('typo3conf/conf.d/'),
    'php',
    true
);
foreach ($configurationFiles as $file) {
    require_once($file);
}
