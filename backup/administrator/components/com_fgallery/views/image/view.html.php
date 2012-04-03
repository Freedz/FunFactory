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
 * FGallery View
 */
class FGalleryViewImage extends JView
{

	protected $form;
	protected $item;
	protected $state;
	
	/**
	 * display method of Image view
	 * @return void
	 */
	public function display($tpl = null) 
	{
		// get the Data
		$item = $this->get('Data');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign the Data

		$editor =& JFactory::getEditor();
		$this->assignRef('editor', $editor);
		$this->assignRef('item', $item);
		// Display the template
		parent::display($tpl);
		// Set the toolbar
		$this->setDocument();
		$this->addToolBar();
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		JRequest::setVar('hidemainmenu', true);
		$isNew = ($this->item->id < 1);
		if (JRequest::getVar('layout') == '') {
			JToolBarHelper::title($isNew ? JText::_('COM_FGALLERY_IMAGE_CREATING') : JText::_('COM_FGALLERY_IMAGE_EDITING'));
		} else {
			JToolBarHelper::title($isNew ? JText::_('COM_FGALLERY_FOLDER_CREATING') : JText::_('COM_FGALLERY_FOLDER_EDITING'));
		}
		if (JRequest::getVar('layout') != 'album') {
			JToolBarHelper::save();
			JToolBarHelper::cancel('cancel', $isNew ? JText::_('JTOOLBAR_CANCEL') : JText::_('JTOOLBAR_CLOSE'));
		} else {
			JToolBarHelper::custom('album','save.png','save.png','Save & Exit', false);
			JToolBarHelper::cancel('album_cancel', $isNew ? JText::_('JTOOLBAR_CANCEL') : JText::_('JTOOLBAR_CLOSE'));
		}
			
	}
		
	protected function setDocument() 
	{
		$isNew = ($this->item->id < 1);
		$document = JFactory::getDocument();
		if (JRequest::getVar('layout') == '') {
			$document->setTitle($isNew ? JText::_('COM_FGALLERY_IMAGE_CREATING') : JText::_('COM_FGALLERY_IMAGE_EDITING'));
		} else {
			$document->setTitle($isNew ? JText::_('COM_FGALLERY_FOLDER_CREATING') : JText::_('COM_FGALLERY_FOLDER_EDITING'));
		}
	}
}
