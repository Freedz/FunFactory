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
$gall_id = JRequest::getVar('gall_id');
?>
<form action="<?php echo JRoute::_('index.php?option=com_fgallery&view=image&layout=album')?>" method="post" name="adminForm" id="image-form">
        <fieldset class="adminform">
                <legend><?php echo JText::_( 'COM_FGALLERY_FOLDER_DETAILS' ); ?></legend>
				<label><?php echo JText::_('COM_FGALLERY_FOLDER_NAME_LABEL')?></label>
				<input type="text" name="title" size="40" value="<?php echo $this->item->title?>" />
        </fieldset>
        <div>
				<input type="hidden" name="folder" value="2" />
				<input type="hidden" name="gall_id" value="<?php echo $gall_id?>" />
				<input type="hidden" name="id" value="<?php echo (int) $this->item->id?>" />
                <input type="hidden" name="task" value="" />
				<input type="hidden" name="controller" value="image" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
</form>