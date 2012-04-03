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
defined('_JEXEC') or die('Restricted Access');

$listOrder	= $this->lists['order'];
$listDirn	= $this->lists['order_Dir'];

?>
<tr>
        <th width="5">
            <a id="sort_url" href="<?php echo JRoute::_('index.php?option=com_fgallery&task=saveimageorder')?>" style="display:none;"></a>
		<?php echo JHtml::_('grid.sort', 'COM_FGALLERY_IMAGES_HEADING_ID', 'id', $listDirn, $listOrder); ?>
        </th>
        <th width="20">
                <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
        </th>      
        <th width="120" style="align: center; vertical-align: middle;">
                <?php echo JText::_('COM_FGALLERY_IMAGES_PREVIEW'); ?>
        </th>  		
        <th>
		<?php echo JHtml::_('grid.sort', 'COM_FGALLERY_IMAGES_TITLE', 'title', $listDirn, $listOrder); ?>
        </th>
	<th>
                <?php echo JText::_('COM_FGALLERY_IMAGES_DESCR'); ?>
        </th>
	<th>
		<?php echo JHtml::_('grid.sort', 'COM_FGALLERY_IMAGES_DATE', 'created', $listDirn, $listOrder); ?>
        </th>			
	<th>
                <?php echo JText::_('COM_FGALLERY_IMAGES_SIZE'); ?>
        </th>
</tr>
