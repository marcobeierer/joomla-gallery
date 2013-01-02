<?php
defined('_JEXEC') or die('Restricted access'); 
require_once (JPATH_COMPONENT . DS . 'helpers' . DS . 'helper.php');

// Access check: is this user allowed to access the gallery
/*if (!JFactory::getUser()->authorise('core.view.photos', 'com_gallery')) { // not necessary because of access level
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR')); // TODO fix this // does not show error
}*/

// Params validation // TODO zentral beim speichern im backend?
$params = JFactory::getApplication()->getParams();
$params->set('gallery_path', JFolder::makeSafe($params->get('gallery_path'))); // TODO safe enough?
// ---

// create htaccess file if it not already exists // TODO with every call?
$htaccessPath = $params->get('gallery_path') . DS . '.htaccess';
if (!file_exists($htaccessPath)) {

	$handle = fopen($htaccessPath, 'a');
	fwrite($handle, "deny from all\n");
	fclose($handle);
}
// ---

// handle file requests
if (JRequest::getVar('view') == 'file') {
	
	//$filename = JFile::makeSafe(JRequest::getString('filename', ''));
	//$path = $params->get('gallery_path') . DS . JFolder::makeSafe(JRequest::getString('path'));
	
	$pathObject = GalleryHelper::splitPath(JRequest::getString('path', ''));
	
	$path = $params->get('gallery_path') . DS . $pathObject->folderPath;
	$filename = $pathObject->filename;
		
	$filepath = $path . DS . $filename;
	if (file_exists($filepath)) {
		
		// open the file in a binary mode
		$fp = fopen($filepath, 'rb');
		
		// send the right headers
		header('Accept-Ranges: bytes');
		header('Content-Length: ' . filesize($filepath));
		header('Content-Type: ' . mime_content_type($filepath));
		
		// dump the picture and stop the script
		fpassthru($fp); // TODO fclose necessary
	}
	exit;
}
// ---

require_once (JPATH_COMPONENT . DS . 'controller.php');

// TODO use spl autoload
require_once(JPATH_COMPONENT . DS . 'classes' . DS . 'folder.php');
require_once(JPATH_COMPONENT . DS . 'classes' . DS . 'photo.php');

$classname = 'GalleryController'; 
$controller = new $classname(); 

$controller->execute(true); 
$controller->redirect(); 
?>
