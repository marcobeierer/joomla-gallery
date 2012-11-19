<?php
defined('_JEXEC') or die('Restricted access'); 

function GalleryBuildRoute(&$query)
{
	$segments = array();
	
	if (isset($query['path'])) {
		$segments[] = $query['path'];
		unset($query['path']);
	}
	
	if (isset($query['filename'])) {
		$segments[] = $query['filename'];
		unset($query['filename']);
	}
	
	unset($query['view']);
	
	return $segments;
}

function GalleryParseRoute($segments)
{
	$vars = array();
	$count = count($segments);
	
	// check if segements ends with .jpg
	if (preg_match('/\.jpg$/', $segments[$count - 1]) === 1) {
		
		$vars['view'] = 'photo';
		$vars['filename'] = array_pop($segments); // use last segment as filename
	}
	
	$vars['path'] = implode('/', $segments); // use rest as path
	
	return $vars;
}