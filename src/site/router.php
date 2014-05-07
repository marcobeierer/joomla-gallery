<?php
defined('_JEXEC') or die('Restricted access'); 

function GalleryBuildRoute(&$query)
{
	$segments = array();
	
	// add file segment if it is a file request
	if (isset($query['controller']) && $query['controller'] == 'file') {
		$segments[] = $query['controller'];
	}
	unset($query['controller']);
	
	if (isset($query['path'])) {
		$segments[] = $query['path'];
		unset($query['path']);
	}
	
	if (isset($query['filename'])) {
		$segments[] = $query['filename'];
		unset($query['filename']);
	}
	
	if (isset($query['view'])) {
		unset($query['view']);
	}
	
	return $segments;
}

function GalleryParseRoute($segments)
{
	$vars = array();
	$count = count($segments);
		
	// check if segements ends with .jpg
	if (preg_match('/\.(jpg|JPG)$/', $segments[$count - 1]) === 1) { // TODO jpg as param
		
		// check if it is a file request
		if ($segments[0] == 'file') { // TODO what happens if a folder in the filepath is called 'file'?
			$vars['controller'] = 'file';
			array_shift($segments); // remove first element which was 'file'
		}
		else {
			$vars['view'] = 'photo';
		}
	}
	
	$vars['path'] = implode('/', $segments); // use rest as path
	
	return $vars;
}
