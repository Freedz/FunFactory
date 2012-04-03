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
$listDirn       = $this->lists['order_Dir'];

$gall_id = (int)JRequest::getVar('id');

?>
<?php foreach($this->items as $i => $item): 

?>
        <tr class="row<?php echo $i % 2; ?>  <?php if ($item->folder != 2) : ?>galleryimage<?php endif;?>" id="image_<?php echo $item->id?>">
                <td>
                        <?php echo $item->id; ?>
                </td>
                <td>
                        <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                </td>
                <td>
                        <?php if (!$item->folder) {
                                    if ($item->path != '') echo '<img src="'.JURI::root().'index.php?option=com_fgallery&task=image&tmpl=component&width=100&image='.$item->path.'" width="100" alt="'.$item->title.'" />';
                            } else {
                                    echo '<img src="'.JURI::base(true).'/components/com_fgallery/images/folder.png" width="100" alt="'.$item->title.'" />';
                            }
                        ?>
                </td>
                <td>
                    <?php if ($item->folder == 2) : ?>
                            <a href="<?php echo JRoute::_('index.php?option=com_fgallery&view=galleryimages&album='.$item->id.'&id='.$gall_id);?>"><?php echo $this->escape($item->title); ?></a>
                    <?php else:?>
                            <a href="<?php echo JRoute::_('index.php?option=com_fgallery&view=galleryimages&layout=image&img_id='.$item->id.'&id='.$gall_id.'&tmpl=component');?>"
                            rel="{handler: 'iframe', size: {x: 600, y: 480}}" class="modal">
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
                                        echo FGalleryHelper::countAlbumImages($item->id);
                                }?>
                </td>
        </tr>
<?php endforeach; ?>
