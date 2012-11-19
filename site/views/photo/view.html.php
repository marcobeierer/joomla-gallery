<?php
defined('_JEXEC') or die( 'Restricted Access' ); 
jimport('joomla.application.component.view');

class GalleryViewPhoto extends JView
{
	function display($tpl = null)
	{
		
		
		// assign Variables
		$this->assignRef('', $tmp); // TODO rename previewPhotos

		
		parent::display($tpl);
	}
}
?>