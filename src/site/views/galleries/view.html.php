<?php
// Licensed under the AGPL v3
// Copyright by Marco Beierer

defined('_JEXEC') or die('Restricted Access'); 

jimport('joomla.application.component.view');
jimport('joomla.html.parameter');

class GalleryViewGalleries extends JViewLegacy
{
	function display($tpl = null)
	{
		$application = JFactory::getApplication();
		
		// params
		$params = $application->getParams();
		$menu = $application->getMenu();
		$menuItems = $menu->getItems('menutype', 'photoalben'); // TODO as param
		// ---
		
		$user = JFactory::getUser();
		$accessLevels = $user->getAuthorisedViewLevels();
		$foundGallery = false;
		do {
			$galleryIndex = rand(0, count($menuItems) - 1);
			$selectedGallery = $menuItems[$galleryIndex];
			
			if (in_array($selectedGallery->level, $accessLevels)) {
				$foundGallery = true;
			}
			else {
				unset($menuItems[$galleryIndex]);
			}
		}
		while ($foundGallery == false && count($menuItems) > 0);
		
		$application->redirect(JRoute::_($selectedGallery->link . '&Itemid=' . $selectedGallery->id, false));
	}
}
?>
