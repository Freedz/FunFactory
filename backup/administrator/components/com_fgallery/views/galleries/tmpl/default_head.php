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

$listOrder	= $this->lists['order'];
$listDirn	= $this->lists['order_Dir'];
$saveOrder	= $listOrder=='ordering';
?>
<tr>
        <th width="5">
				<?php echo JHtml::_('grid.sort', 'COM_FGALLERY_GALLERIES_HEADING_ID', 'id', $listDirn, $listOrder); ?>
        </th>
        <th width="20">
                <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
        </th>                     
        <th>
			<?php echo JHtml::_('grid.sort', 'COM_FGALLERY_GALLERIES_TITLE', 'title', $listDirn, $listOrder); ?>
        </th>
		<th>
                <?php echo JText::_('COM_FGALLERY_GALLERIES_DESCR'); ?>
        </th>	
		<th>
			<?php echo JHtml::_('grid.sort', 'COM_FGALLERY_GALLERIES_PUPLISHED', 'state', $listDirn, $listOrder); ?>
        </th>
		<th>
			<?php echo JHtml::_('grid.sort', 'COM_FGALLERY_GALLERIES_ORDER', 'ordering', $listDirn, $listOrder); ?>
			<?php if ($saveOrder) :?>
				<?php echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'saveorder'); ?>
			<?php endif; ?>
        </th>
		<th>
			<?php echo JHtml::_('grid.sort', 'COM_FGALLERY_GALLERIES_DATE', 'created', $listDirn, $listOrder); ?>
        </th>			
		<th>
                <?php echo JText::_('COM_FGALLERY_GALLERIES_ATTR'); ?>
        </th>
</tr>
