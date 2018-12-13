<?php
declare(strict_types=1);

/*
 * This file is part of the web-tp3/tp3mods.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3mods\ErrorHandling\Log;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 Helmut Hummel <info@helhum.io>
 *  All rights reserved
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the text file GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Maps sys log calls to logging framework
 */
class SysLogAdapter
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    private static $severityMap = [
        GeneralUtility::SYSLOG_SEVERITY_INFO => LogLevel::INFO,
        GeneralUtility::SYSLOG_SEVERITY_NOTICE => LogLevel::NOTICE,
        GeneralUtility::SYSLOG_SEVERITY_WARNING => LogLevel::WARNING,
        GeneralUtility::SYSLOG_SEVERITY_ERROR => LogLevel::ERROR,
        GeneralUtility::SYSLOG_SEVERITY_FATAL => LogLevel::CRITICAL,
    ];

    public function __construct(LoggerInterface $logger = null)
    {
        $this->logger = $logger ?: GeneralUtility::makeInstance(LogManager::class)->getLogger('Tp3.SysLogAdapter');
    }

    public function log(array $arguments)
    {
        $this->logger->log(self::$severityMap[$arguments['severity']], $arguments['msg'], ['extKey' => $arguments['extKey']]);
    }
}
