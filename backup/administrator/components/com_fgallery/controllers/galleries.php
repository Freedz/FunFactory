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
 
// import Joomla controlleradmin library
jimport('joomla.application.component.controller');
 
/**
 * Galleries Controller
 */
class FGalleryControllerGalleries extends JController
{

	function __construct() {
		JRequest::setVar('view', 'Galleries');
		parent::__construct();
	}
		
	public function saveorder() {
		JRequest::checkToken() or jexit('Invalid Token');
		$post = JRequest::get('post');
			$pks = $post['cid'];
			$order = $post['order'];
			$pks = (array) $pks;
			$order = (array) $order;
			JArrayHelper::toInteger($pks);
			JArrayHelper::toInteger($order);
		if (empty($pks)) {
			$this->setError(JText::_('COM_FGALLERY_NO_ITEM_SELECTED'));
			return false;
		}
		$i = 0;
		foreach ($pks as $id) {
			JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
			$row =& JTable::getInstance('gallery', 'FGalleryTable');
			$row->load($id);
			$gall = array('ordering'=>$order[$i]);
			if (!$row->bind($gall)) {
				JError::raiseError(500, $row->getError());
			}	
			if (!$row->store()) {
				JError::raiseError(500, $row->getError());
			}
		$i++;
		}
		$model = $this->getModel('Gallery','FGalleryModel');
		$table = $model->getTable('Gallery', 'FGalleryTable');
		$table->reorder();
		
		$this->setRedirect('index.php?option=com_fgallery&view=galleries');
		
	}
	
	function orderup() {
		$model = $this->getModel( 'gallery', 'FGalleryModel' );
		$model->move(-1);
		$this->setRedirect( 'index.php?option=com_fgallery&view=galleries' );
	}

	function orderdown() {
		$model = $this->getModel( 'gallery', 'FGalleryModel' );
		$model->move(1);
		$this->setRedirect( 'index.php?option=com_fgallery&view=galleries' );
	}
	
	public function edit() {
		$post = JRequest::get('post');
		$cid  = JRequest::getVar('cid', array(0), 'post', 'array' );
		$id = (int) $cid[0];
		if (is_numeric($id) && $id > 0) {
			$this->setRedirect('index.php?option=com_fgallery&view=gallery&id='.$id);
		}
	}
	
	public function delete() {
		JRequest::checkToken() or jexit('Invalid Token');
		$post = JRequest::get('post');
		$pks = $post['cid'];
		$pks = (array) $pks;
		JArrayHelper::toInteger($pks);

		if (empty($pks)) {
			$this->setError(JText::_('COM_FGALLERY_NO_ITEM_SELECTED'));
			return false;
		}
		
		$db = & JFactory::getDbo();
		$query = 'DELETE FROM #__fgallery_gallery_images'
				.' WHERE gall_id IN (' . implode(',',$pks) . ')';
		$db->setQuery($query);
		if (!$db->query()) {
			JError::raiseError(500, $db->getErrorMsg());
		}
		$query = 'DELETE FROM #__fgallery_galleries'
				.' WHERE id IN (' . implode(',',$pks) .')';
		$db->setQuery($query);
		if (!$db->query()) {
			JError::raiseError(500, $db->getErrorMsg());
		}
		$query = 'DELETE FROM #__fgallery_gallery_settings'.
				 ' WHERE gall_id IN ('. implode(',',$pks). ')';
		$db->setQuery($query);
		if (!$db->query()) {
			JError::raiseError(500, $db->getErrorMsg());
		}
		$this->setRedirect('index.php?option=com_fgallery&view=galleries');		
	}

	public function publish($value = 1) {
		JRequest::checkToken() or jexit('Invalid Token');
		$post = JRequest::get('post');
		$pks = $post['cid'];
		// Sanitize the ids.
		$pks = (array) $pks;
		JArrayHelper::toInteger($pks);

		if (empty($pks)) {
			$this->setError(JText::_('COM_FGALLERY_NO_ITEM_SELECTED'));
			return false;
		}

		$db = & JFactory::getDbo();
		$db->setQuery(
			'UPDATE #__fgallery_galleries AS a' .
			' SET a.state = '.(int) $value.
			' WHERE a.id IN ('.implode(',', $pks).')'
		);
		if (!$db->query()) {
			JError::raiseError(500, $db->getErrorMsg());
		}		
		$this->setRedirect('index.php?option=com_fgallery&view=galleries');	
	}

	 public function unpublish($value = 0) {
		JRequest::checkToken() or jexit('Invalid Token');
		$post = JRequest::get('post');
		$pks = $post['cid'];
		// Sanitize the ids.
		$pks = (array) $pks;
		JArrayHelper::toInteger($pks);

		if (empty($pks)) {
			$this->setError(JText::_('COM_FGALLERY_NO_ITEM_SELECTED'));
			return false;
		}

		$db = & JFactory::getDbo();
		$db->setQuery(
			'UPDATE #__fgallery_galleries AS a' .
			' SET a.state = '.(int) $value.
			' WHERE a.id IN ('.implode(',', $pks).')'
		);
		if (!$db->query()) {
			JError::raiseError(500, $db->getErrorMsg());
		}
		$this->setRedirect('index.php?option=com_fgallery&view=galleries');	
	}	
}
