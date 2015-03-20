<?php
defined('_JEXEC') or die('Restricted Access');

jimport('joomla.application.component.model');
jimport('joomla.filesystem.folder');

class Gallery {
	
	private static $instance;
	
	private $galleryPath;
	private $currentRequestPath;
	private $currentRequestFilename;
	
	private $removeBacklinkCode;
	private $loadJQuery;
	private $lazyLoading;
	
	private $thumbnailSize;
	private $maxResizedWidth;
	private $maxResizedHeight;
	
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
		
		unset($params); // make params unaccessible (for safety reasons)
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
		
		$this->setRemoveBacklinkCode($params->get('remove_backlink_code', 0));
		$this->setLoadJQuery($params->get('load_jquery', 1));
		$this->setLazyLoading($params->get('lazy_loading', 0));
		
		$this->setThumbnailSize($params->get('thumbnail_size', 220));
		$this->setMaxResizedWidth($params->get('max_resized_width', 1110));
		$this->setMaxResizedHeight($params->get('max_resized_height', 888));
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
	
	private function setRemoveBacklinkCode($removeBacklinkCode) {

		if (preg_match('/^[a-f0-9]{32}$/', $removeBacklinkCode)) {
			$this->removeBacklinkCode = $removeBacklinkCode;
		} else {
			$this->removeBacklinkCode = 0;
		}
	}
	
	private function setThumbnailSize($thumbnailSize) {
		$this->thumbnailSize = (int) $thumbnailSize;
	}
	
	private function setMaxResizedWidth($maxResizedWidth) {
		$this->maxResizedWidth = $maxResizedWidth;
	}
	
	private function setMaxResizedHeight($maxResizedHeight) {
		$this->maxResizedHeight = $maxResizedHeight;
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
		return !$this->isRemoveBacklinkCodeValid();
	}
	
	private function isRemoveBacklinkCodeValid() {

		if ($this->removeBacklinkCode != 0) {

			$host = $_SERVER['HTTP_HOST'];
			if (strpos($host, 'www.') === 0) {
				$host = substr($host, 4);
			}
			return $this->removeBacklinkCode == md5($host . 'webguerilla.net');
		}
		return false;
	}
	
	public function getThumbnailSize() {
		return $this->thumbnailSize;
	}
	
	public function getMaxResizedWidth() {
		return $this->maxResizedWidth;
	}
	
	public function getMaxResizedHeight() {
		return $this->maxResizedHeight;
	}
}
