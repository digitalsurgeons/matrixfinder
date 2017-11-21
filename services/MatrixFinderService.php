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

class MatrixFinderService extends BaseApplicationComponent
{
    public function blockTypes()
    {
        return craft()->db->createCommand()
            ->select('id, name')
            ->from('matrixblocktypes')
            ->queryAll();
    }

    public function entriesUsingBlockType($blockTypeId)
    {
        $query = craft()->db->createCommand()
            ->selectDistinct('ownerId')
            ->from('matrixblocks')
            ->where(['typeId' => $blockTypeId])
            ->queryAll();

        $criteria = craft()->elements->getCriteria(ElementType::Entry);
        $criteria->id = array_map(function($row) {
            return $row['ownerId'];
        }, $query);
        $criteria->order = 'title ASC';

        return $criteria->find();
    }
}
