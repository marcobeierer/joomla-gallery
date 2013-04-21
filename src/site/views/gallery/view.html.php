<?php
defined('_JEXEC') or die('Restricted Access'); 
jimport('joomla.application.component.view');

class GalleryViewGallery extends JView
{
	private $app;
	public $document; // TODO why not private?
	private $pathway;
	
	private $gallery;
	private $filesystem;
	
	private $folder;
	
	function display($tpl = null)
	{
		$this->app =& JFactory::getApplication();
		$this->document =& JFactory::getDocument();
		$this->pathway =& JSite::getPathway();
		
		$this->gallery =& Gallery::getInstance();
		$this->filesystem =& Filesystem::getInstance();
		
		$this->folder =& $this->filesystem->getFolder($this->gallery->getCurrentRequestPath());
		
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
		
		// add noindex for category pages
		if (count($photos) == 0) {
			$this->document->addCustomTag('<meta name="robots" content="noindex" />');
		}
		
		// assign Variables
		$this->assignRef('title', $title);
		$this->assignRef('childFolders', $childFolders);
		$this->assignRef('photos', $photos);
		$this->assignRef('showBacklink', $this->gallery->showBacklink());
		$this->assignRef('useLazyLoading', $this->gallery->shouldUseLazyLoading());
		$this->assignRef('thumbnailSize', $this->gallery->getThumbnailSize());

		parent::display($tpl);
	}
	
	private function loadJavaScripts() {
		
		if ($this->gallery->shouldLoadJQuery()) {
			$this->document->addScript('media/com_gallery/js/jquery-1.8.3.min.js');
		}
		
		$this->document->addScript('media/com_gallery/js/shutter-reloaded.js');
		$shutterImagesPath = JURI::root(true) . DS . 'media' . DS . 'com_gallery' . DS . 'images' . DS . 'shutter' . DS;
		
		$this->document->addScriptDeclaration('
			jQuery(document).ready(function() {
				shutterReloaded.init(0, \''. $shutterImagesPath . '\');
			});
		');
		
		if ($this->gallery->shouldUseLazyLoading()) {
			$this->document->addScript('media/com_gallery/js/jquery.lazyload.min.js');
			
			$this->document->addScriptDeclaration('
				jQuery(document).ready(function() {
					jQuery(\'#gallery img.lazy\').lazyload();
					
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
	}
	
	private function loadCSS() {
		
		$this->document->addStyleSheet('media/com_gallery/css/gallery.style.css');
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
