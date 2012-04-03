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
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
/**
 * General Controller of FGallery component
 */
class FGalleryController extends JController
{

	/**
	 * Articles element
	 */
	function element()
	{
		$model	= &$this->getModel( 'element' );
		$view	= &$this->getView( 'element');
		$view->setModel( $model, true );
		$view->display();
	}
	
	/**
	 * display task
	 *
	 * @return void
	 */
	function display() 
	{
		require_once JPATH_ADMINISTRATOR.'/components/com_fgallery/helpers/fgallery.php';
		// set default view if not set
		JRequest::setVar('view', JRequest::getCmd('view', 'FGallery'));
                $this->params = &JComponentHelper::getParams( 'com_fgallery' );
		// call parent behavior
		parent::display();
        }
	
	/*
	 * scan all files on FTP server route $link.$dir
	 * $rec - include subfolders 
	 * the results are collected into $filename global array
	 */
	function scan_ftp($link, $dir, $rec) { 
		global $filename; 
		$file_list = ftp_rawlist($link, $dir); 
		foreach($file_list as $file) { 
		  list($acc, 
			   $bloks, 
			   $group, 
			   $user, 
			   $size, 
			   $month, 
			   $day, 
			   $year, 
			   $file) = preg_split("/[\s]+/", $file); 
		  if(substr($file, 0, 1) == '.') continue; 
		  if(substr($acc, 0, 1) == 'd') { 
			if ($rec) scan_ftp($link, $dir.$file."/", $rec); 
		  } 
		  if(substr($acc, 0, 1) == '-') { 
			$filename[] = $dir.$file; 
		  } 
		} 
	  } 
	  
	  /**
	   * gets files from ftp to server and inserting info into db
	   * $array - list of files
	   * $ftp_folder - folder id to insert image to
	   * $conn_id - FTP connection id
	   **/
	  function process_ftp($array, $ftp_folder, $conn_id, $resize) {
		@set_time_limit(0);
		$error = '';
		$i = 0;
		if (!empty($array)) {
			JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
				$url = str_replace('administrator','',JPATH_BASE);
			foreach ($array as $key=>$value) {
				$file_parts = pathinfo($value);
				$targetFile = $url. 'images/stories/fgallery/'.date("YmdHsi").mt_rand(0,10).'.'.$file_parts['extension'];
				$handle = fopen($targetFile, 'w');
				if (@ftp_fget($conn_id, $handle, $value, FTP_BINARY, 0)) {
				 $error .= "successfully written to $targetFile\n";
				} else {
				 $error .= "There was a problem while downloading $value to $targetFile\n";
				}
				fclose($handle);
                                			$targetFile =  str_replace('//','/',$targetPath) . $file_name;
                                
				$file = @getimagesize($targetFile);
				if (strpos($file['mime'],'image') === false) {
					$error .= "$targetFile is not an image file";
					unlink($targetFile);
				} else {
					$i++;
                                        if ($resize) FGalleryHelper::fgallery_resemple($targetFile);
                                        if ($this->params->get('watermark') == 1) FGalleryHelper::fgallery_watermark($targetFile);
					$img_size = filesize($targetFile);
					$img_path = str_replace($url,JURI::root( true ).'/',$targetFile);
					$image = array('title'=> $file_parts['basename'], 'folder' => 0, 'parent' => (int)$ftp_folder, 'created' => date("Y-m-d H:i:s"), 'path' => $img_path, 'size'=>$img_size, 'type' => $file['mime']);
					$row =& JTable::getInstance('image', 'FGalleryTable');
						 if (!$row->bind($image)) {
						   return JError::raiseWarning(500, $row->getError());
						  }	
						 if (!$row->store()) {
						   return JError::raiseWarning(500, $row->getError());
						  }
				}
			}
		}
		if ($error == '') {
			$error = $i;
		}
		return $error;
	  }
	  
	// function that recursively removes directory and all files in it
	function fgallery_delete_dir($path) {
		$files = glob("$path/*");
		foreach($files as $file) {
		  if(is_dir($file) && !is_link($file)) {
			fgallery_delete_dir($file);
		  } else {
			unlink($file);
		  }
		}
		rmdir($path);
	}

	// extract archive to temp dir
	function fgallery_process_zip($data, $folder, $resize) {
		if($data['fgallery_zip']['tmp_name']['size'] && $data['fgallery_zip']['type'] == 'application/zip'){
			jimport( 'joomla.filesystem.archive' );
			$url = str_replace('administrator','',JPATH_BASE);
			$tmp_fname = substr(md5($time), 0, 10) . '.zip';
			move_uploaded_file($data['fgallery_zip']['tmp_name'], $url . 'images/stories/fgallery/tmp/'. $tmp_fname);
			$filename = $url . 'images/stories/fgallery' . '/tmp/'. $tmp_fname;
			if (!is_dir($filename. '_dir')) {
				mkdir($filename. '_dir');
			}
			$result = JArchive::extract( $filename, $filename. '_dir');
			if($result === false){
				unlink($filename);
			}   

			unlink($filename);
			$uploaded_a_file = $this->fgallery_process_directory($filename. '_dir', $url . 'images/stories/fgallery', $folder, $resize);
			$this->fgallery_delete_dir($filename. '_dir');
			unset($data['fgallery_zip']);
			return $uploaded_a_file;
		}
	}

	// process temp directory and insert images to db
	function fgallery_process_directory($dir, $fgallery_dir, $folder, $resize){ 
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$items = glob("$dir/*");
				$i = 0;
				$url = str_replace('administrator','',JPATH_BASE);
		foreach($items as $item){
			$file_name = str_replace($dir.'/', '',$item);
			$file_name = str_replace(' ','_',$file_name);
			$file_name = strtolower($file_name);
			$file_pathinfo = pathinfo($file_name);
			$filename = str_replace('.'.$file_pathinfo['extension'],'',$file_name);
			$file_name = date("YmdHis").rand(0,100).'.'.$file_pathinfo['extension'];
			
			$newitem = $fgallery_dir . '/'. $file_name;
			if (copy($item, $newitem)){
				$fileinfo = getimagesize($newitem);
				$img_type = $fileinfo['mime'];
                                if ($resize) FGalleryHelper::fgallery_resemple($newitem);
                                if ($this->params->get('watermark') == 1) FGalleryHelper::fgallery_watermark($newitem);
				$img_path = str_replace($url,JURI::root( true ).'/',$newitem);
				$img_size = filesize($newitem);
				$image = array('title'=> $file_pathinfo['basename'], 'folder' => 0, 'parent' => $folder, 'created' => date("Y-m-d H:i:s"), 'path' => $img_path, 'size'=>$img_size, 'type' => $img_type);
				$row =& JTable::getInstance('image', 'FGalleryTable');
					 if (!$row->bind($image)) {
					   return JError::raiseWarning(500, $row->getError());
					  }	
					 if (!$row->store()) {
					   return JError::raiseWarning(500, $row->getError());
					  }
				$i++;
			}
		}
		return $i;
	}
	
	/**
	 *  Saves information about files uploaded via Uploadify into db
	 *  $post = array($title, $path, $size, etc...)
	 **/
	function save_uploaded() {
		$post = JRequest::get('post');
		if (!empty($post)) {
			JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
			$row = & JTable::getInstance('image', 'FGalleryTable');
			if (!$row->bind($post)) {
			   return JError::raiseWarning(500, $row->getError());
			}	
			if (!$row->store()) {
			   return JError::raiseWarning(500, $row->getError());
			}
			echo $row->id;
			die();
		}
	}
	
	function get_settings() {
		$post = JRequest::get('post');
		if (!empty($post) && is_numeric($post['id'])) {
			JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
			$row =& JTable::getInstance('gallery', 'FGalleryTable');
			 $row->load($post['id']);
			 echo $row->gall_width.'_'.$row->gall_height.'_'.str_replace('#','',$row->gall_bgcolor).'_'.$row->title;
			 die();
		}
	}
	
	/**
     * Task for handling file uploading via Zip Archive
	 **/
	function unzip() {
		JRequest::checkToken() or jexit('Invalid Token');
		if (!empty($_FILES)) {
                        if (isset($_POST['resize']) && is_numeric($_POST['resize'])) {
                                $resize = $_POST['resize'];
                        } else {
                                $resize = 0;
                        }
			$zip_folder = $_POST['fgallery_url_folder'];
			if ($zip_folder == '') $zip_folder = 0;
			$i = $this->fgallery_process_zip($_FILES, $zip_folder, $resize);
		}
		echo sprintf('%d image(s) were added to the list',$i);
		die();
	}
	
    /**
     * Task for handling file uploading via URL
     **/
	function upload_url() {
            	require_once JPATH_COMPONENT_ADMINISTATOR.'/helpers/fgallery.php';
		JRequest::checkToken() or jexit('Invalid Token');
		if (!empty($_POST)) {
			if (!empty($_POST['fgallery_url'])) {
                                if (isset($_POST['resize']) && is_numeric($_POST['resize'])) {
                                        $resize = $_POST['resize'];
                                } else {
                                        $resize = 0;
                                }
				JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
				$base = str_replace('administrator','',JPATH_BASE);
				$i = 0;
				$folder = $_POST['fgallery_url_folder'];
				if ($folder == '') $folder = 0;
				@set_time_limit(0);
				foreach ($_POST['fgallery_url'] as $url) {
					$info = parse_url($url);
					$file_pathinfo = pathinfo($info['path']);
					$file_name = $base. 'images/stories/fgallery/'.date("YmdHis").rand(0,100).'.'.$file_pathinfo['extension'];
					$fp = fopen($file_name, 'w');
					fwrite($fp, file_get_contents($url));
					fclose($fp); 
					$fileinfo = getimagesize($file_name);
					$img_type = $fileinfo['mime'];
					if (strpos($img_type,'image') === false) {
						echo sprintf(__('%s is not an image'),$url).'<br />';
						unlink($file_name);
						continue;
					}
                                        if ($resize) FGalleryHelper::fgallery_resemple($file_name);
					$img_path = str_replace($base,JURI::root( true ).'/',$file_name);
					$size = filesize($file_name);
					$image = array('title'=> JText::_('COM_FGALLERY_IMAGE_FROM_URL'), 'folder' => 0, 'parent' => $folder, 'created' => date("Y-m-d H:i:s"), 'path' => $img_path, 'size'=>$size, 'type' => $img_type);
					$row =& JTable::getInstance('image', 'FGalleryTable');
						 if (!$row->bind($image)) {
						   return JError::raiseWarning(500, $row->getError());
						  }	
						 if (!$row->store()) {
						   return JError::raiseWarning(500, $row->getError());
						  }
					$i++;
				}
			}
		}
		echo sprintf('%d image(s) were added to the list',$i);
		die();
	}
		
	/**
     * Task for handling file uploading via FTP
	 **/	
	function ftp_upload() {
		global $filename;
		JRequest::checkToken() or jexit('Invalid Token');
		if (!empty($_POST)) {
			if ($_POST['ftp_name'] != '') {
				$ftp_name = $_POST['ftp_name'];
				$ftp_user = $_POST['ftp_username'];
				$ftp_pass = $_POST['ftp_pass'];
                                if (isset($_POST['resize']) && is_numeric($_POST['resize'])) {
					$resize = $_POST['resize'];
				} else {
					$resize = 0;
				}
				$connect = ftp_connect($ftp_name) or die("Couldn't connect to $ftp_name");
				if ($ftp_pass !='') {
					if (!@ftp_login($connect, $ftp_user, $ftp_pass)) {
						die("Couldn't login to $ftp_name");
					}
				}
				$ftp_folder = $_POST['fgallery_url_folder'];
				if ($ftp_folder == '') $ftp_folder = 0;
				$rec = $_POST['fgallery_ftp_subfolders'];
				ftp_chdir($connect, $ftp_folder);
				// enabling passive mode
				ftp_pasv( $connect, true );
				// get contents of the current directory
				$this->scan_ftp($connect, $ftp_folder, $rec); 
				$result = $this->process_ftp($filename,$ftp_foldet,$connect, $resize);
				ftp_close($connect);
			}
		}
		die();
	}
	/**
     * Task for handling file uploading via Media Gallery
	 **/
	function media_upload() {
		JRequest::checkToken() or jexit('Invalid Token');
		if (!empty($_POST['media'])) {
			JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
			$medias = $_POST['media'];
			$folder = $_POST['fgallery_url_folder'];
			if ($folder == '') $folder = 0;
			foreach ($medias as $key=>$value) {
					$fileinfo = getimagesize(JPATH_ROOT.str_replace(JURI::root(true),'',$value));
					$img_type = $fileinfo['mime'];
					$size = filesize(JPATH_ROOT.str_replace(JURI::root(true),'',$value));
					$image = array('title'=> JText::_('COM_FGALLERY_IMAGE_FROM_MEDIA'), 'folder' => 0, 'parent' => $folder, 'created' => date("Y-m-d H:i:s"), 'path' => $value, 'size'=>$size, 'type' => $img_type);
					$row =& JTable::getInstance('image', 'FGalleryTable');
						 if (!$row->bind($image)) {
						   return JError::raiseWarning(500, $row->getError());
						  }	
						 if (!$row->store()) {
						   return JError::raiseWarning(500, $row->getError());
						  }
			}
			echo sprintf('%d image(s) were added to the list',count($medias));
		}
		die();
	}
	/**
	 * Adds information about selected images
	 * that are going to be inserted to gallery
	 **/
	function addtolist() {
		if (!empty($_POST)) {
			if ($_POST['state'] == 1) {
				$_SESSION['image'][] = $_POST['value'];
			} else {
				$key = array_search($_POST['value'], $_SESSION['image']);
				unset($_SESSION['image'][$key]);
			}
		}
		die();
	}
        
        /**
         * Sorting Gallery images 
         */
        function saveimageorder() {
            $get = JRequest::get('get');
            if (isset($get['id']) && is_numeric($get['id'])) {
                    $img_id = $get['id'];
            } else {
                    jexit('Invalid Image Id');
            }
            if (isset($get['gall_id']) && is_numeric($get['gall_id'])) {
                    $gall_id = $get['gall_id'];
            } else {
                    jexit('Invalid Gallery Id');
            }
            if (isset($get['order']) && is_numeric($get['order'])) {
                    $order = $get['order'];
            } else {
                    jexit('Invalid Gallery Id');
            }
            global $mainframe;
            $limitstart = $mainframe->getUserStateFromRequest( 'com_fgallery.galleryimages.limitstart', 'limitstart', 0, 'int' );
            $new_order = $limitstart+$order;
            $db = & JFactory::getDbo();
            $query = 'UPDATE #__fgallery_gallery_images '.
                     ' SET ordering = ' .$new_order.
                     ' WHERE img_id = '.$img_id.' AND gall_id ='.$gall_id;
            $db->setQuery($query);
            if (!$db->query()) {
                    return JError::raiseWarning(500, $row->getError());
            }
            die(1);
        }
        
         /**
         * Returns text for image from gallery
         * @global type $wpdb 
         * @param integer $img_id
         * @param integer $gall_id
         * @return string
         */
        function fgallery_get_image_text(){
            if (isset($_REQUEST['img_id']) && is_numeric($_REQUEST['img_id'])) {
                $img_id = $_REQUEST['img_id'];
            } else {
                die();
            }
            if (isset($_REQUEST['gall_id']) && is_numeric($_REQUEST['gall_id'])) {
                $gall_id = $_REQUEST['gall_id'];
            } else {
                die();
            }
            $db = & JFactory::getDbo();
            $query = "SELECT img_extra FROM #__fgallery_gallery_images 
                      WHERE img_id = ".$img_id." AND gall_id =".$gall_id;
            $db->setQuery($query);
            $res = $db->loadAssoc();
            if ($res) {
                $img_extra = unserialize($res['img_extra']);
                echo stripslashes(html_entity_decode($img_extra['img_text'],ENT_NOQUOTES,"UTF-8"));
            }
            die();
        }
        
                /**
         * Provides uploading with Local Uploader method
         */
        function local(){
            require_once JPATH_COMPONENT_ADMINISTRATOR.'/helpers/uploader.class.php';
            $upload_handler = new UploadHandler();

            header('Pragma: no-cache');
            header('Cache-Control: private, no-cache');
            header('Content-Disposition: inline; filename="files.json"');
            header('X-Content-Type-Options: nosniff');

            switch ($_SERVER['REQUEST_METHOD']) {
                case 'HEAD':
                case 'GET':
                    $upload_handler->get();
                    break;
                case 'POST':
                    $upload_handler->post();
                    break;
                case 'DELETE':
                    $upload_handler->delete();
                    break;
                case 'OPTIONS':
                    break;
                default:
                    header('HTTP/1.0 405 Method Not Allowed');
            }
            die();
        }
}
