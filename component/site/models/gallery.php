<?php
defined('_JEXEC') or die('Restricted Access');
jimport('joomla.application.component.model');

class GalleryModelGallery extends JModel {
	
	private $galleryPath;
	private $currentRequestPath;
	private $currentRequestFilename;
	
	private $showBacklink;
	private $loadJQuery;
	
	function __construct() {
		
		parent::__construct();
		$params = JFactory::getApplication()->getParams();
		
		/* check if valid page (gallery_path isset) */
		if (JRequest::getWord('view') == 'gallery' && $params->get('gallery_path', '') == '') {
			JError::raiseError(404, JText::_("Page Not Found")); exit;
		}
		/* --- */
		
		$this->loadSafeRequestVars();
		$this->loadParams($params);
	}
	
	private function loadSafeRequestVars() {
		
		if (JRequest::getVar('controller') == 'file') {
			$pathObject = GalleryHelper::splitPath(JRequest::getString('path', ''));
			
			$this->currentRequestPath = JFolder::makeSafe($pathObject->folderPath);
			$this->currentRequestFilename = JFile::makeSafe($pathObject->filename);
		}
		else {
			$this->currentRequestPath = JFolder::makeSafe(JRequest::getString('path', ''));
			$this->currentRequestFilename = '';
		}
	}
	
	private function loadParams($params) {

		$this->setGalleryPath($params->get('gallery_path', ''));
		$this->setShowBacklink($params->get('show_backlink', 1));
		$this->setLoadJQuery($params->get('load_jquery', 1));
		
		//$params->set('gallery_path', $this->galleryPath); // for legacy use
	}
	
	private function setGalleryPath($galleryPath) {
		
		// TODO handle absolute path
		$this->galleryPath = JPATH_BASE . DS . JFolder::makeSafe($galleryPath); // TODO safe enough?
	}
	
	private function setLoadJQuery($loadJQuery) {
		$this->loadJQuery = (bool) $loadJQuery;
	}
	
	private function setShowBacklink($showBacklink) {
		$this->showBacklink = (bool) $showBacklink;
	}
	
	
		
	public function getRequestPathWithFilename() {
		return $this->galleryPath . DS . $this->currentRequestPath . DS . $this->currentRequestFilename;
	}
	
	public function getCurrentRequestPath() {
		return $this->currentRequestPath; // TODO refactor to absolute path
	}
	
	public function getCurrentPath() {
		return $this->galleryPath . DS . $this->currentRequestPath;
	}
		
	public function getPhotosPath() {
		return $this->galleryPath . DS . 'photos';
	}
	
	public function getThumbnailsPath() {
		return $this->galleryPath . DS . 'thumbnails';
	}
	
	public function getResizedPath() { // TODO other name
		return $this->galleryPath . DS . 'resized';
	}
	
	public function getGalleryPath() {
		return $this->galleryPath;
	}
	
	public function shouldLoadJQuery() {
		return $this->loadJQuery;
	}
	
	public function showBacklink() {
		return $this->showBacklink;
	}
}