<?php
/*------------------------------------------------------------------------
# 1 Flash Gallery extension for Joomla!
# ------------------------------------------------------------------------
# author 1extension.com
# copyright Copyright (C) 2010-2011 1extension.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://1extension.com.com
# Technical Support:  Forum - http://1extension.com/faq.html
-------------------------------------------------------------------------*/
// No direct access
defined('_JEXEC') or die('Restricted access');
 
// import Joomla table library
jimport('joomla.database.table');
jimport('joomla.filter.input');
 
/**
 * Gallery images Table class
 */
class FGalleryTableRelations extends JTable
{
	var $img_id  	  = null;
	var $gall_id	  = null;
	var $gall_folder  = 0;
	var $ordering	  = 0;
	var $img_url      = null;
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function __construct(&$db) 
	{
		parent::__construct('#__fgallery_gallery_images', 'img_id, gall_id', $db);
	}
	
	function bind($array, $ignore = '') {
		return parent::bind($array, $ignore);
	}

	/**
	 * Overload the store method for the Images table.
	 *
	 * @param	boolean	Toggle whether null values should be updated.
	 * @return	boolean	True on success, false on failure.
	 * @since	1.6
	 */
	public function store($updateNulls = false)
	{
		if (!isset($this->gall_folder))
		$this->gall_folder = 0;
		
		// Attempt to store the user data.
		return parent::store($updateNulls);
	}
}
