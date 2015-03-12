<?php
defined( '_JEXEC' ) or die( 'Restricted access' ); 
jimport('joomla.application.component.controller'); 

class GalleryController extends JControllerLegacy
{
	function display($cachable = false, $urlparams = false) {
		
		if (JRequest::getVar('view') == '') {
			JRequest::setVar('view', 'gallery');
		}
		
		parent::display($cachable, $urlparams); 
	}
}
?>