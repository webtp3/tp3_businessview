<?php
namespace Tp3\Tp3Businessview\Frontend\PageRenderer;

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use Tp3\Tp3Businessview\Domain\Repository\Tp3BusinessViewRepository;
use Tp3\Tp3Businessview\Domain\Repository\PanoramasRepository;
use Tp3\Tp3Businessview\Domain\Repository\BusinessAdressRepository;



class Tp3PageRenderer implements SingletonInterface
{
    /**
     *
     * @var \Tp3\Tp3Businessview\Domain\Repository\Tp3BusinessViewRepository;
     */
    public  $tp3businessviewrepository = null;
    /**
     *
     * @var \Tp3\Tp3Businessview\Domain\Repository\PanoramasRepository;
     */
    public  $panoramasrepository = null;
    /**
     *
     * @var \Tp3\Tp3Businessview\Domain\Repository\BusinessAdressRepository;
     */
    public  $businessadressrepository = null;
    /**
     * @param array $parameters
     * @param PageRenderer $pageRenderer
     * @return string
     */
    public function render(array $parameters, &$pageRenderer)
    {
        /**
         * Check if `config.yoast_seo` is true before any rendering takes place
         * next make sure `plugin.tx_tp3businessview` is properly configured
         * `plugin.tx_tp3businessview.view` is used as configuration array for FLUIDTEMPLATE
         *
         * @see https://docs.typo3.org/typo3cms/TyposcriptReference/ContentObjects/Fluidtemplate/Index.html
         *
         * The content object renderer of TSFE is used to render FLUIDTEMPLATE
         * after `plugin.tx_tp3businessview.settings` is merged with `plugin.tx_tp3businessview.view.settings`
         */
        $config = isset($GLOBALS['TSFE']->tmpl->setup) ? $GLOBALS['TSFE']->tmpl->setup : [];
        if (is_array($config)
            && (bool)$GLOBALS['TSFE']->page['tx_tp3businessview_onpage']
            && isset(
                $config['plugin.']['tx_tp3businessview.']['view.']
            )
            && $GLOBALS['TSFE']->cObj instanceof ContentObjectRenderer
        ) {
            if ($this->objectManager === null) {
                $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
            }
            if ($this->tp3businessviewrepository === null) {
                $this->tp3businessviewrepository = $this->objectManager->get(Tp3BusinessViewRepository::class);
            }
            $businessview = $this->tp3businessviewrepository->findByUid(intval($GLOBALS['TSFE']->page['tx_tp3businessview_panorama']))[0];

            // Social Gallery
            if ($this->businessadressrepository === null  && $businessview['contact'] > 0 ) {
                $this->businessadressrepository = $this->objectManager->get(BusinessAdressRepository::class);
                $businessview['contact'] = $this->businessadressrepository->findByUid($businessview['contact'])[0];
                    if(isset($businessview['social_gallery'])){
                    //#todo social galerie
                    }
                    //#todo addess
            }
            if ($this->panoramasrepository === null && $businessview['panoramas'] > 0) {
                $this->panoramasrepository = $this->objectManager->get(PanoramasRepository::class);
                $panoramas= $this->panoramasrepository->findByUid($businessview['panoramas']);
                $businessview['panoramas'] = $panoramas[0];
            }
            // app will be removed - to much to query -> tsconfig is enough
            /*
            if ($this->panoramasrepository === null && $businessview['app'] > 0) {
                $this->panoramasrepository = $this->objectManager->get(PanoramasRepository::class);
                $this->panoramasrepository>findByUid($businessview['app']);

            }*/
           // $businessview = $this->tp3businessviewrepository->findByUid(intval($GLOBALS['TSFE']->page['tx_tp3businessview_panorama']))->getFirst();

            $parameters["jsFooterInline"] .="<script> var businessviewJson = ".$this->JsonRenderer($businessview, $panoramas).";";
            $parameters["jsFooterInline"] .="  $('".($GLOBALS['TSFE']->page['tx_tp3businessview_injetionpoint'] != "" ? $GLOBALS['TSFE']->page['tx_tp3businessview_injetionpoint'] : '#content') ."').first().attr(\"id\",\"businessview-panorama-canvas\").wrapAll('<div id=\"businessview-canvas\" style=\"width:100%;height:100%;min-height:600px;\"></div>');</script>";
            $parameters["jsFooterFiles"] .='<script src="typoconf/ext/tp3_businessview/Resources/Public/JavaScript/tp3_app.js"></script>';
            $parameters["CssFiles"] .='<script src="typoconf/ext/tp3_businessview/Resources/Public/Css/tp3_app.css"></script>';

            //     die(var_dump($this->JsonRenderer($businessview, $panoramas)));
        }
    }


    /**
     * @param array $businessview
     * @return string
     */
    public function JsonRenderer(array $businessview = [], array $panoramas = [])
    {

        $json = json_encode([
            "details"=> [
                "actionOrder"=>[],
                "areaOrder"=>[],
                "editors"=>[],
                "googleMapsJavaScriptApiKey"=>$GLOBALS["TSFE"]->tmpl->setup["plugin."]["tp3_businessview."]["settings."]["googleMapsJavaScriptApiKey"],
                "legalNoticeUrl"=>$businessview['created_by'],
                "location"=>["formattedAddress"=>$businessview['contact']['address'].", ".$businessview['contact']['zip'] ." " .$businessview['contact']['city'] .",".$businessview['contact']['country'],"position"=>["latitude"=>$businessview['latitude']['country'],"longitude"=>$businessview['contact']['longitude']]],
                "createdBy"=>["name"=>"tp3, http:\/\/web.tp3.de","status"=>true],
                 "modules"=>[
                    "contact"=> ["fields"=>[
                                "name"=>["value"=>$businessview['contact']['name'],"visible"=>($businessview['contact']['twitter'] !="" ? true : false)],
							 	"street"=>["value"=>$businessview['contact']['address'],"visible"=>($businessview['contact']['address'] !="" ? true : false)],
                                "zip"=>["value"=>$businessview['contact']['zip'],"visible"=>($businessview['contact']['zip'] !="" ? true : false)],
							 	"city"=>["value"=>$businessview['contact']['city'],"visible"=>($businessview['contact']['city'] !="" ? true : false)],
                                "phone"=>["value"=>$businessview['contact']['phone'],"visible"=>($businessview['contact']['phone'] !="" ? true : false)],
							 	"email"=>["value"=>$businessview['contact']['email'],"visible"=>($businessview['contact']['email'] !="" ? true : false)],
                                "website"=>["value"=>$businessview['contact']['www'],"visible"=>($businessview['contact']['www'] !="" ? true : false)],
                        ],
                        "color"=>$GLOBALS["TSFE"]->tmpl->setup["plugin."]["tp3_businessview."]["settings."]["color"],
                        "backgroundColor"=>$GLOBALS["TSFE"]->tmpl->setup["plugin."]["tp3_businessview."]["settings."]["backgroundColor"],
                        "textColor"=>$GLOBALS["TSFE"]->tmpl->setup["plugin."]["tp3_businessview."]["settings."]["textColor"],
                        "align"=>$GLOBALS["TSFE"]->tmpl->setup["plugin."]["tp3_businessview."]["settings."]["align"],
                    ],
                    "custom"=>[],
                        "externalLinks"=> ["status"=>true,"links"=>[
                            ["icon"=>"fa-twitter","url"=>"https:\\/\\/twitter.com\\".$businessview['contact']['twitter']."/","target"=>false,"visible"=>($businessview['contact']['twitter'] !="" ? true : false)],
                            ["icon"=>"fa-facebook","url"=>"https:\\/\\/www.facebook.com\\/".$businessview['contact']['facebook']."","target"=>false,"visible"=>($businessview['contact']['facebook'] !="" ? true : false)],
                            ["icon"=>"fa-google-plus","url"=>"https:\\/\\/plus.google.com\\/".$businessview['contact']['googleplus']."\\/about","target"=>false,"visible"=>($businessview['contact']['googleplus'] !="" ? true : false)]
                        ]
                    ],
                    "gallery"=>[],
                    "intro"=>[],
                    "openingHours"=>[],
                    "opentable"=>[],
                    "panoAnimation"=>["jumps"=>$businessview['pano_animation']['jumps'],"rotation"=>$businessview['pano_animation']['rotation']],
                    "socialGallery"=> $businessview['social_gallery']

                ],
                "name"=>$businessview['name'],
                "panoEntry"=>[
                    "heading"=>$businessview['panoramas']['heading'],
                    "panoId"=>$businessview['panoramas']['pano_id'],
                    "pitch"=>$businessview['panoramas']['pitch'],
                    "zoom"=>$businessview['panoramas']['zoom'],
                ],
                "panoOptions"=>[
                    "addressControl"=>false,
                    "disableDefaultUI"=>false,
                    "panControl"=>false,
                    "scaleControl"=>true,
                    "scrollwheel"=>true,
                    "zoomControl"=>false,
                ],
                "panoramas"=>$panoramas,
                "type"=>"businessview",
            ],
            "hasDetails"=>true
        ]);
        return $json;
    }
}
