<?php

/*
 * This file is part of the web-tp3/tp3mods.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

$TYPO3_CONF_VARS['EXTCONF']['realurl']['_DEFAULT']['enableDomainLookup'] = 1;

$TYPO3_CONF_VARS['EXTCONF']['realurl']['_DEFAULT'] = [
    'init' => [
        'enableCHashCache' => 1,
        'enableUrlDecodeCache' => 1,
        'enableUrlEncodeCache' => 1,
        'disableErrorLog'=> 1,
        'appendMissingSlash' => 'ifNotFile,redirect[301]',
        'respectSimulateStaticURLs' => 1,
        'postVarSet_failureMode'=>'redirect_goodUpperDir',
    ],
    'redirects_regex' => [

    ],

    // *** pre vars
    'preVars' => [

        // *** language
        [
            'GETvar' => 'L',
            'valueMap' => [
                'de' => '1',
                'nl' => '2',
                'en' => '3',
                'es' => '4',
                'ru' => '5',
                'cz' => '6',
            ],
            'noMatch' => 'bypass',
        ],

        // *** no cache
        [
            'GETvar' => 'no_cache',
            'valueMap' => [
                'no_cache' => 1,
            ],
            'noMatch' => 'bypass',
        ],

    ],

    // *** page path
    'pagePath' => [
        'type' => 'user',
        'userFunc' => 'Tx\Realurl\UriGeneratorAndResolver->main',
        'spaceCharacter' => '-',
        'languageGetVar' => 'L',
        'expireDays' => '7',
        'rootpage_id' => 1,
    ],

    // *** fixed post vars

    'fixedPostVars' => [
//        'calendarDetailConfiguration' => [
//            [
//                'GETvar' => 'tx_cal_controller[action]',
//                'valueMap' => [
//                    '' => 'detail',
//                ],
//                'noMatch' => 'bypass'
//            ],
//            [
//                'GETvar' => 'tx_cal_controller[controller]',
//                'valueMap' => [
//                    '' => 'detail',
//                ],
//                'noMatch' => 'bypass'
//            ],
//            [
//                'GETvar' => 'tx_cal_controller[uid]',
//                'lookUpTable' => [
//                    'table' => 'tx_cal_event',
//                    'id_field' => 'uid',
//                    'alias_field' => "CONCAT(uid, '-', IF(path_segment!='',path_segment,title))",
//                    'addWhereClause' => ' AND NOT deleted',
//                    'useUniqueCache' => 1,
//                    'languageGetVar' => 'L',
//                    'languageExceptionUids' => '',
//                    'languageField' => 'sys_language_uid',
//                    'transOrigPointerField' => 'l10n_parent',
//                    'expireDays' => 180,
//                    'enable404forInvalidAlias' => true
//                ]
//            ]
//        ],
//        '781' => 'calendarDetailConfiguration',
        //end cal

        // start news
        'newsDetailConfiguration' => [
            [
                'GETvar' => 'tx_news_pi1[action]',
                'valueMap' => [
                    '' => 'detail',
                ],
                'noMatch' => 'bypass'
            ],
            [
                'GETvar' => 'tx_news_pi1[controller]',
                'valueMap' => [
                    '' => 'detail',
                ],
                'noMatch' => 'bypass'
            ],
            [
                'GETvar' => 'tx_news_pi1[news]',
                'lookUpTable' => [
                    'table' => 'tx_news_domain_model_news',
                    'id_field' => 'uid',
                    'alias_field' => "CONCAT(uid, '-', IF(path_segment!='',path_segment,title))",
                    'addWhereClause' => ' AND NOT deleted',
                    'useUniqueCache' => 1,
                    'languageGetVar' => 'L',
                    'languageExceptionUids' => '',
                    'languageField' => 'sys_language_uid',
                    'transOrigPointerField' => 'l10n_parent',
                    'expireDays' => 180,
                    'enable404forInvalidAlias' => true
                ]
            ]
        ],
        'newsCategoryConfiguration' => [
            [
                'GETvar' => 'tx_news_pi1[overwriteDemand][categories]',
                'lookUpTable' => [
                    'table' => 'sys_category',
                    'id_field' => 'uid',
                    'alias_field' => 'title',
                    'addWhereClause' => ' AND NOT deleted',
                    'useUniqueCache' => 1,
                    'enable404forInvalidAlias' => true
                ]
            ]
        ],
        'newsTagConfiguration' => [
            [
                'GETvar' => 'tx_news_pi1[overwriteDemand][tags]',
                'lookUpTable' => [
                    'table' => 'tx_news_domain_model_tag',
                    'id_field' => 'uid',
                    'alias_field' => 'title',
                    'addWhereClause' => ' AND NOT deleted',
                    'useUniqueCache' => 1,
                    'enable404forInvalidAlias' => true
                ]
            ]
        ],
        '792' => 'newsDetailConfiguration',
//        '32' => 'newsDetailConfiguration',
//        '59' => 'newsDetailConfiguration',
//        '36' => 'newsDetailConfiguration',
        //news end

    ],

    'postVarSets' => [
        '_DEFAULT' => [
            // EXT:news start
            'controller' => [
                [
                    'GETvar' => 'tx_news_pi1[action]',
                    'noMatch' => 'bypass'
                ],
                [
                    'GETvar' => 'tx_news_pi1[controller]',
                    'noMatch' => 'bypass'
                ]
            ],

            'dateFilter' => [
                [
                    'GETvar' => 'tx_news_pi1[overwriteDemand][year]',
                ],
                [
                    'GETvar' => 'tx_news_pi1[overwriteDemand][month]',
                ],
            ],
            'page' => [
                [
                    'GETvar' => 'tx_news_pi1[@widget_0][currentPage]',
                ],
            ],

            // EXT:news end
            // cal start
            'calendar' => [
                0 => [
                    'GETvar' => 'tx_cal_controller[year]',
                    'valueMap' => [
                        2000 => '2000',
                        2001 => '2001',
                        2002 => '2002',
                        2003 => '2003',
                        2004 => '2004',
                        2005 => '2005',
                        2006 => '2006',
                        2007 => '2007',
                        2008 => '2008',
                        2009 => '2009',
                        2010 => '2010',
                        2011 => '2011',
                        2012 => '2012',
                        2013 => '2013',
                        2014 => '2014',
                        2015 => '2015',
                        2016 => '2016',
                        2017 => '2017',
                        2018 => '2018',
                        2019 => '2019',
                        2020 => '2020',
                        2021 => '2021',
                        2022 => '2022',
                        2023 => '2023',
                        2024 => '2024',
                    ],
                    'noMatch' => 'bypass',
                ],
                1 => [
                    'GETvar' => 'tx_cal_controller[month]',
                    'valueMap' => [
                        '01' => '01',
                        '02' => '02',
                        '03' => '03',
                        '04' => '04',
                        '05' => '05',
                        '06' => '06',
                        '07' => '07',
                        '08' => '08',
                        '09' => '09',
                        '10' => '10',
                        '11' => '11',
                        '12' => '12',
                    ],
                    'noMatch' => 'bypass',
                ],
                2 => [
                    'GETvar' => 'tx_cal_controller[day]',
                    'valueMap' => [
                        '01' => '01',
                        '02' => '02',
                        '03' => '03',
                        '04' => '04',
                        '05' => '05',
                        '06' => '06',
                        '07' => '07',
                        '08' => '08',
                        '09' => '09',
                        10 => '10',
                        11 => '11',
                        12 => '12',
                        13 => '13',
                        14 => '14',
                        15 => '15',
                        16 => '16',
                        17 => '17',
                        18 => '18',
                        19 => '19',
                        20 => '20',
                        21 => '21',
                        22 => '22',
                        23 => '23',
                        24 => '24',
                        25 => '25',
                        26 => '26',
                        27 => '27',
                        28 => '28',
                        29 => '29',
                        30 => '30',
                        31 => '31',
                    ],
                    'noMatch' => 'bypass',
                ],
                3 => [
                    'GETvar' => 'tx_cal_controller[view]',
                    'valueMap' => [
                        'month' => 'month',
                        'year' => 'year',
                        'week' => 'week',
                        'day' => 'day',
                        'event' => 'event',
                        'list' => 'list',
                        'admin' => 'admin',
                        'search_event' => 'search_event',
                        'search_location' => 'search_location',
                        'search_organizer' => 'search_organizer',
                        'search_all' => 'search_all',
                        'create_event' => 'create_event',
                        'confirm_event' => 'confirm_event',
                        'save_event' => 'save_event',
                        'edit_event' => 'edit_event',
                        'delete_event' => 'delete_event',
                        'remove_event' => 'remove_event',
                        'save_exception_event' => 'save_exception_event',
                        'create_calendar' => 'create_calendar',
                        'confirm_calendar' => 'confirm_calendar',
                        'save_calendar' => 'save_calendar',
                        'edit_calendar' => 'edit_calendar',
                        'delete_calendar' => 'delete_calendar',
                        'remove_calendar' => 'remove_calendar',
                        'create_category' => 'create_category',
                        'confirm_category' => 'confirm_category',
                        'save_category' => 'save_category',
                        'edit_category' => 'edit_category',
                        'delete_category' => 'delete_category',
                        'remove_category' => 'remove_category',
                        'create_location' => 'create_location',
                        'confirm_location' => 'confirm_location',
                        'save_location' => 'save_location',
                        'edit_location' => 'edit_location',
                        'delete_location' => 'delete_location',
                        'remove_location' => 'remove_location',
                        'create_organizer' => 'create_organizer',
                        'confirm_organizer' => 'confirm_organizer',
                        'save_organizer' => 'save_organizer',
                        'edit_organizer' => 'edit_organizer',
                        'delete_organizer' => 'delete_organizer',
                        'remove_organizer' => 'remove_organizer',
                        'organizer' => 'organizer',
                        'location' => 'location',
                        'ics' => 'ics',
                        'icslist' => 'icslist',
                        'single_ics' => 'single_ics',
                        'subscription' => 'subscription',
                        'meeting' => 'meeting',
                        'translation' => 'translation',
                        'todo' => 'todo',
                        'ajax' => 'ajax',
                    ],
                    'noMatch' => 'bypass',
                ],
                4 => [
                    'GETvar' => 'tx_cal_controller[type]',
                    'valueMap' => [
                        'tx_cal_phpicalendar' => 'tx_cal_phpicalendar',
                        'tx_cal_organizer' => 'tx_cal_organizer',
                        'tx_cal_location' => 'tx_cal_location',
                        'tx_cal_calendar' => 'tx_cal_calendar',
                        'tx_cal_category' => 'tx_cal_category',
                        'sys_category' => 'sys_category',
                        'tx_cal_attendee' => 'tx_cal_attendee',
                        'tx_tt_address' => 'tx_tt_address',
                        'tx_feuser' => 'tx_feuser',
                        'tx_partner_main' => 'tx_feuser',
                        'tx_cal_ts_service' => 'tx_cal_ts_service',
                    ],
                    'noMatch' => 'bypass',
                ],
                5 => [
                    'cond' => [
                        'prevValueInList' => 'tx_cal_phpicalendar',
                    ],
                    'GETvar' => 'tx_cal_controller[uid]',
                    'lookUpTable' =>  [
                        'table' => 'tx_cal_event',
                        'id_field' => 'uid',
                        'alias_field' => 'title',
                        'addWhereClause' => ' AND NOT deleted',
                        'useUniqueCache' => 1,
                        'useUniqueCache_conf' => [
                            'strtolower' => 1,
                            'spaceCharacter' => '_',
                        ],
                    ],
                ],
                6 => [
                    'cond' => [
                        'prevValueInList' => 'tx_cal_organizer',
                    ],
                    'GETvar' => 'tx_cal_controller[uid]',
                    'lookUpTable' => [
                        'table' => 'tx_cal_organizer',
                        'id_field' => 'uid',
                        'alias_field' => 'name',
                        'addWhereClause' => ' AND NOT deleted',
                        'useUniqueCache' => 1,
                        'useUniqueCache_conf' => [
                            'strtolower' => 1,
                            'spaceCharacter' => '_',
                        ],
                    ],
                ],
                7 => [
                    'cond' => [
                        'prevValueInList' => 'tx_cal_location',
                    ],
                    'GETvar' => 'tx_cal_controller[uid]',
                    'lookUpTable' => [
                        'table' => 'tx_cal_location',
                        'id_field' => 'uid',
                        'alias_field' => 'name',
                        'addWhereClause' => ' AND NOT deleted',
                        'useUniqueCache' => 1,
                        'useUniqueCache_conf' => [
                            'strtolower' => 1,
                            'spaceCharacter' => '_',
                        ],
                    ],
                ],
            ],
            'export' => [
                0 => [
                    'GETvar' => 'tx_cal_controller[calendar]',
                    'lookUpTable' => [
                        'table' => 'tx_cal_calendar',
                        'id_field' => 'uid',
                        'alias_field' => 'title',
                        'addWhereClause' => ' AND NOT deleted',
                        'useUniqueCache' => 1,
                        'useUniqueCache_conf' => [
                            'strtolower' => 1,
                            'spaceCharacter' => '_',
                        ],
                    ],
                ],
            ],
            // cal end

            'erweitert' => [
                [
                    'GETvar' => 'tx_indexedsearch[ext]',
                ],
            ],
            'user' => [
                [
                    'GETvar' => 'tx_srfeuserregister_pi1[regHash]',
                ],
            ],
            'register' => [
                'type' => 'single',
                'keyValues' => [
                    'tx_srfeuserregister_pi1[cmd]=edit' => 1,
                ],
            ],
            'register_edit' => [
                'type' => 'single',
                'keyValues' => [
                    'tx_srfeuserregister_pi1[cmd]=create' => 1,
                ],
            ],
            'portal_users' => [
                'type' => 'single',
                'keyValues' => [
                    'tx_srfeuserregister_pi1[token]' => 1,
                ],
            ],
        ],
    ],

    'fileName' => [
        'defaultToHTMLsuffixOnPrev'=>1,
        'index' => [

            'rss.xml' => [
                'keyValues' => [
                    'type' => 100,
                ],
            ],
            'rss091.xml' => [
                'keyValues' => [
                    'type' => 101,
                ],
            ],
            'rdf.xml' => [
                'keyValues' => [
                    'type' => 102,
                ],
            ],
            'atom.xml' => [
                'keyValues' => [
                    'type' => 103,
                ],
            ],
            'vcard.vcf' => [
                'keyValues' => [
                    'type' => 2,
                ],
            ],
        ],
    ],

];
