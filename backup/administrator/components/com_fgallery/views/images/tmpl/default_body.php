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
$saveOrder	= $listOrder=='ordering';
$user		= JFactory::getUser();
$userId		= $user->get('id');
?>
<?php foreach($this->items as $i => $item): 
			$ordering	= ($listOrder == 'ordering');
			$canCheckin	= $item->checked_out == $userId || $item->checked_out == 0;
			$canChange	= $canCheckin;
?>
        <tr class="row<?php echo $i % 2; ?>">
                <td>
                        <?php echo $item->id; ?>
                </td>
                <td>
                        <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                </td>
				<td>
					<?php if (!$item->folder) {
								if ($item->path != '') echo '<img src="'.JURI::root().'index.php?option=com_fgallery&task=image&tmpl=component&width=200&image='.$item->path.'" width="100" alt="'.$item->title.'" />';
							} else {
								echo '<img src="'.JURI::base(true).'/components/com_fgallery/images/folder.png" width="100" alt="'.$item->title.'" />';
							}
					?>
				</td>
                <td>
					<?php if ($item->checked_out) : ?>
						<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'galleries.', $canCheckin); ?>
					<?php endif; ?>
						<?php if (!$item->folder):?>
						<a href="<?php echo JRoute::_('index.php?option=com_fgallery&view=image&task=edit&cid[]='.$item->id);?>">
							<?php echo $this->escape($item->title); ?></a>
						<?php else:?>
							<a href="<?php echo JRoute::_('index.php?option=com_fgallery&view=images&folder='.$item->id);?>">
							<?php echo $this->escape($item->title); ?></a>
						<?php endif;?>
                </td>
				<td>
                        <?php echo $item->description; ?>
                </td>
				<td>
                        <?php echo JHTML::_('date',$item->created, JText::_('DATE_FORMAT_LC3')); ?>
                </td>
				<td>
					<?php if (!$item->folder) {
							echo FGalleryHelper::formatBytes($item->size);
						} else {
							echo FGalleryHelper::getFolderSize($item->id);
						} ?>
				</td>
        </tr>
<?php endforeach; ?>
