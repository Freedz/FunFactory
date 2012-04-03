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
?>
		<div id="fgallery_info" class="fgallery_box">
			<p><b>"1 Flash Gallery"</b> - photo gallery Joomla extension. It provides a comprehensive interface for managing photos and images through a set of admin pages, and it displays flash gallery in a way that makes your web site look very nice. You can display galleries with a beautiful image gallery skins integrated with "1 Flash Gallery".</p>

			<p>Flipping Book with Page Flip effect demo:
			The Flipping Book is adaptable and can almost be used by any user to create portfolio, wedding album or online publication.
			<a href="http://1extension.com/page-flip" target="_blank">http://1extension.com/page-flip</a></p>

			<p>Photo Gallery demos:</p>
			<ul>
				<li><a href="http://1extension.com/galleries/arai" target="_blank">http://1extension.com/galleries/arai</a></li> 
				<li><a href="http://1extension.com/galleries/airion" target="_blank">http://1extension.com/galleries/airion</a></li>
				<li><a href="http://1extension.com/galleries/acosta" target="_blank">http://1extension.com/galleries/acosta</a></li>
				<li><a href="http://1extension.com/galleries/pazin" target="_blank">http://1extension.com/galleries/pazin</a></li>
			</ul>
			<p>Photo Gallery features:</p>
			<ul>
				<li> Image gallery full screen viewing</li>
				<li> Slideshow function</li>
				<li> Multiple albums/categories per post</li>
				<li> Configurable photo gallery background, logo and highlight color</li>
				<li> Sort images feature</li>
				<li> Cool flash skin</li>
			</ul>
		</div>
		<div id="fgallery_faq" class="fgallery_box">
			<a href="http://1extension.com/faq" target="_blank">FAQ</a>
		</div>
		<h2><?php echo JText::_('COM_FGALLERY_PREF_PAGE')?></h2>
		<div id="fgallery_settings" class="fgallery_box">
			<h2><?php JText::_('COM_FGALLERY_SERVER_SETTINGS')?></h2>
                        <?php echo '<p><span class="lbl">'.JText::_('COM_FGALLERY_SERVER_NAME').'</span>'.$_SERVER['SERVER_NAME']."</p>";
                               echo '<p><span class="lbl">'.JText::_('COM_FGALLERY_DOCUMENT_ROOT').'</span>'.$_SERVER['DOCUMENT_ROOT']."</p>";
                               echo '<p><span class="lbl">'.JText::_('COM_FGALLERY_WEB_SERVER').'</span>'.$_SERVER['SERVER_SOFTWARE']."</p>";
                               echo '<p><span class="lbl">'.JText::_('COM_FGALLERY_HOST').'</span>'.$_SERVER['HTTP_HOST']."</p>";
                               echo '<p><span class="lbl">'.JText::_('COM_FGALLERY_CLIENT_AGENT').'</span>'.$_SERVER['HTTP_USER_AGENT']."</p>";
                               echo '<p><span class="lbl">'.JText::_('COM_FGALLERY_JOOMLA_VERSION').'</span>'.JVERSION ;
                               echo '<p><span class="lbl">'.JText::_('COM_FGALLERY_MAX_FILESIZE').'</span>'.ini_get('upload_max_filesize').'</p>';
                               echo '<p><span class="lbl">'.JText::_('COM_FGALLERY_MEMORY_LIMIT').'</span>'.ini_get('memory_limit').'</p>';
                               if (extension_loaded('gd') && function_exists('gd_info')) {
                                    $gd = JText::_('COM_FGALLERY_INSTALLED');
                                } else {
                                    $gd = '<span class="fgallery_error">'.JText::_('COM_FGALLERY_NOT_INSTALLED').'</span>';
                                }
                               echo '<p><span class="lbl">'.JText::_('COM_FGALLERY_GD').'</span>'.$gd.'</p>';
                               if (!is_dir(JPATH_SITE.'/images/stories/fgallery')) {
                                   echo '<p class="fgallery_error">'.JText::_("COM_FGALLERY_FOLDER").' images/stories/fgallery '.JText::_("COM_FGALLERY_DOESNT_EXIST").'</p>';
                               } elseif (!is_writeable(JPATH_SITE.'/images/stories/fgallery')) {
                                   echo '<p class="fgallery_error">'.JText::_("COM_FGALLERY_FOLDER").' images/stories/fgallery '.JText::_("COM_FGALLERY_NOT_WRITABLE").'</p>';
                               }
                               if (!is_dir(JPATH_SITE.'/images/stories/fgallery/tmp')) {
                                   echo '<p class="fgallery_error">'.JText::_("COM_FGALLERY_FOLDER").' images/stories/fgallery/tmp '.JText::_("COM_FGALLERY_DOESNT_EXIST").'</p>';
                               } elseif (!is_writeable(JPATH_SITE.'/images/stories/fgallery/tmp')) {
                                   echo '<p class="fgallery_error">'.JText::_("COM_FGALLERY_FOLDER").' images/stories/fgallery/tmp '.JText::_("COM_FGALLERY_NOT_WRITABLE").'</p>';
                               }
                         ?>
		</div>
		<script type="text/javascript">
			jQuery.noConflict();
		</script>
                <?php echo '<button id="copypref" rel="'.JURI::base(true).'/components/com_fgallery/swf/ZeroClipboard.swf">'.JText::_('COM_FGALLERY_COPY_SETTINGS').'</button>';?>
				