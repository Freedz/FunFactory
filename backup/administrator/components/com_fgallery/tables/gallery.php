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
 * Gallery Table class
 */
class FGalleryTableGallery extends JTable
{
	var $id				= null;
	var $title			= null;
	var $description		= null;
	var $cover 			= 0;
	var $state			= 0;
	var $created			= 0;
	var $created_by		= 0;
	var $modified 		= 0;
	var $modified_by 		= 0;
	var $checked_out 		= 0;
	var $checked_out_time = 0;
	var $publish_up 		= 0;
	var $publish_down 	= 0;
	var $gall_width 		= 450;
	var $gall_height 		= 385;
	var $gall_bgcolor 	= 'ffffff';
	var $gall_type 		= 3;
	var $ordering 		= 0;
  
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function __construct(&$db) 
	{
		parent::__construct('#__fgallery_galleries', 'id', $db);
	}
	
	public function bind($array, $ignore='') {
		if (isset($array['gall_bgcolor'])) $array['gall_bgcolor'] = str_replace('#','',$array['gall_bgcolor']);
		return parent::bind($array, $ignore);
	}
	/**
	 * Overload the store method for the Gallery table.
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
				$this->created_by = $user->get('id');
			}
		}
		// Attempt to store the user data.
		return parent::store($updateNulls);
	}		
}
