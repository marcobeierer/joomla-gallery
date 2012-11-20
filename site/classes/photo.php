<?php
class Photo extends JObject
{
	private $folder;
	private $filename;
	
	private $thumbnail;
	private $resized; // TODO other name

	
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
			$classReference = &$this->thumbnail;
			$scale = 3; // SCALE_OUTSIDE
		}
		else if ($type == 'resized') {
			
			$path = $this->folder->getResizedPath();
			$classReference = &$this->resized;
			$scale = 2; // SCALE_INSIDE
		}
		else {
			return;
		}
		
		// define file paths
		$thumbnailFilepath = $path . DS . $this->folder->getFolderPath() . DS . $this->filename;
		$photoFilepath = $this->folder->getPhotosPath() . DS . $this->folder->getFolderPath() . DS . $this->filename;
		
		// check if thumbnail already exists and create it if not
		if (!JFile::exists($thumbnailFilepath)) {
			
			// resize image
			$photo = new JImage($photoFilepath);
			$thumbnail = $photo->resize($width, $height, true, $scale);
			
			// crop image
			if ($crop) {
				$offsetLeft = ($thumbnail->getWidth() - $width) / 2;
				$offsetTop = ($thumbnail->getHeight() - $height) / 2;
				$thumbnail->crop($width, $height, $offsetLeft, $offsetTop, false);
			}
			
			// create folders (recursive) and write file
			if (JFolder::create($path . DS . $this->folder->getFolderPath())) {
				$thumbnail->toFile($thumbnailFilepath);
			}
		}

		$classReference = new JImage($thumbnailFilepath);
	}

	public function getThumbnailURL() {
		
		if ($this->thumbnail == null) {
			$this->resize('thumbnail', 220, 220, true); // TODO fix it / params
		}
		return str_replace(JPATH_BASE . DS, '', $this->thumbnail->getPath());
	}
	
	public function getResizedURL() { // TODO merge with getThumbnailURL
		
		if ($this->resized == null) {
			$this->resize('resized', 1760, 1320); // TODO fix it / params
		}
		return str_replace(JPATH_BASE . DS, '', $this->resized->getPath());
	}
}
