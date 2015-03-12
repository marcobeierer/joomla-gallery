<?php
defined('_JEXEC') or die( 'Restricted Access' );
 
jimport( 'joomla.application.component.view' ); 
jimport('joomla.html.pagination');

class GalleryViewGallery extends JViewLegacy
{ 	
	function display($tpl = null)
	{
		JToolBarHelper::title("Gallery Documentation");
		JToolBarHelper::preferences('com_gallery');
		
		parent::display($tpl); 
	} 
} 
?>