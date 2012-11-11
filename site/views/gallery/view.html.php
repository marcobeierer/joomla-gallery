<?php
defined('_JEXEC') or die( 'Restricted Access' ); 
jimport('joomla.application.component.view');

class GalleryViewGallery extends JView
{ 
	function display($tpl = null)
	{
		// params // TODO auslagern
		$rootFolder = 'images/gallery/';
		
		
		// ---
		
		parent::display($tpl);
	}
}
?>