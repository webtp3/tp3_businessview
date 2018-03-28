<?php
namespace Tp3\Tp3Businessview\Frontend\PageRenderer;

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use Tp3\Tp3Businessview\Domain\Repository\Tp3BusinessViewRepository;


class Tp3PageRenderer implements SingletonInterface
{
    /**
     *
     * @var \Tp3\Tp3Businessview\Domain\Repository\Tp3BusinessViewRepository;
     */
    public  $tp3businessviewrepository = null;

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
            $businessview = $this->tp3businessviewrepository->findByPid($GLOBALS["TSFE"]->page["uid"]);
        }
    }

    /**
     * @return array
     */
    protected function getYoastTagsTypoScript()
    {
        return $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_tp3businessview.']['view.']['variables.'] ?: [];
    }

    /**
     * @param string $tag
     * @param array $config
     * @return string
     */
    public function getTagToRender($tag, array $config = [])
    {
        if (empty($config)) {
            $config = $this->getYoastTagsTypoScript();
        }

        return (string)$GLOBALS['TSFE']->cObj->cObjGetSingle($config[$tag], $config[$tag . '.']);
    }

    /**
     * @param array $config
     * @return array
     */
    public function getUniqueTagsFromConfig(array $config = [])
    {
        if (empty($config)) {
            $config = $this->getYoastTagsTypoScript();
        }
        $tags = array_filter(
            $config,
            function ($k) {
                if (preg_match('/\.+$/', $k)) {
                    return false;
                }
                return true;
            },
            ARRAY_FILTER_USE_KEY
        );

        return $tags;
    }
}
