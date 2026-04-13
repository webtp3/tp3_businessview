<?php

/*
 * This file is part of the package web-tp3/tp3-businessview.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3Businessview\Controller;

use TYPO3\CMS\Backend\View\BackendViewFactory;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ModuleController extends ActionController
{
    protected ModuleTemplate $moduleTemplate;

    public function __construct(
        private readonly BackendViewFactory $backendViewFactory
    ) {}

    protected function initializeAction(): void
    {
        parent::initializeAction();
        $this->moduleTemplate = $this->backendViewFactory->create($this->request);
    }
}
