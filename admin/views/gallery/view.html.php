<?php
defined('_JEXEC') or die( 'Restricted Access' );
 
jimport( 'joomla.application.component.view' ); 
jimport('joomla.html.pagination');

class GalleryViewGallery extends JView
{ 	
	function display($tpl = null)
	{
		JToolBarHelper::title("Gallery Documentation");
		parent::display($tpl); 
	} 
} 
?>