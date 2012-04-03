ALTER TABLE `#__fgallery_gallery_images` 
ADD `img_url` VARCHAR( 255 ) NULL ,
ADD `img_extra` TEXT NULL;

CREATE TABLE IF NOT EXISTS `#__fgallery_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gall_type` smallint(5) NOT NULL,
  `gall_settings` text NOT NULL,
  `created` date NOT NULL,
  `templ_title` varchar(255) NOT NULL,
  `templ_description` text,
  PRIMARY KEY (`id`),
  KEY `gall_type` (`gall_type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;