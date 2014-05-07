<?php
defined('_JEXEC') or die('Restricted Access'); 
jimport('joomla.application.component.model');

class Photo {
	
	private $gallery;
	
	private $folder;
	private $filename;
	
	private $thumbnailFilepath;
	private $resizedFilepath; // TODO other name
	
	private $iptcInfo;
	
	function __construct($folder, $filename) {

		$this->gallery = Gallery::getInstance();
		
		$this->folder = $folder;
		$this->filename = $filename;
		
		$this->iptcInfo = new IPTC($this->gallery->getPhotosPath() 
							. DS . $this->folder->getFolderPath()
							. DS . $this->filename);
	}
	
	public function getFolder() {
		return $this->folder;
	}
	
	public function getFilename() {
		return $this->filename;
	}
	
	public function getWidth() {
		
	}
	
	public function getHeight() {
		
	}
	
	public function resize($type, $width, $height, $crop = false) {
		
		if ($type == 'thumbnail') {
			
			$path = $this->gallery->getThumbnailsPath();
			$filePath = &$this->thumbnailFilepath;
			$scale = 3; // SCALE_OUTSIDE
			$options =  array('quality' => 75); // TODO as param
		}
		else if ($type == 'resized') {
			
			$path = $this->gallery->getResizedPath();
			$filePath = &$this->resizedFilepath;
			$scale = 2; // SCALE_INSIDE
			$options =  array('quality' => 85); // TODO as param
		}
		else {
			return;
		}
		
		// define file paths
		$newPhotoFilepath = $path . DS . $this->folder->getFolderPath() . DS . $this->filename;
		$photoFilepath = $this->gallery->getPhotosPath() . DS . $this->folder->getFolderPath() . DS . $this->filename;
		
		// check if thumbnail already exists and create it if not
		if (!JFile::exists($newPhotoFilepath)) { // TODO add check if file size (width and height) is correct
			
			// resize image
			$photo = new JImage($photoFilepath);
			$newPhoto = $photo->resize($width, $height, true, $scale);
			
			// crop image
			if ($crop) {
				$offsetLeft = ($newPhoto->getWidth() - $width) / 2;
				$offsetTop = ($newPhoto->getHeight() - $height) / 2;
				$newPhoto->crop($width, $height, $offsetLeft, $offsetTop, false);
			}
			
			// create folders (recursive) and write file
			if (JFolder::create($path . DS . $this->folder->getFolderPath())) {
				$newPhoto->toFile($newPhotoFilepath, IMAGETYPE_JPEG, $options);
			}
		}

		$filePath = str_replace($this->gallery->getGalleryPath(), '', $newPhotoFilepath);
	}
	
	private function getURL() {
		
	}

	public function getThumbnailURL() {
		
		if (!isset($this->thumbnail)) {
			
			$thumbnailSize = $this->gallery->getThumbnailSize();
			$this->resize('thumbnail', $thumbnailSize, $thumbnailSize, true);
		}
		return JRoute::_('index.php?option=com_gallery&controller=file&path=' . $this->thumbnailFilepath);
	}
	
	public function getResizedURL() { // TODO merge with getThumbnailURL
		
		if (!isset($this->resized)) {
			
			$maxResizedWidth = $this->gallery->getMaxResizedWidth();
			$maxResizedHeight = $this->gallery->getMaxResizedHeight();
			$this->resize('resized', $maxResizedWidth, $maxResizedHeight);
		}
		
		return JRoute::_('index.php?option=com_gallery&controller=file&path=' . $this->resizedFilepath);
	}
	
	public function getIptcInfo() {
		return $this->iptcInfo;
	}
	
	public function getLightboxDescription() {
		
		$lightboxDescription = "";
		
		if ($this->iptcInfo->getTitle() != null) {
			
			$lightboxDescription .= $this->iptcInfo->getTitle();
			if ($this->iptcInfo->getDescription() != null) {
				$lightboxDescription .= ": " . $this->iptcInfo->getDescription();
			}
		}
		else if ($this->iptcInfo->getDescription() != null) {
			$lightboxDescription .= $this->iptcInfo->getDescription();
		}
		
		return $lightboxDescription;
	}
}
