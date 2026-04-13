<?php

namespace Tp3\Tp3Businessview\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;

class ModuleController
{
    public function __construct(
        private readonly ModuleTemplateFactory $moduleTemplateFactory
    ) {}

    public function indexAction(ServerRequestInterface $request): ResponseInterface
    {
        $moduleTemplate = $this->moduleTemplateFactory->create($request);

        return $moduleTemplate->renderResponse('Module/Index');
    }
}
