<?php
defined('_JEXEC') or die( 'Restricted Access' ); 
jimport('joomla.application.component.view');

class GalleryViewPhoto extends JView
{
	function display($tpl = null)
	{
		// params // TODO auslagern // do not forget to validate
		$galleryPath = JPATH_BASE . DS . 'images' . DS . 'gallery';
		
		// validate
		$folderPath = JFolder::makeSafe(JRequest::getString('path'));
		$filename = JFile::makeSafe(JRequest::getString('filename'));
		// ---
		
		$folder = new Folder($galleryPath, $folderPath);
		$photo = new Photo($folder, $filename);
		
		// assign Variables
		$this->assignRef('photo', $photo);
		
		parent::display($tpl);
	}
}
?>