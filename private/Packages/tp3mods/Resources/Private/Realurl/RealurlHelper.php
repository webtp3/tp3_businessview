<?php


$TYPO3_CONF_VARS['EXTCONF']['realurl']['_DEFAULT']['enableDomainLookup'] = 1;

$TYPO3_CONF_VARS['EXTCONF']['realurl']['_DEFAULT'] = array(
    'init' => array(
        'enableCHashCache' => 1,
        'enableUrlDecodeCache' => 1,
        'enableUrlEncodeCache' => 1,
        'disableErrorLog'=> 1,
        'appendMissingSlash' => 'ifNotFile,redirect[301]',
        'respectSimulateStaticURLs' => 1,
        'postVarSet_failureMode'=>'redirect_goodUpperDir',
    ),
    'redirects_regex' => array (

    ),

    // *** pre vars
    'preVars' => array(

        // *** language
        array(
            'GETvar' => 'L',
            'valueMap' => array(
                'de' => '1',
                'da' => '2',
                'en' => '3',
                'es' => '4',
                'ru' => '5',
                'cz' => '6',
            ),
            'noMatch' => 'bypass',
        ),

        // *** no cache
        array(
            'GETvar' => 'no_cache',
            'valueMap' => array(
                'no_cache' => 1,
            ),
            'noMatch' => 'bypass',
        ),

    ),

    // *** page path
    'pagePath' => array(
        'type' => 'user',
        'userFunc' => 'Tx\Realurl\UriGeneratorAndResolver->main',
        'spaceCharacter' => '-',
        'languageGetVar' => 'L',
        'expireDays' => '7',
        'rootpage_id' => 1,
    ),

    // *** fixed post vars

    'fixedPostVars' => array(

    ),

    'postVarSets' => array(
        '_DEFAULT' => array(

            // EXT:news start
            'news' => array(
                array(
                    'GETvar' => 'tx_news_pi1[action]',
                ),
                array(
                    'GETvar' => 'tx_news_pi1[controller]',
                ),
                array(
                    'GETvar' => 'tx_news_pi1[news]',
                    'lookUpTable' => array(
                        'table' => 'tx_news_domain_model_news',
                        'id_field' => 'uid',
                        'alias_field' => 'title',
                        'addWhereClause' => ' AND NOT deleted',
                        'useUniqueCache' => 1,
                        'useUniqueCache_conf' => array(
                            'strtolower' => 1,
                            'spaceCharacter' => '-',
                        ),
                        'languageGetVar' => 'L',
                        'languageExceptionUids' => '',
                        'languageField' => 'sys_language_uid',
                        'transOrigPointerField' => 'l10n_parent',
                        'autoUpdate' => 1,
                        'expireDays' => 180,
                    ),
                ),

                'controller' => array(
                    array(
                        'GETvar' => 'tx_news_pi1[action]',
                        'noMatch' => 'bypass'
                    ),
                    array(
                        'GETvar' => 'tx_news_pi1[controller]',
                        'noMatch' => 'bypass'
                    )
                ),

                'dateFilter' => array(
                    array(
                        'GETvar' => 'tx_news_pi1[overwriteDemand][year]',
                    ),
                    array(
                        'GETvar' => 'tx_news_pi1[overwriteDemand][month]',
                    ),
                ),
                'page' => array(
                    array(
                        'GETvar' => 'tx_news_pi1[@widget_0][currentPage]',
                    ),
                ),
            ),
            // EXT:news end
            'erweitert' => array(
                array(
                    'GETvar' => 'tx_indexedsearch[ext]',
                ),
            ),
            'user' => array (
                array(
                    'GETvar' => 'tx_srfeuserregister_pi1[regHash]',
                ),
            ),
            'register' => array(
                'type' => 'single',
                'keyValues' => array(
                    'tx_srfeuserregister_pi1[cmd]=edit' => 1,
                ),
            ),
            'register_edit' => array(
                'type' => 'single',
                'keyValues' => array(
                    'tx_srfeuserregister_pi1[cmd]=create' => 1,
                ),
            ),
            'portal_users' => array(
                'type' => 'single',
                'keyValues' => array(
                    'tx_srfeuserregister_pi1[token]' => 1,
                ),
            ),
        ),
    ),
    // configure filenames for different pagetypes
    'fileName' => array(
        //'defaultToHTMLsuffixOnPrev' => 1,
        'acceptHTMLsuffix' => 1,
        'index' => array(

            'vcard.vcf' => array(
                'keyValues' => array(
                    'type' => 731,
                ),
            ),
            'export.xml' => array(
                'keyValues' => array(
                    'type' => 334,
                ),
            ),
            'dialog.html' => array(
                'keyValues' => array(
                    'type' => 1000,
                ),
            ),
            'print.html' => array(
                'keyValues' => array(
                    'type' => 98,
                ),
            ),
            'calendarRSS.xml' => array(
                'keyValues' => array(
                    'type' => 151,
                ),
            ),
            'calendar.ics' => array(
                'keyValues' => array(
                    'type' => 150,
                ),
            ),
            'popup.html' => array(
                'keyValues' => array(
                    'type' => 1000,
                ),
            ),
            'news.xml' => array(
                'keyValues' => array(
                    'type' => 9818,
                ),
            ),
            'sitemap.xml' => array(
                'keyValues' => array(
                    'type' => 776,
                ),
            ),

            'jq.js' => array(
                'keyValues' => array(
                    'type' => 7076,
                    'ajax' => 1,

                ),
            ),
            'rss091.xml' => array(
                'keyValues' => array(
                    'type' => 101,
                ),
            ),
            'rdf.xml' => array(
                'keyValues' => array(
                    'type' => 102,
                ),
            ),
            'atom.xml' => array(
                'keyValues' => array(
                    'type' => 103,
                ),
            ),
            'seo.html' => array(
                'keyValues' => array(
                    'type' => 1480321830,
                ),
            ),
        ),
    ),
);
?>