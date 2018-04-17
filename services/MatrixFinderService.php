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
    public function matrixFields()
    {
        return craft()->db->createCommand()
            ->select('id, name')
            ->from('fields')
            ->where(['type' => 'Matrix'])
            ->order('name ASC')
            ->queryAll();
    }

    public function blockTypes($fieldId = null)
    {
        return craft()->db->createCommand()
            ->select('id, name')
            ->where($fieldId ? ['fieldId' => $fieldId] : [])
            ->from('matrixblocktypes')
            ->order('name ASC')
            ->queryAll();
    }

    public function blockTypeById($blockTypeId = null)
    {
        return craft()->db->createCommand()
            ->select('id, name')
            ->where($blockTypeId ? ['id' => $blockTypeId] : [])
            ->from('matrixblocktypes')
            ->order('name ASC')
            ->queryRow();
    }

    public function blockTypesByMatrixFieldId($matrixFieldId)
    {
        return craft()->db->createCommand()
            ->select('id, name')
            ->from('matrixblocktypes')
            ->order('name ASC')
            ->where(['fieldId' => $matrixFieldId])
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
        $criteria->id = array_map(
            function($row) {
                return $row['ownerId'];
            },
            $query
        );
        $criteria->order = 'title ASC';

        $entries = $criteria->find();

        $groupedEntries = [];

        foreach ($entries as $entry) {
            $groupedEntries[$entry->section->name][] = [
                'title' => $entry->title,
                'url' => $entry->url,
                'editUrl' => $entry->getCpEditUrl()
            ];

        }

        return $groupedEntries;
    }
}
