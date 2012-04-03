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
class FGalleryViewGalleryImages extends JView
{
	var $_context = 'com_fgallery.galleryimages';

	protected $state;
	protected $items;
	protected $pagination;
	
        /**
         * display method of Gallery view
         * @return void
         */
        public function display($tpl = null) 
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
                        $image 	= $this->getImage();

			// Check for errors.
			if (count($errors = $this->get('Errors'))) 
			{
				JError::raiseError(500, implode('<br />', $errors));
				return false;
			}

			$this->assignRef('lists',		$lists);
			$this->assignRef('items',		$items);
			$this->assignRef('pagination',	$pagination);
			$this->assignRef('image',	$image);
                        
                        // Set the toolbar
			$this->addToolBar();
                        $this->setDocument();
                         // Display the template
                         parent::display($tpl);
			 
			
        }
        
        protected function getImage() {
            $img_id = JRequest::getVar('img_id');
            if ($img_id == '') return false; 
            $gall_id = JRequest::getVar('id');
            if ($gall_id == '') return false;
            $db = JFactory::getDBO();
            $query = $db->getQuery(true);
            // Select some fields
            $query = ' SELECT a.*, b.* '.
            // From the gallery table
                     ' FROM #__fgallery_images as a '.
                     ' LEFT JOIN #__fgallery_gallery_images as b ON (a.id = b.img_id)'.
                     ' WHERE b.gall_id = '.$gall_id.' AND a.id ='.$img_id;
            $db->setQuery($query);
            $result = $db->loadObjectList();
            return $result[0];
        }
 
        /**
         * Setting the toolbar
         */
        protected function addToolBar() 
        {
            JRequest::setVar('hidemainmenu', true);
            $gall_id = (int)JRequest::getVar('id');
            $album = (int)JRequest::getVar('album');
            JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
            $gall = & JTable::getInstance('gallery', 'FGalleryTable');
            $gall->load($gall_id);
            JToolBarHelper::title('<a href="index.php?option=com_fgallery&view=gallery&id='.$gall_id.'">"'.$gall->title.'"</a> '.
                    JText::_('COM_FGALLERY_ADD_IMAGES_TO_GALLERY'));
            $bar = JToolBar::getInstance('toolbar');
            if ($album) {
                    $bar->appendButton('Link', 'back', 'Back', 'index.php?option=com_fgallery&view=galleryimages&id='.$gall_id);
            } else {
                    $bar->appendButton('Link', 'back', 'Back', 'index.php?option=com_fgallery&view=gallery&id='.$gall_id);
                    $bar->appendButton('Link', 'folder', 'New folder', 'index.php?option=com_fgallery&view=image&layout=album&gall_id='.$gall_id);
            }
            if (!$isNew) 
            $bar->appendButton('Popup', 'add_images', 'COM_FGALLERY_GALLERY_ADD_IMAGES', 'index.php?option=com_fgallery&amp;view=images&amp;layout=select&amp;gall_id='.$gall_id.'&amp;tmpl=component',800,400);
            JToolBarHelper::customX('movetoalbum','move.png','move.png','Move to album');
            JToolBarHelper::deleteListX('Are you sure you want to remove this images from gallery?','delete');
        }
        
        protected function setDocument() 
        {
            $document = JFactory::getDocument();
            $document->addScript(JURI::root() . "administrator/components/com_fgallery/js/jquery.js");
            $document->addScript(JURI::root() . "administrator/components/com_fgallery/js/ui.core.js");
            $document->addScript(JURI::root() . "administrator/components/com_fgallery/js/ui.widget.js");
            $document->addScript(JURI::root() . "administrator/components/com_fgallery/js/ui.mouse.js");
            $document->addScript(JURI::root() . "administrator/components/com_fgallery/js/ui.sortable.js");
            $document->addScript(JURI::root() . "administrator/components/com_fgallery/views/galleryimages/js/galleryimages.js");
            $document->addStyleSheet(JURI::root() . "administrator/components/com_fgallery/views/gallery/css/configurator.css");
            $document->addStyleSheet(JURI::root() . "administrator/components/com_fgallery/views/images/css/fgallery_images.css");
            $document->addStyleSheet(JURI::root() . "administrator/components/com_fgallery/views/images/css/fgallery_images.css");
        }
		
}
