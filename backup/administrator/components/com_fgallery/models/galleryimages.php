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
// import the Joomla modellist library
jimport('joomla.application.component.model');
/**
 * Gallery Images List Model
 */
class FGalleryModelGalleryImages extends JModel
{
	var $_context = 'com_fgallery.galleryimages';
	function __construct(){
	
		require_once JPATH_COMPONENT.'/helpers/fgallery.php';
		
		parent::__construct();
		
		global $mainframe;
		
		$search = $mainframe->getUserStateFromRequest($this->_context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$access = $mainframe->getUserStateFromRequest($this->_context.'.filter.access', 'filter_access', 0, 'int');
		$this->setState('filter.access', $access);
		
		// Get the pagination request variables
		$limit	= $mainframe->getUserStateFromRequest( $this->_context.'.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart	= $mainframe->getUserStateFromRequest( $this->_context.'.limitstart', 'limitstart', 0, 'int' );

		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);	
	}
        

	
	function getTotal() {
		if (empty($this->_total)) {
			$query = $this->_buildQuery();
			$this->_total = $this->_getListCount($query);
		}
		return $this->_total;
	}
	
	function getPagination() {
		if (empty($this->_pagination)) {
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}
		return $this->_pagination;
	}
	
	function getData() {
		if (empty($this->_data)) {
			$query = $this->_buildQuery();
			$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
		}		
		return $this->_data;
	}
        	
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return      string  An SQL query
	 */
	protected function _buildQuery()
	{
		$gall_id = JRequest::getVar('id',0);
		if (!is_numeric($gall_id)) {
			jexit('Invaild Gallery ID');
		}
		$album = JRequest::getVar('album');
		if (!is_numeric($album)) $album = 0;
		// Create a new query object.         
		$db = JFactory::getDBO();
		// Select some fields
		$query = ' SELECT a.*, b.* '.
		// From the gallery table
                         ' FROM #__fgallery_images as a '.
                         ' LEFT JOIN #__fgallery_gallery_images as b ON (a.id = b.img_id)'.
                         ' WHERE b.gall_id = '.$gall_id.
                         ' AND b.gall_folder = '.$album.
                        // Add the list ordering clause.
                         ' ORDER BY a.folder DESC, b.ordering';
		return $query;
	}
				
}
