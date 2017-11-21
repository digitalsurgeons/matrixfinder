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
            'blockTypes' => craft()->matrixFinder->blockTypes(),
            'entries' => null,
            'selectedBlockTypeId' => null
        ]);
    }

    public function actionHandleSubmit()
    {
        $this->requirePostRequest();
        $blockTypeId = craft()->request->getRequiredPost('blockType');
        $entries = craft()->matrixFinder->entriesUsingBlockType($blockTypeId);
        $this->renderTemplate('matrixfinder/index', [
            'blockTypes' => craft()->matrixFinder->blockTypes(),
            'entries' => $entries,
            'selectedBlockTypeId' => $blockTypeId
        ]);
    }
}
