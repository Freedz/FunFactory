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
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * Images View
 */
class FGalleryViewImages extends JView
{
	var $_context 	= 'com_fgallery.images';
	
	/**
	 * Images view display method
	 * @return void
	 */
	function display($tpl = null) 
	{
		global $mainframe;
		
		$filter_order = $mainframe->getUserStateFromRequest( $this->_context.'.filter_order',	'filter_order',	'created', 'cmd' );
		$filter_order_Dir = $mainframe->getUserStateFromRequest( $this->_context.'.filter_order_Dir',	'filter_order_Dir',	'',	'word' );
		
		// state filter
		$lists['state']	= JHTML::_('grid.state',  $filter_state );

		// table ordering
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] = $filter_order;
		
		// Get data from the model
		$items		= & $this->get('Data');
		$total		= & $this->get('Total');
		$pagination = & $this->get('Pagination');
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		$this->assignRef('lists',		$lists);
		$this->assignRef('items',		$items);
		$this->assignRef('pagination',	$pagination);
		
		// Display the template
		parent::display($tpl);
		
		$this->setDocument();
		$this->addToolbar();
	}
	
	protected function addToolBar() 
	{
            $params = &JComponentHelper::getParams('com_fgallery');
		JToolBarHelper::title(JText::_('COM_FGALLERY_MANAGER_IMAGES'));
		$bar =& JToolBar::getInstance('toolbar');
		if ((int)JRequest::getVar('folder') > 0) {
			JToolBarHelper::back();
		} else {
			$bar->appendButton('Link', 'folder', 'New folder', 'index.php?option=com_fgallery&view=image&layout=folder');
		}
		JToolBarHelper::deleteListX(JText::_('COM_FGALLERY_CONFIRM_IMAGES_DELETE'), 'delete', 'Delete');
		JToolBarHelper::editList('edit');
		JToolBarHelper::customX('creategal','default.png','default.png','Create gallery');
                $wm = $params->get('watermark','0');
		if ($wm) JToolBarHelper::customX('watermark','default.png','default.png','Watermark');
		JToolBarHelper::customX('movetofolder','move.png','move.png','Move to folder');
		$bar->appendButton('Link', 'upload', 'Upload', 'index.php?option=com_fgallery&view=upload');        
	}
	
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->addScript(JURI::root() . "administrator/components/com_fgallery/js/jquery.js");
		$document->addStyleSheet(JURI::root() . "administrator/components/com_fgallery/views/images/css/fgallery_images.css");
		$document->addStyleSheet(JURI::root() . "administrator/components/com_fgallery/views/gallery/css/configurator.css");
		$document->setTitle(JText::_('COM_FGALLERY_ADMINISTRATION'));
	}
}
