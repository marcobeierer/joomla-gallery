<?php
class Folder extends JObject { // TODO or JFolder?

	private $galleryPath;
	private $folderPath;

	private $photosPath;
	private $thumbnailsPath;
	private $resizedPath;
	
	function __construct($galleryPath, $folderPath) {
		
		$this->galleryPath 		= $galleryPath;
		$this->folderPath 		= $folderPath; // TODO correct validation?
		
		$this->photosPath 		= $this->galleryPath . DS . 'photos';
		$this->thumbnailsPath 	= $this->galleryPath . DS . 'thumbnails';
		$this->resizedPath 		= $this->galleryPath . DS . 'resized'; // TODO other name
	}
		
	public function getChildFolders() {
		
		// TODO create every for call or just once?
		
		$childFolders = JFolder::folders($this->photosPath . DS . $this->folderPath);
		$childFolderList  = new SplDoublyLinkedList();
		
		foreach ($childFolders as $childFolder) {

			if ($this->folderPath == '') {
				$folderPath = $childFolder;
			} else {
				$folderPath = $this->folderPath . DS . $childFolder;
			}

			$childFolderList->push(new Folder($this->galleryPath, $folderPath));
		}
		
		return $childFolderList;
	}

	public function getPhotos($recursive = false) {

		// TODO create for every call or just once?
		
		if ($recursive) {
			$photoPaths = JFolder::files($this->photosPath . DS . $this->folderPath, '.', true, true);
		} else {
			$photoPaths = JFolder::files($this->photosPath . DS . $this->folderPath, '.', false, true);
		}
		
		$photoList = new SplDoublyLinkedList();

		foreach ($photoPaths as $photoPath) {
			
			$relativePhotoPath = str_replace($this->photosPath . DS, '', $photoPath);
			$parts = explode('/', $relativePhotoPath);

			$filename = array_pop($parts);

			$folderPath = implode('/', $parts);
			$folder = new Folder($this->galleryPath, $folderPath); // TODO make sure that no folder object is created twice

			$photoList->push(new Photo($folder, $filename));
		}

		return $photoList;
	}

	// get random folder preview photos
	public function getPreviewPhoto() {
		
		$photos = $this->getPhotos(true);

		if ($photos->isEmpty()) {
			return null;
		}

		$previewPhotoIndex = rand(0, $photos->count() - 1);
		$previewPhoto = $photos->offsetGet($previewPhotoIndex);

		return $previewPhoto;
	}

	public function getThumbnailsPath() {
		return $this->thumbnailsPath;
	}
	
	public function getResizedPath() {
		return $this->resizedPath;
	}

	public function getPhotosPath() {
		return $this->photosPath;
	}
	
	public function getFolderPath() {
		return $this->folderPath;
	}
	
	public function getFolderNames() {
		return explode('/', $this->folderPath);
	}

	public function getFolderName() {
		$parts = explode('/', $this->folderPath);
		return $parts[count($parts) - 1]; // return last element
	}
	
}
