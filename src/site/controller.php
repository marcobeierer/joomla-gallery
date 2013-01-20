<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller'); 

class GalleryController extends JController
{
	private $model;
	
	public function __construct() {
		
		parent::__construct();
		$this->model = JModel::getInstance('Gallery', 'GalleryModel');
	}

	/* create htaccess file if it not already exists */
	public function createHtaccessFile() {
		
		$htaccessPath = $this->model->getGalleryPath() . DS . '.htaccess';
		
		if (!JFile::exists($htaccessPath)) { // TODO error handling
			
			$htaccessContent = "deny from all\n";
			JFile::write($htaccessPath, $htaccessContent);
		}
	}
	
	/* create photos directory if it not already exists */
	public function createInitialDirectories() {
		
		if (!JFolder::exists($this->model->getPhotosPath())) { // TODO error handling
			JFolder::create($this->model->getPhotosPath());
		}
	}
	
	public function setModuleParams() {
		
		JRequest::setVar('is_gallery', true);
		JRequest::setVar('current_path', $this->model->getPhotosPath() . DS . $this->model->getCurrentRequestPath());
		JRequest::setVar('photos_path', $this->model->getPhotosPath());
	}
	
	function display() {
		parent::display();
	}
} 
?>