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
 
// import Joomla controlleradmin library
jimport('joomla.application.component.controller');
 
/**
 * Galleries Controller
 */
class FGalleryControllerTemplates extends JController
{

        /**
         * Constructor.
         *
         * @param	array An optional associative array of configuration settings.
         * @see		JController
         * @since	1.6
         */
        public function __construct($config = array())
        {
             require_once JPATH_COMPONENT.'/helpers/fgallery.php';
             parent::__construct($config);
             $this->registerTask( 'create', 'create' );
             $this->registerTask( 'load', 'loadtemplate' );
        }	
	
        
        public function loadtemplate() {
            JRequest::checkToken() or jexit('Invalid Token');
            $post = JRequest::get('post');
            JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
            if (isset($post['gall_id']) && is_numeric($post['gall_id'])) {
                    $gall_id = $post['gall_id'];
            } else {
                    die('Invalid gallery');
            }
            if (isset($post['templ']) && is_numeric($post['templ'])) {
                    $templ_id = $post['templ'];
                    $row =& JTable::getInstance('template', 'FGalleryTable');
                    $row->load($templ_id);
                    $settings = unserialize($row->gall_settings);
            } else {
                    if (!empty($_FILES)) {
                            $to_store = simplexml_load_file($_FILES['settings_file']['tmp_name']);
                            $settings_array = array();
                            foreach ($to_store as $key=>$value) {
                                    $name = 'sc_'.$key.'__';
                                    foreach ($value as $key_2=>$value_2) {
                                            $attr_name = $name.$key_2;
                                            $new_value = (string)$value_2;
                                            $settings_array[$attr_name] = str_replace('0x','',$new_value);
                                    }
                            }
                            if (empty($settings_array)) {
                                    die('Invalid settings');
                            } 
                            $settings = FGalleryHelper::prepare_settings($settings_array);
                    } else {
                            die('Invalid template');
                    }
            }
            $query = 'SELECT id FROM #__fgallery_gallery_settings'
                    .' WHERE gall_id ='.$gall_id;
            $db = & JFactory::getDbo();
            $db->setQuery($query);
            if (!$db->query()) {
                throw new Exception($db->getErrorMsg());
            }
            $result = $db->loadResult();
            $row =& JTable::getInstance('settings', 'FGalleryTable');			
            $row->load($result);

            $set = array('gall_id'=>$gall_id, 'value'=>serialize($settings));
             if (!$row->bind($set)) {
               return JError::raiseWarning(500, $row->getError());
              }	
             if (!$row->store()) {
               return JError::raiseWarning(500, $row->getError());
              }
            $this->setRedirect('index.php?option=com_fgallery&view=close');
        }
        
        public function create() {
            JRequest::checkToken() or jexit('Invalid Token');
            $post = JRequest::get('post');
            
            if (isset($post['gall_id']) && is_numeric($post['gall_id'])) {
                    $gall_id = $post['gall_id'];
            } else {
                    die('Invalid gallery');
            }
            if (isset($post['gall_type']) && is_numeric($post['gall_type'])) {
                    $gall_type = $post['gall_type'];
            } else {
                    die('Invalid gallery');
            }
            $settings = FGalleryHelper::fgallery_get_album_settings($gall_id);
            if ($post['templ_title'] != '') {
                    JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
                    $row =& JTable::getInstance('template', 'FGalleryTable');
                    $data = array('gall_type' => $post['gall_type'], 
                        'gall_settings' => serialize($settings), 
                        'templ_title' => $post['templ_title'],
                        'templ_description'=>$post['templ_description']);
                    if (!$row->bind($data)) {
                            return JError::raiseWarning(500, $row->getError());
                    }	
                    if (!$row->store()) {
                            return JError::raiseWarning(500, $row->getError());
                    }
                    $this->setRedirect('index.php?option=com_fgallery&view=close');
            } elseif (isset($post['update_ex']) && is_numeric($post['update_ex'])) {
                    $templ_id = $post['update_ex'];
                        JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
                        $row =& JTable::getInstance('template', 'FGalleryTable');
                        $row->load($templ_id);
                        $data = array('gall_type' => $post['gall_type'], 
                            'gall_settings' => serialize($settings), 
                            'templ_description'=>$post['templ_description']);
                        if (!$row->bind($data)) {
                                return JError::raiseWarning(500, $row->getError());
                        }	
                        if (!$row->store()) {
                                return JError::raiseWarning(500, $row->getError());
                        }
                        $this->setRedirect('index.php?option=com_fgallery&view=close');
             } else {
                 die('Invalid template');
             }
        }
				
}
