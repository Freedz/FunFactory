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

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.helper');
jimport( 'joomla.application.component.model');

/**
 * Content Component Article Model
 *
 * @package		Joomla
 * @subpackage	Content
 * @since		1.5
 */
class FGalleryModelElement extends JModel
{
	/**
	 * Content data in category array
	 *
	 * @var array
	 */
	var $_list = null;

	var $_page = null;

	/**
	 * Method to get content article data for the frontpage
	 *
	 * @since 1.5
	 */
	function getList()
	{
		global $mainframe;

		if (!empty($this->_list)) {
			return $this->_list;
		}

		// Initialize variables
		$db		=& $this->getDBO();
		$filter	= null;

		// Get some variables from the request
		$option				= JRequest::getCmd( 'option' );
		$limit				= $mainframe->getUserStateFromRequest('global.list.limit',					'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart			= $mainframe->getUserStateFromRequest('galleryelement.limitstart',			'limitstart',		0,	'int');

		// Get the total number of records
		$query = 'SELECT COUNT(*)' .
				' FROM #__fgallery_galleries';
		$db->setQuery($query);
		$total = $db->loadResult();

		// Create the pagination object
		jimport('joomla.html.pagination');
		$this->_page = new JPagination($total, $limitstart, $limit);

		// Get the articles
		$query = 'SELECT *' .
				' FROM #__fgallery_galleries';
		$db->setQuery($query, $this->_page->limitstart, $this->_page->limit);
		$this->_list = $db->loadObjectList();

		// If there is a db query error, throw a HTTP 500 and exit
		if ($db->getErrorNum()) {
			JError::raiseError( 500, $db->stderr() );
			return false;
		}

		return $this->_list;
	}

	function getPagination()
	{
		if (is_null($this->_list) || is_null($this->_page)) {
			$this->getList();
		}
		return $this->_page;
	}
}
?>
