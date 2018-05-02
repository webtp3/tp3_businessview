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
    public  $Tp3BusinessViewRepository = null;
    /**
     *
     * @var \Tp3\Tp3Businessview\Domain\Repository\PanoramasRepository;
     */
    public  $panoramasRepository = null;
    /**
     *
     * @var \Tp3\Tp3Businessview\Domain\Repository\BusinessAdressRepository;
     */
    public  $businessAdressRepository = null;
    /**
     *
     * @var \Tp3\Tp3Openhours\Domain\Repository\OpenHourRepository;
     */
    public  $openHourRepository = null;
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
            if($GLOBALS['TSFE']->page['tx_tp3businessview_onpage'] < 1)return;
            if ($this->objectManager === null) {
                $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
            }
            if ($this->Tp3BusinessViewRepository === null) {
                $this->Tp3BusinessViewRepository = $this->objectManager->get(Tp3BusinessViewRepository::class);
            }
            if ($this->panoramasRepository === null ) {
                $this->panoramasRepository = $this->objectManager->get(PanoramasRepository::class);

            }
            if ($this->businessAdressRepository === null ) {
                $this->businessAdressRepository = $this->objectManager->get(BusinessAdressRepository::class);
                if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded ('tp3_openhours')) {
                    if ($this->openHourRepository === null ) {
                        $this->openHourRepository = $this->objectManager->get(\Tp3\Tp3Openhours\Domain\Repository\OpenHourRepository::class);

                    }
                }

            }
            $businessViews = $this->Tp3BusinessViewRepository->findByPanoramas($GLOBALS['TSFE']->page['tx_tp3businessview_panorama']);
            try{
                $businessView = $businessViews->getFirst();
                if (!$businessView instanceof \Tp3\Tp3BusinessView\Domain\Model\Tp3BusinessView) {
                    $panorama = $this->panoramasRepository->findByUid($GLOBALS['TSFE']->page['tx_tp3businessview_panorama']);
                    if (!is_array($panorama) &&  count($panorama)< 1) return;
                    /*
                     * #todo display panorama only
                     */
                    $businessView = new \Tp3\Tp3BusinessView\Domain\Model\Tp3BusinessView;
                    $bw = $businessView->getPropertiesArray();
                    $bw['panoramas'] = [];
                    $bw['panorama'] = $panorama[0];
                }
                else{
                    $panolist = [];
                    foreach ($businessView->getPanoramas() as $panoramas => $pano){
                        $panolist[]=  $pano->getUid();
                    }
                    $panoramas = $this->panoramasRepository->findByList($panolist);
                    //find selcted
                    $panorama = $this->panoramasRepository->findByUid($GLOBALS['TSFE']->page['tx_tp3businessview_panorama']);
                    $bw = $businessView->getPropertiesArray();

                    $businessAdresses = $this->businessAdressRepository->findByUidArray($businessView->getContact());
                    if ($this->openHourRepository !== null ){
                        $openhours = $this->openHourRepository->findByAddress($businessView->getContact());
                        $formattedText = "";
                        $hoursArray = [];
                        foreach ($openhours as $oh){
                            //$dateconv = \date("H:i",$oh->getOpenTime());
                            $formattedText .= $oh->getDayName() . " " .\date("H:i", $oh->getOpenTime())  . "-" . \date("H:i", $oh->getCloseTime()) ."<br>";
                            $hoursArray[] = [\date("H:i", $oh->getOpenTime()),\date("H:i", $oh->getCloseTime())];
                        }
                        if($formattedText != ""){
                            $bw['openingHours'] = [
                                "formattedText" => $formattedText,
                                "status"=>true,
                                "hours"=>$hoursArray,
                            ];
                        }
                        /*
                        *
                        "openingHours":{"formattedText":"Montag: geschlossen<br>Di - Fr: 10:00 - 18:00 Uhr<br>Sa - So: 10:00 - 18:00 Uhr","status":true,"hours":[null,["9:00","18:00"],["9:00","18:00"],["9:00","18:00"],["9:00","18:00"],["9:00","18:00"],[],[]]},

                        */
                    }
                    $bw['contact'] = $businessAdresses[0];
                    //$bw['panorama'] = $panoramas[0];
                    $bw['panoramas'] = [$panoramas];
                    $bw['panorama'] = $panorama[0];

                    // Social Gallery

                    // $businessview['contact'] = $this->businessAdressRepository->findByUid($businessview['contact'])[0];

                    $parameters["jsInline"] .='<script> window.businessviewJson = window.businessviewJson || '.$this->JsonRenderer($bw,$panoramas).';window.tp3_app = window.tp3_app || {};window.tp3_app.AnmationOptions  = {  panoJumpTimer:'.
                        ( $GLOBALS["TSFE"]->tmpl->setup["plugin."]['tx_tp3businessview.']["settings."]["panoJumpTimer"] != "" ? $GLOBALS["TSFE"]->tmpl->setup["plugin."]['tx_tp3businessview.']["settings."]["panoJumpTimer"] : 5000) . ', panoRotationTimer:'.
                        ( $GLOBALS["TSFE"]->tmpl->setup["plugin."]['tx_tp3businessview.']["settings."]["panoRotationTimer"] != "" ? $GLOBALS["TSFE"]->tmpl->setup["plugin."]['tx_tp3businessview.']["settings."]["panoRotationTimer"] : 10 ).', panoRotationFactor:'.
                        ( $GLOBALS["TSFE"]->tmpl->setup["plugin."]['tx_tp3businessview.']["settings."]["panoRotationFactor"] != "" ? $GLOBALS["TSFE"]->tmpl->setup["plugin."]['tx_tp3businessview.']["settings."]["panoRotationFactor"] : 0.060 ).', panoJumpsRandom:'.
                        ( $GLOBALS["TSFE"]->tmpl->setup["plugin."]['tx_tp3businessview.']["settings."]["panoJumpsRandom"] != "" ? $GLOBALS["TSFE"]->tmpl->setup["plugin."]['tx_tp3businessview.']["settings."]["panoJumpsRandom"]  : true ).'};</script>';


                }
                $parameters["jsFooterInline"] .="<script>  $('".($GLOBALS['TSFE']->page['tx_tp3businessview_injetionpoint'] != "" ? $GLOBALS['TSFE']->page['tx_tp3businessview_injetionpoint'] : '#content') ."').first().attr(\"id\",\"businessview-panorama-canvas\").wrapAll('<div id=\"businessview-canvas\" style=\"width:100%;height:100%;min-height:600px;\"></div>');</script>";
                $parameters["jsFooterLibs"] .='<script src="typo3conf/ext/tp3_businessview/Resources/Public/JavaScript/tp3_app.js"></script>';

                if($GLOBALS["TSFE"]->tmpl->setup["plugin."]["tp3_businessview."]["settings."]["loadApi"]){
                    $parameters["jsFooterFiles"] .='<script src="//maps.googleapis.com/maps/api/js?key='.$GLOBALS["TSFE"]->tmpl->setup["plugin."]["tp3_businessview."]["settings."]["googleMapsJavaScriptApiKey"].'&libraries=places&callback=tp3_app.initialize"></script>';
                }

                $parameters["CssFiles"] .='<style src="typo3conf/ext/tp3_businessview/Resources/Public/Css/Tp3App.css"></style>';
            }
            catch (Exception $e) {
             //   $message = $GLOBALS['LANG']->sL(self::LL_PATH . $e->getMessage());
             //   throw new \RuntimeException($message);
            }




        }
    }


    /**
     * @param array $businessview
     * @return string
     */
    public function JsonRenderer(array $businessview = [], array $panoramas = [], $settings = null)
    {
       if(!is_array($settings)){
           $settings = [
           "color"=>"#fff",
           "backgroundColor"=>"rgba(98, 98, 98, 0.8)",
           "textColor"=> "#fff",
           "align"=>"right",
               ];

       }
       if($businessview['panoAnimation'] != undefined && !is_array($businessview['panoAnimation'])) {
           $pano_animation = explode(",",$businessview['panoAnimation']);
           $businessview['pano_animation'] = array();
           foreach ($pano_animation as &$value) {
               $businessview['pano_animation'][$value] =  true;
           }
           unset($value);
       }
       else if($businessview['panoAnimation'] == undefined && $businessview['pano_animation'] != undefined && !is_array($businessview['pano_animation'])) {
           $pano_animation = explode(",",$businessview['pano_animation']);
           $businessview['pano_animation'] = array();
           foreach ($pano_animation as &$value) {
               $businessview['pano_animation'][$value] =  true;
           }
           unset($value);
       }
       else if(is_array($businessview['panoAnimation']))
       $businessview['pano_animation'] = $businessview['panoAnimation'];

        if($businessview['panoOptions'] != undefined && !is_array($businessview['panoOptions'])) {

            $pano_options = explode(",", $businessview['panoOptions']);
            $businessview['pano_options'] = array();
            foreach ($pano_options as &$value) {
                $businessview['pano_options'][$value] = true;
            }
            unset($value);
        }
        else  if($businessview['panoOptions'] == undefined  && $businessview['pano_options'] != undefined && !is_array($businessview['pano_options'])) {

            $pano_options = explode(",", $businessview['pano_options']);
            $businessview['pano_options'] = array();
            foreach ($pano_options as &$value) {
                $businessview['pano_options'][$value] = true;
            }
            unset($value);
        }
        else if(is_array($businessview['panoOptions']))
            $businessview['pano_options'] = $businessview['panoOptions'];

        $pano_array = [];
        foreach ($panoramas as $panorama ){
            $pano_array[] =  [ "id"=>$panorama["pano_id"],
                "areas"=>[],
                "infoPoints"=>[],
                "pano" => [
                    "heading"=>$panorama['heading'],
                    "panoId"=>$panorama['pano_id'],
                    "pitch"=>$panorama['pitch'],
                    "zoom"=>is_numeric($panorama['zoom']) ? $panorama['zoom'] : 0 ,
                ],
                "actions"=>[   ],
            ];
        };


        $json = json_encode([
            "details"=> [
                "actionOrder"=>[],
                "areaOrder"=>[],
                "editors"=>[],
                "googleMapsJavaScriptApiKey"=>$GLOBALS["TSFE"]->tmpl->setup["plugin."]["tp3_businessview."]["settings."]["googleMapsJavaScriptApiKey"],
                "legalNoticeUrl"=>"http://".urlencode($businessview['external_links'] != "" ? $businessview['external_links'] : $businessview['externalLinks']),
                "location"=>["formattedAddress"=>$businessview['contact']['address'].", ".$businessview['contact']['zip'] ." " .$businessview['contact']['city'] .",".$businessview['contact']['country'],"position"=>["latitude"=>$businessview['contact']['latitude'],"longitude"=>$businessview['contact']['longitude']]],
                "createdBy"=>["name"=>($businessview['created_by'] != "" ? $businessview['created_by'] : $businessview['createdBy']) .",".urlencode($businessview['external_links'] != "" ? $businessview['external_links'] : $businessview['externalLinks']),"status"=>true],
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
                        "color"=>$GLOBALS["TSFE"]->tmpl->setup["plugin."]["tp3_businessview."]["settings."]["color"] != null ? $GLOBALS["TSFE"]->tmpl->setup["plugin."]["tp3_businessview."]["settings."]["color"] : $settings["color"],
                        "backgroundColor"=>$GLOBALS["TSFE"]->tmpl->setup["plugin."]["tp3_businessview."]["settings."]["backgroundColor"] != null ? $GLOBALS["TSFE"]->tmpl->setup["plugin."]["tp3_businessview."]["settings."]["backgroundColor"] : $settings["backgroundColor"],
                        "textColor"=>$GLOBALS["TSFE"]->tmpl->setup["plugin."]["tp3_businessview."]["settings."]["textColor"]  != null ? $GLOBALS["TSFE"]->tmpl->setup["plugin."]["tp3_businessview."]["settings."]["textColor"] : $settings["textColor"],
                        "align"=>$GLOBALS["TSFE"]->tmpl->setup["plugin."]["tp3_businessview."]["settings."]["align"] != null ? $GLOBALS["TSFE"]->tmpl->setup["plugin."]["tp3_businessview."]["settings."]["align"] : $settings["align"],

                    ],
                    "custom"=>[],
                        "externalLinks"=> ["status"=>true,"align"=>$GLOBALS["TSFE"]->tmpl->setup["plugin."]["tp3_businessview."]["settings."]["alignSocial"] != "" ? $GLOBALS["TSFE"]->tmpl->setup["plugin."]["tp3_businessview."]["settings."]["alignSocial"] : "left","links"=>[
                            ["icon"=>"fa-twitter","url"=>"https://twitter.com".$businessview['contact']['twitter']."/","target"=>false,"visible"=>($businessview['contact']['twitter'] !="" && ( $businessview['social_gallery'] ||  $businessview['socialGallery'] )? true : false)],
                            ["icon"=>"fa-facebook","url"=>"https://www.facebook.com/".$businessview['contact']['facebook']."","target"=>false,"visible"=>($businessview['contact']['facebook'] !="" && ( $businessview['social_gallery'] ||  $businessview['socialGallery'] ) ? true : false)],
                            ["icon"=>"fa-google-plus","url"=>"https://plus.google.com/".$businessview['contact']['googleplus']."/about","target"=>false,"visible"=>($businessview['contact']['googleplus'] !="" && ( $businessview['social_gallery'] ||  $businessview['socialGallery'] ) ? true : false)
                            ]
                        ]
                    ],
                    "gallery"=>[],
                     "intro"=>[
                         "headline"=>$businessview['name'],"message"=> $businessview['description'] != null ? htmlentities($businessview['description']) : '',
                         "backgroundColor"=>$GLOBALS["TSFE"]->tmpl->setup["plugin."]["tp3_businessview."]["settings."]["backgroundColor"] != null ? $GLOBALS["TSFE"]->tmpl->setup["plugin."]["tp3_businessview."]["settings."]["backgroundColor"] : $settings["backgroundColor"],
                         "textColor"=>$GLOBALS["TSFE"]->tmpl->setup["plugin."]["tp3_businessview."]["settings."]["textColor"]  != null ? $GLOBALS["TSFE"]->tmpl->setup["plugin."]["tp3_businessview."]["settings."]["textColor"] : $settings["textColor"],
                         "status"=>$businessview['intro']
                     ],
                    "openingHours"=> $businessview['openingHours'],
                    "opentable"=>[],
                    "panoAnimation"=>["jumps"=>$businessview['pano_animation']['jumps'] ? true : false ,"rotation"=>$businessview['pano_animation']['rotation'] ? true : false],
                    "socialGallery"=> $businessview['social_gallery']

                ],
                "name"=>$businessview['title'],
                "panoEntry"=>[
                    "heading"=>$businessview['panorama']['heading'],
                    "panoId"=>$businessview['panorama']['pano_id'],
                    "pitch"=>$businessview['panorama']['pitch'],
                    "zoom"=>is_numeric($businessview['panorama']['zoom']) ? $businessview['panorama']['zoom'] : 0 ,
                ],
                "panoOptions"=>[
                    "addressControl"=>$businessview['pano_options']['addressControl'] ? true : false ,
                    "disableDefaultUI"=>$businessview['pano_options']['disableDefaultUI'] ? true : false ,
                    "panControl"=>$businessview['pano_options']['panControl'] ? true : false ,
                    "scaleControl"=>$businessview['pano_options']['scaleControl'] ? true : false ,
                    "scrollwheel"=>$businessview['pano_options']['scrollwheel'] ? true : false ,
                    "zoomControl"=>$businessview['pano_options']['zoomControl'] ? true : false ,
                    "fullScreen"=>$businessview['pano_options']['fullScreen'] ? true : false ,
                ],
                "panoramas"=>$pano_array,
                "type"=>"businessview",
            ],
            "hasDetails"=>true
        ]);//JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE
        return $json;
    }
}
