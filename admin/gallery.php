<?php
defined('_JEXEC') or die('Restricted access');

require_once(JPATH_COMPONENT . DS . 'controller.php');

// Require specific controller if requested
if ($controller = JRequest::getVar('controller')) {
	require_once(JPATH_COMPONENT . DS . 'controllers' . DS . $controller . '.php');
}
// ---

// Create controller
$classname = 'GalleryController' . $controller; 
$controller = new $classname();
$controller->execute(JRequest::getVar('task'));
$controller->redirect();
// ---
?>