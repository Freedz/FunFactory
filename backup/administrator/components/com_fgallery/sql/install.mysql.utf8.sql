CREATE TABLE IF NOT EXISTS `#__fgallery_galleries` (
  `id` int(10) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `description` text,
  `cover` int(10) default '0',
  `state` tinyint(3) default '0',
  `created` datetime default '0000-00-00 00:00:00',
  `created_by` int(10) default '0',
  `modified` date default '0000-00-00',
  `modified_by` int(10) default '0',
  `checked_out` int(10) default '0',
  `checked_out_time` datetime default '0000-00-00 00:00:00',
  `publish_up` datetime default '0000-00-00 00:00:00',
  `publish_down` datetime default '0000-00-00 00:00:00',
  `gall_width` int(11) default '450',
  `gall_height` int(11) default '385',
  `gall_bgcolor` varchar(6) default 'ffffff',
  `gall_type` smallint(3) default '3',
  `ordering` int(11) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__fgallery_gallery_images` (
  `img_id` int(10) NOT NULL,
  `gall_id` int(10) NOT NULL,
  `gall_folder` int(10) NOT NULL,
  `ordering` int(10) NOT NULL,
  `img_url` varchar(255) NULL,
  `img_extra` TEXT NULL,
  PRIMARY KEY  (`img_id`,`gall_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__fgallery_gallery_settings` (
  `id` int(10) NOT NULL auto_increment, 
  `gall_id` int(10) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__fgallery_images` (
  `id` int(10) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `description` text,
  `type` varchar(50) NOT NULL,
  `size` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `preview_path` VARCHAR( 255 ) NULL DEFAULT NULL,
  `folder` smallint(5) default '0',
  `parent` int(10) default '0',
  `checked_out` int(10) default NULL,
  `checked_out_time` datetime default '0000-00-00 00:00:00',
  `modified` datetime default '0000-00-00 00:00:00',
  `modified_by` int(10) default '0',
  `created` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;


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