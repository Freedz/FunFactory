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
class FGalleryViewGallery extends JView
{

	protected $form;
	protected $item;
	protected $state;
	
	/**
	 * display method of Gallery view
	 * @return void
	 */
	public function display($tpl = null) 
	{
		// get the Data
		$this->item = $this->get('Data');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign the Data
		$editor =& JFactory::getEditor();
		$this->assignRef('editor', $editor);
		$this->assignRef('item', $this->item);

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
		JRequest::setVar('hidemainmenu', true);
		$isNew = ($this->item->id == 0);
		JToolBarHelper::title($isNew ? JText::_('COM_FGALLERY_MANAGER_FGALLERY_NEW') : JText::_('COM_FGALLERY_MANAGER_FGALLERY_EDIT').' "'.$this->item->title.'"');
		$bar = JToolBar::getInstance('toolbar');
		if (!$isNew) {
                    $bar->appendButton('Popup', 'add_images', 'COM_FGALLERY_GALLERY_ADD_IMAGES', 'index.php?option=com_fgallery&amp;view=images&amp;layout=select&amp;gall_id='.$this->item->id.'&amp;tmpl=component',800,400);
                    $bar->appendButton('Link', 'view_images', 'COM_FGALLERY_SUBMENU_GALLERY_IMAGES', 'index.php?option=com_fgallery&view=galleryimages&id='.$this->item->id);
                }
		JToolBarHelper::apply('apply');
		JToolBarHelper::save('save');
		JToolBarHelper::cancel('cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
	}
		
	protected function setDocument() {
		$isNew = ($this->item->id < 1);
		$document = JFactory::getDocument();
		$document->setTitle($isNew ? JText::_('COM_FGALLERY_GALLERY_CREATING') : JText::_('COM_FGALLERY_GALLERY_EDITING'));
		$document->addScript(JURI::root() . "administrator/components/com_fgallery/js/jquery.js");
		$document->addScript(JURI::root() . "administrator/components/com_fgallery/js/swfobject.js");
		$document->addScript(JURI::root() . "components/com_fgallery/views/gallery/js/swfhelper.js");
		$document->addScript(JURI::root() . "administrator/components/com_fgallery/js/ui.core.js");
                $document->addScript(JURI::root() . "administrator/components/com_fgallery/js/ui.widget.js");
		$document->addScript(JURI::root() . "administrator/components/com_fgallery/js/ui.tabs.js");
                $document->addScript(JURI::root() . "administrator/components/com_fgallery/views/gallery/js/ui.mouse.js");
		$document->addScript(JURI::root() . "administrator/components/com_fgallery/views/gallery/js/ui.slider.js");
		$document->addScript(JURI::root() . "administrator/components/com_fgallery/views/gallery/js/configurator.js");
		$document->addScript(JURI::root() . "administrator/components/com_fgallery/views/gallery/js/farbtastic.js");
		 $document->addStyleSheet(JURI::root() . "administrator/components/com_fgallery/css/ui.theme.css");
		 $document->addStyleSheet(JURI::root() . "administrator/components/com_fgallery/css/ui.tabs.css");
		 $document->addStyleSheet(JURI::root() . "administrator/components/com_fgallery/views/gallery/css/farbtastic.css");
		 $document->addStyleSheet(JURI::root() . "administrator/components/com_fgallery/views/gallery/css/configurator.css");
		 $document->addStyleSheet(JURI::root() . "administrator/components/com_fgallery/views/gallery/css/ui.slider.css");
		 $document->addScript(JURI::root() . "administrator/components/com_fgallery/js/ZeroClipboard.js");
		$document->addScript(JURI::root() . "administrator/components/com_fgallery/js/copy.js");
	}
		
                /**
                 * Element text
                 */
                function sc_controls_text($p) {
                   $output = '<div class="form-item ' . $p['zebra'] . '" >'
                           . '<label for="' . $p['element_name'] . '">' . $p['title'] . ':</label>'
                           . '<input name="' . $p['element_name'] . '" id="' . $p['element_name'] . '" type="text" value="' . (string)$p['default'] .'" size="10" maxlength="255" class="form-text '.$p['class'].'"/>';
                    if ($p['type'] == 'file') {
                        $output .= '<input type="file" id="'.$p['element_name'].'_file" name="'.$p['element_name'].'_file" class="configurator_file" />';
                    }
                    $output .= '</div>';
                   return $output;
                }

		/**
		 * Element - checkbox.
		 */
		function sc_controls_checkbox($p) {
                    $checked = (int)$p['default'] ? 'checked="checked"' : '';
                    if ($checked == '' && (string)$p['default'] == 'true') $checked = 'checked = "checked"';
                    return '<div class="form-item ' . $p['zebra'] . '" >'
                    . '<input name="' . $p['element_name'] . '" type="hidden" value="0" />' 
                    . '<input name="' . $p['element_name'] . '" id="' . $p['element_name'] . '" type="checkbox" ' . $checked . ' class="form-checkbox" value="'.$p['values'].'"/>'
                    . '<label for="' . $p['element_name'] . '">' . $p['title'] . '</label>'
                    . '</div>';
		}

		/**
		 * Element - select.
		 */
		function sc_controls_select($p) {
		  $options_raw = explode(',', $p['values']);
		  $options = '';
		  foreach ($options_raw as $o) {
			$selected = (string) $p['default'] == $o ? 'selected="selected"' : '';
			$options .= '<option value="' . $o . '" ' . $selected . '>' . $o . '</option>';
		  }
		  return '<div class="form-item ' . $p['zebra'] . '" >'
			   . '<label for="' . $p['element_name'] . '">' . $p['title'] . ':</label>'
			   . '<select name="' . $p['element_name'] . '" id="' . $p['element_name'] . '" class="form-select">' . $options . '</select>'
			   . '</div>';
		}

		/**
		 * Element - slider (jQuery UI slider).
		 */
		function sc_controls_slider($p) {
		  $values = explode(':', $p['values']); // format "1..5:1"
		  $range = $values[0];
		  $range = explode('..', $range);
		  $min = $range[0];
		  $max = $range[1];

		  $step = $values[1];

		  // Validate values
		  if (!is_numeric($step) || !is_numeric($min) || !is_numeric($max)) {
			return '<div class="form-item ' . $p['zebra'] . '" >Parse error</div>';
		  }

		  return '<div class="form-item ' . $p['zebra'] . '" >'
			   . '<label for="' . $p['element_name'] . '">' . $p['title'] . ':</label>'
			   . '<input name="' . $p['element_name'] . '" id="' . $p['element_name'] . '" type="text" value="' . $p['default'] .'" size="3" maxlength="3" readonly="readonly" class="sc-slider-val form-text" min="' . $min . '" max="' . $max . '" step="' . $step .'"/>'
			   . '</div>';
		}

		/**
		 * Form element - color picker (Farbtastic).
		 */
		function sc_controls_color($p) {
		  return '<div class="form-item ' . $p['zebra'] . '" >'
			   . '<label for="' . $p['element_name'] . '">' . $p['title'] . ':</label>'
			   . '<input name="' . $p['element_name'] . '" id="' . $p['element_name'] . '" type="text" value="' . str_replace('0x', '#', $p['default']) .'" size="10" maxlength="7" class="sc-color-val form-text"/>'
			   . '</div>';
		}
}
