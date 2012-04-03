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
 
// import Joomla controllerform library
jimport('joomla.application.component.controller');
 
/**
 * Gallery Controller
 */
class FGalleryControllerGallery extends JController
{

	function __construct()
	{
        require_once JPATH_COMPONENT.'/helpers/fgallery.php';
        parent::__construct();
	}
	
	
	protected function prepare_settings($data) {
		unset($data['option']);
		unset($data['task']);
                if ($data['gallery']['gall_type'] != $data['gallery']['old_gall_type'])
                    $data = FGalleryHelper::fgallery_default_album_settings($data['gallery']['gall_type']);
		unset($data['gallery']);
                return $data;
	}
	
	protected function gallery_store() {
                jimport('joomla.filesystem.file');
                jimport('joomla.filesystem.folder');
		$post = JRequest::get('post');
		$task = $post['task'];
		if (is_numeric($post['gallery']['id'])) {
			$gall_id = $post['gallery']['id'];
		} else {
			$this->setError(JText::_('COM_FGALLERY_NO_SUCH_GALLERY'));
			$this->setRedirect('index.php?option=com_fgallery&view=galleries');
		}
		if (!empty($post)) {
			JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
				$gal =& JTable::getInstance('gallery', 'FGalleryTable');
				if ($gall_id > 0) {
					$gal->load($gall_id);
				}
				if (!$gal->bind($post['gallery'])) {
				   return JError::raiseWarning(500, $gal->getError());
				}	
				if (!$gal->store()) {
				   return JError::raiseWarning(500, $gal->getError());
				}
			$gal->checkin();
			$gall_id = $gal->id;
                        if (!empty($_FILES)) {
                              foreach ($_FILES as $key=>$value) {
                                if ($_FILES[$key]['name'] == '') {
                                    continue;
                                }
                                //any errors the server registered on uploading
                                    $fileError = $_FILES[$key]['error'];
                                    if ($fileError > 0) 
                                    {
                                        echo $_FILES[$key]['name'].'<br />';
                                         switch ($fileError) {
                                            case 1:
                                            echo JText::_( 'FILE TOO LARGE THAN PHP INI ALLOWS' );
                                            return;

                                            case 2:
                                            echo JText::_( 'FILE TOO LARGE THAN HTML FORM ALLOWS' );
                                            return;

                                            case 3:
                                            echo JText::_( 'ERROR PARTIAL UPLOAD' );
                                            return;
                                         }
                                    }
                                    $validMime = array('0'=>'image','1'=>'audio');
                                    $fileTemp = $_FILES[$key]['tmp_name'];
                                    $fileOk = false;
                                    foreach($validMime as $num => $type){
                                        if( preg_match("/$type/i", $_FILES[$key]['type'] ) ){
                                            $fileOk = true;
                                        }
                                    }
                                    if ($fileOk == false) {
                                            echo $_FILES[$key]['name'].'<br />';
                                            echo JText::_( 'INVALID FILE TYPE' );
                                            return;
                                    }
                                    $fileName = $_FILES[$key]['name'];
                                    //lose any special characters in the filename
                                    $fileName = ereg_replace("[^A-Za-z0-9.]", "-", $fileName);
                                    $fileName ='gallery'.$gal->id.'_'.$fileName;
                                    //always use constants when making file paths, to avoid the possibilty of remote file inclusion
                                    $uploadPath = JPATH_SITE.DS.'images'.DS.'stories'.DS.'fgallery'.DS.$fileName;

                                    if(!JFile::upload($fileTemp, $uploadPath)) {
                                            echo JText::_( 'ERROR MOVING FILE' );
                                            return;
                                    }
                                    $fieldName = str_replace('_file','',$key);
                                    $post[$fieldName] = Juri::root(true).'/images/stories/fgallery/'.$fileName;
                            }
                        }
			$to_store = $this->prepare_settings($post);
			$db = & JFactory::getDbo();
		
			$query = 'SELECT id FROM #__fgallery_gallery_settings'
					.' WHERE gall_id ='.$gall_id;
			$db->setQuery($query);
			if (!$db->query()) {
				return JError::raiseWarning(500, $db->getErrorMsg());
			}
			$result = $db->loadResult();
			$row =& JTable::getInstance('settings', 'FGalleryTable');			
			$row->load($result);
			
			$set = array('gall_id'=>$gall_id, 'value'=>serialize($to_store));
				 if (!$row->bind($set)) {
				   return JError::raiseWarning(500, $row->getError());
				  }	
				 if (!$row->store()) {
				   return JError::raiseWarning(500, $row->getError());
				  }
		}
		if ($task == 'save') {
				$this->setRedirect('index.php?option=com_fgallery&view=galleries');
			} else {
				$this->setRedirect('index.php?option=com_fgallery&view=gallery&id='.$gall_id);
			}
		$model = $this->getModel('Gallery','FGalleryModel');
		$table = $model->getTable('Gallery', 'FGalleryTable');
		$table->reorder();
	}
	
	public function apply() {
		$this->gallery_store();
	}
	
	public function save() {
		$this->gallery_store();
	}
	
	public function cancel() {
		$this->setRedirect('index.php?option=com_fgallery&view=galleries');
	}
	
}
