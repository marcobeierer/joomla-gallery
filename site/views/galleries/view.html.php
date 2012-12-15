<?php
defined('_JEXEC') or die('Restricted Access'); 
jimport('joomla.application.component.view');
jimport('joomla.html.parameter');

class GalleryViewGalleries extends JView
{
	function display($tpl = null)
	{
		$application = JFactory::getApplication();
		
		// params
		$params = $application->getParams();
		$menu = $application->getMenu();
		$menuItems = $menu->getItems('menutype', 'photoalben'); // TODO variabel als param
		// ---
		
		$galleryFolders = array();
		foreach ($menuItems as $menuItem) {
			
			$menuItemParams = new JParameter($menuItem->params);
			$galleryPath = JPATH_BASE . DS . $menuItemParams->get('gallery_path'); // TODO validate
			
			$folder = new Folder($galleryPath, '/');
			$folder->menuItem = $menuItem; // TODO don't do such ugly stuff
			$folder->menuItemParams = $menuItemParams;
			
			$galleryFolders[] = $folder;
		}
		
		// TODO add scripts and css files in a separate file, so that it isn't necessary to add all stuff in every view
		
		// add scripts
		$document = &JFactory::getDocument();
		
		$document->addScript('media/com_gallery/js/jquery-1.8.3.min.js');
		$document->addScript('media/com_gallery/js/jquery.capty.min.js');
		
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
		
		$this->assignRef('galleryFolders', $galleryFolders);
		parent::display($tpl);
	}
	
}
?>
