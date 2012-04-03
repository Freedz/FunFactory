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

/**
 * FGallery component helper.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_fgallery
 * @since		1.5
 */
class FGalleryHelper
{
    
     function fgallery_resemple($fullpath) {
        if (version_compare(PHP_VERSION, '5.0.0', '<')) {
            require_once JPATH_COMPONENT_SITE.'/includes/Thumbnail.inc.php';    
            $thumb = new Thumbnail($fullpath, 0);
        } else {
            require_once JPATH_COMPONENT_SITE.'/includes/ThumbLib.inc.php';
            $thumb = PhpThumbFactory::create($fullpath, array(), false, 0);
        }
        $thumb->resize(1200, 1200);
        $thumb->save($fullpath); 
    }
    
            /**
         * Watermark given image
         * @param string $fullpath
         * @return image 
         */
        function fgallery_watermark($fullpath) {
            $params = &JComponentHelper::getParams( 'com_fgallery' );
            $wm_file = $params->get('watermark_source','');
            if ($wm_file == '') return false;
            $wm_file = JPATH_SITE.DS.'images'.DS.'stories'.DS.$wm_file;
            $wm_place = $params->get('watermark_position','C');
            if (version_compare(PHP_VERSION, '5.0.0', '<')) {
                require_once JPATH_COMPONENT_SITE.'/includes/Thumbnail.inc.php';    
                $thumb = new Thumbnail($fullpath, 0);
            } else {
                require_once JPATH_COMPONENT_SITE.'/includes/ThumbLib.inc.php';
                $thumb = PhpThumbFactory::create($fullpath, array(), false, 0);
            }
            return $thumb->watermarkImageGD($fullpath,$fullpath,$wm_file,$wm_place);
        }
        
        /**
         * Watermark given image by id
         * @param string $fullpath
         * @return image 
         */
        function fgallery_watermark_by_id($id) {
            JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
            $image = JTable::getInstance('image', 'FGalleryTable');  
            $image->load($id);
            $img_path = $_SERVER['DOCUMENT_ROOT'].$image->path;
            FGalleryHelper::fgallery_watermark($img_path);
        }
	/**
	 *
	 * @author Martin Sweeny
	 * @version 2010.0617
	 *
	 * returns formatted number of bytes.
	 * two parameters: the bytes and the precision (optional).
	 * if no precision is set, function will determine clean
	 * result automatically.
	 *
	 **/
	public function formatBytes($b,$p = null) {
		$units = array("B","kB","MB","GB","TB","PB","EB","ZB","YB");
		$c=0;
		if(!$p && $p !== 0) {
			$r = array();
			foreach($units as $k => $u) {
				if(($b / pow(1024,$k)) >= 1) {
					$r["bytes"] = $b / pow(1024,$k);
					$r["units"] = $u;
					$c++;
				}
			}
			return number_format($r["bytes"],2) . " " . $r["units"];
		} else {
			return number_format($b / pow(1024,$p)) . " " . $units[$p];
		}
	}
	
	public function getComponentParams(){
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query = ' SELECT params'.
				 ' FROM #__components '.
				 ' WHERE name = "com_fgallery" ';
		$db->setQuery((string)$query);
		$result = $db->loadResult();
		$params = json_decode($result->params);
		return $params;
	}
	
	public function updateIsInstalled($type) {
		$db = JFactory::getDBO();
		$ad = 'com_fgallery_update_'.$type;
		$query = $db->getQuery(true);
		$query = ' SELECT * '.
				 ' FROM #__components '.
				 " WHERE `option` = '".$ad."'
                                     OR `option` = 'com_fgallery_update'";
		$db->setQuery((string)$query);
		$result = $db->loadObject();
		if (!empty($result)){
			if ($result->id > 0) {
				return true;
			} else {
				return false;
			}	 
		}else {
			return false;
		}
	}
	
	public function updatefunction($ad) {
		if (!$ad) {
			$params = 'musicPath';
		} else {
			$params = 'mus1cPath';
		}
		return $params;
	}
	
	public function getFolderSize($id) {
		if (!is_numeric($id)) die();
		$db = JFactory::getDBO();
		$query = "SELECT SUM(size) as 'total' FROM #__fgallery_images WHERE parent =".$id;
		$db->setQuery($query);
		$result = $db->loadResult();
		return FGalleryHelper::formatBytes($result);
	}
	
	public function getFolders() {
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query = 'SELECT id,title '.
				 ' FROM #__fgallery_images '.
				 ' WHERE folder = 1';
		$db->setQuery((string)$query);
		$folders = $db->loadObjectList();
		$options = array();
		$options[] = JHtml::_('select.option', '', JText::_('COM_FGALLERY_IMAGES_CHOOSE_ACTION'));
		$options[] = JHtml::_('select.option', 0, JText::_('COM_FGALLERY_ROOT_FOLDER'));
		if ($folders){
			foreach($folders as $folder) 
			{
				$options[] = JHtml::_('select.option', $folder->id, $folder->title);
			}
		}
		return $options;
	}
        
        public function getTemplates($gall_type) {
            if (!is_numeric($gall_type)) die('Invalid Gallery Type');
            $db = JFactory::getDBO();
            $query = $db->getQuery(true);
            $query = ' SELECT id,templ_title '.
                     ' FROM #__fgallery_templates '.
                     ' WHERE gall_type = '.$gall_type;
            $db->setQuery((string)$query);
            $messages = $db->loadObjectList();
            $options = array();
            $options[] = JHtml::_('select.option', '', '---------------');
            if ($messages)
            {
                foreach($messages as $message) 
                {
                   $options[] = JHtml::_('select.option', $message->id, $message->templ_title);
                }
            }
            return $options;
	}
	
	public function getAlbums() {
		$gall_id = JRequest::getVar('id');
		if (!is_numeric($gall_id)) die();
		$db = JFactory::getDBO();
			$query = ' SELECT id,title '.
					 ' FROM #__fgallery_images as a '.
					 ' LEFT JOIN #__fgallery_gallery_images as b ON (a.id = b.img_id) '.
					 ' WHERE a.folder = 2 '.
					 ' AND b.gall_id = '.$gall_id;
			$db->setQuery((string)$query);
			$messages = $db->loadObjectList();
			$options = array();
			$options[] = JHtml::_('select.option', 0, JText::_('COM_FGALLERY_ALBUM_ROOT'));
			if ($messages)
			{
					foreach($messages as $message) 
					{
							$options[] = JHtml::_('select.option', $message->id, $message->title);
					}
			}
		return $options;
	}
	
	public function getGalleries() {
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query = ' SELECT id,title '.
				 ' FROM #__fgallery_galleries as a';
		$db->setQuery((string)$query);
		$messages = $db->loadObjectList();
		$options = array();
		$options[] = JHtml::_('select.option', 0, JText::_('COM_FGALLERY_CHOOSE_GALLERY'));
		if ($messages)
		{
			foreach($messages as $message) 
			{
				$options[] = JHtml::_('select.option', $message->id, $message->title);
			}
		}
		return $options;
	}
	
	public function countAlbumImages($id) {
	if (!is_numeric($id)) die();
		$db = JFactory::getDBO();
		$query = ' SELECT COUNT(*)'.
				 ' FROM #__fgallery_gallery_images '.
				 ' WHERE gall_folder ='.$id;
		$db->setQuery((string)$query);
		return $db->loadResult().' '.JText::_('COM_FGALLERY_IMAGES_IN_ALBUM');
	}
	
	public function fgallery_get_flash_type($type) {
		switch ($type) {
			case 1: return 'acosta';
			case 2: return 'airion';
			case 3: return 'arai';
			case 4: return 'pax';
			case 5: return 'pazin';
			case 6: return 'postma';
			case 7: return 'pageflip';
			case 8: return 'nilus';
			case 9: return 'nusl';
			case 10: return 'kranjk';
			case 11: return 'perona';
			case 12: return 'ables';
			default: return 'arai';
		}
	}
	
	public function fgallery_search_flash_path($album) {
		$type = FGalleryHelper::fgallery_get_flash_type($album->gall_type);
		if (file_exists(JPATH_SITE . DS. 'components'.DS.'com_fgallery_update'.DS.'swf'.DS.$type.'.swf')) {
				return JURI::root( true ).'/components/com_fgallery_update/swf/'.$type.'.swf';
			} elseif (file_exists(JPATH_SITE . DS.'components'.DS.'com_fgallery_update_'.$type.DS.'swf'.DS.$type.'.swf')) {
				return JURI::root( true ).'/components/com_fgallery_update_'.$type.'/swf/'.$type.'.swf';
			} else {
				return JURI::root( true ).'/components/com_fgallery/swf/'.$type.'.swf';
			}
	}
	
	public function fgallery_get_album_attributes($id) {
		if (!is_numeric($id)) die();
		$db = JFactory::getDBO();
			$query = ' SELECT COUNT(a.id) as "quantity", SUM(a.size) as "total_size" '.
					 ' FROM #__fgallery_images as a '.
					 ' LEFT JOIN #__fgallery_gallery_images as b ON (a.id = b.img_id)'.
					 ' WHERE b.gall_id='.$id.
					 ' AND a.folder <> 2';
			$db->setQuery((string)$query);
			$attr= $db->loadAssocList();
			$output = JText::_('Number of photos').' '.$attr[0]['quantity']. '<br />';
			$output .= JText::_('Total size').' '.FGalleryHelper::formatBytes($attr[0]['total_size']). '<br />';
			return $output;
		}
		
	function fgallery_create_thumb_url($width) {
	if (is_numeric($width)) {
		return JURI::root().'index.php?option=com_fgallery&task=image&tmpl=component&width='.$width.'&amp;image=';
	} else {
		return JURI::root().'index.php?option=com_fgallery&task=image&tmpl=component&width=200&amp;image=';
	}
}

	function fgallery_get_album_cover($album, $width='') {
		$db = JFactory::getDBO();
		$gall_id = $album->id;
			if ($album->cover != 0){
				$cover_id = $album->cover;
				$query = ' SELECT path, title '.
						 ' FROM #__fgallery_images '.
						 ' WHERE id = '.$cover_id;
				$db->setQuery((string)$query);
				$cover = $db->loadResult();
			} else {
			$query = $db->getQuery(true);
				$query = ' SELECT a.path, a.title '.
						 ' FROM #__fgallery_images as a '.
						 ' LEFT JOIN #__fgallery_gallery_images as b ON (a.id = b.img_id) '.
						 ' WHERE a.folder = 0 AND b.gall_id = '.$gall_id.
						 ' LIMIT 1';
				$db->setQuery((string)$query);
				$cover = $db->loadAssocList();
			}
			if ($cover[0]['path'] !=''){
				$gall_cover = '<img src="'.FGalleryHelper::fgallery_create_thumb_url($width).$cover[0]['path'].'" alt="'.$cover[0]['title'].'" />';
			}
			return $gall_cover;
		}
                
         public function prepare_settings($data) {
		unset($data['option']);
		unset($data['task']);
                if ($data['gallery']['gall_type'] != $data['gallery']['old_gall_type'])
                    $data = FGalleryHelper::fgallery_default_album_settings($data['gallery']['gall_type']);
		unset($data['gallery']);
                return $data;
	}

        function fgallery_get_settings_param($param, $settings) {
            $name = (string)$param['element_name'];
            return $settings[$name];
        }

         function fgallery_get_album_settings($gall_id) {
		 if (!isset($gall_id)) $gall_id = 0;
            JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
            $settings =& JTable::getInstance('settings', 'FGalleryTable');
            $db = & JFactory::getDbo();
            $query = 'SELECT id FROM #__fgallery_gallery_settings'
					.' WHERE gall_id ='.$gall_id;
            $db->setQuery($query);
            if (!$db->query()) {
				return JError::raiseWarning(500, $db->getErrorMsg());
            }
            $result = $db->loadResult();
            $settings->load($result);
            $config = unserialize($settings->value);
            if (empty($config)) {
                $gallery = & JTable::getInstance('gallery', 'FGalleryTable');
                $gallery->load($gall_id);
                $config = FGalleryHelper::fgallery_default_album_settings($gallery->gall_type);
            }
            return $config;
         }
		 
        public function fgallery_get_album_images($gall_id, $album_id) {
                if (!is_numeric($gall_id)) die();
                if (!is_numeric($album_id)) die();
                $db = & JFactory::getDbo();
                $query = $db->getQuery(true);
                        $query = ' SELECT a.*, b.* '.
                                 ' FROM #__fgallery_images as a '.
                                 ' LEFT JOIN #__fgallery_gallery_images as b ON(a.id = b.img_id) '.
                                 ' WHERE b.gall_id ='.$gall_id.
                                 ' AND b.gall_folder ='.$album_id.
                                 ' ORDER BY b.ordering ASC';
                        $db->setQuery((string)$query);
                        if (!$db->query()) {
                        return JError::raiseWarning(500, $db->getErrorMsg());
                        }
                        $results = $db->loadAssocList();
                        return $results;
                }

         // returns default gallery settings if there is no user customize
function fgallery_default_album_settings($gall_type) {
      $settings = array();
      $params_xml = simplexml_load_file(JPATH_COMPONENT_ADMINISTRATOR . '/xml/params_'.$gall_type.'.xml');
      foreach ($params_xml->params->group as $g) {
          foreach ($g->p as $p) {
              $name = 'sc_' . $g['name'] . '__' . $p['name'];
              if ($p['control'] == 'color') {
                $settings[$name] = str_replace('0x','#',(string)$p['default']);
              } else {
                $settings[$name] = (string)$p['default'];
              }
          }
      }		
    return $settings;
    }
}