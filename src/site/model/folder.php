<?php
defined('_JEXEC') or die('Restricted Access');
jimport('joomla.application.component.model');

class GalleryModelFolder extends JModel {

	private $gallery;
	private $folderPath;
	
	function __construct($config) {
		
		parent::__construct();
		$this->gallery =& Gallery::getInstance();
		
		if (count($config) > 0) {
			$this->folderPath = $config[0];
		} else {
			$this->folderPath = $this->gallery->getCurrentRequestPath();
		}
	}
	
	public function getChildFolders() {
		
		// TODO create $childFolderList for every call or just once?
		
		$childFolders = JFolder::folders($this->gallery->getPhotosPath() . DS . $this->folderPath);
		$childFolderList  = new SplDoublyLinkedList();
		
		foreach ($childFolders as $childFolder) {

			if ($this->folderPath == '') {
				$folderPath = $childFolder;
			} else {
				$folderPath = $this->folderPath . DS . $childFolder;
			}

			$childFolderList->push(JModel::getInstance('Folder', 'GalleryModel', array($folderPath)));
		}
		
		return $childFolderList;
	}
	
	public function getChildFoldersWithoutEmptyFolders() {
		
		$childFolders = $this->getChildFolders();
		
		// remove empty folders from list
		for ($i = 0; $i < $childFolders->count(); $i++) {
			if (!$childFolders[$i]->hasPhotos(true)) {
				$childFolders->offsetUnset($i);
			}
		}
		
		return $childFolders;
	}
	
	public function hasPhotos($recursive = false) {
		
		$photos = JFolder::files($this->gallery->getPhotosPath() . DS . $this->folderPath, '.', $recursive);
		return count($photos) > 0;
	}

	public function getPhotos($recursive = false) {

		// TODO create $photoList for every call or just once?
		
		$photoPaths = JFolder::files($this->gallery->getPhotosPath() . DS . $this->folderPath, '.', $recursive, true);
		$photoList = new SplDoublyLinkedList();

		foreach ($photoPaths as $photoPath) {
			
			$relativePhotoPath = str_replace($this->gallery->getPhotosPath() . DS, '', $photoPath);
			$parts = explode('/', $relativePhotoPath);

			$filename = array_pop($parts);

			$folderPath = implode('/', $parts);
			
			if ($recursive) {
				
				$photoPathObject->folderPath = $folderPath;
				$photoPathObject->filename = $filename;
				
				$photoList->push($photoPathObject);
			}
			else {
				
				$folder = JModel::getInstance('Folder', 'GalleryModel', array($folderPath)); // TODO make sure that no folder object is created twice
				$photoList->push(JModel::getInstance('Photo', 'GalleryModel', array('folder' => $folder, 'filename' => $filename)));
			}
		}

		return $photoList;
	}

	/* get random folder preview photos */
	public function getPreviewPhoto() {
		
		$photos = $this->getPhotos(true);

		if ($photos->isEmpty()) {
			return null;
		}

		$previewPhotoIndex = rand(0, $photos->count() - 1);
		$previewPhoto = $photos->offsetGet($previewPhotoIndex);

		$folder = JModel::getInstance('Folder', 'GalleryModel', array($previewPhoto->folderPath)); // TODO make sure that no folder object is created twice
		$previewPhoto = JModel::getInstance('Photo', 'GalleryModel', array('folder' => $folder, 'filename' => $previewPhoto->filename));
		
		return $previewPhoto;
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
	
	public function getReadableFolderName() {
		return GalleryHelper::getReadableFolderName($this->getFolderName());
	}
	
}
