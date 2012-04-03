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
 * Galleries Controller
 */
class FGalleryControllerGalleryImages extends JController
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
                parent::__construct($config);
                $this->registerTask('movetoalbum', 'movetoalbum');
                $this->registerTask('save_url', 'save_url');
        }	


        public function movetoalbum() {
                $post = JRequest::get('post');

                JRequest::checkToken() or jexit('Invalid Token');

                if (is_numeric($post['id'])) {
                        $gall_id = $post['id'];
                } else {
                        jexit('Invalid Gallery Id');
                }
                $pks = $post['cid'];
                        $pks = (array) $pks;
                        JArrayHelper::toInteger($pks);
                if (empty($pks)) {
                        $this->setError(JText::_('COM_FGALLERY_NO_ITEM_SELECTED'));
                        return false;
                }
                $folder = JRequest::getVar('move_to_album');
                if (!is_numeric($folder)) {
                        $this->setError(JText::_('COM_FGALLERY_SELECT_album'));
                }

                $db = & JFactory::getDbo();
                 $query = 'UPDATE #__fgallery_gallery_images SET gall_folder =' .$folder 
                                .' WHERE img_id IN (' . implode(',',$pks) . ') AND gall_id ='.$gall_id;
                $db->setQuery($query);
                if (!$db->query()) {
                        return JError::raiseWarning(500, $row->getError());
                }

                $this->setRedirect('index.php?option=com_fgallery&view=galleryimages&album='.$folder.'&id='.$gall_id);
        }
			
        public function delete() {
                $post = JRequest::get('post');
                JRequest::checkToken() or jexit('Invalid Token');
                $pks = $post['cid'];
                $pks = (array) $pks;
                JArrayHelper::toInteger($pks);
                if (is_numeric($post['id'])) {	
                        $gall_id = $post['id'];
                }
                if (is_numeric($post['album'])) {
                        $album = $post['album'];
                }
                if (empty($pks)) {
                        $this->setError(JText::_('COM_FGALLERY_NO_ITEM_SELECTED'));
                        return false;
                }

                $db = & JFactory::getDbo();
                $query = 'DELETE FROM #__fgallery_gallery_images'
                                .' WHERE img_id IN (' . implode(',',$pks) . ') AND gall_id ='.$gall_id;
                $db->setQuery($query);
                if (!$db->query()) {
                        return JError::raiseWarning(500, $db->getErrorMsg());
                }
                $this->setRedirect('index.php?option=com_fgallery&view=galleryimages&id='.$gall_id.'&album='.$album);
        }
                
        public function save_url() {
            JRequest::checkToken() or jexit('Invalid Token');
            $post = JRequest::get('post');
            $post['img_text'] = JRequest::getVar( 'img_text', 'defaultValue', 'post', 'string', JREQUEST_ALLOWRAW );
            JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
            if (isset($post['gall_id']) && is_numeric($post['gall_id'])) {
                    $gall_id = $post['gall_id'];
            } else {
                    die('Invalid gallery');
            }
            if (isset($post['img_id']) && is_numeric($post['img_id'])) {
                    $img_id = $post['img_id'];
            } else {
                    die('Invalid image');
            }
            $row = & JTable::getInstance('image', 'FGalleryTable');
            $image = array('title'=>$post['img_title'], 'description'=>$post['img_description']);
            $row->load($img_id);

            if (!$row->bind($image)) {
                    return JError::raiseWarning(500, $row->getError());
            }	
            if (!$row->store()) {
                    return JError::raiseWarning(500, $row->getError());
            }
            $db = & JFactory::getDbo();
            $array = array('img_type' => $post['img_type'], 'img_text' => $post['img_text']);
            $img_extra = serialize($array);
            $query = "UPDATE #__fgallery_gallery_images SET img_url ='".$post['img_url']."' , img_extra = '".$img_extra."'".
                     " WHERE img_id = ".$img_id." AND gall_id =".$gall_id;
            $db->setQuery($query);
            if (!$db->query()) {
                return JError::raiseWarning(500, $db->getErrorMsg());
            }
             $this->setRedirect('index.php?option=com_fgallery&view=close');
        }

		
}
