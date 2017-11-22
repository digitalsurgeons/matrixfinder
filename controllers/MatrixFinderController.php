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
        $fieldId = craft()->request->getParam('field');
        $blockTypeId = craft()->request->getParam('blockType');
        $field = $fieldId ? craft()->fields->getFieldById($fieldId) : null;
        $blockType = $blockTypeId ? craft()->matrixFinder->blockTypeById($blockTypeId) : null;
        $entries = $blockType ? craft()->matrixFinder->entriesUsingBlockType($blockTypeId) : [];

        $this->renderTemplate('matrixfinder/index', [
            'selectedField' => $field,
            'selectedBlockType' => $blockType,
            'entries' => $entries,
            'matrixFields' => craft()->matrixFinder->matrixFields(),
            'blockTypes' => craft()->matrixFinder->blockTypes($fieldId)
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
        $this->returnJson([
            'entries' => craft()->matrixFinder->entriesUsingBlockType($blockTypeId)
        ]);
    }
}
