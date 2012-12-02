<?php
defined('_JEXEC') or die( 'Restricted Access' ); 
jimport('joomla.application.component.view');

class GalleryViewPhoto extends JView
{
	function display($tpl = null)
	{
		// params
		$params = JFactory::getApplication()->getParams();
		$galleryPath = JPATH_BASE . DS . $params->get('gallery_path');
		
		// validate
		$folderPath = JFolder::makeSafe(JRequest::getString('path'));
		$filename = JFile::makeSafe(JRequest::getString('filename'));
		// ---
		
		$folder = new Folder($galleryPath, $folderPath);
		$photo = new Photo($folder, $filename);
		
		// add css
		$document = &JFactory::getDocument();
		$document->addStyleSheet('media/com_gallery/css/gallery.style.css');
		
		// assign Variables
		$this->assignRef('photo', $photo);
		
		parent::display($tpl);
	}
}
?>