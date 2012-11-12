<?php
defined('_JEXEC') or die( 'Restricted Access' ); 
jimport('joomla.application.component.view');

class GalleryViewGallery extends JView
{ 
	function display($tpl = null)
	{
		// params // TODO auslagern
		$galleryBasePath 	= JPATH_BASE . DS . 'images' . DS . 'gallery';
		$photosBasePath 	= $galleryBasePath . DS . 'photos';
		$thumbnailsBasePath = $galleryBasePath . DS . 'thumbnails';
		
		$photosBasePath 	.= DS . '2012'; // TODO remove
		$thumbnailsBasePath .= DS . '2012'; // TODO remove
		
		$photoWidth  = 220;
		$photoHeight = 220;
		// ---
		
		// get folders
		$folders = JFolder::folders($photosBasePath);
		
		// get random folder preview photos
		$previewPhotos = array();
		
		foreach($folders as $folder) {
			
			// define folders
			$photosBasePathFolder = $photosBasePath . DS . $folder;
			$thumbnailsBasePathFolder = $thumbnailsBasePath . DS . $folder;
			
			// get files in folders
			$files = JFolder::files($photosBasePathFolder);
			$filesCount = count($files);
			
			// calculate index of preview photo
			$photoIndex = rand(0, $filesCount - 1);
			$photoPath = $photosBasePathFolder . DS . $files[$photoIndex];
			
			// define thumbnail file path
			$thumbnailFilePath = $thumbnailsBasePathFolder . DS . $files[$photoIndex];
			
			// check if thumbnail already exists and create it if not
			if (!JFile::exists($thumbnailFilePath)) {
				
				// resize image
				$photo = new JImage($photoPath);
				$thumbnail = $photo->resize($photoWidth, $photoHeight, true, 3);
				
				// crop image
				$offsetLeft = ($thumbnail->getWidth() - $photoWidth) / 2;
				$offsetTop = ($thumbnail->getHeight() - $photoHeight) / 2;
				$thumbnail->crop($photoWidth, $photoHeight, $offsetLeft, $offsetTop, false);
				
				// create folders (recursive) and write file
				if (JFolder::create($thumbnailsBasePathFolder)) {
					$thumbnail->toFile($thumbnailFilePath);
				}
			}
			
			// remove file path and add uri to list
			$thumbnailURI = str_replace(JPATH_BASE . DS, '', $thumbnailFilePath);
			$previewPhotos[] = $thumbnailURI;
		}
		// ---
		
		// assign Variables
		$this->assignRef('photos', $previewPhotos);
		
		parent::display($tpl);
	}
}
?>