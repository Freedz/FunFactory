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
 * Galleries List Model
 */
class FGalleryModelGalleries extends JModel
{
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @return	void
	 * @since	1.6
	 */
	function __construct()
	{
		require_once JPATH_ADMINISTRATOR.'/components/com_fgallery/helpers/fgallery.php';
		
		parent::__construct();
		
		global $mainframe;
		
		$search = $mainframe->getUserStateFromRequest($this->_context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$access = $mainframe->getUserStateFromRequest($this->_context.'.filter.access', 'filter_access', 0, 'int');
		$this->setState('filter.access', $access);

		$published = $mainframe->getUserStateFromRequest($this->_context.'.filter.published', 'filter_published', '');
		$this->setState('filter.published', $published);
		
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
		$orderby	= $this->_buildContentOrderBy();
			// Create a new query object.         
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);
			// Select some fields
			$query = 'SELECT a.*, b.images, b.size '
			 .'FROM #__fgallery_galleries as a '
			 .'LEFT JOIN ( '
			 .'SELECT c.gall_id, COUNT(*) as images, SUM(d.size) as size '
			 .'FROM #__fgallery_gallery_images as c '
			 .'LEFT JOIN #__fgallery_images as d ON (c.img_id = d.id) '
			 .'WHERE d.folder = 0 GROUP BY gall_id) as b ' 
			 .'ON (b.gall_id = a.id) '
			 . $orderby;
			 //die($query);
			return $query;
	}
	
	function _buildContentOrderBy() {
		global $mainframe;
		$filter_order		= $mainframe->getUserStateFromRequest( $this->_context.'.list_order',	'filter_order',	'a.ordering', 'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $this->_context.'.filter_order_Dir',	'filter_order_Dir',	'',	'word' );

		if ($filter_order == 'a.ordering'){
			$orderby 	= ' ORDER BY  a.ordering '.$filter_order_Dir;
		} else {
			$orderby 	= ' ORDER BY '.$filter_order.' '.$filter_order_Dir.' , a.ordering ';
		}
		return $orderby;
	} 
}
