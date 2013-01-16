<?php
defined('_JEXEC') or die('Restricted access');

// TODO use spl autoload
require_once (JPATH_COMPONENT . DS . 'helpers' . DS . 'helper.php');

// Params validation // TODO at this place or when saved in backend?
$params = JFactory::getApplication()->getParams();

if (JRequest::getWord('view') == 'gallery' && $params->get('gallery_path', '') == '') { // check if valid page (gallery_path isset)
	JError::raiseError(404, JText::_("Page Not Found")); exit;
}
// TODO check if absolute path is used as gallery_path in settings and add JPATH_BASE just if relative
$params->set('gallery_path', JPATH_BASE . DS . JFolder::makeSafe($params->get('gallery_path'))); // TODO safe enough?
// ---

// check if path is valid and raise error otherwise // TODO cleaner
$path = JRequest::getString('path', '');
if (JRequest::getVar('view') == 'file') {
	$fullPath = $params->get('gallery_path', '') . DS . $path;
} else {
	$fullPath = $params->get('gallery_path', '') . DS . 'photos' . DS . $path;
}

if ($path != '' && !(JFolder::exists($fullPath) || JFile::exists($fullPath))) {
	JError::raiseError(404, JText::_("Page Not Found")); exit;
}
// ---

// create htaccess file if it not already exists // TODO necessary with every call?
$htaccessPath = $params->get('gallery_path') . DS . '.htaccess';

if (!JFile::exists($htaccessPath)) {
	
	$htaccessContent = "deny from all\n";
	JFile::write($htaccessPath, $htaccessContent);
}
// TODO error handling
// ---

// create photos directory if it not already exists
$photosPath = $params->get('gallery_path') . DS . 'photos';

if (!JFolder::exists($photosPath)) {
	JFolder::create($photosPath);
}
// TODO error handling
// ---

// handle file requests
if (JRequest::getVar('view') == 'file') {
	
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
		fpassthru($fp);
		fclose($fp);
	}
	exit;
}
// ---

// set params for modules
JRequest::setVar('is_gallery', true);
JRequest::setVar('current_path', $photosPath . DS . JFolder::makeSafe(JRequest::getString('path', '')));
JRequest::setVar('photos_path', $photosPath);
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
