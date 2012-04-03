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
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.modeladmin');
 
/**
 * Settings Model
 */
class FGalleryModelSettings extends JModelAdmin
{
        /**
         * Returns a reference to the a Table object, always creating it.
         *
         * @param       type    The table type to instantiate
         * @param       string  A prefix for the table class name. Optional.
         * @param       array   Configuration array for model. Optional.
         * @return      JTable  A database object
         * @since       1.6
         */
        public function getTable($type = 'Settings', $prefix = 'FGalleryTable', $config = array())
        {
                return JTable::getInstance($type, $prefix, $config);
        }
		
			/**
			 * Method to get a single record.
			 *
			 * @param	integer	The id of the primary key.
			 *
			 * @return	mixed	Object on success, false on failure.
			 */
			public function getItem($pk = null)
			{
				if ($item = parent::getItem($pk)) {

				}

				return $item;
			}
		
}
