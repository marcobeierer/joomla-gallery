<?php
defined('_JEXEC') or die('Restricted access');

/* include files (TODO use spl autoload) */ 
require_once(JPATH_COMPONENT . DS . 'helpers' . DS . 'helper.php');

require_once(JPATH_COMPONENT . DS . 'model' . DS . 'gallery.php');
require_once(JPATH_COMPONENT . DS . 'model' . DS . 'filesystem.php');
require_once(JPATH_COMPONENT . DS . 'model' . DS . 'folder.php');
require_once(JPATH_COMPONENT . DS . 'model' . DS . 'photo.php');

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

GalleryHelper::validateRequestPath();
JPluginHelper::importPlugin('gallery');

// execute requested controller
$controller = JController::getInstance($controller);

if ($controller->getName() == 'gallery') {

	$controller->execute('createHtaccessFile');
	$controller->execute('createInitialDirectories');
	$controller->execute('setModuleParams');
}

$controller->execute(true);
$controller->redirect(); 
?>
