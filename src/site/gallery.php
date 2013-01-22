<?php
defined('_JEXEC') or die('Restricted access');

/* include files (TODO use spl autoload) */ 
require_once(JPATH_COMPONENT . DS . 'helpers' . DS . 'helper.php');

require_once(JPATH_COMPONENT . DS . 'models' . DS . 'gallery.php');
require_once(JPATH_COMPONENT . DS . 'models' . DS . 'filesystem.php');
require_once(JPATH_COMPONENT . DS . 'models' . DS . 'folder.php');
require_once(JPATH_COMPONENT . DS . 'models' . DS . 'photo.php');

require_once(JPATH_COMPONENT . DS . 'controller.php');
/* --- */

/* Require specific controller if requested */
if ($controller = JRequest::getWord('controller', 'Gallery')) {
	
    $path = JPATH_COMPONENT . DS . 'controllers' . DS . $controller . '.php';
    if (file_exists($path)) {
        require_once($path);
    }
}
/* --- */

// execute requested controller
$controller = JController::getInstance($controller);
GalleryHelper::validateRequestPath($controller->getModel());

if ($controller->getName() == 'gallery') {

	$controller->execute('createHtaccessFile');
	$controller->execute('createInitialDirectories');
	$controller->execute('setModuleParams');
}

$controller->execute(true);
$controller->redirect(); 
?>
