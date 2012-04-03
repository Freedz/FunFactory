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
 * Gallery Settings class
 */
class FGalleryTableSettings extends JTable
{
	var $id        = null;
	var $gall_id   = null;
	var $value	   = null;
	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function __construct(&$db) 
	{
		parent::__construct('#__fgallery_gallery_settings', 'id', $db);
	}
	
	function bind($array, $ignore = '') {
		return parent::bind($array, $ignore);
	}
	
	public function store($updateNulls = false)
	{
		// Attempt to store the user data.
		return parent::store($updateNulls);
	}
}
