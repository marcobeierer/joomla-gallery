<?php
defined('_JEXEC') or die('Restricted access');

/* include files (TODO use spl autoload) */ 
require_once(JPATH_COMPONENT . DS . 'controller.php');
require_once(JPATH_COMPONENT . DS . 'helpers' . DS . 'helper.php');

require_once(JPATH_COMPONENT . DS . 'models' . DS . 'gallery.php');

require_once(JPATH_COMPONENT . DS . 'classes' . DS . 'folder.php');
require_once(JPATH_COMPONENT . DS . 'classes' . DS . 'photo.php');
/* --- */

/* Require specific controller if requested */
if ($controller = JRequest::getWord('controller')) {
	
    $path = JPATH_COMPONENT . DS . 'controllers' . DS . $controller . '.php';
    if (file_exists($path)) {
        require_once($path);
    } else {
        $controller = '';
    }
}
/* --- */

/* initialise gallery */
$app =& JFactory::getApplication();
$gallery = new Gallery($app->getParams());

$gallery->validateRequestPath();
$gallery->createHtaccessFile(); // TODO necessary with every call?
$gallery->createInitialDirectories();
//$gallery->handleFileRequests();
$gallery->setModuleParams();
/* --- */

JRequest::setVar('gallery', $gallery); // TODO is there a better way?

// execute gallery controller
//$galleryController = new GalleryController();
//$galleryController->execute(true);

// execute requested controller
$classname = 'GalleryController' . $controller; 
$controller = new $classname(); 

$controller->execute(true); // TODO or JRequest::getVar('task')
$controller->redirect(); 
?>
