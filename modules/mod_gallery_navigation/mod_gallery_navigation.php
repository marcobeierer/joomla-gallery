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

$folders = JFolder::folders($photosPath, '.', true, true); // TODO ineffective to get hole list
$indexOfCurrentFolder = array_search($currentPath, $folders, true); // TODO do in a non linear way

$previousFolder = '';
if ($indexOfCurrentFolder > 0) {
	
	$previousFolderPath = $folders[$indexOfCurrentFolder - 1];
	$previousFolderRelativePath = str_replace($photosPath . DS, '', $previousFolderPath);
	$hrefPreviousFolder = 'index.php?option=com_gallery&path=' . $previousFolderRelativePath;
	
	$previousFolder = str_replace(DS, ' | ', GalleryHelper::getReadableFolderName($previousFolderRelativePath));
}

$nextFolder = '';
if (count($folders) > ($indexOfCurrentFolder + 1)) {
	
	$nextFolderPath = $folders[$indexOfCurrentFolder + 1];
	$nextFolderRelativePath = str_replace($photosPath . DS, '', $nextFolderPath);
	$hrefNextFolder = JRoute::_('index.php?option=com_gallery&path=' . $nextFolderRelativePath);
	
	$nextFolder = str_replace(DS, ' | ', GalleryHelper::getReadableFolderName($nextFolderRelativePath));
	
	// TODO
	/*$currentFolderRelativePath = str_replace($photosPath . DS, '', $currentPath);
	
	$nextFolderParts = explode(DS, $nextFolderRelativePath);
	$currentFolderParts = explode(DS, $currentFolderRelativePath);
	
	for ($i = 0; $i <= count($currentFolderParts) && $i <= count($nextFolderParts); $i++) {
		
		if ($nextFolderParts[$i] != $currentFolderParts[$i]) {
			
			if ($nextFolder != '' && $nextFolderParts[$i] != '') {
				$nextFolder .= ' | ';
			}
			$nextFolder .= $nextFolderParts[$i];
		}
	}*/
}

require JModuleHelper::getLayoutPath('mod_gallery_navigation', 'default');
?>