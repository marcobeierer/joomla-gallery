<?php
// Licensed under the AGPL v3
// Copyright by Marco Beierer

defined('_JEXEC') or die('Restricted access'); 

function GalleryBuildRoute(&$query)
{
	$segments = array();
	
	// add file segment if it is a file request
	if (isset($query['controller']) && $query['controller'] == 'file') {

		$segments[] = $query['controller'];
		$query['path'] = preg_replace('/\.(.*)/', '/$1', $query['path']); // remove filetype
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

	foreach ($segments as &$segment) { // TODO quickfix for joomla core bug
		$segment = str_replace(':', '-', $segment);
	}

    // check if it is a file request
    if ($segments[0] == 'file') { // TODO what happens if a folder in the filepath is called 'file'?

		$vars['controller'] = array_shift($segments); // remove first element which was 'file'

		$filetype = array_pop($segments);
		$filename = array_pop($segments);

		array_push($segments, $filename . '.' . $filetype);
    }
    //else {
    	//$vars['view'] = 'photo';
    //}
	
	$vars['path'] = implode('/', $segments); // use rest as path

	return $vars;
}
