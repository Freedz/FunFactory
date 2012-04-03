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
unset($_SESSION['image']);
JHtml::_('behavior.tooltip');

?>
<script type="text/javascript">
	jQuery.noConflict();
</script>
        <fieldset class="adminform">
                <legend><?php echo JText::_( 'COM_FGALLERY_GALLERY_DETAILS' ); ?></legend>
                <?php if ($this->item->gall_type != '') {
					$gall_type = $this->item->gall_type;
				} else {
					$gall_type = 3;
				} ?>
					<?php if ($this->item->state == 1 && $this->item->id != 0) : ?>   
						<p><?php echo JText::_('COM_FGALLERY_EMBED_CODE')?> </p>
						<div id="shortcode_view">[fgallery id=<?php echo $this->item->id?> w=<?php echo $this->item->gall_width?> h=<?php echo $this->item->gall_height?> bg=<?php echo str_replace('#','',$this->item->gall_bgcolor)?> t=0 title="<?php echo $this->item->title?>"]</div>
						<button id="shortcode" rel="<?php echo JURI::base(true)?>/components/com_fgallery/swf/ZeroClipboard.swf"><?php echo JText::_('COM_FGALLERY_COPY_TO_CLIPBOARD') ?></button>
						<br clear="all" />
					<?php endif;?>
				<form method="post" action="<?php echo JRoute::_('index.php?option=com_fgallery&view=gallery&layout=edit&id='.(int) $this->item->id)?>" id="gallery-form" name="adminForm" enctype="multipart/form-data">
				<div>
				  <?php
					$params_xml = simplexml_load_file(JPATH_COMPONENT_ADMINISTRATOR . '/xml/params_'.$gall_type.'.xml');
					$settings = FGalleryHelper::fgallery_get_album_settings($this->item->id);
                                        $s = array('element_name'=>'sc_slideshow__source');
                                        $source = FGalleryHelper::fgallery_get_settings_param($s, $settings);
				  ?>
				  
                                  <ul>
                                        <li><a href="#sc-group-general"><?php echo JText::_('COM_FGALLERY_GENERAL') ?></a></li>
                                  <?php foreach ($params_xml->params->group as $g):
                                            if (isset($g['type']) && $g['type'] == 'source') {
                                                if ($g['name'] == $source){
                                                ?>
                                                    <li><a href="#sc-group-<?php echo $g['name'] ?>"><?php echo $g['title'] ?></a></li>					
                                  <?php         }
                                            } else { ?>
                                                <li><a href="#sc-group-<?php echo $g['name'] ?>"><?php echo $g['title'] ?></a></li>					
                                  <?php     }
                                        endforeach ;?>
                                  </ul>
				  <div id="sc-group-general">
					<div class="form-item">
						<label for="title"><?php echo JText::_('COM_FGALLERY_GALLERY_TITLE_LABEL')?></label>
						<input type="text" class="inputbox" size="40" name="gallery[title]" id="title" value="<?php echo $this->item->title?>" />
					</div>
					<div class="form-item">
						<label for="desciption">
							<?php echo JText::_( 'COM_FGALLERY_GALLERY_DESC_LABEL' ); ?>:
						</label>
					</div>
					<br clear="all" />
					<?php echo $this->editor->display( 'gallery[description]',  $this->item->description, '550', '300', '60', '20', array('pagebreak', 'readmore', 'fgallery') ) ; ?>
					<div class="form-item">
						<label for="state">
							<?php echo JText::_( 'COM_FGALLERY_STATE' ); ?>:
						</label>						
						<select name="gallery[state]" id="state">
							<option value="1" <?php if ($this->item->state == 1) echo 'selected="selected"'?>>
								<?php echo JText::_('COM_FGALLERY_PUBLISHED')?>
							</option>
							<option value="0" <?php if ($this->item->state == 0) echo 'selected="selected"'?>>
								<?php echo JText::_('COM_FGALLERY_UNPUBLISHED')?>
							</option>
						</select>
					</div>
					<div class="form-item">
						<label for="gall_width"><?php echo JText::_('COM_FGALLERY_GALLERY_WIDTH_LABEL')?></label>
						<input type="gall_width" class="inputbox numeric" size="40" name="gallery[gall_width]" id="gall_width" value="<?php echo $this->item->gall_width?>" />
					</div>
					<div class="form-item">
						<label for="gall_height"><?php echo JText::_('COM_FGALLERY_GALLERY_HEIGHT_LABEL')?></label>
						<input type="gall_height" class="inputbox numeric" size="40" name="gallery[gall_height]" id="gall_height" value="<?php echo $this->item->gall_height?>" />
					</div>
					<div class="form-item">
						<label for="gall_bgcolor"><?php echo JText::_('COM_FGALLERY_GALLERY_BG_LABEL')?></label>
						<input type="gall_bgcolor" class="inputbox sc-color-val" size="40" name="gall_bgcolor" id="gall_bgcolor" value="<?php echo $this->item->gall_bgcolor?>" />
					</div>
					<div class="form-item">
						<label for="gall_type">
							<?php echo JText::_( 'COM_FGALLERY_GALLERY_TYPE_LABEL' ); ?>:
						</label>						
						<select name="gallery[gall_type]" id="gall_type">
							<option value="1" <?php if ($this->item->gall_type == 1) echo 'selected="selected"'?>>
								Acosta
							</option>
							<option value="2" <?php if ($this->item->gall_type == 2) echo 'selected="selected"'?>>
								Airion
							</option>
							<option value="3" <?php if ($this->item->gall_type == 3) echo 'selected="selected"'?>>
								Arai
							</option>
							<option value="4" <?php if ($this->item->gall_type == 4) echo 'selected="selected"'?>>
								Pax
							</option>
							<option value="5" <?php if ($this->item->gall_type == 5) echo 'selected="selected"'?>>
								Pazin
							</option>
							<option value="6" <?php if ($this->item->gall_type == 6) echo 'selected="selected"'?>>
								Postma
							</option>
							<option value="7" <?php if ($this->item->gall_type == 7) echo 'selected="selected"'?>>
								PageFlip
							</option>
							<option value="8" <?php if ($this->item->gall_type == 8) echo 'selected="selected"'?>>
								Nilus
							</option>
							<option value="9" <?php if ($this->item->gall_type == 9) echo 'selected="selected"'?>>
								Nusl
							</option>
							<option value="10" <?php if ($this->item->gall_type == 10) echo 'selected="selected"'?>>
								Kranjk
							</option>
                                                        <option value="12" <?php if ($this->item->gall_type == 12) echo 'selected="selected"'?>>
								Ables
							</option>
						</select>
                                                <input type="hidden" value="<?php echo $this->item->gall_type?>" name="gallery[old_gall_type]" />
					</div>
					<br clear="all" />
                  </div>
                  <?php foreach ($params_xml->params->group as $g) :
                          if (isset($g['type']) && $g['type'] == 'source') {
                               if ($g['name'] == $source){ ?>
                                    <div id="sc-group-<?php echo $g['name'] ?>" class="sc-skin-params-tab-panel">
                                    <?php $zebra = 'even';
                                    foreach ($g->p as $p) {
                                            $fn = 'sc_controls_' . $p['control'];
                                            $p['element_name'] = 'sc_' . $g['name'] . '__' . $p['name'];
                                            $p['default'] = FGalleryHelper::fgallery_get_settings_param($p,$settings);
                                            $p['zebra'] = $zebra;
                                            echo $this->$fn($p);
                                            $zebra = $zebra == 'even' ? 'odd' : 'even';
                                    }
                                    ?>
                                    </div>
                    <?php       }

                            } else { ?>
                                    <div id="sc-group-<?php echo $g['name'] ?>" class="sc-skin-params-tab-panel">
                                    <?php $zebra = 'even';
                                    foreach ($g->p as $p) {
                                            $fn = 'sc_controls_' . $p['control'];
                                            $p['element_name'] = 'sc_' . $g['name'] . '__' . $p['name'];
                                            $p['default'] = FGalleryHelper::fgallery_get_settings_param($p,$settings);
                                            $p['zebra'] = $zebra;
                                            echo $this->$fn($p);
                                            $zebra = $zebra == 'even' ? 'odd' : 'even';
                                    }
                                    ?>
                                    </div>
                            <?php }
                    endforeach; ?>
				  <input type="hidden" name="task" value="" />
				  <input type="hidden" name="controller" value="gallery" />
				  <input type="hidden" name="gallery[id]" value="<?php echo $this->item->id?>" />
				  <?php echo JHtml::_('form.token'); ?>
				  </div>
				  </form>
				

					
        </fieldset>
        
    <?php if ($this->item->id != 0): ?> 
        <div class="fgallery_<?php echo $this->item->id?>" style="width:<?php echo $this->item->gall_width?>px;">
		<?php $path = FGalleryHelper::fgallery_search_flash_path($this->item);
	        echo '<script type="text/javascript">
                var flashvars = {settings: "'.Juri::root().'index.php?option=com_fgallery%26view=settings%26gall_id='.$this->item->id.'", images: "'.Juri::root().'index.php?option=com_fgallery%26view=images%26gall_id='.$this->item->id.'"};
                var params = {bgcolor: "#'.$this->item->gall_bgcolor.'", allowFullScreen: "true", wmode: "transparent"};
                    swfobject.switchOffAutoHideShow();
                swfobject.embedSWF("'.$path.'", "flashcontent", "'.$this->item->gall_width.'", "'.$this->item->gall_height.'", "10.0.0",false, flashvars, params);
              </script> ';
        echo '<div id="flashcontent">
                <strong>You need to upgrade your Flash Player</strong>
             </div><br />
             <div class="flash_text"></div>
              </div>'; ?>

	
    <div class="edit_gallery_urls">
        <a href="<?php echo JRoute::_('index.php?option=com_fgallery&view=templates&gall_id='.
                $this->item->id.'&gall_type='.$this->item->gall_type.'&tmpl=component')?>" 
                class="modal fgallery_action" rel="{handler: 'iframe', size: {x: 600, y: 300}}">
            <?php echo JText::_('COM_FGALLERY_SAVE_SETTINGS')?>
        </a>
        <a href="<?php echo Juri::root().'index.php?option=com_fgallery&view=settings&gall_id='.$this->item->id.'&download=1'; ?>" class="fgallery_action">
            <?php echo JText::_('COM_FGALLERY_EXPORT_SETTINGS')?>
        </a>
        <a href="<?php echo JRoute::_('index.php?option=com_fgallery&view=templates&layout=load&gall_id='.
                $this->item->id.'&gall_type='.$this->item->gall_type.'&tmpl=component')?>" 
                class="modal fgallery_action" rel="{handler: 'iframe', size: {x: 600, y: 480}}">
            <?php echo JText::_('COM_FGALLERY_LOAD_SETTINGS')?>
        </a>
    </div>
            
        <?php echo JText::_( 'COM_FGALLERY_FIELD_CREATED_BY_LABEL' )?> <br />
        <?php $user = JFactory::getUser();
              echo $user->get('name');?> <br />
        <?php echo JText::_( 'COM_FGALLERY_FIELD_CREATED_LABEL'); ?> <br />
        <?php echo JHTML::_('date',$this->item->created, JText::_('DATE_FORMAT_LC3'));?> 	
                
      <?php endif; ?>