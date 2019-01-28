<?php
namespace Tp3\Tp3Parallax\Frontend\PageRenderer;

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use Tp3\Tp3mods\Domain\Repository\Tp3AdressRepository;
use Tp3\Tp3Parallax\Domain\Repository\CollectionsRepository;


class Tp3PageRenderer implements SingletonInterface
{
    /**
     * tp3AdressRepository
     *
     * @var \Tp3\Tp3Parallax\Domain\Repository\CollectionsRepository
     * @inject
     */
    protected $CollectionsRepository = null;

    /**


    /**
     * @param array $parameters
     * @param PageRenderer $pageRenderer
     * @return string
     */
    public function render($parameters, &$pageRenderer)
    {
        if(!is_array($parameters))return;
        $config = isset($GLOBALS['TSFE']->tmpl->setup) ? $GLOBALS['TSFE']->tmpl->setup : [];
        if (is_array($config)
            && (int)$GLOBALS['TSFE']->page['page_parallax'] > 0
            && $GLOBALS['TSFE']->cObj instanceof ContentObjectRenderer
        ) {

            if ($this->objectManager === null) {
                $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
            }


            if ($this->CollectionsRepository === null) {
                $this->CollectionsRepository = $this->objectManager->get(CollectionsRepository::class);


            }
            $page_parallax = $this->CollectionsRepository->findByUid($GLOBALS['TSFE']->page['page_parallax']);

            try{

              if(is_array($page_parallax))  $parameters["jsInline"] .='<script> '.$this->JsonRenderer($page_parallax).'</script>';

            }
            catch (Exception $e) {
                //   $message = $GLOBALS['LANG']->sL(self::LL_PATH . $e->getMessage());
                //   throw new \RuntimeException($message);
            }




        }


    }

    /**
     * @param array $microdata, array $settings
     * @return string
     */
    public function JsonRenderer(array $parallax = [], $settings = null)
    {

        $json =  $parallax; 

        return $json;
    }
}
