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
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');

?>
<script type="text/javascript">
    function submitbutton(action) {
          var form = document.adminForm;
          switch(action)
          {
          case 'save_url':
           <?php
                         $editor =& JFactory::getEditor();
                         echo $editor->save( 'img_text' );
                 ?>
          default:
           submitform( action );
          }
         } 
 </script>
<form action="<?php echo JRoute::_('index.php?option=com_fgallery'); ?>" method="post" name="adminForm" id="image-form">
        <fieldset class="adminform">
                <legend><?php echo JText::_( 'COM_FGALLERY_IMAGE_DETAILS' ); ?></legend>
                <a class="toolbar button_link" style="float: right;margin-right: 100px;" onclick="javascript:submitbutton('save_url')" href="#">
                    <?php echo JText::_('COM_FGALLERY_SAVE') ?>
                </a>
                <br clear="all" />
                <label for="img_title">
                    <?php echo JText::_('COM_FGALLERY_IMAGE_TITLE_LABEL')?>
                </label>
                <input type="text" name="img_title" id="img_title" value="<?php echo $this->image->title?>" /><br />
                <label for="img_url">
                    <?php echo JText::_('COM_FGALLERY_IMAGE_URL_LABEL')?>
                </label>
                <input type="text" name="img_url" id="img_url" value="<?php echo $this->image->img_url?>" /><br />
                <?php 
                      $item_img_type = unserialize($this->image->img_extra);
                        if ($item_img_type['img_type'] == 'page') {
                            $selected_page = ' selected="selected"';
                            $selected_spread = '';
                        } else {
                            $selected_spread = ' selected="selected"';
                            $selected_page = '';
                        }
                ?>
                <label for="img_type">
                    <?php echo JText::_('COM_FGALLERY_IMAGE_TYPE_LABEL')?>
                </label>
                <select name="img_type" id="img_type">
                    <option value="page"<?php echo $selected_page?>>Page</option>
                    <option value="spread"<?php echo $selected_spread?>>Spread</option>
                </select> <br />
                <label for="img_description">
                    <?php echo JText::_('COM_FGALLERY_IMAGE_DESC_LABEL')?>
                </label>
                <textarea cols="70" rows="10" name="img_description" id="img_description"><?php echo $this->image->description?></textarea>
                <br clear="all" />
                <label for="img_text">
                    <?php echo JText::_('COM_FGALLERY_IMAGE_TEXT_LABEL')?>
                </label>
                <br clear="all" />
                 <?php $editor =& JFactory::getEditor();
                echo $editor->display( 'img_text',  stripslashes($item_img_type['img_text']), '550', '300', '70', '10', array('article','pagebreak', 'readmore', 'fgallery') ) ; ?>
                <br clear="all" />
                <a class="toolbar button_link" onclick="javascript:submitbutton('save_url')" href="#">
                    <?php echo JText::_('COM_FGALLERY_SAVE') ?>
                </a> <br />
		<img src="<?php echo JURI::root().'index.php?option=com_fgallery&task=image&tmpl=component&width=400&image='.$this->image->path?>" alt="<?php echo $this->image->title ?>" />
        </fieldset>
        <div>
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="controller" value="galleryimages" />
                <input type="hidden" name="img_id" value="<?php echo $this->image->id?>" />
                <input type="hidden" name="gall_id" value="<?php echo $this->image->gall_id?>" />

                <?php echo JHtml::_('form.token'); ?>
        </div>
</form>
