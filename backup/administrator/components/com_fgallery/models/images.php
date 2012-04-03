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
 * Images List Model
 */
class FGalleryModelImages extends JModel
{
	var $_data 			= null;
	var $_total 		= null;
	var $_pagination 	= null;
	var $_context		= 'com_fgallery.images';

	function __construct()
	{
		parent::__construct();

		global $mainframe, $option;		
		
		// Get the pagination request variables
		$limit	= $mainframe->getUserStateFromRequest( $this->_context.'.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart	= $mainframe->getUserStateFromRequest( $this->_context.'.limitstart', 'limitstart', 0, 'int' );

		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
	}
	
	function getData() {
		if (empty($this->_data)) {
			$query = $this->_buildQuery();
			$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
		}
		return $this->_data;	
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
	
	

	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return      string  An SQL query
	 */
	function _buildQuery()
	{
		$orderby	= $this->_buildOrderBy();
		
		$folder = (int) JRequest::getVar('folder');
		$gall_id = (int) JRequest::getVar('gall_id', '');
		// Select some fields
		$query = ' SELECT * '.
			     ' FROM #__fgallery_images '.
				 ' WHERE parent = '.$folder.
				 ' AND folder IN (0,1) ';
		if (is_numeric($gall_id)) {
			$query .= ' AND id NOT IN (SELECT img_id FROM #__fgallery_gallery_images WHERE gall_id = '.$gall_id.') ';
		}
		$query .= $orderby;
		return $query;
	}
	
	function _buildOrderBy() {
		global $mainframe;
		$filter_order		= $mainframe->getUserStateFromRequest( $this->_context.'.filter_order',	'filter_order',	'created','cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $this->_context.'.filter_order_Dir',	'filter_order_Dir',	'',	'word' );
		if ($filter_order == 'created'){
			$orderby 	= ' ORDER BY folder DESC, created '.$filter_order_Dir;
		} else {
			$orderby 	= ' ORDER BY folder DESC, '.$filter_order.' '.$filter_order_Dir.' , created ';
		}
		return $orderby;
	}
}
