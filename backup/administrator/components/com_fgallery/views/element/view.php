<?php
/**
 * @version		$Id: view.php 17299 2010-05-27 16:06:54Z ian $
 * @package		Joomla
 * @subpackage	Content
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

/**
 * HTML Article Element View class for the Content component
 *
 * @package		Joomla
 * @subpackage	Content
 * @since 1.5
 */
class FGalleryViewElement extends JView
{
	function display()
	{
		global $mainframe;

		// Initialize variables
		$db			= &JFactory::getDBO();
		$nullDate	= $db->getNullDate();

		$document	= & JFactory::getDocument();
		$document->setTitle(JText::_('Gallery Selection'));

		JHTML::_('behavior.modal');

		$template = $mainframe->getTemplate();
		$document->addStyleSheet("templates/$template/css/general.css");

		$limitstart = JRequest::getVar('limitstart', '0', '', 'int');


		$rows = &$this->get('List');
		$page = &$this->get('Pagination');
		JHTML::_('behavior.tooltip');
		?>
		<form action="index.php?option=com_fgallery&amp;task=element&amp;tmpl=component&amp;object=id" method="post" name="adminForm">

			<table class="adminlist" cellspacing="1">
			<thead>
				<tr>
					<th width="5">
						<?php echo JText::_( 'Num' ); ?>
					</th>
					<th class="title">
						<?php echo JHTML::_('grid.sort',   'Title', 'title', @$lists['order_Dir'], @$lists['order'] ); ?>
					</th>
					<th width="2%" class="title">
						<?php echo JHTML::_('grid.sort',   'ID', 'id', @$lists['order_Dir'], @$lists['order'] ); ?>
					</th>
				</tr>
			</thead>
			<tfoot>
			<tr>
				<td colspan="15">
					<?php echo $page->getListFooter(); ?>
				</td>
			</tr>
			</tfoot>
			<tbody>
			<?php
			$k = 0;
			for ($i=0, $n=count( $rows ); $i < $n; $i++)
			{
				$row = &$rows[$i];
				?>
				<tr class="<?php echo "row$k"; ?>">
					<td>
						<?php echo $page->getRowOffset( $i ); ?>
					</td>
					<td>
						<a style="cursor: pointer;" onclick="window.parent.jSelectGallery('<?php echo $row->id; ?>', '<?php echo str_replace(array("'", "\""), array("\\'", ""),$row->title); ?>', '<?php echo JRequest::getVar('object'); ?>');">
							<?php echo htmlspecialchars($row->title, ENT_QUOTES, 'UTF-8'); ?></a>
					</td>
					<td>
						<?php echo $row->id; ?>
					</td>
				</tr>
				<?php
				$k = 1 - $k;
			}
			?>
			</tbody>
			</table>

		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $lists['order_Dir']; ?>" />
		</form>
		<?php
	}
}
