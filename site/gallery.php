<?php
defined('_JEXEC') or die('Restricted access');

// TODO use spl autoload
require_once (JPATH_COMPONENT . DS . 'helpers' . DS . 'helper.php');

// Params validation // TODO at this place or when saved in backend?
$params = JFactory::getApplication()->getParams();
$params->set('gallery_path', JFolder::makeSafe($params->get('gallery_path'))); // TODO safe enough?
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

require_once (JPATH_COMPONENT . DS . 'controller.php');

// TODO use spl autoload
require_once(JPATH_COMPONENT . DS . 'classes' . DS . 'folder.php');
require_once(JPATH_COMPONENT . DS . 'classes' . DS . 'photo.php');

$classname = 'GalleryController'; 
$controller = new $classname(); 

$controller->execute(true); 
$controller->redirect(); 
?>
