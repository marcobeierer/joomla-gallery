<?php
defined('_JEXEC') or die( 'Restricted Access' ); 
jimport('joomla.application.component.view');

class GalleryViewGallery extends JView
{
	var $photoWidth  = 220; // TODO params
	var $photoHeight = 220;
	
	function display($tpl = null)
	{
		// params // TODO auslagern
		$galleryPath = JPATH_BASE . DS . 'images' . DS . 'gallery';
		
		// get path from GET
		$folder = new Folder($galleryPath, JRequest::getString('path'));
		
		// get child folders of this folder
		$childFolders = $folder->getChildFolders();

		// get photos of this folder
		$photos = $folder->getPhotos();

		// assign Variables
		//$this->assignRef('title', 'Gallery'); // TODO as param
		$this->assignRef('childFolders', $childFolders);
		$this->assignRef('photos', $photos);
		
		parent::display($tpl);
	}
	
}
?>
