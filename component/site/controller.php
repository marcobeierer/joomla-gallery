<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller'); 

class GalleryController extends JController
{ 
	function display() {
		
		/* initialise gallery */
		$app =& JFactory::getApplication();
		$gallery = new Gallery($app->getParams());
		
		$gallery->validateRequestPath();
		$gallery->createHtaccessFile(); // TODO necessary with every call?
		$gallery->createInitialDirectories();
		$gallery->handleFileRequests();
		$gallery->setModuleParams();
		/* --- */
		
		JRequest::setVar('gallery', $gallery); // TODO is there a better way?
		parent::display(); 
	}
} 
?>