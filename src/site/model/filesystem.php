<?php
// Licensed under the AGPL v3
// Copyright by Marco Beierer

defined('_JEXEC') or die('Restricted Access');

jimport('joomla.application.component.model');

class Filesystem { // TODO implement against Cache Interface
	
	private static $instance;
	private $gallery;
	
	private $folders;
	private $photos;
	
	/** @return Filesystem */
	public static function getInstance() {
	
		if (!isset(self::$instance)) {
			self::$instance = new Filesystem();
		}
		return self::$instance;
	}
	
	private function __construct() {
		
		$this->gallery = Gallery::getInstance();
		
		$this->folders = array(); // TODO is that effective? or use another data structure?
		$this->photos = array();
	}
	
	private function __clone() {}
	
	public function getFolder($folderPath) {
		
		if (array_key_exists($folderPath, $this->folders)) {
			return $this->folders[$folderPath];
		}
		
		$folder = new Folder($folderPath);
		$this->folders[$folderPath] = $folder;
		
		return $folder;
	}
	
	public function getPhoto(Folder $folder, $filename) {
		
		$photoPath = $folder->getFolderPath() . DS . $filename;
		
		if (array_key_exists($photoPath, $this->photos)) {
			return $this->photos[$photoPath];
		}
		
		$photo = new Photo($folder, $filename);
		$this->photos[$photoPath] = $photo;
		
		return $photo;
		
	}
}
