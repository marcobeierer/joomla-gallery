<?php
defined('_JEXEC') or die('Restricted access'); 

// Access check: is this user allowed to access the gallery
if (!JFactory::getUser()->authorise('core.view.photos', 'com_gallery')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR')); // TODO fix this // does not show error
}

require_once (JPATH_COMPONENT . DS . 'controller.php');

// TODO use spl autoload
require_once(JPATH_COMPONENT . DS . 'classes' . DS . 'folder.php');
require_once(JPATH_COMPONENT . DS . 'classes' . DS . 'photo.php');

$classname = 'GalleryController'; 
$controller = new $classname(); 

$controller->execute(true); 
$controller->redirect(); 
?>
