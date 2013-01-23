<?php
defined('_JEXEC') or die('Restricted Access');
jimport('joomla.application.component.model');

class Folder {

	private $gallery;
	private $filesystem;
	
	private $relativeFolderPath;
	private $absoluteFolderPath;
	
	private $childFolders;
	private $photos;
	
	/** @param String $folderPath relative path of folder */
	public function __construct($relativeFolderPath) {
		
		$this->gallery =& Gallery::getInstance();
		$this->filesystem =& Filesystem::getInstance();
		
		$this->relativeFolderPath = $relativeFolderPath; // TODO make sure it is relative
		$this->absoluteFolderPath = $this->gallery->getPhotosPath() . DS . $relativeFolderPath;
	}
	
	public function getChildFolders() {
		
		if (isset($this->childFolders)) {
			return $this->childFolders;
		}
		
		$childFolders = JFolder::folders($this->absoluteFolderPath);
		$this->childFolders  = new SplDoublyLinkedList();
		
		foreach ($childFolders as $childFolder) {

			if ($this->relativeFolderPath == '') { // root
				$folderPath = $childFolder;
			} else {
				$folderPath = $this->relativeFolderPath . DS . $childFolder;
			}

			$folder = $this->filesystem->getFolder($folderPath);
			if ($folder->hasPhotos(true)) { // just add non empty folders
				$this->childFolders->push($folder);
			}
			
		}
		return $this->childFolders;
	}
	
	public function hasPhotos($recursive = false) {
		return count($this->getPhotoPaths($recursive)) > 0;
	}
	
	public function getPhotoPaths($recursive = false, $fullPath = true) {
		return JFolder::files($this->absoluteFolderPath, '.', $recursive, $fullPath);
	}

	public function getPhotos($recursive = false) {

		if (isset($this->photos) && !$recursive) {
			return $this->photos;
		}
		
		$this->photos = new SplDoublyLinkedList();

		foreach ($this->getPhotoPaths() as $photoPath) {
			
			$relativePhotoPath = GalleryHelper::makeRelative($photoPath);
			$relativePhotoPath = GalleryHelper::splitPath($relativePhotoPath);
			
			$folder = $this->filesystem->getFolder($relativePhotoPath->folderPath);
			$this->photos->push($this->filesystem->getPhoto($folder, $relativePhotoPath->filename));
		}

		return $this->photos;
	}

	/** get random preview photo for folder */
	public function getRandomPhoto() {
		
		$photoPaths = $this->getPhotoPaths(true);
		$numberOfPhotoPaths = count($photoPaths);

		if ($numberOfPhotoPaths <= 0) {
			return null;
		}

		$previewPhotoIndex = rand(0, $numberOfPhotoPaths - 1);
		
		$previewPhotoPath = $photoPaths[$previewPhotoIndex];
		$previewPhotoPath = GalleryHelper::splitPath($previewPhotoPath);

		$folder = $this->filesystem->getFolder($previewPhotoPath->folderPath);
		$previewPhoto = $this->filesystem->getPhoto($folder, $previewPhotoPath->filename);
		
		return $previewPhoto;
	}
	
	public function getFolderPath() {
		return $this->relativeFolderPath;
	}
	
	public function getFolderNames() {
		return explode('/', $this->relativeFolderPath);
	}

	public function getFolderName() {
		$parts = explode('/', $this->relativeFolderPath);
		return $parts[count($parts) - 1]; // return last element
	}
	
	public function getReadableFolderName() {
		return GalleryHelper::getReadableFolderName($this->getFolderName());
	}
	
}
