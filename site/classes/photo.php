<?php
class Photo extends JObject
{
	private $folder;
	private $filename;
	
	private $thumbnail;
	//private $resized;

	
	function __construct(Folder $folder, $filename) {

		$this->folder = $folder;
		$this->filename = $filename;
	}
	
	public function getWidth() {
		
	}
	
	public function getHeight() {
		
	}
	
	
	public function resize() {
		
	}
	
	public function generateThumbnail($width, $height) {
		
		// define file paths
		$thumbnailFilepath = $this->folder->getThumbnailsPath() . DS . $this->folder->getFolderPath() . DS . $this->filename;
		$photoFilepath = $this->folder->getPhotosPath() . DS . $this->folder->getFolderPath() . DS . $this->filename;
		
		// check if thumbnail already exists and create it if not
		if (!JFile::exists($thumbnailFilepath)) {
			
			// resize image
			$photo = new JImage($photoFilepath);
			$thumbnail = $photo->resize($width, $height, true, 3);
			
			// crop image
			$offsetLeft = ($thumbnail->getWidth() - $width) / 2;
			$offsetTop = ($thumbnail->getHeight() - $height) / 2;
			$thumbnail->crop($width, $height, $offsetLeft, $offsetTop, false);
			
			// create folders (recursive) and write file
			if (JFolder::create($this->folder->getThumbnailsPath() . DS . $this->folder->getFolderPath())) {
				$thumbnail->toFile($thumbnailFilepath);
			}
		}

		$this->thumbnail = new JImage($thumbnailFilepath);
	}

	public function getThumbnail() {
		
		if ($this->thumbnail == null) {
			$this->generateThumbnail(220, 220); // TODO fix it / params
		}
		return $this->thumbnail;
	}

	public function getThumbnailURL() {
		
		if ($this->thumbnail == null) {
			$this->generateThumbnail(220, 220); // TODO fix it / params
		}
		return str_replace(JPATH_BASE . DS, '', $this->thumbnail->getPath());
	}
	
}
