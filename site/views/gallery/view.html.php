<?php
defined('_JEXEC') or die( 'Restricted Access' ); 
jimport('joomla.application.component.view');

class GalleryViewGallery extends JView
{
	var $photoWidth  = 220; // TODO params
	var $photoHeight = 220;
	
	function display($tpl = null)
	{
		// params // TODO auslagern // do not forget to validate
		$galleryPath = JPATH_BASE . DS . 'images' . DS . 'gallery';
		
		// validate
		$folderPath = JFolder::makeSafe(JRequest::getString('path'));
		
		// get path from GET
		$folder = new Folder($galleryPath, $folderPath);
		
		// get child folders of this folder
		$childFolders = $folder->getChildFolders(false);
		
		// remove empty folders from list
		for ($i = 0; $i < $childFolders->count(); $i++) {
			if (!$childFolders[$i]->hasPhotos(true)) {
				$childFolders->offsetUnset($i);
			}
		}

		// get photos of this folder
		$photos = $folder->getPhotos();

		// add scripts
		$document = &JFactory::getDocument();
		
		$document->addScript('media/com_gallery/js/jquery-1.8.3.min.js');
		$document->addScript('media/com_gallery/js/shutter-reloaded.js');
		$document->addScript('media/com_gallery/js/jquery.capty.min.js');
		
		$document->addScriptDeclaration('
			window.onload = function(){
				shutterReloaded.init();
				shutterReloaded.settings(\'/dev.joomla.test/joomla25/media/com_gallery/images/shutter/\');
			}
		'); // TODO path as param
		
		$document->addScriptDeclaration('
			$(function(){
				$(\'#gallery .caption\').capty({
					animation: \'fade\',
					speed: 400
				});
			});
		');
		// ---
		
		// add css
		$document->addStyleSheet('media/com_gallery/css/gallery.style.css');
		$document->addStyleSheet('media/com_gallery/css/jquery.capty.css');
		$document->addStyleSheet('media/com_gallery/css/shutter-reloaded.css');
		
		// get title
		if ($folderPath == '') {
			$title = 'Gallery';
		} else {
			$title = $folder->getFolderName();
		}
		
		// set breadcrumbs
		$pathway = JSite::getPathway();
				
		foreach ($folder->getFolderNames() as $folderName) {
			
			if (isset($currentPath)) {
				$currentPath .= DS . $folderName;
			} else {
				$currentPath .= $folderName;
			}
			
			// replace underscores
			$folderName = str_replace('_', ' ', $folderName);  // TODO replace with methode call
			
			$pathway->addItem($folderName, 'index.php?option=com_gallery&path=' . $currentPath);
		}
		
		// set title
		$document = JFactory::getDocument();
		$folderName = $folder->getReadableFolderName();
		
		if ($folderName != '') {
			$document->setTitle($folderName);
		}
		
		// assign Variables
		$this->assignRef('title', $title);
		$this->assignRef('childFolders', $childFolders);
		$this->assignRef('photos', $photos);
		
		parent::display($tpl);
	}
	
}
?>
