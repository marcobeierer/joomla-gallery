<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller'); 

class GalleryController extends JController
{
	private static $model;
	
	public function __construct() {
		parent::__construct();
	}
	
	public function getModel() {
		
		if (!isset(self::$model)) {
			self::$model = parent::getModel('Gallery', 'GalleryModel'); // or use JModel::getInstance('Gallery', 'GalleryModel'); ?
		}
		return self::$model;
	}

	/* create htaccess file if it not already exists */
	public function createHtaccessFile() {
		
		$htaccessPath = $this->getModel()->getGalleryPath() . DS . '.htaccess';
		
		if (!JFile::exists($htaccessPath)) { // TODO error handling
			
			$htaccessContent = "deny from all\n";
			JFile::write($htaccessPath, $htaccessContent);
		}
	}
	
	/* create photos directory if it not already exists */
	public function createInitialDirectories() {
		
		if (!JFolder::exists($this->getModel()->getPhotosPath())) { // TODO error handling
			JFolder::create($this->getModel()->getPhotosPath());
		}
	}
	
	public function setModuleParams() {
		
		JRequest::setVar('is_gallery', true);
		JRequest::setVar('current_path', $this->getModel()->getPhotosPath() . DS . $this->getModel()->getCurrentRequestPath());
		JRequest::setVar('photos_path', $this->getModel()->getPhotosPath());
	}
	
	public function display() {
		parent::display();
	}
} 
?>