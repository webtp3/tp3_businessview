<?php

declare(strict_types=1);

/*
 * This file is part of the package web-tp3/tp3-businessview.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Security\ContentSecurityPolicy\Directive;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\Mutation;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\MutationCollection;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\MutationMode;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\Scope;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\SourceScheme;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\UriValue;
use TYPO3\CMS\Core\Type\Map;

return Map::fromEntries(
    [
        Scope::backend(),
        new MutationCollection(
            new Mutation(MutationMode::Extend, Directive::ImgSrc, SourceScheme::data, new UriValue('https://*.openstreetmap.org')),
            new Mutation(MutationMode::Extend, Directive::ScriptSrc, SourceScheme::data, new UriValue('https://*.openstreetmap.org')),
            new Mutation(MutationMode::Extend, Directive::ConnectSrc, SourceScheme::data, new UriValue('https://*.openstreetmap.org')),
            new Mutation(MutationMode::Extend, Directive::ImgSrc, new UriValue('https://*.ytimg.com')),
            new Mutation(MutationMode::Extend, Directive::ScriptSrc, new UriValue('https://*.ytimg.com')),
            new Mutation(MutationMode::Extend, Directive::ConnectSrc, new UriValue('https://*.ytimg.com')),
            new Mutation(MutationMode::Extend, Directive::ScriptSrc, new UriValue('https://maps.googleapis.com')),
            new Mutation(MutationMode::Extend, Directive::ScriptSrc, new UriValue('https://maps.google.com')),
            new Mutation(MutationMode::Extend, Directive::ScriptSrc, new UriValue('https://maps.gstatic.com')),
            new Mutation(MutationMode::Extend, Directive::ImgSrc, new UriValue('https://maps.gstatic.com')),
            new Mutation(MutationMode::Extend, Directive::ConnectSrc, new UriValue('https://maps.googleapis.com')),
            new Mutation(MutationMode::Extend, Directive::ConnectSrc, new UriValue('https://maps.gstatic.com')),
            new Mutation(MutationMode::Extend, Directive::ImgSrc, new UriValue('https://maps.googleapis.com')),
            new Mutation(MutationMode::Extend, Directive::ImgSrc, new UriValue('https://maps.gstatic.com')),
            new Mutation(MutationMode::Extend, Directive::ImgSrc, new UriValue('https://*.googleapis.com')),
            new Mutation(MutationMode::Extend, Directive::ImgSrc, new UriValue('https://*.ggpht.com')),
        )],
    [
            Scope::frontend(),
            new MutationCollection(
                new Mutation(MutationMode::Extend, Directive::ImgSrc, SourceScheme::data, new UriValue('https://*.openstreetmap.org')),
                new Mutation(MutationMode::Extend, Directive::ScriptSrc, SourceScheme::data, new UriValue('https://*.openstreetmap.org')),
                new Mutation(MutationMode::Extend, Directive::ConnectSrc, SourceScheme::data, new UriValue('https://*.openstreetmap.org')),
                new Mutation(MutationMode::Extend, Directive::ImgSrc, new UriValue('https://*.ytimg.com')),
                new Mutation(MutationMode::Extend, Directive::ScriptSrc, new UriValue('https://*.ytimg.com')),
                new Mutation(MutationMode::Extend, Directive::ConnectSrc, new UriValue('https://*.ytimg.com')),
                new Mutation(MutationMode::Extend, Directive::ScriptSrc, new UriValue('https://maps.googleapis.com')),
                new Mutation(MutationMode::Extend, Directive::ScriptSrc, new UriValue('https://maps.google.com')),
                new Mutation(MutationMode::Extend, Directive::ScriptSrc, new UriValue('https://maps.gstatic.com')),
                new Mutation(MutationMode::Extend, Directive::ImgSrc, new UriValue('https://maps.gstatic.com')),
                new Mutation(MutationMode::Extend, Directive::ConnectSrc, new UriValue('https://maps.googleapis.com')),
                new Mutation(MutationMode::Extend, Directive::ConnectSrc, new UriValue('https://maps.gstatic.com')),
                new Mutation(MutationMode::Extend, Directive::ImgSrc, new UriValue('https://maps.googleapis.com')),
                new Mutation(MutationMode::Extend, Directive::ImgSrc, new UriValue('https://maps.gstatic.com')),
            ),
        ]
);
