<?php

class FGallery_XML_Builder {

function fgallery_build_configXML($config, $gallery_type, $params = NULL) {
    define('FGALLERY_PHP4_MODE', false);
    // create new XML document
    $configXML = self::fgallery_create_document();
    // create root element
    $xmlRoot = self::fgallery_create_element('config', '', $configXML);
    self::fgallery_append_child($configXML, $xmlRoot);
    // sort array to group by parameter's group
    ksort($config);

    if ($params != NULL){
        $config = json_decode(str_replace('musicPath',$params,json_encode($config)));
    }

    // set current group to empty string be default
    $current_group = '';
    foreach ($config as $key=>$value) {
        // check if this is a parameter
        if (preg_match('/sc_(.*)__(.*)/', $key, $matches)){
            if ($matches[1]!='') {
                // if group name is not empty
                if ($current_group != $matches[1]){
                    // add new group of the parameters to the list
                    $group = self::fgallery_create_element($matches[1], '', $configXML);
                    self::fgallery_append_child($xmlRoot, $group);
                    $current_group = $matches[1];
                }
                if ($matches[2]!='') {
                    // if param name is not empty
                  
                    if (preg_match('/\#[0-9A-Fa-f]{6}/', $value) && strlen($value) == 7){
                        if (strpos($value,'#')===false) {
                            $val = $value;
                        } else {
                            $val = '0x'.str_replace('#','',$value);
                        }                    
                    }else {
                        $val = $value;
                    }
                    if ($matches[2] == MUSIC_PATH) {
                        // if this is music parameter
                        $matches[2] = get_option('1_flash_gallery_'.$gallery_type , MUSIC_PATH);
                    }
                    // add new param to group element
                    $param = self::fgallery_create_element($matches[2], $val, $configXML);
                    
                    if ($gallery_type == 7 && $current_group == 'menu'){
                        $srcAttribute = $configXML->createAttribute('src');
                        $srcAttribute->value = JURI::base() .'components/com_fgallery/swf/skin/'.$matches[2].'.swf';
                        $param->appendChild($srcAttribute);
                    }
                    
                    self::fgallery_append_child($group, $param);
                }
            }
            //$current_group = $matches[1];
        }
    }

    // save document as XML
    self::fgallery_show_document($configXML);
}
    
    
function fgallery_create_document() {
    if (FGALLERY_PHP4_MODE) {
        $document = domxml_new_doc('1.0');
    } else {
        /* create a dom document with encoding utf8 */
        $document = new DOMDocument('1.0', 'UTF-8');
    }
    return $document;
}

/**
 * Displays the XML document
 * 
 * @param DOMDocument $document 
 */
function fgallery_show_document($document) {
    if (FGALLERY_PHP4_MODE) {
        echo $document->dump_mem(true);
    } else {
        echo $document->saveXML();
    }
}

/**
 * Create Element
 * 
 * @param string $name
 * @param string $value
 * @param DOMDocument $document
 * @return DOMElement 
 */
function fgallery_create_element($name, $value, &$document) {
    if (FGALLERY_PHP4_MODE) {
        $element = $document->create_element($name, $value);
    } else {
        $element = $document->createElement($name, $value);
    }
    return $element;
}

/**
 * Create CDATA section 
 * @param string $value
 * @param DOMDocument $document
 * @return DOMCDATASection 
 */
function fgallery_create_cdata_section($value, &$document){
    if (FGALLERY_PHP4_MODE) {
        $cdata = $document->create_cdata_section($value);
    } else {
        $cdata = $document->createCDATASection($value);
    }
    return $cdata;
}

/**
 * Append Child
 * 
 * @param DOMElement $parent
 * @param DOMElement $child
 * @return DOMElement parent 
 */
function fgallery_append_child(&$parent, $child) {
    if (FGALLERY_PHP4_MODE) {
        $parent->append_child($child);
    } else {
        $parent->appendChild($child);
    }
    return $parent;
}

/**
 * Removes child 
 * @param DOMElement $parent
 * @param DOMElement $child
 * @return DOMElement child 
 */
function fgallery_remove_child(&$parent, $child) {
    if (FGALLERY_PHP4_MODE) {
        $result = $parent->remove_child($child);
    } else {
        $result = $parent->removeChild($child);
    }
    return $result;
}

/**
 * Function to create attribute to image
 * 
 * @param string $name
 * @param string $value
 * @param DOMElement $parent
 * @param DOMDocument $imagesXML
 * @return DOMAttribute 
 */
function fgallery_create_attribute($name, $value, &$parent, &$document) {
    if (FGALLERY_PHP4_MODE) {
        $attribute = $document->create_attribute($name, $value);
        $parent->append_child($attribute);
    } else {
        $attribute = $document->createAttribute($name);
        $attribute->value = $value;
        $parent->appendChild($attribute);
    }
    return $attribute;
}    

}

?>