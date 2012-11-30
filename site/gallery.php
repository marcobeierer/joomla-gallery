<?php
defined('_JEXEC') or die('Restricted access'); 

// Access check: is this user allowed to access the gallery
if (!JFactory::getUser()->authorise('core.view.photos', 'com_gallery')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR')); // TODO fix this // does not show error
}

// handle files
//http://localhost/projects.mysites/gallery.erstellung/index.php?option=com_gallery&view=file&path=/var/www/localhost/htdocs/projects.mysites/gallery.erstellung/images/gallery/photos/2012/11_Stockhorn/&filename=0002.jpg
if (JRequest::getVar('view') == 'file') {
	
	$filename = JFile::makeSafe(JRequest::getString('filename')); // use last element as filename
	$path = JFolder::makeSafe(JRequest::getString('path')); // use rest as path
		
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
		exit;
		
		/*$type = mime_content_type($filepath);
		$filename = basename($filepath);
		
		header("Content-Type: $type");
		//header("Content-Disposition: inline; filename=\"$filename\""); // TODO
		header("Content-Disposition: attachment; filename=\"$filename\"");
		
		@readfile($filepath);
		exit;*/
	}
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
