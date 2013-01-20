<?php
defined('_JEXEC') or die;

class GalleryHelper {
	
	public static function splitPath($path) {
		
		$parts = explode(DS, $path);

		$object->filename = JFile::makeSafe(array_pop($parts)); // last element is filename
		$object->folderPath = JFolder::makeSafe(implode(DS, $parts)); // use rest as path
		
		return $object;
	}
	
	public static function getReadableFolderName($folderName) {
		
		// TODO different sets for different languages
		// TODO one ruleset per gallery (via menu item settings)
	
		$folderName = str_replace('_', ' ', $folderName);
		
		
		$folderName = str_replace('ae', 'ä', $folderName);
		$folderName = str_replace('ue', 'ü', $folderName);
		//$folderName = str_replace('oe', 'ö', $folderName); // TODO works not with NL
		
		$folderName = str_replace('Ae', 'Ä', $folderName);
		$folderName = str_replace('Ue', 'Ü', $folderName);
		$folderName = str_replace('Oe', 'Ö', $folderName);
		
		$folderName = str_replace('sz', 'ß', $folderName);
		
		$folderName = preg_replace('/(\d+)ter/', '${1}.', $folderName);
		
		return $folderName;
	}
	
	/* check if path is valid and raise error otherwise */
	public static function validateRequestPath() { 
		
		$model = JModel::getInstance('Gallery', 'GalleryModel');
		
		if (JRequest::getVar('controller') == 'file') { // TODO cleaner
			$fullPath = $model->getGalleryPath();
		} else {
			$fullPath = $model->getPhotosPath();
		}
		$fullPath .= DS . $model->getCurrentRequestPath();
		
		if ($model->getCurrentRequestPath() != '' && !(JFolder::exists($fullPath) || JFile::exists($fullPath))) {
			JError::raiseError(404, JText::_("Page Not Found")); exit;
		}
	}
}