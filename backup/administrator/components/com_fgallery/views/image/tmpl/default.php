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
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');

?>
<form action="<?php echo JRoute::_('index.php?option=com_fgallery&view=image&task=edit&cid[]='.(int) $this->item->id); ?>" method="post" name="adminForm" id="image-form" enctype="multipart/form-data">
        <fieldset class="adminform">
                <legend><?php echo JText::_( 'COM_FGALLERY_IMAGE_DETAILS' ); ?></legend>
				<label for="title">
					<?php echo JText::_( 'Caption' ); ?>:
				</label>
				<input type="text" name="title" size="128" value="<?php echo $this->item->title?>" id="title" />
				<br clear="all" />
				<label for="title">
					<?php echo JText::_( 'Description' ); ?>:
				</label>
					<?php echo $this->editor->display( 'description',  $this->item->description, '550', '300', '60', '20', array() ) ; ?>
				<br clear="all" />
				<?php if ($this->item->path != ''):?>
				<a href="<?php echo $this->item->path?>" title="<?php echo JText::_('COM_FGALLERY_CLICK_TO_VIEW_LARGE')?>" target="_blank">
					<img src="<?php echo JURI::root().'index.php?option=com_fgallery&task=image&tmpl=component&width=400&image='.$this->item->path?>" alt="<?php echo $this->item->title ?>" />
				</a>
				<?php endif;?>
                                <br clear="all" />
                                <label for="preview"><?php echo JText::_('COM_FGALLERY_PREVIEW_UPLOAD_TEXT')?></label>
                                <input type="file" name="preview_path" id="preview" /> <br clear="all" />
                                <?php if ($this->item->preview_path != ''):?>
                                <a href="<?php echo $this->item->preview_path?>" title="<?php echo JText::_('COM_FGALLERY_CLICK_TO_VIEW_LARGE')?>" target="_blank">
                                        <img src="<?php echo JURI::root().'index.php?option=com_fgallery&task=image&tmpl=component&width=400&image='.$this->item->preview_path?>" alt="<?php echo $this->item->title ?>" />
                                </a>
                                <?php endif;?>
        </fieldset>
        <div>
                <input type="hidden" name="task" value="" />
				<input type="hidden" name="cid[]" value="<?php echo $this->item->id ?>" />
                <input type="hidden" name="controller" value="image" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
</form>