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
 
// import Joomla modelform library
jimport('joomla.application.component.model');
 
/**
 * Gallery Model
 */
class FGalleryModelTemplate extends JModel
{
	function __construct() {
		parent::__construct();	
		$array = JRequest::getVar('id',  0, '', 'array');
		if ($array[0] == 0) {
			$post = JRequest::getVar('post');
			$array  = JRequest::getVar('cid', array(0), 'post', 'array' );
		}
		$this->setId((int)$array[0]);
	}


	function setId($id) {
		$this->_id	= $id;
		$this->_data	= null;
	}

	function &getData() {
		if ($this->_loadData()) {
			
		} else {
			$this->_initData();
		}
		return $this->_data;
	}
	

	function _loadData() {
            // Lets load the content if it doesn't already exist
            if (empty($this->_data))
            {
                    $query = 'SELECT * '.
                            ' FROM #__fgallery_templates' .
                            ' WHERE id = '.(int) $this->_id;
                    $this->_db->setQuery($query);
                    $this->_data = $this->_db->loadObject();
                    return (boolean) $this->_data;
            }
            return true;
	}
	
	function _initData() {
            if (empty($this->_data)) {
                    $template = new stdClass();
                    $template->id				= 0;
                    $template->templ_title			= null;
                    $template->templ_desctipion		= null;
                    $template->gall_type			= 3;
                    $template->gall_settings                = '';
                    $template->created			= 0;
                    $this->_data				= $template;
                    return (boolean) $this->_data;
            }
            return true;
	}
		    
}
