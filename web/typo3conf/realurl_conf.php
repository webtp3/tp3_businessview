<?php

/**
 * RealURL alternate rootpage_id and multiple domain setup example
 *
 * multiple domain setup
 * 	Update domains
 * 	Update rootpage_id
 *	The root page id is the uid of your domain home in the TYPO3 page tree
 *
 * @author Michael Cannon <mc@acqal.com>
 * @version $Id: realurl-custom.php,v 1.6 2009/03/10 05:50:14 cannon Exp $
 */

$TYPO3_CONF_VARS['EXTCONF']['realurl']['_DEFAULT'] = array(
    'init' => array(
        'enableCHashCache' => 1,
        'appendMissingSlash' => 'ifNotFile',
        'enableUrlDecodeCache' => 1,
        'enableUrlEncodeCache' => 1,
        'respectSimulateStaticURLs' => 0,
        'postVarSet_failureMode'=>'redirect_goodUpperDir',
    ),
    'redirects_regex' => array (
    ),
    'preVars' => array(

        array(
            'GETvar' => 'no_cache',
            'valueMap' => array(
                'no_cache' => 1,
            ),
            'noMatch' => 'bypass',
        ),
        array(
            'GETvar' => 'L',
            'valueMap' => array(
                'de' => '1',
//								'de' => '0',
                'da' => '2',
                'en' => '3',
                'es' => '4',
                'ru' => '5',
                'cz' => '6',
            ),
            'defaultValue' => 'de',
            'noMatch' => 'bypass',
        ),
    ),
    'pagePath' => array(
        'type' => 'user',
        'userFunc' => 'Tx\Realurl\UriGeneratorAndResolver->main',
        'spaceCharacter' => '-',
        'languageGetVar' => 'L',
        'expireDays' => '7',
        'rootpage_id' => 1,
    ),
    'fixedPostVars' => array(
        // EXT:news start
        'newsDetailConfiguration' => array(
            array(
                'GETvar' => 'tx_news_pi1[action]',
                'valueMap' => array(
                    'detail' => '',
                ),
                'noMatch' => 'bypass'
            ),
            array(
                'GETvar' => 'tx_news_pi1[controller]',
                'valueMap' => array(
                    'News' => '',
                ),
                'noMatch' => 'bypass'
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
                        'spaceCharacter' => '-'
                    ),
                    'languageGetVar' => 'L',
                    'languageExceptionUids' => '',
                    'languageField' => 'sys_language_uid',
                    'transOrigPointerField' => 'l10n_parent',
                    'autoUpdate' => 1,
                    'expireDays' => 180,
                )
            )
        ),
        'newsCategoryConfiguration' => array(
            array(
                'GETvar' => 'tx_news_pi1[overwriteDemand][categories]',
                'lookUpTable' => array(
                    'table' => 'sys_category',
                    'id_field' => 'uid',
                    'alias_field' => 'title',
                    'addWhereClause' => ' AND NOT deleted',
                    'useUniqueCache' => 1,
                    'useUniqueCache_conf' => array(
                        'strtolower' => 1,
                        'spaceCharacter' => '-'
                    )
                )
            )
        ),
        'newsTagConfiguration' => array(
            array(
                'GETvar' => 'tx_news_pi1[overwriteDemand][tags]',
                'lookUpTable' => array(
                    'table' => 'tx_news_domain_model_tag',
                    'id_field' => 'uid',
                    'alias_field' => 'title',
                    'addWhereClause' => ' AND NOT deleted',
                    'useUniqueCache' => 1,
                    'useUniqueCache_conf' => array(
                        'strtolower' => 1,
                        'spaceCharacter' => '-'
                    )
                )
            )
        ),
        //		'70' => 'newsDetailConfiguration',
        //		'701' => 'newsDetailConfiguration', // For additional detail pages, add their uid as well
        //		'71' => 'newsTagConfiguration',
        //		'72' => 'newsCategoryConfiguration',
    ),

    // EXT:news end

    'postVarSets' => array(

        '_DEFAULT' => array (

            'cal'=> array(
                array(
                    'GETvar' => 'tx_cal_controller[view]'
                ),
                array(
                    'GETvar' => 'tx_cal_controller[getdate]'
                ),
                array(
                    'GETvar' => 'tx_cal_controller[lastview]'
                ),
                array(
                    'GETvar' => 'tx_cal_controller[type]'
                ),

                array(
                    'GETvar' => 'tx_cal_controller[category]',
                    'lookUpTable' => array(
                        'table' => 'tx_cal_category',
                        'id_field' => 'uid',
                        'alias_field' => 'title',
                        'addWhereClause'  => ' AND NOT deleted',
                        'useUniqueCache' => 1,
                        'useUniqueCache_conf' => array(
                            'strtolower' => 1,
                            'spaceCharacter' => '_',
                        ),

                    ),
                ),
                array(
                    'GETvar' => 'tx_cal_controller[uid]',
                    'lookUpTable' => array(
                        'table' => 'tx_cal_event',
                        'id_field' => 'uid',
                        'alias_field' => 'title',
                        'addWhereClause'  => ' AND NOT deleted',
                        'useUniqueCache' => 1,
                        'useUniqueCache_conf' => array(
                            'strtolower' => 1,
                            'spaceCharacter' => '_',
                        ),
                    ),
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
            'cal.xml' => array(
                'keyValues' => array(
                    'type' => 151,
                ),
            ),
            'cal.ics' => array(
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


// edit for single subdomains
if ( false ) {
    $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'] = $TYPO3_CONF_VARS['EXTCONF']['realurl']['_DEFAULT'];
    $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de']['pagePath']['rootpage_id'] = 37;
}

// edit for multiple domains


$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'] = $TYPO3_CONF_VARS['EXTCONF']['realurl']['_DEFAULT'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de']['pagePath']['rootpage_id'] = 1961;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['r-p-it.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['r-p-it.com']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.com']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['test.r-p-it.com']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];


$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.zigarettensuche.de'] = $TYPO3_CONF_VARS['EXTCONF']['realurl']['_DEFAULT'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.zigarettensuche.de']['pagePath']['rootpage_id'] = 374;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['zigarettensuche.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.zigarettensuche.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['zigarettenautomatensuche.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.zigarettensuche.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.zigarettenautomatensuche.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.zigarettensuche.de'];


$TYPO3_CONF_VARS['EXTCONF']['realurl']['test.r-p-it.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['web.tp3.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];

$TYPO3_CONF_VARS['EXTCONF']['realurl']['web.tp3.de']['pagePath']['rootpage_id'] = 1;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['dev.tp3.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['web.tp3.de'];

$TYPO3_CONF_VARS['EXTCONF']['realurl']['shops.tp3.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['shops.tp3.de']['pagePath']['rootpage_id'] = 1776;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['teltec.tp3.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['teltec.tp3.de']['pagePath']['rootpage_id'] = 1793;

$TYPO3_CONF_VARS['EXTCONF']['realurl']['heinzmann.tp3.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['heinzmann.tp3.de']['pagePath']['rootpage_id'] = 2032;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['hv-heinzmann.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['heinzmann.tp3.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.hv-heinzmann.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['heinzmann.tp3.de'];

$TYPO3_CONF_VARS['EXTCONF']['realurl']['ofengalerie.r-p-it.com']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['ofengalerie.r-p-it.com']['pagePath']['rootpage_id'] = 1605;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.ofengalerie-hohenstein.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['ofengalerie.r-p-it.com'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['ofengalerie-hohenstein.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['ofengalerie.r-p-it.com'];

$TYPO3_CONF_VARS['EXTCONF']['realurl']['taichi.tp3.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['_DEFAULT'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['taichi.tp3.de']['pagePath']['rootpage_id'] = 2081;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['tai-chi.tp3.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['taichi.tp3.de'];

$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.sterncardirekt.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['_DEFAULT'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.sterncardirekt.de']['pagePath']['rootpage_id'] = 1639;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['sterncardirekt.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.sterncardirekt.de'];

$TYPO3_CONF_VARS['EXTCONF']['realurl']['123.tp3.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['123.tp3.de']['pagePath']['rootpage_id'] = 2145;

$TYPO3_CONF_VARS['EXTCONF']['realurl']['rootbox.r-p-it.com']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['rootbox.r-p-it.com']['pagePath']['rootpage_id'] = 589;

$TYPO3_CONF_VARS['EXTCONF']['realurl']['hamm-sieg.tp3.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['hamm-sieg.tp3.de']['pagePath']['rootpage_id'] = 2341;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['hamm-sieg.cdu.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['hamm-sieg.tp3.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.hamm-sieg.cdu.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['hamm-sieg.tp3.de'];

$TYPO3_CONF_VARS['EXTCONF']['realurl']['123-engineering.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['123.tp3.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.123-engineering.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['123.tp3.de'];

$TYPO3_CONF_VARS['EXTCONF']['realurl']['erk-npp.tp3.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['erk-npp.tp3.de']['pagePath']['rootpage_id'] = 2129;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['erk-npp.com']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['erk-npp.tp3.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.erk-npp.com']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['erk-npp.tp3.de'];

$TYPO3_CONF_VARS['EXTCONF']['realurl']['shops.tp3.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['shops.tp3.de']['pagePath']['rootpage_id'] = 1776;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['shop.tp3.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['shop.tp3.de']['pagePath']['rootpage_id'] = 1622;

$TYPO3_CONF_VARS['EXTCONF']['realurl']['demo.tp3.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['demo.tp3.de']['pagePath']['rootpage_id'] = 109;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['cdu.tp3.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['cdu.tp3.de']['pagePath']['rootpage_id'] = 1814;

$TYPO3_CONF_VARS['EXTCONF']['realurl']['test.tp3.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['test.tp3.de']['pagePath']['rootpage_id'] = 109;

$TYPO3_CONF_VARS['EXTCONF']['realurl']['thomasruta.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['thomasruta.de']['pagePath']['rootpage_id'] = 223;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['thomas-ruta.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['thomas-ruta.de']['pagePath']['rootpage_id'] = 223;

$TYPO3_CONF_VARS['EXTCONF']['realurl']['yreim.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['yreim.de']['pagePath']['rootpage_id'] = 543;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.yreim.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['yreim.de'];

$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.urban-fahrschule.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.urban-fahrschule.de']['pagePath']['rootpage_id'] = 474;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['urban-fahrschule.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.urban-fahrschule.de'];

$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.fremdwaehrungskredit-geld-zurueck.at']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.fremdwaehrungskredit-geld-zurueck.at']['pagePath']['rootpage_id'] = 1916;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['fremdwaehrungskredit-geld-zurueck.at']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.fremdwaehrungskredit-geld-zurueck.at'];

$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.strausswirtschaft-am-weiher.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.strausswirtschaft-am-weiher.de']['pagePath']['rootpage_id'] = 688;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['strausswirtschaft-am-weiher.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.strausswirtschaft-am-weiher.de'];

$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-rutra.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-rutra.de']['pagePath']['rootpage_id'] = 1942;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['r-rutra.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-rutra.de'];


$TYPO3_CONF_VARS['EXTCONF']['realurl']['srt-wiesbaden.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['srt-wiesbaden.de']['pagePath']['rootpage_id'] = 710;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.srt-wiesbaden.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['srt-wiesbaden.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['test.srt-wiesbaden.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['srt-wiesbaden.de'];

$TYPO3_CONF_VARS['EXTCONF']['realurl']['leder.srt-wiesbaden.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['leder.srt-wiesbaden.de']['pagePath']['rootpage_id'] = 728;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.srt-ledermoebelreinigung.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['leder.srt-wiesbaden.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['test.srt-ledermoebelreinigung.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['leder.srt-wiesbaden.de'];

$TYPO3_CONF_VARS['EXTCONF']['realurl']['wiesbaden.toasternet.eu']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['wiesbaden.toasternet.eu']['pagePath']['rootpage_id'] = 329;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.toasternet.eu']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['wiesbaden.toasternet.eu'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['toasternet.eu']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['wiesbaden.toasternet.eu'];

$TYPO3_CONF_VARS['EXTCONF']['realurl']['neodental.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['neodental.de']['pagePath']['rootpage_id'] = 1048;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.neodental.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['neodental.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['neodental.r-p-it.com']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['neodental.r-p-it.com']['pagePath']['rootpage_id'] = 1048;

$TYPO3_CONF_VARS['EXTCONF']['realurl']['zweilindenhof-reim.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['zweilindenhof-reim.de']['pagePath']['rootpage_id'] = 2160;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.zweilindenhof-reim.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['zweilindenhof-reim.de'];

$TYPO3_CONF_VARS['EXTCONF']['realurl']['cruta.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['cruta.de']['pagePath']['rootpage_id'] = 1877;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.ruta-cad-and-more.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['cruta.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['ruta-cad-and-more.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['cruta.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.cruta.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['cruta.de'];

$TYPO3_CONF_VARS['EXTCONF']['realurl']['gt.r-p-it.com']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['gt.r-p-it.com']['pagePath']['rootpage_id'] = 436;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.gt-elektrobau.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['gt.r-p-it.com'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.gt-elektrobau.de']['pagePath']['rootpage_id'] = 436;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['gt-elektrobau.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.gt-elektrobau.de'];


$TYPO3_CONF_VARS['EXTCONF']['realurl']['kpwj.r-p-it.com']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['kpwj.r-p-it.com']['pagePath']['rootpage_id'] = 819;

$TYPO3_CONF_VARS['EXTCONF']['realurl']['unitec.r-p-it.com']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['unitec.r-p-it.com']['pagePath']['rootpage_id'] = 625;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['unitec.tp3.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['unitec.r-p-it.com'];

$TYPO3_CONF_VARS['EXTCONF']['realurl']['hondralis.r-p-it.com']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['hondralis.r-p-it.com']['pagePath']['rootpage_id'] = 908;

$TYPO3_CONF_VARS['EXTCONF']['realurl']['test.honda-lorenz.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['test.honda-lorenz.de']['pagePath']['rootpage_id'] = 2433;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.honda-lorenz.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.honda-lorenz.de']['pagePath']['rootpage_id'] = 2433;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['honda-lorenz.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['honda-lorenz.de']['pagePath']['rootpage_id'] = 2433;

$TYPO3_CONF_VARS['EXTCONF']['realurl']['abbate.tp3.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['abbate.tp3.de']['pagePath']['rootpage_id'] = 2306;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['my-abbate.com']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['abbate.tp3.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.my-abbate.com']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['abbate.tp3.de'];


$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.hjm-management.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.r-p-it.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.hjm-management.de']['pagePath']['rootpage_id'] = 1005;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['hjm-management.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.hjm-management.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['hansjoachimmendig.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['www.hjm-management.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.hansjoachimmendig.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['hansjoachimmendig.de'];
$TYPO3_CONF_VARS['EXTCONF']['realurl']['www.hansjoachimmendig.de']= $TYPO3_CONF_VARS['EXTCONF']['realurl']['hansjoachimmendig.de'];
	
