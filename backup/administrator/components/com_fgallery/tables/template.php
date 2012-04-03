<?php
/*------------------------------------------------------------------------
# 1 Flash Gallery extension for Joomla!
# ------------------------------------------------------------------------
# author 1extension.com
# copyright Copyright (C) 2010-2011 1extension.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://1extension.com
# Technical Support:  Forum - http://1extension.com/faq.html
-------------------------------------------------------------------------*/
// No direct access
defined('_JEXEC') or die('Restricted access');
 
// import Joomla table library
jimport('joomla.database.table');
jimport('joomla.filter.input');
 
/**
 * Gallery Templates Table class
 */
class FGalleryTableTemplate extends JTable
{
    var $id                = null;
    var $gall_type         = 3;
    var $gall_settings     = '';
    var $created           = null;
    var $templ_title       = '';
    var $templ_description = null;
    
    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function __construct(&$db) 
    {
        parent::__construct('#__fgallery_templates', 'id', $db);
    }

    function bind($array, $ignore = '') {
        return parent::bind($array, $ignore);
    }

    /**
     * Overload the store method for the Templates table.
     *
     * @param	boolean	Toggle whether null values should be updated.
     * @return	boolean	True on success, false on failure.
     * @since	1.6
     */
    public function store($updateNulls = false)
    {
        $date	= JFactory::getDate();
        $this->created = $date->toMySQL();

        // Attempt to store the user data.
        return parent::store($updateNulls);
    }
}
