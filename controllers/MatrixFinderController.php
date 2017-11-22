<?php
/**
 * MatrixFinder plugin for Craft CMS
 *
 * Find which entries are using a matrix block type
 *
 * @author    Digital Surgeons
 * @copyright Copyright (c) 2017 Digital Surgeons
 * @link      https://www.digitalsurgeons.com
 * @package   MatrixFinder
 * @since     0.0.1
 */

namespace Craft;

class MatrixFinderController extends BaseController
{
    public function actionIndex()
    {
        $this->renderTemplate('matrixfinder/index', [
            'matrixFields' => craft()->matrixFinder->matrixFields(),
            'blockTypes' => craft()->matrixFinder->blockTypes(),
        ]);
    }

    public function actionGetBlockTypesForMatrixField()
    {
        $fieldId = craft()->request->getParam('fieldId');
        $this->returnJson(['blockTypes' => craft()->matrixFinder->blockTypesByMatrixFieldId($fieldId)]);
    }

    public function actionGetEntriesForBlockType()
    {
        $blockTypeId = craft()->request->getParam('blockType');
        $fieldId = craft()->request->getParam('fieldId');
        $entries = craft()->matrixFinder->entriesUsingBlockType($blockTypeId, $fieldId);
        $this->returnJson(['entries' => array_map(function ($entry) {
            return [
                'title' => $entry->title,
                'url' => $entry->url,
                'editUrl' => $entry->getCpEditUrl()
            ];
        }, $entries)]);
    }
}
