<?php
defined('_JEXEC') or die('Restricted access');

/* include files (TODO use spl autoload) */ 
require_once(JPATH_COMPONENT . DS . 'controller.php');
require_once(JPATH_COMPONENT . DS . 'helpers' . DS . 'helper.php');

require_once(JPATH_COMPONENT . DS . 'classes' . DS . 'gallery.php');
require_once(JPATH_COMPONENT . DS . 'classes' . DS . 'folder.php');
require_once(JPATH_COMPONENT . DS . 'classes' . DS . 'photo.php');
/* --- */

/* initialise gallery */
$app =& JFactory::getApplication();
$gallery = new Gallery($app->getParams());

$gallery->validateRequestPath();
$gallery->createHtaccessFile(); // TODO necessary with every call?
$gallery->createInitialDirectories();
$gallery->handleFileRequests();
$gallery->setModuleParams();
/* --- */

$classname = 'GalleryController'; 
$controller = new $classname(); 

$controller->execute(true); 
$controller->redirect(); 
?>
