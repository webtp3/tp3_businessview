<?php
namespace Tp3\Tp3Parallax\Domain\Model;

/***
 *
 * This file is part of the "tp3 Parallax" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Thomas Ruta <email@thomasruta.de>, tp3
 *
 ***/

/**
 * Collections
 */
class Collections extends \TYPO3\CMS\Core\Resource\Collection\StaticFileCollection
{
    /**
     * parallaxPage
     *
     * @var int
     */
    protected $parallaxPage = 0;

    /**
     * parallaxContent
     *
     * @var string
     */
    protected $parallaxContent = '';

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {

    }

    /**
     * Returns the parallaxPage
     *
     * @return int $parallaxPage
     */
    public function getParallaxPage()
    {
        return $this->parallaxPage;
    }

    /**
     * Sets the parallaxPage
     *
     * @param int $parallaxPage
     * @return void
     */
    public function setParallaxPage($parallaxPage)
    {
        $this->parallaxPage = $parallaxPage;
    }

    /**
     * Returns the parallaxContent
     *
     * @return string $parallaxContent
     */
    public function getParallaxContent()
    {
        return $this->parallaxContent;
    }

    /**
     * Sets the parallaxContent
     *
     * @param string $parallaxContent
     * @return void
     */
    public function setParallaxContent($parallaxContent)
    {
        $this->parallaxContent = $parallaxContent;
    }
}
