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
        $this->renderTemplate('matrixfinder/index');
    }

    public function actionGetMatrixFields()
    {
        $fields = craft()->matrixFinder->matrixFields();
        $this->returnJson(['matrixFields' => $fields]);
    }

    public function actionGetMatrixBlockTypesByField()
    {
        $fieldId = craft()->request->getParam('fieldId');
        $this->returnJson([
            'matrixBlockTypes' => craft()->matrixFinder->blockTypesByMatrixFieldId($fieldId)
        ]);
    }

    public function actionGetEntriesUsingMatrixBlockType()
    {
        $blockTypeId = craft()->request->getParam('matrixBlockTypeId');
        $this->returnJson([
            'entries' => craft()->matrixFinder->entriesUsingBlockType($blockTypeId)
        ]);
    }
}
