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
		$menuItems = $menu->getItems('menutype', 'photoalben'); // TODO as param
		// ---
		
		$selectedGallery = $menuItems[rand(0, count($menuItems) - 1)];
		
		$application->redirect(JRoute::_($selectedGallery->link . '&Itemid=' . $selectedGallery->id, false));
	}
}
?>
