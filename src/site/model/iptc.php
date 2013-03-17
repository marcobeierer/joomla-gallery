<?php
defined('_JEXEC') or die('Restricted Access');

class IPTC {
	
	private $title = null;
	private $documentTitle = null;
	private $description = null;
	private $descriptionAuthor = null;
	private $author = null;
	private $authorTitle = null;
	private $copyright = null;
	private $keywords = null;
	private $category = null;
	private $city = null;
	private $state = null;
	private $country = null;
	private $instruction = null;
	private $creationTime = null;
	
	function __construct($filepath) {
		
		getimagesize($filepath, $photoInfo);
		
		if (isset($photoInfo['APP13'])) {

			$iptc = iptcparse($photoInfo['APP13']);
			
			$this->title = 				$iptc['2#105'][0];
			$this->documentTitle = 		$iptc['2#005'][0];
			$this->description = 		$iptc['2#120'][0];
			$this->descriptionAuthor = 	$iptc['2#122'][0];
			$this->author = 			$iptc['2#080'][0];
			$this->authorTitle = 		$iptc['2#085'][0];
			$this->copyright = 			$iptc['2#116'][0];
			$this->keywords = 			$iptc['2#025'][0];
			$this->category = 			$iptc['2#015'][0];
			$this->city = 				$iptc['2#090'][0];
			$this->state = 				$iptc['2#095'][0];
			$this->country = 			$iptc['2#101'][0];
			$this->instruction = 		$iptc['2#040'][0];
			$this->creationTime = 		substr($iptc['2#055'][0],6,2) 
											. '.'
											. substr($iptc['2#055'][0],4,2)
											. '.'
											. substr($iptc['2#055'][0],0,4);
		}
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function getDocumentTitle() {
		return $this->documentTitle;
	}
	
	public function getDescription() {
		return $this->description;
	}
	
	public function getDescriptionAuthor() {
		return $this->descriptionAuthor;
	}
	
	public function getAuthor() {
		return $this->author;
	}
	
	public function getAuthorTitle() {
		return $this->authorTitle;
	}
		
	public function getCopyright() {
		return $this->copyright;
	}
	
	public function getKeywords() {
		return $this->keywords;
	}
	
	public function getCategory() {
		return $this->category;
	}
	
	public function getCity() {
		return $this->city;
	}
	
	public function getState() {
		return $this->state;
	}
	
	public function getCountry() {
		return $this->country;
	}
	
	public function getInstruction() {
		return $this->instruction;
	}
	
	public function getCreationTime() {
		return $this->creationTime;
	}
}