<?php
defined('_JEXEC') or die('Restricted Access');
jimport('joomla.application.component.model');

class Gallery {
	
	private static $instance;
	
	private $galleryPath;
	private $currentRequestPath;
	private $currentRequestFilename;
	
	private $showBacklink;
	private $loadJQuery;
	private $lazyLoading;
	
	/** @return Gallery */
	public static function getInstance() {
	
		if (!isset(self::$instance)) {
			self::$instance = new Gallery();
		}
		return self::$instance;
	}
	
	private function __construct() {
		
		$params = JFactory::getApplication()->getParams();
		
		/* check if valid page (gallery_path isset) */
		if (JRequest::getWord('view') == 'gallery' && $params->get('gallery_path', '') == '') {
			JError::raiseError(404, JText::_("Page Not Found")); exit;
		}
		/* --- */
		
		$this->loadSafeRequestVars();
		$this->loadParams($params);
	}
	
	private function __clone() {}
	
	private function loadSafeRequestVars() {
		
		if (JRequest::getVar('controller') == 'file') {
			$pathObject = GalleryHelper::splitPath(JRequest::getString('path', ''), false);
			
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
		$this->setLazyLoading($params->get('lazy_loading', 0));
	}
	
	private function setGalleryPath($galleryPath) {
		
		// TODO handle absolute path
		$this->galleryPath = JPATH_BASE . DS . JFolder::makeSafe($galleryPath); // TODO safe enough?
	}
	
	private function setLoadJQuery($loadJQuery) {
		$this->loadJQuery = (bool) $loadJQuery;
	}
	
	private function setLazyLoading($lazyLoading) {
		$this->lazyLoading = (bool) $lazyLoading;
	}
	
	private function setShowBacklink($showBacklink) {
		$this->showBacklink = (bool) $showBacklink;
	}
		
	public function getRequestPathWithFilename() {
		return $this->galleryPath . DS . $this->currentRequestPath . DS . $this->currentRequestFilename;
	}
	
	/** Relative Request Path */
	public function getCurrentRequestPath() { // TODO better names
		return $this->currentRequestPath; // TODO refactor to absolute path
	}
	
	/** Absolute Request Path */
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
	
	public function shouldUseLazyLoading() {
		return $this->lazyLoading;
	}
	
	public function showBacklink() {
		return $this->showBacklink;
	}
}