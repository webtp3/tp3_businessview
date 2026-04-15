<?php
declare(strict_types=1);

namespace Tp3\Tp3Businessview\Domain\Model\Dto;

/*
 * This file is part of the "tt_address" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class Settings
{
    protected string $googleMapsJavaScriptApiKey = '';
    /** @var string */
    protected string $telephoneValidationPatternForPhp = '/[^\d\+\s\-]/';

    /** @var string */
    protected string $telephoneValidationPatternForJs = '/[^\d\+\s\-]/g';

    /** @var bool */
    protected bool $newPagination = false;

    public function __construct()
    {
        $settings = $this->getSettings();

        if (!empty($settings)) {
            $this->newPagination = (bool)($settings['newPagination'] ?? false);
            if ($settings['googleMapsJavaScriptApiKey'] ?? '') {
                $this->googleMapsJavaScriptApiKey = (string)$settings['googleMapsJavaScriptApiKey'];
            }
            if ($settings['telephoneValidationPatternForPhp'] ?? '') {
                $this->telephoneValidationPatternForPhp = (string)$settings['telephoneValidationPatternForPhp'];
            }
            if ($settings['telephoneValidationPatternForJs'] ?? '') {
                $this->telephoneValidationPatternForJs = (string)$settings['telephoneValidationPatternForJs'];
            }
        }
    }

    public function getTelephoneValidationPatternForPhp(): string
    {
        return $this->telephoneValidationPatternForPhp;
    }

    public function getTelephoneValidationPatternForJs(): string
    {
        return $this->telephoneValidationPatternForJs;
    }

    protected function getSettings(): array
    {
        try {
            return GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('tp3_businessview', '');
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getGoogleMapsJavaScriptApiKey(): string
    {
        return $this->googleMapsJavaScriptApiKey;
    }
}
