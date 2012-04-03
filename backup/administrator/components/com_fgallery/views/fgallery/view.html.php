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
class FGalleryViewFGallery extends JView
{
	/**
	 * display method of Image view
	 * @return void
	 */
	public function display($tpl = null) 
	{
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		// Display the template
		parent::display($tpl);
		
		// Set the toolbar
		$this->addToolBar();
		$this->setDocument();
	}
	
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		JToolBarHelper::title(JText::_('1 Flash Gallery'));
		JToolBarHelper::preferences('com_fgallery','460');
		JToolBarHelper::help( 'screen.fgallery', true );
	}

	
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->addScript(JURI::root() . "administrator/components/com_fgallery/js/jquery.js");
		$document->addScript(JURI::root() . "administrator/components/com_fgallery/js/ZeroClipboard.js");
		$document->addScript(JURI::root() . "administrator/components/com_fgallery/js/copy.js");
		$document->setTitle(JText::_('1 Flash Gallery'));
	}
}
