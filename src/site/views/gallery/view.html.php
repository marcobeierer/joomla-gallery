<?php
defined('_JEXEC') or die('Restricted Access'); 
jimport('joomla.application.component.view');

class GalleryViewGallery extends JView
{
	private $app;
	public $document; // TODO why not private?
	private $pathway;
	
	private $gallery;
	private $folder;
	
	function display($tpl = null)
	{
		$this->app =& JFactory::getApplication();
		$this->document =& JFactory::getDocument();
		$this->pathway =& JSite::getPathway();
		
		$this->gallery = JModel::getInstance('Gallery', 'GalleryModel');
		$this->folder = JModel::getInstance('Folder', 'GalleryModel');
		
		// get child folders of this folder
		$childFolders = $this->folder->getChildFoldersWithoutEmptyFolders();

		// get photos of this folder
		$photos = $this->folder->getPhotos();

		// load js and css files
		$this->loadJavaScripts();
		$this->loadCSS();
		
		// get title
		if ($this->gallery->getCurrentRequestPath() == '') {
			$title = 'Gallery';
		} else {
			$title = $this->folder->getFolderName();
		}
		
		// set breadcrumbs and title
		$this->setBreadcrumbs();
		$this->setTitle();
		
		// assign Variables
		$this->assignRef('title', $title);
		$this->assignRef('childFolders', $childFolders);
		$this->assignRef('photos', $photos);
		$this->assignRef('showBacklink', $this->gallery->showBacklink());

		parent::display($tpl);
	}
	
	private function loadJavaScripts() {
		
		if ($this->gallery->shouldLoadJQuery()) {
			$this->document->addScript('media/com_gallery/js/jquery-1.8.3.min.js');
		}
		
		$this->document->addScript('media/com_gallery/js/shutter-reloaded.js');
		$this->document->addScript('media/com_gallery/js/jquery.capty.min.js');
		
		$shutterImagesPath = JURI::root(true) . DS . 'media' . DS . 'com_gallery' . DS . 'images' . DS . 'shutter' . DS;
		
		$this->document->addScriptDeclaration('
			jQuery(document).ready(function() {
				shutterReloaded.init(0, \''. $shutterImagesPath . '\');
				
				var $jg = jQuery.noConflict();
				$jg(\'#gallery .caption\').capty({
					animation: \'fade\',
					speed: 400
				});
			});
		');
	}
	
	private function loadCSS() {
		
		$this->document->addStyleSheet('media/com_gallery/css/gallery.style.css');
		$this->document->addStyleSheet('media/com_gallery/css/jquery.capty.css');
		$this->document->addStyleSheet('media/com_gallery/css/shutter-reloaded.css');
	}
	
	private function setBreadcrumbs() {
				
		foreach ($this->folder->getFolderNames() as $folderName) {
			
			if ($folderName == '') {
				continue; // skip if foldername is empty
			}
			
			if (isset($currentPath)) {
				$currentPath .= DS . $folderName;
			} else {
				$currentPath = $folderName;
			}
			
			// replace underscores
			$folderName = GalleryHelper::getReadableFolderName($folderName);
			
			$this->pathway->addItem($folderName, 'index.php?option=com_gallery&path=' . $currentPath);
		}
	}
	
	private function setTitle() {
				
		$folderName = $this->folder->getReadableFolderName();
		
		if ($folderName == '') {
			$folderName = $this->document->getTitle();
		}
		
		$sitename = $this->app->getCfg('sitename', ''); // TODO validate ?
		switch ($this->app->getCfg('sitename_pagetitles', 0)) {
			case 2: // after
				$this->document->setTitle($folderName . ' - ' . $sitename);
				break;
			case 1: // before
				$this->document->setTitle($sitename . ' - ' . $folderName);
				break;
			default: // none
				$this->document->setTitle($folderName);
		}
	}
}
?>
