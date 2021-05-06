<?php

/*
 * This file is part of the web-tp3/tp3businessview.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3Businessview\Domain\Model;

use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * A file object (File Abstraction Layer)
 *
 * @internal experimental! This class is experimental and subject to change!
 */
class File extends \TYPO3\CMS\Extbase\Domain\Model\AbstractFileFolder
{
    /**
     * @return \TYPO3\CMS\Core\Resource\File
     */
    public function getOriginalResource()
    {
        if ($this->originalResource === null) {
            $this->originalResource = GeneralUtility::makeInstance(ResourceFactory::class)->getFileObject($this->getUid());
        }

        return $this->originalResource;
    }
}
