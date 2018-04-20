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

class MatrixFinderPlugin extends BasePlugin
{
    /**
     * @return mixed
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @return mixed
     */
    public function getName()
    {
         return Craft::t('Matrix Finder');
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return Craft::t('A Craft CMS plugin for determining which entries are using which matrix block types');
    }

    /**
     * @return string
     */
    public function getDocumentationUrl()
    {
        return 'https://github.com/digitalsurgeons/matrixfinder/blob/master/README.md';
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return '0.2.0';
    }

    /**
     * @return string
     */
    public function getSchemaVersion()
    {
        return '0.2.0';
    }

    /**
     * @return string
     */
    public function getDeveloper()
    {
        return 'Digital Surgeons';
    }

    /**
     * @return string
     */
    public function getDeveloperUrl()
    {
        return 'https://www.digitalsurgeons.com';
    }

    /**
     * @return bool
     */
    public function hasCpSection()
    {
        return true;
    }
}
