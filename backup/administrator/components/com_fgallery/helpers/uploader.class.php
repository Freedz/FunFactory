<?php

class UploadHandler
{
    private $options;
    
    function __construct($options=null) {
        $base = str_replace('administrator','',JPATH_BASE);
        $base_url = str_replace('administrator','',JURI::root());
        $this->options = array(
            'script_url' => JRoute::_('index.php?option=com_fgallery&task=local&tmpl=component'),
            'upload_dir' => $base. 'images/stories/fgallery/',
            'upload_url' => $base_url. 'images/stories/fgallery/',
            'param_name' => 'files',
            // The php.ini settings upload_max_filesize and post_max_size
            // take precedence over the following max_file_size setting:
            'max_file_size' => null,
            'min_file_size' => 1,
            'accept_file_types' => '/.(jpg|jpeg|gif|bmp|png)$/i',
            'max_number_of_files' => null,
            'discard_aborted_uploads' => true,
            'image_versions' => array(
                // Uncomment the following version to restrict the size of
                // uploaded images. You can also add additional versions with
                // their own upload directories:
                /*
                'large' => array(
                    'upload_dir' => dirname(__FILE__).'/files/',
                    'upload_url' => dirname($_SERVER['PHP_SELF']).'/files/',
                    'max_width' => 1920,
                    'max_height' => 1200
                ),
                
                'thumbnail' => array(
                    'upload_dir' => dirname(__FILE__).'/thumbnails/',
                    'upload_url' => dirname($_SERVER['PHP_SELF']).'/thumbnails/',
                    'max_width' => 80,
                    'max_height' => 80
                )
                 */
            )
        );
        if ($options) {
            $this->options = array_replace_recursive($this->options, $options);
        }
    }
    
    private function get_file_object($file_name) {
        $file_path = $this->options['upload_dir'].$file_name;
        if (is_file($file_path) && $file_name[0] !== '.') {
            $file = new stdClass();
            $file->name = $file_name;
            $file->size = filesize($file_path);
            $file->url = $this->options['upload_url'].rawurlencode($file->name);
            $file->thumbnail_url = JURI::root().'index.php?option=com_fgallery&task=image&tmpl=component&width=200&image='.$file_name;
            $file->delete_url = $this->options['script_url']
                .'&file='.rawurlencode($file->name);
            $file->delete_type = 'DELETE';
            return $file;
        }
        return null;
    }
    
    private function get_file_objects() {
        return array_values(array_filter(array_map(
            array($this, 'get_file_object'),
            scandir($this->options['upload_dir'])
        )));
    }
    
    private function has_error($uploaded_file, $file, $error) {
        if ($error) {
            return $error;
        }
        
        $fileinfo = getimagesize($uploaded_file);
        $img_type = $fileinfo['mime'];
        if (strpos($img_type,'image') === false) {
             @unlink($uploaded_file);
             return sprintf('%s is not an image',$file->name);
        }
        
        if (strpos($file->type,'image') === false) {
            return 'acceptFileTypes';
        }        
        
        if (!preg_match($this->options['accept_file_types'], $file->name)) {
            return 'acceptFileTypes';
        }
        if ($uploaded_file && is_uploaded_file($uploaded_file)) {
            $file_size = filesize($uploaded_file);
        } else {
            $file_size = $_SERVER['CONTENT_LENGTH'];
        }
        if ($this->options['max_file_size'] && (
                $file_size > $this->options['max_file_size'] ||
                $file->size > $this->options['max_file_size'])
            ) {
            return 'maxFileSize';
        }
        if ($this->options['min_file_size'] &&
            $file_size < $this->options['min_file_size']) {
            return 'minFileSize';
        }
        if (is_int($this->options['max_number_of_files']) && (
                count($this->get_file_objects()) >= $this->options['max_number_of_files'])
            ) {
            return 'maxNumberOfFiles';
        }
        return $error;
    }
    
    private function trim_file_name($name, $type) {
        // Remove path information and dots around the filename, to prevent uploading
        // into different directories or replacing hidden system files.
        // Also remove control characters and spaces (\x00..\x20) around the filename:
        $file_name = trim(basename(stripslashes($name)), ".\x00..\x20");
        // Add missing file extension for known image types:
        if (strpos($file_name, '.') === false &&
            preg_match('/^image\/(gif|jpe?g|png)/', $type, $matches)) {
            $file_name .= '.'.$matches[1];
        }
        return $file_name;
    }
    
    private function handle_file_upload($uploaded_file, $name, $size, $type, $error) {
        $file = new stdClass();
        $file->name = $this->trim_file_name($name, $type);
        $clean_name = $file->name;
        $file_extension = pathinfo($clean_name);
        $file->size = intval($size);
        $file->type = $type;
        $error = $this->has_error($uploaded_file, $file, $error);
        if (!$error && $file->name) {
            $file->name = date("YmdHis").rand(0,100).'.'.$file_extension['extension'];
            $file_path = $this->options['upload_dir'].$file->name;
            $append_file = !$this->options['discard_aborted_uploads'] &&
                is_file($file_path) && $file->size > filesize($file_path);
            clearstatcache();
            if ($uploaded_file && is_uploaded_file($uploaded_file)) {
                // multipart/formdata uploads (POST method uploads)
                if ($append_file) {
                    file_put_contents(
                        $file_path,
                        fopen($uploaded_file, 'r'),
                        FILE_APPEND
                    );
                } else {
                    move_uploaded_file($uploaded_file, $file_path);
                }
            } else {
                // Non-multipart uploads (PUT method support)
                file_put_contents(
                    $file_path,
                    fopen('php://input', 'r'),
                    $append_file ? FILE_APPEND : 0
                );
            }
            $file_size = filesize($file_path);
            if ($file_size === $file->size) {
                $file->url = $this->options['upload_url'].rawurlencode($file->name);
            } else if ($this->options['discard_aborted_uploads']) {
                unlink($file_path);
                $file->error = 'abort';
            }
            $file->size = $file_size;
            
            // write info to database
            JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
            require_once JPATH_COMPONENT_ADMINISTRATOR.'/helpers/fgallery.php';
            
            if (isset($_REQUEST['resize']) && is_numeric($_REQUEST['resize'])) {
                    $resize = $_REQUEST['resize'];
            } else {
                    $resize = 0;
            }
            
            if (isset($_REQUEST['folder']) && is_numeric($_REQUEST['folder'])) {
                    $folder = $_REQUEST['folder'];
            } else {
                    $folder = 0;
            }
            if ($resize) FGalleryHelper::fgallery_resemple($file_path);
            $params = &JComponentHelper::getParams( 'com_fgallery' );
            if ($params->get('watermark',0) == 1) FGalleryHelper::fgallery_watermark($file_path);          
            $img_path = JURI::root( true ).'/images/stories/fgallery/'.$file->name;
            $image = array('title'=> $clean_name,
                           'folder' => 0,
                           'parent' => $folder,
                           'created' => date("Y-m-d H:i:s"),
                           'path' => $img_path,
                           'size'=>$file->size,
                           'type' => $file->type);
            $row =& JTable::getInstance('image', 'FGalleryTable');
                     if (!$row->bind($image)) {
                       return JError::raiseWarning(500, $row->getError());
                      }	
                     if (!$row->store()) {
                       return JError::raiseWarning(500, $row->getError());
                      }
            $file->delete_url = $this->options['script_url']
                .'&file='.rawurlencode($file->name).'&id='.$row->id;
            $file->delete_type = 'DELETE';
            $file->thumbnail_url = JURI::root().'index.php?option=com_fgallery&task=image&tmpl=component&width=80&image='.$img_path;
        } else {
            $file->error = $error;
        }
        return $file;
    }
    
    public function get() {
        $file_name = isset($_REQUEST['file']) ?
            basename(stripslashes($_REQUEST['file'])) : null; 
        if ($file_name) {
            $info = $this->get_file_object($file_name);
        } else {
            $info = $this->get_file_objects();
        }
        header('Content-type: application/json');
        echo json_encode($info);
    }
    
    public function post() {
        $upload = isset($_FILES[$this->options['param_name']]) ?
            $_FILES[$this->options['param_name']] : null;
        $info = array();
        if ($upload && is_array($upload['tmp_name'])) {
            foreach ($upload['tmp_name'] as $index => $value) {
                $info[] = $this->handle_file_upload(
                    $upload['tmp_name'][$index],
                    isset($_SERVER['HTTP_X_FILE_NAME']) ?
                        $_SERVER['HTTP_X_FILE_NAME'] : $upload['name'][$index],
                    isset($_SERVER['HTTP_X_FILE_SIZE']) ?
                        $_SERVER['HTTP_X_FILE_SIZE'] : $upload['size'][$index],
                    isset($_SERVER['HTTP_X_FILE_TYPE']) ?
                        $_SERVER['HTTP_X_FILE_TYPE'] : $upload['type'][$index],
                    $upload['error'][$index]
                );
            }
        } elseif ($upload) {
            $info[] = $this->handle_file_upload(
                $upload['tmp_name'],
                isset($_SERVER['HTTP_X_FILE_NAME']) ?
                    $_SERVER['HTTP_X_FILE_NAME'] : $upload['name'],
                isset($_SERVER['HTTP_X_FILE_SIZE']) ?
                    $_SERVER['HTTP_X_FILE_SIZE'] : $upload['size'],
                isset($_SERVER['HTTP_X_FILE_TYPE']) ?
                    $_SERVER['HTTP_X_FILE_TYPE'] : $upload['type'],
                $upload['error']
            );
        }
        header('Vary: Accept');
        if (isset($_SERVER['HTTP_ACCEPT']) &&
            (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
            header('Content-type: application/json');
        } else {
            header('Content-type: text/plain');
        }
        echo json_encode($info);
    }
    
    public function delete() {
        $file_name = isset($_REQUEST['file']) ?
            basename(stripslashes($_REQUEST['file'])) : null;
        if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
            $id = $_REQUEST['id'];
        } else {
            echo 'Invalid Image Id';
            die();
        }
        $file_path = $this->options['upload_dir'].$file_name;
        $success = is_file($file_path) && $file_name[0] !== '.' && unlink($file_path);
        if ($success) {
            JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
            $row =& JTable::getInstance('image', 'FGalleryTable');
            $row->load($id);
            $row->delete();
        }
        header('Content-type: application/json');
        echo json_encode($success);
    }
}
