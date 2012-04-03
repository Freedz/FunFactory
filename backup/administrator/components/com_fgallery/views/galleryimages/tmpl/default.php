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
defined('_JEXEC') or die('Restricted Access');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');

$listOrder	= $this->lists['order'];
$listDirn	= $this->lists['order_Dir'];
$gall_id = (int)JRequest::getVar('id');
$album = (int)JRequest::getVar('album');
?>
<form action="<?php echo JRoute::_('index.php?option=com_fgallery&view=galleryimages'); ?>" method="post" name="adminForm">
		<fieldset id="images-actions">
                    <label for="move_to_album">
                        <?php echo JText::_('COM_FGALLERY_CHOOSE_ALBUM_LABEL')?></label>
                        <?php $albums = FGalleryHelper::getAlbums();
			     echo JHTML::_('select.genericlist', $albums, 'move_to_album', null, 'value', 'text', '');?>
		</fieldset>
        <table class="adminlist" id="<?php echo $gall_id?>">
                <thead><?php echo $this->loadTemplate('head');?></thead>
                <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
                <tbody><?php echo $this->loadTemplate('body');?></tbody>
        </table>
	<div>
                <input type="hidden" name="task" value="" />
		<input type="hidden" name="controller" value="galleryimages" />
                <input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<input type="hidden" name="id" value="<?php echo $gall_id?>" />
		<input type="hidden" name="album" value="<?php echo $album?>" />
                <?php echo JHtml::_('form.token'); ?>
        </div>

</form>
