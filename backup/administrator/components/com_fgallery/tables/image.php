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
 * Image Table class
 */
class FGalleryTableImage extends JTable
{
	var $id               = null; 
	var $title 	      = null;
	var $description      = null;
	var $type             = null;
	var $size             = null;
	var $path             = null;
	var $preview_path     = null;
	var $folder           = 0;
	var $parent           = 0;
	var $checked_out      = 0;
	var $checked_out_time = 0;
	var $modified         = 0;
	var $modified_by      = 0;
	var $created          = 0;

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function __construct(&$db) 
	{
		parent::__construct('#__fgallery_images', 'id', $db);
	}

	function bind($array, $ignore = '') {
		if (isset($array['path'])) {
			$array['path'] = '/'.$array['path'];
			$array['path'] = str_replace('//','/',$array['path']);
		}
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
		$date	= JFactory::getDate();
		$user	= JFactory::getUser();
		if ($this->id) {
			// Existing item
			$this->modified		= $date->toMySQL();
			$this->modified_by	= $user->get('id');
			} else {
			// New image. An image created and created_by field can be set by the user,
			// so we don't touch either of these if they are set.
			if (!intval($this->created)) {
				$this->created = $date->toMySQL();
			}
			if ($this->folder == 0) {
				if ($this->size == '')
				$file = getimagesize($_SERVER['DOCUMENT_ROOT'].$this->path);
				if ($this->type == '') $this->type = $file['mime'];
			}
		}
		// Attempt to store the user data.
		return parent::store($updateNulls);
	}
}
