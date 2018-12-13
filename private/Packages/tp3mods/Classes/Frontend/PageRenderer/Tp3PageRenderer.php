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

class Tp3PageRenderer implements SingletonInterface
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
                $this->tp3ModsRepository = $this->objectManager->get(Tp3ModsRepository::class);
                if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('tt_address')) {
                    if ($this->tp3AdressRepository === null) {
                        $this->tp3AdressRepository = $this->objectManager->get(Tp3AdressRepository::class);
                    }
                    if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('tp3_openhours')) {
                        if ($this->openHourRepository === null) {
                            $this->openHourRepository = $this->objectManager->get(\Tp3\Tp3Openhours\Domain\Repository\OpenHourRepository::class);
                        }
                    }
                }
            }
            $tp3micro = $this->tp3ModsRepository->findByUid($GLOBALS['TSFE']->page['tp3microdata']);
            if (is_array($tp3micro) &&  $tp3micro[0]['address'] > 0) {
                $tp3micro[0]['address_object'] = $this->tp3AdressRepository->findByUid($tp3micro[0]['address']);
            }

            // todo openhours Rich Snippets
            if ($this->openHourRepository !== null) {
                $openhours = $this->openHourRepository->findByAddress($tp3micro[0]['address']);
                $formattedText = '';
                $hoursArray = [];
                foreach ($openhours as $oh) {
                    //$dateconv = \date("H:i",$oh->getOpenTime());
                    $formattedText .= $oh->getDayName() . ' ' . \date('H:i', $oh->getOpenTime()) . '-' . \date('H:i', $oh->getCloseTime()) . '<br>';
                    $hoursArray[] = [\date('H:i', $oh->getOpenTime()), \date('H:i', $oh->getCloseTime())];
                }
                if ($formattedText != '') {
                    $bw['openingHours'] = [
                        'formattedText' => $formattedText,
                        'status'=>true,
                        'hours'=>$hoursArray,
                    ];
                }
                /*
                *
                "openingHours":{"formattedText":"Montag: geschlossen<br>Di - Fr: 10:00 - 18:00 Uhr<br>Sa - So: 10:00 - 18:00 Uhr","status":true,"hours":[null,["9:00","18:00"],["9:00","18:00"],["9:00","18:00"],["9:00","18:00"],["9:00","18:00"],[],[]]},

                */
            }
            try {
                if (is_array($tp3micro[0]['address_object'])) {
                    $parameters['jsInline'] .='<script> ' . $this->JsonRenderer($tp3micro[0], $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_tp3mods_tp3micro.']['settings.']) . '</script>';
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
    public function JsonRenderer(array $microdata = [], $settings = null)
    {
        $json =      ' {
         "@context": "http://schema.org",
         "@type": "' . $microdata['snippetType'] . '",
         "url": "' . $microdata['address_object']['www'] . '",
         "logo": "' . $microdata['address_object']['image'] . '",
         "telephone": "' . $microdata['address_object']['phone'] . '",
         "sameAs": ' . $microdata['address_object']['social_profiles'] . ' 
         "contactPoint": [{
           "@type": "ContactPoint",
           "telephone": "' . $microdata['address_object']['phone'] . '",
           "contactType": "customer service"
         }]
         "@id": "' . $microdata['address_object']['url'] . '",
          "name": "' . $microdata['address_object']['name'] . '",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "' . $microdata['address_object']['address'] . '",
            "addressLocality": "' . $microdata['address_object']['city'] . '",
            "addressRegion": "' . $microdata['address_object']['region'] . '",
            "postalCode": "' . $microdata['address_object']['zip'] . '",
            "addressCountry": "' . $microdata['address_object']['country'] . '"
          },
          "geo": {
            "@type": "GeoCoordinates",
            "latitude": ' . $microdata['address_object']['latitude'] . ',
            "longitude": ' . $microdata['address_object']['longitude'] . '
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
