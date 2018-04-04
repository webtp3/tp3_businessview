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

            if ($this->panoramasrepository === null ) {
                $this->panoramasrepository = $this->objectManager->get(PanoramasRepository::class);

            }
            $panoramas= $this->panoramasrepository->findByUid(intval($GLOBALS['TSFE']->page['tx_tp3businessview_panorama']));
            if ($this->tp3businessviewrepository === null) {
                $this->tp3businessviewrepository = $this->objectManager->get(Tp3BusinessViewRepository::class);
            }
            $businessview = $this->tp3businessviewrepository->findByPanoramas($panoramas[0]["uid"])[0];
            $businessview['panoramas'] = $panoramas[0];

            // Social Gallery
            if ($this->businessadressrepository === null  && $businessview['contact'] > 0 ) {
                $this->businessadressrepository = $this->objectManager->get(BusinessAdressRepository::class);
                $businessview['contact'] = $this->businessadressrepository->findByUid($businessview['contact'])[0];
                    if(isset($businessview['social_gallery'])){
                    //#todo social galerie
                    }
                    //#todo addess
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
            $parameters["jsFooterFiles"] .='<script src="typo3conf/ext/tp3_businessview/Resources/Public/JavaScript/tp3_app.js"></script>';
            $parameters["CssFiles"] .='<script src="typo3conf/ext/tp3_businessview/Resources/Public/Css/Tp3App.css"></script>';

            //     die(var_dump($this->JsonRenderer($businessview, $panoramas)));
        }
    }


    /**
     * @param array $businessview
     * @return string
     */
    public function JsonRenderer(array $businessview = [], array $panoramas = [])
    {
        $businessview['pano_animation'] = explode(",",$businessview['pano_animation']);
        $businessview['pano_options'] = explode(",",$businessview['pano_options']);

        $json = json_encode([
            "details"=> [
                "actionOrder"=>[],
                "areaOrder"=>[],
                "editors"=>[],
                "googleMapsJavaScriptApiKey"=>$GLOBALS["TSFE"]->tmpl->setup["plugin."]["tp3_businessview."]["settings."]["googleMapsJavaScriptApiKey"],
                "legalNoticeUrl"=>urlencode($businessview['externalLinks']),
                "location"=>["formattedAddress"=>$businessview['contact']['address'].", ".$businessview['contact']['zip'] ." " .$businessview['contact']['city'] .",".$businessview['contact']['country'],"position"=>["latitude"=>$businessview['contact']['latitude'],"longitude"=>$businessview['contact']['longitude']]],
                "createdBy"=>[
                    "name"=>"\"".$businessview['createdBy'].",".urlencode($businessview['externalLinks'])."\"","status"=>true],
                 "modules"=>[
                    "contact"=> ["fields"=>[
                                "name"=>["value"=>$businessview['contact']['name'],"visible"=>($businessview['contact']['name'] !="" ? true : false)],
							 	"street"=>["value"=>$businessview['contact']['address'],"visible"=>($businessview['contact']['address'] !="" ? true : false)],
                                "zip"=>["value"=>$businessview['contact']['zip'],"visible"=>($businessview['contact']['zip'] !="" ? true : false)],
							 	"city"=>["value"=>$businessview['contact']['city'],"visible"=>($businessview['contact']['city'] !="" ? true : false)],
                                "phone"=>["value"=>$businessview['contact']['phone'],"visible"=>($businessview['contact']['phone'] !="" ? true : false)],
							 	"email"=>["value"=>$businessview['contact']['email'],"visible"=>($businessview['contact']['email'] !="" ? true : false)],
                                "website"=>["value"=>$businessview['contact']['www'],"visible"=>($businessview['contact']['www'] !="" ? true : false)],
                        ],
                        "color"=>$GLOBALS["TSFE"]->tmpl->setup["plugin."]["tp3_businessview."]["settings."]["color"] != null ? $GLOBALS["TSFE"]->tmpl->setup["plugin."]["tp3_businessview."]["settings."]["color"] : "#fff",
                        "backgroundColor"=>$GLOBALS["TSFE"]->tmpl->setup["plugin."]["tp3_businessview."]["settings."]["backgroundColor"] != null ? $GLOBALS["TSFE"]->tmpl->setup["plugin."]["tp3_businessview."]["settings."]["backgroundColor"] : "rgba(98, 98, 98, 0.8)",
                        "textColor"=>$GLOBALS["TSFE"]->tmpl->setup["plugin."]["tp3_businessview."]["settings."]["textColor"]  != null ? $GLOBALS["TSFE"]->tmpl->setup["plugin."]["tp3_businessview."]["settings."]["textColor"] : "#fff",
                        "align"=>$GLOBALS["TSFE"]->tmpl->setup["plugin."]["tp3_businessview."]["settings."]["align"] != null ? $GLOBALS["TSFE"]->tmpl->setup["plugin."]["tp3_businessview."]["settings."]["align"] : "right",
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
                    "panoAnimation"=>["jumps"=>$businessview['pano_animation']['jumps'] ? true : false ,"rotation"=>$businessview['pano_animation']['rotation'] ? true : false],
                    "socialGallery"=> $businessview['social_gallery']

                ],
                "name"=>$businessview['name'],
                "panoEntry"=>[
                    "heading"=>$businessview['panoramas']['heading'],
                    "panoId"=>$businessview['panoramas']['pano_id'],
                    "pitch"=>$businessview['panoramas']['pitch'],
                    "zoom"=>is_numeric($businessview['panoramas']['zoom']) ? $businessview['panoramas']['zoom'] : 0 ,
                ],
                "panoOptions"=>[
                    "addressControl"=>$businessview['pano_options']['addressControl'] ? true : false ,
                    "disableDefaultUI"=>$businessview['pano_options']['disableDefaultUI'] ? true : false ,
                    "panControl"=>$businessview['pano_options']['panControl'] ? true : false ,
                    "scaleControl"=>$businessview['pano_options']['scaleControl'] ? true : false ,
                    "scrollwheel"=>$businessview['pano_options']['scrollwheel'] ? true : false ,
                    "zoomControl"=>$businessview['pano_options']['zoomControl'] ? true : false ,
                ],
                "panoramas"=>$panoramas,
                "type"=>"businessview",
            ],
            "hasDetails"=>true
        ]);
        return $json;
    }
}
