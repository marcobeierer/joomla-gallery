<?php
// Licensed under the AGPL v3
// Copyright by Marco Beierer

defined('_JEXEC') or die('Restricted Access'); 

jimport('joomla.application.component.view');

class GalleryViewGallery extends JViewLegacy
{
	private $app;
	public $document; // TODO why not private?
	private $pathway;
	
	private $gallery;
	private $filesystem;
	
	private $folder;
	
	function display($tpl = null)
	{
		$this->app = JFactory::getApplication();
		$this->document = JFactory::getDocument();
		$this->pathway = JFactory::getApplication('site')->getPathway();
		
		$this->gallery = Gallery::getInstance();
		$this->filesystem = Filesystem::getInstance();
		
		$this->folder = $this->filesystem->getFolder($this->gallery->getCurrentRequestPath());
		
		// get child folders of this folder
		$childFolders = $this->folder->getChildFolders();

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

		$this->childFoldersCount = count($childFolders);
		$this->photosCount = count($photos);
		
		// add noindex for category pages
		if ($this->photosCount == 0) {
			$this->document->addCustomTag('<meta name="robots" content="noindex" />');
		}
		
		// assign Variables
		$this->assignRef('title', $title); // TODO change to direct assign
		$this->assignRef('childFolders', $childFolders); // TODO change to direct assign
		$this->assignRef('photos', $photos); // TODO change to direct assign

		$this->showBacklink = $this->gallery->showBacklink();
		$this->useLazyLoading = $this->gallery->shouldUseLazyLoading();
		$this->thumbnailSize = $this->gallery->getThumbnailSize();

		parent::display($tpl);
	}
	
	private function loadJavaScripts() {
		
		if ($this->gallery->shouldLoadJQuery()) {
			JHtml::_('jquery.framework');
		}

		if ($this->gallery->getLightbox() == 'fluidbox') {

			$this->document->addScript('media/com_gallery/js/jquery.fluidbox.min.js');
			$this->document->addScriptDeclaration('
				jQuery(document).ready(function() {
					jQuery(\'#gallery a[rel=lightbox]\').fluidbox();
				});
			');
		}
		else if ($this->gallery->getLightbox() == 'lightbox2') {
			$this->document->addScript('media/com_gallery/js/lightbox.min.js');
		}
		else { // shutter reloaded
			$this->document->addScript('media/com_gallery/js/shutter-reloaded.js');
			$shutterImagesPath = JURI::root(true) . '/media/com_gallery/images/shutter/';
			
			$this->document->addScriptDeclaration('
				jQuery(document).ready(function() {
					shutterReloaded.init(\'sh\', \''. $shutterImagesPath . '\');
				});
			');
		}
		
		if ($this->gallery->shouldUseLazyLoading()) {
			$this->document->addScript('media/com_gallery/js/jquery.lazyload.min.js');
			
			$this->document->addScriptDeclaration('
				jQuery(document).ready(function() {
					jQuery(\'#gallery img.lazy\').lazyload();
				});
			');
		}
		
		$this->document->addScriptDeclaration('
			jQuery(document).ready(function() {
				var $jg = jQuery.noConflict();
				$jg(\'#gallery .folder a\').hover(
					function() {
						$jg(this).children(\'.caption\').css(\'opacity\', \'0.9\');
					},
					function() {
						$jg(this).children(\'.caption\').css(\'opacity\', \'0.5\');
					}
				);
			});
		');
	}
	
	private function loadCSS() {

		if ($this->gallery->getLightbox() == 'fluidbox') {
			$this->document->addStyleSheet('media/com_gallery/css/fluidbox.css');
		}
		else if ($this->gallery->getLightbox() == 'lightbox2') {
			$this->document->addStyleSheet('media/com_gallery/css/lightbox.css');
		}
		else { // shutter reloaded
			$this->document->addStyleSheet('media/com_gallery/css/shutter-reloaded.css');
		}

		$this->document->addStyleSheet('media/com_gallery/css/gallery.style.css');
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
