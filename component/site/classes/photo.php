<?php
defined('_JEXEC') or die('Restricted Access'); 
class Photo extends JObject
{
	private $folder;
	private $filename;
	
	private $params;
	
	private $thumbnailFilepath;
	private $resizedFilepath; // TODO other name

	
	function __construct(Folder $folder, $filename) {

		$this->folder = $folder;
		$this->filename = $filename;
		
		$this->params = JFactory::getApplication()->getParams();
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
			
			$path = $this->folder->getThumbnailsPath();
			$filePath = &$this->thumbnailFilepath;
			$scale = 3; // SCALE_OUTSIDE
			$options =  array('quality' => 75); // TODO as param
		}
		else if ($type == 'resized') {
			
			$path = $this->folder->getResizedPath();
			$filePath = &$this->resizedFilepath;
			$scale = 2; // SCALE_INSIDE
			$options =  array('quality' => 85); // TODO as param
		}
		else {
			return;
		}
		
		// define file paths
		$newPhotoFilepath = $path . DS . $this->folder->getFolderPath() . DS . $this->filename;
		$photoFilepath = $this->folder->getPhotosPath() . DS . $this->folder->getFolderPath() . DS . $this->filename;
		
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

		$filePath = str_replace($this->folder->getGalleryPath(), '', $newPhotoFilepath);
	}
	
	private function getURL() {
		
	}

	public function getThumbnailURL() {
		
		if ($this->thumbnail == null) {
			$this->resize('thumbnail', 220, 220, true); // TODO as params
		}
		return JRoute::_('index.php?option=com_gallery&view=file&path=' . $this->thumbnailFilepath);
	}
	
	public function getResizedURL() { // TODO merge with getThumbnailURL
		
		if ($this->resized == null) {
			$this->resize('resized', 1110, 888); // TODO as params
		}
		
		return JRoute::_('index.php?option=com_gallery&view=file&path=' . $this->resizedFilepath);
	}
}
