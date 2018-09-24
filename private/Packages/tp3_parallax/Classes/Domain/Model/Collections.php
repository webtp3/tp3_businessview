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
class Collections extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * parallaxsection
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Tp3\Tp3Parallax\Domain\Model\Section>
     * @cascade remove
     */
    protected $parallaxsection = null;

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
        $this->parallaxsection = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Adds a Section
     *
     * @param \Tp3\Tp3Parallax\Domain\Model\Section $parallaxsection
     * @return void
     */
    public function addParallaxsection(\Tp3\Tp3Parallax\Domain\Model\Section $parallaxsection)
    {
        $this->parallaxsection->attach($parallaxsection);
    }

    /**
     * Removes a Section
     *
     * @param \Tp3\Tp3Parallax\Domain\Model\Section $parallaxsectionToRemove The Section to be removed
     * @return void
     */
    public function removeParallaxsection(\Tp3\Tp3Parallax\Domain\Model\Section $parallaxsectionToRemove)
    {
        $this->parallaxsection->detach($parallaxsectionToRemove);
    }

    /**
     * Returns the parallaxsection
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Tp3\Tp3Parallax\Domain\Model\Section> $parallaxsection
     */
    public function getParallaxsection()
    {
        return $this->parallaxsection;
    }

    /**
     * Sets the parallaxsection
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Tp3\Tp3Parallax\Domain\Model\Section> $parallaxsection
     * @return void
     */
    public function setParallaxsection(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $parallaxsection)
    {
        $this->parallaxsection = $parallaxsection;
    }
}
