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
 
// import Joomla controlleradmin library
jimport('joomla.application.component.controller');
 
/**
 * Images Controller
 */
class FGalleryControllerImages extends JController
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
		
		$this->registerTask( 'creategal', 'creategal' );
		$this->registerTask( 'watermark', 'watermark' );
		$this->registerTask( 'movetofolder', 'movetofolder' );
		$this->registerTask( 'addtogallery', 'addtogallery' );
	}	

	
	public function movetofolder() {
		JRequest::checkToken() or jexit('Invalid Token');
		$post = JRequest::get('post');
			$pks = $post['cid'];
			$pks = (array) $pks;
			JArrayHelper::toInteger($pks);
		if (empty($pks)) {
			$this->setError(JText::_('COM_FGALLERY_NO_ITEM_SELECTED'));
			return false;
		}
		$folder = JRequest::getVar('move_to_folder');
		if (!is_numeric($folder)) {
			$this->setError(JText::_('COM_FGALLERY_SELECT_FOLDER'));
		}

		$db = & JFactory::getDbo();
		$query = 'UPDATE #__fgallery_images SET parent =' .$folder 
				.' WHERE id IN (' . implode(',',$pks) . ') AND folder = 0';
		$db->setQuery($query);
		if (!$db->query()) {
			JError::raiseError(500, $db->getErrorMsg());
		}

		$this->setRedirect('index.php?option=com_fgallery&view=images&folder='.$folder);		
	}
	
	public function creategal() {
		JRequest::checkToken() or jexit('Invalid Token');
			$post = JRequest::get('post');
			$pks = $post['cid'];
			$pks = (array) $pks;
			JArrayHelper::toInteger($pks);
			
		if (empty($pks)) {
			$this->setError(JText::_('COM_FGALLERY_NO_ITEM_SELECTED'));
			return false;
		}

		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$row =& JTable::getInstance('gallery', 'FGalleryTable');
		$gallery = array('title'=>JText::_('COM_FGALLERY_NEW_GALLERY'), 'gall_type' => 3);
		if (!$row->bind($gallery)) {
				JError::raiseError(500, $row->getError());
			}	
		if (!$row->store()) {
				JError::raiseError(500, $row->getError());
			}
			
		$gall_id = $row->id;
		$new = FGalleryHelper::fgallery_default_album_settings();
		$row =& JTable::getInstance('settings', 'FGalleryTable');						
		$set = array('gall_id'=>$gall_id, 'value'=>serialize($new));
		    if (!$row->bind($set)) {
			   return JError::raiseError(500, $row->getError());
			}	
			if (!$row->store()) {
			   return JError::raiseError(500, $row->getError());
			}
		
		foreach ($pks as $img_id) {
			$image =& JTable::getInstance('image', 'FGalleryTable');
			$image->load($img_id);
			if ($image->folder == 0) {
				$rel =& JTable::getInstance('relations', 'FGalleryTable');
				$image_to_gall = array('img_id'=>$image->id, 'gall_id'=> $gall_id);
				if (!$rel->bind($image_to_gall)) {
						JError::raiseError(500, $rel->getError() );
					}	
				if (!$rel->store()) {
						JError::raiseError(500, $rel->getError() );
					}
			} else {
				$db = & JFactory::getDbo();
					$query = 'SELECT id FROM #__fgallery_images'
							.' WHERE parent ='.$img_id;
					$db->setQuery($query);
					if (!$db->query()) {
						throw new Exception($db->getErrorMsg());
					}
					$results = $db->loadAssocList();
					foreach ($results as $result) {
						$rel =& JTable::getInstance('relations', 'FGalleryTable');
						$img_to_gall = array('img_id'=>$result['id'], 'gall_id'=>$gall_id, 'gall_folder'=>0, 'ordering' =>0);
						if (!$rel->bind($img_to_gall)) {
								JError::raiseError(500, $rel->getError() );
							}	
						if (!$rel->store()) {
								JError::raiseError(500, $rel->getError() );
							}
					}
			}
		}
		
		$this->setRedirect('index.php?option=com_fgallery&view=gallery&id='.$gall_id);
	}
	
	public function addtogallery(){
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$post = JRequest::get('post');
                if (is_numeric($post['gall_id'])) {
                        $gall_id = $post['gall_id'];
                } else {
                        jexit('Invalid Gallery ID');
                }
                $images = array();
                if ($_SESSION['image'][0] != 0){
                    $images = $_SESSION['image'];
                } else {
                    $images = $post['cid'];
                }
		if (!empty($images)) {
			foreach ($images as $id) {
				$image =& JTable::getInstance('Image', 'FGalleryTable');
				$image->load($id);
				if (!$image->folder) {
					$image_to_gall = array('img_id'=>$image->id, 'gall_id'=> $gall_id);
					$row =& JTable::getInstance('Relations', 'FGalleryTable');
					if (!$row->bind($image_to_gall)) {
						return JError::raiseWarning(500, $row->getError());
					}	
					if (!$row->store()) {
						return JError::raiseWarning(500, $row->getError());
					}
				} else {
					$db = & JFactory::getDbo();
					$query = 'SELECT id FROM #__fgallery_images'
							.' WHERE parent ='.$id;
					$db->setQuery($query);
					if (!$db->query()) {
						return JError::raiseWarning(500, $db->getErrorMsg());
					}
					$results = $db->loadAssocList();
					foreach ($results as $result) {
						$rel =& JTable::getInstance('Relations', 'FGalleryTable');
						$img_to_gall = array('img_id'=>$result['id'], 'gall_id'=>$gall_id, 'gall_folder'=>0, 'ordering' =>0);
						if (!$rel->bind($img_to_gall)) {
								return JError::raiseWarning(500, $rel->getError());
							}	
						if (!$rel->store()) {
								return JError::raiseWarning(500, $rel->getError());
							}
					}
				}
			}
			unset($_SESSION['image']);
			$this->setRedirect('index.php?option=com_fgallery&view=close');
		} else {
                    $this->setRedirect('index.php?option=com_fgallery&view=images&layout=select&gall_id='.$gall_id.'&tmpl=component',
                        JText::_('COM_FGALLERY_CHOOSE_ATLEAST_ONE_IMAGE'));
                }
		
	}
	
	public function delete() {
		$post = JRequest::get('post');
		$pks  = JRequest::getVar('cid', array(0), 'post', 'array' );
		
		JRequest::checkToken() or jexit('Invalid Token');
		JArrayHelper::toInteger($pks);

		if (empty($pks)) {
			$this->setError(JText::_('COM_FGALLERY_NO_ITEM_SELECTED'));
			return false;
		}

		$db = & JFactory::getDbo();
		$query = 'SELECT path FROM #__fgallery_images'
				.' WHERE id IN (' . implode(',',$pks) . ')';
		$db->setQuery($query);
		if (!$db->query()) {
			throw new Exception($db->getErrorMsg());
		}
		$results = $db->loadAssocList();
		
		$query = 'DELETE FROM #__fgallery_gallery_images'
				.' WHERE img_id IN (' . implode(',',$pks) . ')';
		$db->setQuery($query);
		if (!$db->query()) {
			JError::raiseError(500, $db->getErrorMsg() );
		}
		$query = 'DELETE FROM #__fgallery_images'
				.' WHERE id IN (' . implode(',',$pks) .')';
		$db->setQuery($query);
		if (!$db->query()) {
			JError::raiseError(500, $db->getErrorMsg() );
		}
		
		$msg = JText::_(sprintf('%d items were successfully deleted', count($pks)));
		
		foreach ($results as $result) {
			if (strpos($result['path'],'fgallery') > 0) {
				@unlink($_SERVER['DOCUMENT_ROOT'].$result['path']);
			}
		}
		
		$this->setRedirect( 'index.php?option=com_fgallery&view=images', $msg );
		return true;
	}
        
       function watermark() {
            require_once JPATH_COMPONENT_ADMINISTRATOR.'/helpers/fgallery.php';
            JRequest::checkToken() or jexit('Invalid Token');
                $post = JRequest::get('post');
		$pks  = JRequest::getVar('cid', array(0), 'post', 'array' );
                JArrayHelper::toInteger($pks);
                if (empty($pks)) {
                        $this->setError(JText::_('COM_FGALLERY_NO_ITEM_SELECTED'));
                        return false;
                }
                foreach ($pks as $img_id) {
                    FGalleryHelper::fgallery_watermark_by_id($img_id);
                }
                $this->setRedirect('index.php?option=com_fgallery&view=images');
                return true;
        }
		
}
