<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller'); 
jimport('joomla.filesystem.file');

class GalleryController extends JControllerLegacy
{
	private $gallery;
	
	public function __construct() {
		
		parent::__construct();
		$this->gallery = Gallery::getInstance();
	}

	/* create htaccess file if it not already exists */
	public function createHtaccessFile() {
		
		$htaccessPath = $this->gallery->getGalleryPath() . DS . '.htaccess';
		
		if (!JFile::exists($htaccessPath)) { // TODO error handling
			
			$htaccessContent = "deny from all\n";
			JFile::write($htaccessPath, $htaccessContent);
		}
	}
	
	/* create photos directory if it not already exists */
	public function createInitialDirectories() {
		
		if (!JFolder::exists($this->gallery->getPhotosPath())) { // TODO error handling
			JFolder::create($this->gallery->getPhotosPath());
		}
	}
	
	public function setModuleParams() {
		
		JRequest::setVar('is_gallery', true);
		JRequest::setVar('current_path', $this->gallery->getPhotosPath() . DS . $this->gallery->getCurrentRequestPath());
		JRequest::setVar('photos_path', $this->gallery->getPhotosPath());
	}
	
	public function display($cachable = false, $urlparams = false) {
		parent::display($cachable, $urlparams);
	}
} 
?>