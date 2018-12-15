<?php

/*
 * This file is part of the web-tp3/tp3mods.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3mods\Frontend\PageRenderer;

use Tp3\Tp3mods\Domain\Repository\Tp3AdressRepository;
use Tp3\Tp3mods\Domain\Repository\Tp3ModsRepository;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class Tp3RichSnippetsRenderer implements SingletonInterface
{
    /**
     * tp3AdressRepository
     *
     * @var \Tp3\Tp3mods\Domain\Repository\Tp3AdressRepository
     * @inject
     */
    protected $tp3AdressRepository = null;

    /**
     * tp3AdressRepository
     *
     * @var \Tp3\Tp3Openhours\Domain\Repository\OpenHourRepository
     * @inject
     */
    protected $openHourRepository = null;
    /**
     * RatingsdataRepository
     *
     * @var \Tp3\Tp3ratings\Domain\Repository\RatingsdataRepository
     * @inject
     */
    protected $ratingsdataRepository = null;
    /**
     * tp3ModsRepository
     *
     * @var \Tp3\Tp3mods\Domain\Repository\Tp3ModsRepository
     * @inject
     */
    protected $tp3ModsRepository = null;

    /**
     * @param array $parameters
     * @param PageRenderer $pageRenderer
     * @return string
     */
    public function render($parameters, &$pageRenderer)
    {
        if (!is_array($parameters)) {
            return;
        }
        $config = isset($GLOBALS['TSFE']->tmpl->setup) ? $GLOBALS['TSFE']->tmpl->setup : [];
        if (is_array($config)
            && (bool)$GLOBALS['TSFE']->page['tp3microdata']
            && isset(
                $config['plugin.']['tx_tp3mods_tp3micro.']['view.']
            )
            && $GLOBALS['TSFE']->cObj instanceof ContentObjectRenderer
        ) {
            if ($GLOBALS['TSFE']->page['tp3microdata'] < 1) {
                return;
            }
            if ($this->objectManager === null) {
                $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
            }

            if ($this->tp3ModsRepository === null) {
                $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
                //  $querySettings->setStoragePageIds();
                $querySettings->setRespectStoragePage(false);

                $this->tp3ModsRepository = $this->objectManager->get(Tp3ModsRepository::class);
                $this->tp3ModsRepository->setDefaultQuerySettings($querySettings);

                if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('tt_address')) {
                    if ($this->tp3AdressRepository === null) {
                        $this->tp3AdressRepository = $this->objectManager->get(Tp3AdressRepository::class);
                    }
                    $this->tp3AdressRepository->setDefaultQuerySettings($querySettings);

                    if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('tp3_openhours')) {
                        if ($this->openHourRepository === null) {
                            $this->openHourRepository = $this->objectManager->get(\Tp3\Tp3Openhours\Domain\Repository\OpenHourRepository::class);
                        }
                    }

                    if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('tp3ratings')) {
                        if ($this->ratingsdataRepository === null) {
                            $this->ratingsdataRepository = $this->objectManager->get(\Tp3\Tp3ratings\Domain\Repository\RatingsdataRepository::class);
                        }

                    }
                }
            }

            $tp3micro = $this->tp3ModsRepository->findByUid($GLOBALS['TSFE']->page['tp3microdata']);
            if (is_array($tp3micro) &&  $tp3micro[0]['address'] > 0) {
                $tp3micro[0]['address_object'] = $this->tp3AdressRepository->findByUid($tp3micro[0]['address']);
            }

            // todo rating Rich Snippets
            if ($this->ratingsdataRepository !== null) {
                $ratingsdata = $this->ratingsdataRepository->findAll();
                $tp3micro[0]['aggregateRating'] = '';
                $ratingValue = 5;
                 $reviewCount = 1;
                /*
                 * "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "4.4",
            "reviewCount": "89"
          },
                 */
                foreach ($ratingsdata as $rate) {
                    $ratingValue = $ratingValue + $rate->getRating();

                    $reviewCount= $reviewCount + $rate->getVotecount();
                }
                if ($ratingValue > 5) {
                    $tp3micro[0]['aggregateRating'] = '"aggregateRating":[
                                        "@type": "aggregateRating",
                                                "ratingValue": "'.round($ratingValue/ $reviewCount,2).'",
                                                "reviewCount": "'.$reviewCount.'",
                                                "worstRating": 1,
                                                "bestRating": 5,
                                                "ratingCount": "'.$reviewCount.'",
                                        },';
                }


            }
            // todo rating Rich Snippets
            if ($this->ratingsdataRepository !== null) {
                $ratingsdata = $this->ratingsdataRepository->findbyStorgePid($GLOBALS["TSFE"]->page["uid"]);
                $tp3micro[0]['pageAggregateRating'] = '';
                $ratingValue = 5;
                $reviewCount = 1;

                foreach ($ratingsdata as $rate) {
                    $ratingValue = $ratingValue + $rate->getRating();

                    $reviewCount= $reviewCount + $rate->getVotecount();
                }
                if ($ratingValue > 5) {
                    $tp3micro[0]['pageAggregateRating'] = '"aggregateRating":[
                                        "@type": "aggregateRating",
                                                "ratingValue": "'.round($ratingValue/ $reviewCount,2).'",
                                                "reviewCount": "'.$reviewCount.'",
                                                "worstRating": 1,
                                                "bestRating": 5,
                                                "ratingCount": "'.$reviewCount.'",
                                        },';
                }


            }
            // todo date openhours Rich Snippets
            if ($this->openHourRepository !== null) {
                $openhours = $this->openHourRepository->findByAddress($tp3micro[0]['address']);
                $formattedText = '';
                $OpeningHoursSpecification = '';
                $tp3micro[0]['OpeningHoursSpecification'] = '';
                foreach ($openhours as $oh) {
                    $OpeningHoursSpecification .= '{
                                        "@type": "OpeningHoursSpecification",
                              "dayOfWeek": [ 
                              "'.$oh->getDayName().'"
                                        ],
                              "opens": "'.\date('H:i', $oh->getOpenTime()).'",
                              "closes": "'.\date('H:i', $oh->getCloseTime()).'"
                            },';
                    // $oh->getDayName() . ' ' . \date('H:i', $oh->getOpenTime()) . '-' . \date('H:i', $oh->getCloseTime()) . '<br>';
                    //$hours = [\date('H:i', $oh->getOpenTime()), \date('H:i', $oh->getCloseTime())];
                }
                if ($OpeningHoursSpecification != '') {
                    $formattedText = '"openingHoursSpecification": [
                                      '.$OpeningHoursSpecification.'
                          ],';
                    $tp3micro[0]['OpeningHoursSpecification'] = $formattedText;
                }
                /*
                *
                "openingHours":{"formattedText":"Montag: geschlossen<br>Di - Fr: 10:00 - 18:00 Uhr<br>Sa - So: 10:00 - 18:00 Uhr","status":true,"hours":[null,["9:00","18:00"],["9:00","18:00"],["9:00","18:00"],["9:00","18:00"],["9:00","18:00"],[],[]]},

                */
            }
            try {
                if (is_object($tp3micro[0]['address_object'])) {
                    $parameters['jsInline'] .='<script> ' . $this->JsonRenderer($tp3micro[0], $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_tp3mods_tp3micro.']['settings.']) . '</script>';
                    $parameters['jsInline'] .='<script> ' . $this->JsonWeb($tp3micro[0], $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_tp3mods_tp3micro.']['settings.']) . '</script>';
                    $parameters['jsInline'] .='<script> ' . $this->JsonSearch($tp3micro[0], $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_tp3mods_tp3micro.']['settings.']) . '</script>';

                }
                else{
                    // #todo without address
                }
            } catch (Exception $e) {
                //   $message = $GLOBALS['LANG']->sL(self::LL_PATH . $e->getMessage());
                //   throw new \RuntimeException($message);
            }
        }
    }
    /**
     * @param array $microdata, array $settings
     * @return string
     */
    public function JsonWeb(array $microdata = [], $settings = null)
    {

        $json = ' {
         "@context": "http://schema.org",
         "@type": "' . $microdata['snippet_type'] . '",
         "url": "' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/' . $_SERVER['REQUEST_URI'] . '",
         "name": "'.$GLOBALS["TSFE"]->cObj->data["title"].'",
         "keywords": "'.$GLOBALS["TSFE"]->cObj->data["keywords"].'",
         "description": "'.$GLOBALS["TSFE"]->cObj->data["description"].'",
             potentialAction": {
                "@type": "SearchAction",
                "target": "' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/?tx_indexedsearch_pi2%5Baction%5D=search&tx_indexedsearch_pi2%5Bcontroller%5D=Search&tx_indexedsearch_pi2%5Bsearch%5D%5Bsword%5D={skeyword}",
                "query-input": "required name=skeyword"
              },
          '
             .  $microdata['pageAggregateRating'] .
            '
 
        
       }';
        return $json;

    }
    /**
     * @param array $microdata, array $settings
     * @return string
     */
    public function JsonSearch(array $microdata = [], $settings = null)
    {

        $json = ' {
         "@context": "http://schema.org",
         "@type": "WebSite",
         "url": "' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '",
         "name": "'.$GLOBALS["TSFE"]->tmpl->sitetitle.'",
         potentialAction": {
            "@type": "SearchAction",
            "target": "' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '//?tx_indexedsearch_pi2%5Baction%5D=search&tx_indexedsearch_pi2%5Bcontroller%5D=Search&tx_indexedsearch_pi2%5Bsearch%5D%5Bsword%5D={skeyword}",
            "query-input": "required name=skeyword"
          },
            '.  $microdata['aggregateRating'] . '
       }';
        return $json;

    }
    /**
     * @param array $microdata, array $settings
     * @return string
     */
    public function JsonRenderer(array $microdata = [], $settings = null)
    {
        /*
         * "logo": "' . $microdata['address_object']->getImage() . '",
         */
        $json =      ' {
         "@context": "http://schema.org",
         "@type": "' . $microdata['konfiguration'] . '",
         "url": "'. $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] .'/' . $microdata['address_object']->getWww() . '",
         "image": "' . $GLOBALS["TSFE"]->tmpl->setup_constants["logo"] . '",
          "image": "' . $GLOBALS["TSFE"]->tmpl->setup_constants["logo"] . '",
          "email": "' . $GLOBALS["TSFE"]->tmpl->setup_constants["email"] . '",
          "telephone": "' . $microdata['address_object']->getPhone() . '",
         "sameAs": [' . implode(",",$microdata['address_object']->getSocialProfiles() ). ']
         "contactPoint": [{
           "@type": "ContactPoint",
           "telephone": "' . $microdata['address_object']->getPhone() . '",
           "email": "' . $GLOBALS["TSFE"]->tmpl->setup_constants["email"] . '",
           "contactType": "customer service"
         }]
         "@id": "'. $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] .'",
          "name": "' . $microdata['address_object']->getName() . '",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "' . $microdata['address_object']->getAddress() . '",
            "addressLocality": "' . $microdata['address_object']->getCity() . '",
            "addressRegion": "' . $microdata['address_object']->getRegion() . '",
            "postalCode": "' . $microdata['address_object']->getZip() . '",
            "addressCountry": "' . $microdata['address_object']->getCountry() . '"
          },'
            . $microdata['OpeningHoursSpecification'] .  $microdata['aggregateRating'] .
            '
          "geo": {
            "@type": "GeoCoordinates",
            "latitude": ' . $microdata['address_object']->getLatitude() . ',
            "longitude": ' . $microdata['address_object']->getLongitude() . '
          },
       }';

        /*{
          "@context": "http://schema.org",
          "@type": "Store",
          "image": [
            "https://example.com/photos/1x1/photo.jpg",
            "https://example.com/photos/4x3/photo.jpg",
            "https://example.com/photos/16x9/photo.jpg"
           ],
          "@id": "http://davesdeptstore.example.com",
          "name": "Dave's Department Store",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "1600 Saratoga Ave",
            "addressLocality": "San Jose",
            "addressRegion": "CA",
            "postalCode": "95129",
            "addressCountry": "US"
          },
         "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "4.4",
            "reviewCount": "89"
          },
          "geo": {
            "@type": "GeoCoordinates",
            "latitude": 37.293058,
            "longitude": -121.988331
          },
          "url": "http://www.example.com/store-locator/sl/San-Jose-Westgate-Store/1427",
          "telephone": "+14088717984",
          "openingHoursSpecification": [
            {
              "@type": "OpeningHoursSpecification",
              "dayOfWeek": [
                "Monday",
                "Tuesday",
                "Wednesday",
                "Thursday",
                "Friday",
                "Saturday"
              ],
              "opens": "08:00",
              "closes": "23:59"
            },
            {
              "@type": "OpeningHoursSpecification",
              "dayOfWeek": "Sunday",
              "opens": "08:00",
              "closes": "23:00"
            }
          ],
          "department": [
            {
              "@type": "Pharmacy",
              "image": [
            "https://example.com/photos/1x1/photo.jpg",
            "https://example.com/photos/4x3/photo.jpg",
            "https://example.com/photos/16x9/photo.jpg"
           ],
              "name": "Dave's Pharmacy",
              "telephone": "+14088719385",
              "openingHoursSpecification": [
                {
                  "@type": "OpeningHoursSpecification",
                  "dayOfWeek": [
                    "Monday",
                    "Tuesday",
                    "Wednesday",
                    "Thursday",
                    "Friday"
                  ],
                  "opens": "09:00",
                  "closes": "19:00"
                },
                {
                  "@type": "OpeningHoursSpecification",
                  "dayOfWeek": "Saturday",
                  "opens": "09:00",
                  "closes": "17:00"
                },
                {
                  "@type": "OpeningHoursSpecification",
                  "dayOfWeek": "Sunday",
                  "opens": "11:00",
                  "closes": "17:00"
                }
              ]
            }
          ]
        }
        */
        return $json;
    }
}
