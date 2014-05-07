<?php
defined('_JEXEC') or die;

class GalleryHelper {
	
	public static function splitPath($path, $makeRelative = true) {
		
		if ($makeRelative) {
			$path = GalleryHelper::makeRelative($path);
		}
		$parts = explode(DS, $path);
		
		$object = new ArrayObject();

		$object->filename = JFile::makeSafe(array_pop($parts)); // last element is filename
		$object->folderPath = JFolder::makeSafe(implode(DS, $parts)); // use rest as path
		
		return $object;
	}
	
	public static function makeRelative($path) {
		
		$gallery = Gallery::getInstance();
		return str_replace($gallery->getPhotosPath() . DS, '', $path);
	}
	
	public static function getReadableFolderName($folderName) {
		
		$folderName = str_replace('_', ' ', $folderName);
		
		$dispatcher = JDispatcher::getInstance();
		$dispatcher->trigger('onConvertLanguageSpecificChars', array(&$folderName));
		
		return $folderName;
	}
	
	/* check if path is valid and raise error otherwise */
	public static function validateRequestPath() { 
		
		$gallery = Gallery::getInstance();
		
		if (JRequest::getVar('controller') == 'file') {
			$fullPath = $gallery->getGalleryPath();
		} else {
			$fullPath = $gallery->getPhotosPath();
		}
		$fullPath .= DS . $gallery->getCurrentRequestPath();
		
		if ($gallery->getCurrentRequestPath() != '' && !(JFolder::exists($fullPath) || JFile::exists($fullPath))) {
			JError::raiseError(404, JText::_("Page Not Found")); exit;
		}
	}
}