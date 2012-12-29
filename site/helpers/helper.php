<?php
defined('_JEXEC') or die;

class GalleryHelper {
	
	public static function splitPath($path) { // TODO use where it is not used yet (refactorate)
		
		$parts = explode(DS, $path);

		$object->filename = JFile::makeSafe(array_pop($parts)); // last element is filename
		$object->folderPath = JFolder::makeSafe(implode(DS, $parts)); // use rest as path
		
		return $object;
	}
}