<?php
defined('_JEXEC') or die('Restricted access'); 

require_once (JPATH_COMPONENT . DS . 'controller.php');

$classname = 'GalleryController'; 
$controller = new $classname(); 

$controller->execute(true); 
$controller->redirect(); 
?>