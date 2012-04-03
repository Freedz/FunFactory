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
 * Image Controller
 */
class FGalleryControllerImage extends JController
{

	/**
	 * Class constructor.
	 *
	 * @param	array	$config	A named array of configuration variables.
	 *
	 * @return	JControllerForm
	 * @since	1.6
	 */
	function __construct($config = array())
	{
		parent::__construct($config);
		$this->registerTask( 'album', 'album' );
		$this->registerTask( 'album_cancel', 'album_cancel' );
	}
	
	function edit() {
		JRequest::setVar('hidemainmenu', 1 );

		parent::display();
		$model = $this->getModel('image');
		$model->checkout();
	}
	
	function cancel() {
		$model = $this->getModel( 'image' );
		$model->checkin();
		$this->setRedirect( 'index.php?option=com_fgallery&view=images' );
	}
	
	
	public function save() {
                jimport('joomla.filesystem.file');
                jimport('joomla.filesystem.folder');
		$post = JRequest::get('post');
		$cid  = JRequest::getVar('cid', array(0), 'post', 'array' );
		$post['id'] = (int) $cid[0];
		$post['title'] = JRequest::getVar( 'title', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$post['description'] = JRequest::getVar( 'description', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$post['folder'] = JRequest::getVar( 'folder', '', 'post', 'int', JREQUEST_ALLOWRAW );
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
                                    $validMime = array('0'=>'image');
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
                                    $fileName ='thumb'.$id.'_'.$fileName;
                                    //always use constants when making file paths, to avoid the possibilty of remote file inclusion
                                    $uploadPath = JPATH_SITE.DS.'images'.DS.'stories'.DS.'fgallery'.DS.$fileName;

                                    if(!JFile::upload($fileTemp, $uploadPath)) {
                                            echo JText::_( 'ERROR MOVING FILE' );
                                            return;
                                    }
                                    $post['preview_path'] = Juri::root(true).'/images/stories/fgallery/'.$fileName;
                            }
                        }
		$model = $this->getModel('image');
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$row = & JTable::getInstance('Image', 'FGalleryTable');
		
		if ($post['id'] > 0) 
			$row->load($post['id']);
		if (!$row->bind($post)) {
		   return JError::raiseWarning(500, $row->getError());
		}	
		if (!$row->store()) {
		   return JError::raiseWarning(500, $row->getError());
		} else {
			$msg = JText::_( 'Image information saved' );
		}
			
		$model->checkin();
		$link = 'index.php?option=com_fgallery&view=images';
		$this->setRedirect($link, $msg);
	}
	
	public function album() {
		$post = JRequest::get('post');
		if (!empty($post)) {
			JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
			$row =& JTable::getInstance('Image', 'FGalleryTable');
			$folder = array('title'=>$post['title'],'folder'=>$post['folder']);
			 if (!$row->bind($folder)) {
			   return JError::raiseWarning(500, $row->getError());
			  }	
			 if (!$row->store()) {
			   return JError::raiseWarning(500, $row->getError());
			  }
			  
			$img_id = $row->id;
			if (is_numeric($post['gall_id'])) {
				$gall_id = $post['gall_id'];
			} else {
				jexit('Invalid Gallery ID');
			}
			$img_to_gall = array('img_id'=>$img_id, 'gall_id'=>$gall_id, 'gall_folder'=>0);
			$rel =& JTable::getInstance('Relations', 'FGalleryTable');
			 if (!$rel->bind($img_to_gall)) {
			   return JError::raiseWarning(500, $rel->getError());
			  }	
			 if (!$rel->store()) {
			   return JError::raiseWarning(500, $rel->getError());
			  }
		}
		$this->setRedirect('index.php?option=com_fgallery&view=galleryimages&id='.$gall_id);
	}
	
	public function album_cancel() {
		$post = JRequest::get('post');
		if (!empty($post)) {
			if (is_numeric($post['gall_id'])) {
				$gall_id = $post['gall_id'];
			} else {
				jexit('Invalid gallery ID');
			}
			$this->setRedirect('index.php?option=com_fgallery&view=galleryimages&id='.$gall_id);
		}
	}
	
}
