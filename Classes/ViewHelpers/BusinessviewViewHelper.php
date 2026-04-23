<?php

/*
 * This file is part of the package tna/sitepack.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3Businessview\ViewHelpers;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\ParameterType;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * will return certain system categories (sys_category) data of an element
 * either as an array or as a string with certain parameters
 *
 * EXAMPLES:
 *
 * EMBEDDING IN TEMPLATE: {namespace jb = Tp3\Sitepack\ViewHelpers}
 *
 * call an array with all category data to be used in a loop, e.g. for an HTML tag for each category:
 *    <f:if condition="{data.categories}">
 *        <f:for each="{my:CategoriesOutput(recUid: data.uid)}" as="category">
 *            <span class="{category.slug}">{category.title}</span>
 *        </f:for>
 *    </f:if>
 *
 * call a “data-categories” attribute with the slug field of the categories, comma-separated (default):
 *     {my:CategoriesOutput(recUid: data.uid, fieldString: 'slug', htmlAttr: 'data-categories')}
 *     output: ' data-categories="catx,caty"'
 *
 * call all categories as CSS classes (space as string separator, prefix 'cat-' for each category)
 *     {my:CategoriesOutput(recUid: data.uid, fieldString: 'slug', stringSeparator: ' ', catPrefix: 'cat-')}
 *     output: 'cat-catx cat-caty'
 */
class BusinessviewViewHelper extends AbstractViewHelper
{
    protected $escapeOutput = false;

    public function initializeArguments(): void
    {
        $this->registerArgument('uid', 'integer', 'record UID, content element', true);
        $this->registerArgument('model', 'string', 'businessvie or Pano', true);

    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function render(): mixed
    {
        $uid = $this->arguments['uid'];
        $model = $this->arguments['model'];

        /**
         * default query for sys_category table
         */
        if($model === 'businessview'){
            $table = 'tx_tp3businessview_domain_model_tp3businessview';
        }else{
            $table = 'tx_tp3businessview_domain_model_panoramas';
        }
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);

        /**
         * select the fields that will be returned, use asterisk for all
         */
        $queryBuilder->select('*');
        $queryBuilder->from($table);
        $queryBuilder->where(
            $queryBuilder->expr()->eq($table.'.uid', $queryBuilder->createNamedParameter($uid, ParameterType::INTEGER))
        );

        $result = $queryBuilder->executeQuery();
        $res = [];
        $returnString = '';
        $i = 0;
        while ($row = $result->fetchAssociative()) {
            $res[$i] = $row;
            $i++;
        }

        if (!empty($res)) {
            $addressData = $res[0];

            // Get image files if they exist
//            if (!empty($addressData['image'])) {
//                $fileRepository = GeneralUtility::makeInstance(FileRepository::class);
//                $fileObjects = $fileRepository->findByRelation('tt_address', 'image', $uid);
//
//                if (!empty($fileObjects)) {
//                    $addressData['image'] = $fileObjects;
//                }
//            }

            return $addressData;
        } else {
            return '';
        }
    }
}
