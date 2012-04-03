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
$user		= JFactory::getUser();
$userId		= $user->get('id');
?>
<?php foreach($this->items as $i => $item): 
			$ordering	= ($listOrder == 'ordering');
			$canCheckin	= $item->checked_out == $userId || $item->checked_out == 0;
			$canEditOwn	= $item->created_by == $userId;
			$canChange	= $canCheckin;
			$item->published = $item->state;
?>
        <tr class="row<?php echo $i % 2; ?>">
                <td>
                        <?php echo $item->id; ?>
                </td>
                <td>
                        <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                </td>
                <td>
					<?php if ($item->checked_out) : ?>
						<?php echo JHtml::_('grid.checkedout', $i, $item->editor); ?>
					<?php endif; ?>
					<?php if ($canEdit || $canEditOwn) : ?>
						<a href="<?php echo JRoute::_('index.php?option=com_fgallery&view=gallery&id='.$item->id);?>">
							<?php echo $this->escape($item->title); ?></a>
					<?php else : ?>
						<?php echo $this->escape($item->title); ?>
					<?php endif; ?>
                </td>
				<td>
                        <?php echo $item->description; ?>
                </td>
				<td align="center">
					<?php echo JHtml::_('grid.published', $item, $i); ?>
				</td>
				<td class="order">
					<?php if ($canChange) : ?>
						<?php if ($saveOrder) : ?>
							<?php if ($listDirn == 'asc') : ?>
								<span><?php echo $this->pagination->orderUpIcon($i, (1 == 1), 'orderup', 'COM_FGALLERY_MOVE_UP', $ordering); ?></span>
								<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, (1 == 1), 'orderdown', 'COM_FGALLERY_MOVE_DOWN', $ordering); ?></span>
							<?php elseif ($listDirn == 'desc') : ?>
								<span><?php echo $this->pagination->orderUpIcon($i, (1 == 1), 'orderdown', 'COM_FGALLERY_MOVE_UP', $ordering); ?></span>
								<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, ( 1 == 1), 'orderup', 'COM_FGALLERY_MOVE_DOWN', $ordering); ?></span>
							<?php endif; ?>
						<?php endif; ?>
						<?php $disabled = $saveOrder ?  '' : 'disabled="disabled"'; ?>
						<input type="text" name="order[]" size="5" value="<?php echo $item->ordering;?>" <?php echo $disabled;?> class="text-area-order" />
					<?php else : ?>
						<?php echo $item->ordering; ?>
					<?php endif; ?>
				</td>
				<td>
                        <?php echo JHTML::_('date',$item->created, JText::_('DATE_FORMAT_LC3')); ?>
                </td>
				<td>
					<?php echo JText::_('COM_FGALLERY_NUM_OF_PHOTOS').': '.(int)$item->images ?> <br />
					<?php echo JText::_('COM_FGALLERY_TOTAL_SIZE').': '.FGalleryHelper::formatBytes($item->size)?> <br />
				</td>
        </tr>
<?php endforeach; ?>
