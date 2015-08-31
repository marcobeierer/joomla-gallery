<?php
// Licensed under the AGPL v3
// Copyright by Marco Beierer

defined('_JEXEC') or die('Restricted Access');

jimport('joomla.application.component.model');
jimport('joomla.filesystem.folder');

class Gallery {
	
	private static $instance;
	
	private $galleryPath;
	private $relativeGalleryPath;

	private $currentRequestPath;
	private $currentRequestFilename;
	
	private $removeBacklinkCode;
	private $lightbox;
	private $loadJQuery;
	private $lazyLoading;
	private $protectImages;
	
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
			JError::raiseError(404, JText::_("Page Not Found")); exit; // TODO use return?
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
		$this->setLightbox($params->get('lightbox', 'shutter_reloaded'));
		$this->setLoadJQuery($params->get('load_jquery', 1));
		$this->setLazyLoading($params->get('lazy_loading', 0));
		$this->setProtectImages($params->get('protect_images', 0));
		
		$this->setThumbnailSize($params->get('thumbnail_size', 220));
		$this->setMaxResizedWidth($params->get('max_resized_width', 1110));
		$this->setMaxResizedHeight($params->get('max_resized_height', 888));
	}
	
	private function setGalleryPath($galleryPath) {

		// TODO handle if absolute path is used as input
		
		$this->relativeGalleryPath = JFolder::makeSafe($galleryPath); // TODO safe enough?
		$this->galleryPath = JPATH_BASE . DS . $this->relativeGalleryPath;
	}
	
	private function setLoadJQuery($loadJQuery) {
		$this->loadJQuery = (bool) $loadJQuery;
	}
	
	private function setLazyLoading($lazyLoading) {
		$this->lazyLoading = (bool) $lazyLoading;
	}

	private function setProtectImages($protectImages) {
		$this->protectImages = (bool) $protectImages;
	}

	private function setLightbox($lightbox) {
		$this->lightbox = filter_var($lightbox, FILTER_SANITIZE_STRING);
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
		return $this->getCachePath() . DS . $this->currentRequestPath . DS . $this->currentRequestFilename;
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
		return $this->galleryPath;
	}

	public function getCachePath() {
		return JPATH_CACHE . DS . 'gallery' . DS . $this->relativeGalleryPath;
	}
	
	public function getThumbnailsPath() {
		return $this->getCachePath() . DS . 'thumbnails';
	}
	
	public function getResizedPath() { // TODO other name
		return $this->getCachePath() . DS . 'resized';
	}
	
	public function getGalleryPath() {
		return $this->galleryPath;
	}

	public function getLightbox() {
		return $this->lightbox;
	}
	
	public function shouldLoadJQuery() {
		return $this->loadJQuery;
	}
	
	public function shouldUseLazyLoading() {
		return $this->lazyLoading;
	}

	public function shouldProtectImages() {
		return $this->protectImages;
	}
	
	public function showBacklink() {
		return !$this->isRemoveBacklinkCodeValid();
	}
	
	private function isRemoveBacklinkCodeValid() {

		if (is_string($this->removeBacklinkCode) && $this->removeBacklinkCode != '') {

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
