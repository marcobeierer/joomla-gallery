<?php
class Photo extends JObject
{
	private $folder;
	private $filename;
	
	private $thumbnailFilepath;
	private $resizedFilepath; // TODO other name

	
	function __construct(Folder $folder, $filename) {

		$this->folder = $folder;
		$this->filename = $filename;
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
		}
		else if ($type == 'resized') {
			
			$path = $this->folder->getResizedPath();
			$filePath = &$this->resizedFilepath;
			$scale = 2; // SCALE_INSIDE
		}
		else {
			return;
		}
		
		// define file paths
		$newPhotoFilepath = $path . DS . $this->folder->getFolderPath() . DS . $this->filename;
		$photoFilepath = $this->folder->getPhotosPath() . DS . $this->folder->getFolderPath() . DS . $this->filename;
		
		// check if thumbnail already exists and create it if not
		if (!JFile::exists($newPhotoFilepath)) {
			
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
				$newPhoto->toFile($newPhotoFilepath);
			}
		}

		$filePath = $newPhotoFilepath;
	}

	public function getThumbnailURL() {
		
		if ($this->thumbnail == null) {
			$this->resize('thumbnail', 220, 220, true); // TODO fix it / params
		}
		return str_replace(JPATH_BASE . DS, '', $this->thumbnailFilepath);
	}
	
	public function getResizedURL() { // TODO merge with getThumbnailURL
		
		if ($this->resized == null) {
			$this->resize('resized', 1110, 888); // TODO fix it / params
		}
		return str_replace(JPATH_BASE . DS, '', $this->resizedFilepath);
	}
}
