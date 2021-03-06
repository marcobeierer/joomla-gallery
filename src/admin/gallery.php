<?php
// Licensed under the AGPL v3
// Copyright by Marco Beierer

defined('_JEXEC') or die('Restricted access');

if(!defined('DS')){
	define('DS', DIRECTORY_SEPARATOR);
}

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
