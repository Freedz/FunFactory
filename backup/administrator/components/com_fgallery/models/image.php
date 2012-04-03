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
 
/**
 * Image Model
 */
class FGalleryModelImage extends JModel
{
	function __construct() {
		parent::__construct();
		$array = JRequest::getVar('cid',  0, '', 'array');
		$this->setId((int)$array[0]);
	}

	function setId($id) {
		$this->_id				= $id;
		$this->_data			= null;
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
			$fgallery = & $this->getTable('Image', 'FGalleryTable');
			if(! $fgallery->checkin($this->_id)) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return false;
	}
	
	function checkout($uid = null) {
		if ($this->_id) {
			// Make sure we have a user id to checkout the image with
			if (is_null($uid)) {
				$user	=& JFactory::getUser();
				$uid	= $user->get('id');
			}
			// Lets get to it and checkout the thing...
			$fgallery = & $this->getTable('Images', 'FGalleryTable');
			if(!$fgallery->checkout($uid, $this->_id)) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
			return true;
		}
		return false;
	}
	
	function delete($cid = array()) {
		if (count( $cid )) {
			JArrayHelper::toInteger($cid);
			$cids = implode( ',', $cid );

			$query = 'DELETE FROM #__fgallery_images'
				   . ' WHERE id IN ( '.$cids.' )';
			$this->_db->setQuery( $query );
			if(!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return true;
	}
	
	function _loadData() {
		// Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
			$query = 'SELECT *'.
					' FROM #__fgallery_images' .
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
			$fgallery->desciption                   = null;
			$fgallery->type				= null;
			$fgallery->path				= null;
			$fgallery->preview_path			= null;
			$fgallery->size				= 0;
			$fgallery->checked_out		= 0;
			$fgallery->checked_out_time	= 0;
			$fgallery->modified			= 0;
			$fgallery->modified_by		= 0;
			$fgallery->parent			= 0;
			$fgallery->folder			= 0;
			$fgallery->created 			= 0;
			$this->_data				= $fgallery;
			return (boolean) $this->_data;
		}
		return true;
	}
}
