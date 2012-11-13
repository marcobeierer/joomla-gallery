<?php
defined('_JEXEC') or die( 'Restricted Access' ); 
jimport('joomla.application.component.view');

class GalleryViewGallery extends JView
{
	var $photoWidth  = 220;
	var $photoHeight = 220;
	
	function display($tpl = null)
	{
		// params // TODO auslagern
		$galleryBasePath 	= JPATH_BASE . DS . 'images' . DS . 'gallery';
		$photosBasePath 	= $galleryBasePath . DS . 'photos';
		$thumbnailsBasePath = $galleryBasePath . DS . 'thumbnails';
		// ---
		
		// get path from GET
		$basePath = JRequest::getString('path');
		$basePath = JFolder::makeSafe($basePath);
		
		if ($basePath != '') {
			$photosPath		= $photosBasePath . DS . $basePath;
			$thumbnailsPath = $thumbnailsBasePath . DS . $basePath;
		}
		else {
			$photosPath		= $photosBasePath;
			$thumbnailsPath = $thumbnailsBasePath;
		}
		// ---
		
		// get folders
		$folders = JFolder::folders($photosPath);
		
		// get random folder preview photos
		$previewPhotos = array();
		
		for ($i = 0; $i < count($folders); $i++) {
			
			$folder = $folders[$i];
			
			// define folders
			$photosBasePathFolder = $photosPath . DS . $folder;
			$thumbnailsBasePathFolder = $thumbnailsPath . DS . $folder;
			
			// get files in folders
			$filepaths = JFolder::files($photosBasePathFolder, '.', true, true);
			$filesCount = count($filepaths);
			
			// check if a image is available
			if ($filesCount > 0) {
			
				// calculate index of preview photo
				$photoIndex = rand(0, $filesCount - 1);
				$photoPath = $filepaths[$photoIndex];
				
				$thumbnailFilePath = self::getThumbnailFilePath($photosPath, $thumbnailsPath, $photoPath, $thumbnailsBasePathFolder);
				
				// create folder object for view and add to list
				unset($tmp);
				$tmp->path = str_replace($thumbnailsBasePath . DS, '', $thumbnailsBasePathFolder);
				$tmp->previewPhoto = str_replace(JPATH_BASE . DS, '', $thumbnailFilePath); // remove file path
				
				$previewPhotos[] = $tmp;
			}
		}
		// ---
		
		// get photos of this folder
		$photos = array();
		
		$filepaths = JFolder::files($photosPath, '.', false, true);
		$filesCount = count($filepaths);
		
		for ($i = 0; $i < $filesCount; $i++) {
			$thumbnailFilePath = self::getThumbnailFilePath($photosPath, $thumbnailsPath, $filepaths[$i], $thumbnailsBasePathFolder);
			$photos[] = str_replace(JPATH_BASE . DS, '', $thumbnailFilePath);
		}
		
		// assign Variables
		$this->assignRef('folders', $previewPhotos); // TODO rename previewPhotos
		$this->assignRef('photos', $photos);
		//$this->assignRef('title', ''); // TODO
		
		parent::display($tpl);
	}
	
	function getThumbnailFilePath($photosPath, $thumbnailsPath, $photoPath, $thumbnailsBasePathFolder) {
		// define thumbnail file path
		$thumbnailFilePath = str_replace($photosPath, $thumbnailsPath, $photoPath);
		
		// check if thumbnail already exists and create it if not
		if (!JFile::exists($thumbnailFilePath)) {
			
			// resize image
			$photo = new JImage($photoPath);
			$thumbnail = $photo->resize($this->photoWidth, $this->photoHeight, true, 3);
			
			// crop image
			$offsetLeft = ($thumbnail->getWidth() - $this->photoWidth) / 2;
			$offsetTop = ($thumbnail->getHeight() - $this->photoHeight) / 2;
			$thumbnail->crop($this->photoWidth, $this->photoHeight, $offsetLeft, $offsetTop, false);
			
			// create folders (recursive) and write file
			if (JFolder::create($thumbnailsBasePathFolder)) {
				$thumbnail->toFile($thumbnailFilePath);
			}
		}
		
		return $thumbnailFilePath;
	}
}
?>