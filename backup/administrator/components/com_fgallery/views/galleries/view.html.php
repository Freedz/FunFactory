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
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * Galleries View
 */
class FGalleryViewGalleries extends JView
{
	var $_context 	= 'com_fgallery.galleries';

	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Galleries view display method
	 * @return void
	 */
	function display($tpl = null) 
	{
		global $mainframe;
		// Get data from the model
		$items		= & $this->get('Data');
		$pagination	= & $this->get('Pagination');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
				JError::raiseError(500, implode('<br />', $errors));
				return false;
		}
		
		$filter_order = $mainframe->getUserStateFromRequest( $this->_context.'.filter_order',	'filter_order',	'a.ordering', 'cmd' );
		$filter_order_Dir = $mainframe->getUserStateFromRequest( $this->_context.'.filter_order_Dir',	'filter_order_Dir',	'',	'word' );
		// table ordering
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] = $filter_order;
		
		$this->assignRef('lists',		$lists);
		$this->assignRef('items',		$items);
		$this->assignRef('pagination',	$pagination);
		
		// Display the template
		parent::display($tpl);
		$this->addToolbar();
	}
	
	protected function addToolBar() 
	{
		JToolBarHelper::title(JText::_('COM_FGALLERY_MANAGER_GALLERIES'));
		JToolBarHelper::deleteListX('Are you sure you want to delete selected items?', 'delete');
		JToolBarHelper::editListX();
		$bar = JToolBar::getInstance('toolbar');
		$bar->appendButton('Link', 'new', 'Add new', 'index.php?option=com_fgallery&view=gallery');
		JToolBarHelper::divider();
		JToolBarHelper::publishList('publish');
		JToolBarHelper::unpublishList('unpublish');
		JToolBarHelper::divider();
	}
	
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_FGALLERY_ADMINISTRATION'));
	}
}
