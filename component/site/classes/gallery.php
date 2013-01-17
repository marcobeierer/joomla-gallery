<?php
defined('_JEXEC') or die('Restricted Access');

class Gallery extends JObject { 
	
	private $galleryPath;
	private $currentRequestPath;
	private $currentRequestFilename;
	
	private $loadJQuery;
	
	function __construct($params) {
		
		/* check if valid page (gallery_path isset) */
		if (JRequest::getWord('view') == 'gallery' && $params->get('gallery_path', '') == '') {
			JError::raiseError(404, JText::_("Page Not Found")); exit;
		}
		/* --- */
		
		$this->loadSafeRequestVars();
		$this->loadParams($params);
	}
	
	private function loadSafeRequestVars() {
		
		if (JRequest::getVar('view') == 'file') {
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
		$this->setLoadJQuery($params->get('load_jquery', 1));
		
		$params->set('gallery_path', $this->galleryPath); // for legacy use
	}
	
	private function setGalleryPath($galleryPath) {

		// TODO check if absolute path is used as gallery_path in settings and add JPATH_BASE just if relative
		$this->galleryPath = JPATH_BASE . DS . JFolder::makeSafe($galleryPath); // TODO safe enough?
	}
	
	private function setLoadJQuery($loadJQuery) {
		$this->loadJQuery = (int) $loadJQuery;
	}
		
	public function getRequestPathWithFilename() {
		return $this->galleryPath . DS . $this->currentRequestPath . DS . $this->currentRequestFilename;
	}
	
	public function getCurrentRequestPath() {
		return $this->currentRequestPath; // TODO refactor to absolute path
	}
		
	public function getPhotosPath() {
		return $this->galleryPath . DS . 'photos';
	}
	
	public function getGalleryPath() {
		return $this->galleryPath;
	}
	
	/* check if path is valid and raise error otherwise */
	public function validateRequestPath() { 
		
		if (JRequest::getVar('view') == 'file') { // TODO cleaner
			$fullPath = $this->galleryPath . DS . $this->currentRequestPath;
		} else {
			$fullPath = $this->galleryPath . DS . 'photos' . DS . $this->currentRequestPath;
		}
		
		if ($this->currentRequestPath != '' && !(JFolder::exists($fullPath) || JFile::exists($fullPath))) {
			JError::raiseError(404, JText::_("Page Not Found")); exit;
		}
	}
	
	/* create htaccess file if it not already exists */
	public function createHtaccessFile() {
		
		$htaccessPath = $this->galleryPath . DS . '.htaccess';
		
		if (!JFile::exists($htaccessPath)) { // TODO error handling
			
			$htaccessContent = "deny from all\n";
			JFile::write($htaccessPath, $htaccessContent);
		}
	}
	
	/* create photos directory if it not already exists */
	public function createInitialDirectories() {
		
		if (!JFolder::exists($this->getPhotosPath())) { // TODO error handling
			JFolder::create($this->getPhotosPath());
		}
	}
	
	public function handleFileRequests() {

		if (JRequest::getVar('view') == 'file') {

			$filepath = $this->getRequestPathWithFilename();
			if (file_exists($filepath)) {
				
				// open the file in a binary mode
				$fp = fopen($filepath, 'rb');
				
				// send the right headers
				header('Accept-Ranges: bytes');
				header('Content-Length: ' . filesize($filepath));
				header('Content-Type: ' . mime_content_type($filepath));
				//header('Cache-Control: public, min-fresh=3600, max-age=3600, s-maxage=3600, must-revalidate');
				
				// dump the picture and stop the script
				fpassthru($fp);
				fclose($fp);
			}
			exit;
		}
	}
	
	public function setModuleParams() {
		
		JRequest::setVar('is_gallery', true);
		JRequest::setVar('current_path', $this->getPhotosPath() . DS . $this->currentRequestPath);
		JRequest::setVar('photos_path', $this->getPhotosPath());
	}
	
	public function shouldLoadJQuery() {
		return $this->loadJQuery;
	}
}