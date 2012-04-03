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
$gall_id = (int)JRequest::getVar('gall_id');
?>

<a onclick="javascript:submitbutton('addtogallery')" class="button_link toolbar" href="#"><?php echo JText::_('COM_FGALLERY_ADD_IMAGES_TO_ALBUM')?></a>

<form action="<?php echo JRoute::_('index.php?option=com_fgallery&view=images&tmpl=component&layout=select'); ?>" method="post" name="adminForm">
        <table class="adminlist">
                <thead><?php echo $this->loadTemplate('head');?></thead>
                <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
                <tbody><?php echo $this->loadTemplate('body');?></tbody>
        </table>
		<div>
                <input type="hidden" name="task" value="" />
		<input type="hidden" name="controller" value="images" />
                <input type="hidden" name="boxchecked" value="0" />
                <input type="hidden" name="gall_id" value="<?php echo $gall_id?>" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
                <?php echo JHtml::_('form.token'); ?>
        </div>

</form>

<a onclick="javascript:submitbutton('addtogallery')" class="button_link toolbar" href="#"><?php echo JText::_('COM_FGALLERY_ADD_IMAGES_TO_ALBUM')?></a>

<script type="text/javascript">
	jQuery.noConflict();
	jQuery(document).ready(function(){
		jQuery('form input[type="checkbox"]').change(function(){
		c = jQuery(this).attr('checked');
		if (c) {
			state = 1;
		} else {
			state = 0;
		}
			jQuery.ajax({
				url  : '<?php echo Juri::root()?>administrator/index.php?option=com_fgallery&task=addtolist',
				type : "POST",
				data : ({'value' : jQuery(this).val() , 'state' : state})
			});
		});
	});
</script>