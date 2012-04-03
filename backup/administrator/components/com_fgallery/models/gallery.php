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
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.model');
 
/**
 * Gallery Model
 */
class FGalleryModelGallery extends JModel
{
	function __construct() {
		parent::__construct();	
		$array = JRequest::getVar('id',  0, '', 'array');
		if ($array[0] == 0) {
			$post = JRequest::getVar('post');
			$array  = JRequest::getVar('cid', array(0), 'post', 'array' );
		}
		$this->setId((int)$array[0]);
	}

	function setId($id) {
		$this->_id	= $id;
		$this->_data	= null;
	}

	function &getData() {
		if ($this->_loadData()) {
			
		} else {
			$this->_initData();
		}
		return $this->_data;
	}
	
	function isCheckedOut( $uid=0 ) {
		if ($this->_loadData()) {
			if ($uid) {
				return ($this->_data->checked_out && $this->_data->checked_out != $uid);
			} else {
				return $this->_data->checked_out;
			}
		}
	}

	function checkin() {
		if ($this->_id) {
			$fgallery = & $this->getTable('gallery','FGalleryTable');
			if(! $fgalery->checkin($this->_id)) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return false;
	}

	function checkout($uid = null) {
		if ($this->_id) {
			// Make sure we have a user id to checkout the article with
			if (is_null($uid)) {
				$user	=& JFactory::getUser();
				$uid	= $user->get('id');
			}
			// Lets get to it and checkout the thing...
			$fgallery = & $this->getTable('gallery','FGalleryTable');
			if(!$fgallery->checkout($uid, $this->_id)) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
			return true;
		}
		return false;
	}
	
	function move($direction) {
		$row =& $this->getTable('Gallery','FGalleryTable');
		if (!$row->load($this->_id)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}		
		if (!$row->move( $direction )) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		return true;
	}


	function _loadData() {
		// Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
			$query = 'SELECT * '.
					' FROM #__fgallery_galleries' .
					' WHERE id = '.(int) $this->_id;
			$this->_db->setQuery($query);
			$this->_data = $this->_db->loadObject();
			return (boolean) $this->_data;
		}
		return true;
	}
	
	function _initData() {

		if (empty($this->_data)) {
			$fgallery = new stdClass();
			$fgallery->id				= 0;
			$fgallery->title			= null;
			$fgallery->desctipion		= null;
			$fgallery->cover			= 0;
			$fgallery->state			= 1;
			$fgallery->created			= 0;
			$fgallery->created_by		= 0;			
			$fgallery->modified			= 0;
			$fgallery->modified_by		= 0;
			$fgallery->checked_out		= 0;
			$fgallery->checked_out_time	= 0;
			$fgallery->publish_up		= 0;
			$fgallery->publish_down 	= 0;
			$fgallery->gall_width       = 450;
			$fgallery->gall_height      = 385;
			$fgallery->gall_bgcolor     = 'ffffff';
			$fgallery->gall_type 		= 3;
			$fgallery->ordering			= 0;
			$this->_data				= $fgallery;
			return (boolean) $this->_data;
		}
		return true;
	}	
		
        
}
