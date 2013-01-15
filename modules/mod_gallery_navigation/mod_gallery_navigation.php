<?php
defined('_JEXEC') or die('Restricted access');

// TODO replace _ etc ueber helper (methode in klasse bleibt, aber ruft auch helper an)
// TODO language files (naechster vorheriger

// skip if not a gallery view
if (!JRequest::getBool('is_gallery', false)) {
	return;
}

// get vars
$currentPath = JRequest::getString('current_path', '');
$parentPath = substr($currentPath, 0, strrpos($currentPath, DS));
$photosPath = JRequest::getString('photos_path', '');
// ---

$folders = JFolder::folders($parentPath, '.', false, true);
$indexOfCurrentFolder = array_search($currentPath, $folders, true); // TODO search in a non linear way

$previousFolder = '';
$oneLayerUp = false;
$nextFolder = '';

if ($photosPath . DS != $currentPath) { // if not root

	if ($indexOfCurrentFolder > 0) {
		
		$previousFolderPath = $folders[$indexOfCurrentFolder - 1];
		$previousFolderRelativePath = str_replace($photosPath . DS, '', $previousFolderPath);
		$hrefPreviousFolder = 'index.php?option=com_gallery&path=' . $previousFolderRelativePath;
		
		$previousFolder = str_replace($parentPath . DS, '', $previousFolderPath);
		$previousFolder = GalleryHelper::getReadableFolderName($previousFolder);
	}
	
	// one layer up
	$oneLayerUpRelativePath = str_replace($photosPath, '', $parentPath);
	$hrefOneLayerUp = JRoute::_('index.php?option=com_gallery&path=' . $oneLayerUpRelativePath);
	$oneLayerUp = true;
	// ---
	
	if (count($folders) > ($indexOfCurrentFolder + 1)) {
		
		$nextFolderPath = $folders[$indexOfCurrentFolder + 1];
		$nextFolderRelativePath = str_replace($photosPath . DS, '', $nextFolderPath);
		$hrefNextFolder = JRoute::_('index.php?option=com_gallery&path=' . $nextFolderRelativePath);
		
		$nextFolder = str_replace($parentPath . DS, '', $nextFolderPath);
		$nextFolder = GalleryHelper::getReadableFolderName($nextFolder);
	}
}

require JModuleHelper::getLayoutPath('mod_gallery_navigation', 'default');
?>