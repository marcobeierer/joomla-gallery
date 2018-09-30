<?php
// Licensed under the AGPL v3
// Copyright by Marco Beierer

defined('_JEXEC') or die('Restricted Access');

class IPTC {
	
	private $intellectualGenre = null;
	private $title = null;
	private $subjectCode = null;
	private $keywords = null;
	private $instructions = null;
	private $dateCreated = null;
	
	private $creator = null;
	private $creatorJobtitle = null;
	
	private $jobId = null;
	private $headline = null;
	private $creditLine = null;
	private $source = null;
	private $copyrightNotice = null;
	private $description = null;
	private $descriptionWriter = null;
	
	private $city = null;
	private $sublocation = null;
	private $province = null;
	private $countryCode = null;
	private $country = null;
	
	//private $sceneCode = null;
	//private $creatorsContactInfo = null;
	//private $rightsUsageTerms = null;
	
	function __construct($filepath) {
		
		getimagesize($filepath, $photoInfo);
		
		if (isset($photoInfo['APP13'])) {

			$iptc = iptcparse($photoInfo['APP13']);
			
			if (isset($iptc['2#004'][0])) {
				$this->intellectualGenre =	$iptc['2#004'][0];
			}
			if (isset($iptc['2#005'][0])) {
				$this->title = 				$iptc['2#005'][0];
			}
			if (isset($iptc['2#012'][0])) {
				$this->subjectCode =		$iptc['2#012'][0];
			}
			if (isset($iptc['2#025'][0])) {
				$this->keywords = 			$iptc['2#025'][0];
			}
			if (isset($iptc['2#040'][0])) {
				$this->instructions = 		$iptc['2#040'][0];
			}
			if (isset($iptc['2#055'][0])) {
				$this->dateCreated =		$iptc['2#055'][0];
			}

			if (isset($iptc['2#080'][0])) {
				$this->creator = 			$iptc['2#080'][0];
			}
			if (isset($iptc['2#085'][0])) {
				$this->creatorsJobtitle = 	$iptc['2#085'][0];
			}

			if (isset($iptc['2#103'][0])) {
				$this->jobId =				$iptc['2#103'][0];
			}
			if (isset($iptc['2#105'][0])) {
				$this->headline = 			$iptc['2#105'][0];
			}
			if (isset($iptc['2#110'][0])) {
				$this->creditLine =			$iptc['2#110'][0];
			}
			if (isset($iptc['2#115'][0])) {
				$this->source =				$iptc['2#115'][0];
			}
			if (isset($iptc['2#116'][0])) {
				$this->copyrightNotice = 	$iptc['2#116'][0];
			}
			if (isset($iptc['2#120'][0])) {
				$this->description = 		$iptc['2#120'][0];
			}
			if (isset($iptc['2#122'][0])) {
				$this->descriptionWriter = 	$iptc['2#122'][0];
			}

			/* legacy */
			if (isset($iptc['2#090'][0])) {
				$this->city = 				$iptc['2#090'][0];
			}
			if (isset($iptc['2#092'][0])) {
				$this->sublocation =		$iptc['2#092'][0];
			}
			if (isset($iptc['2#095'][0])) {
				$this->province = 			$iptc['2#095'][0];
			}
			if (isset($iptc['2#100'][0])) {
				$this->countryCode = 		$iptc['2#100'][0];
			}
			if (isset($iptc['2#101'][0])) {
				$this->country = 			$iptc['2#101'][0];
			}
			
			//$this->sceneCode =		$iptc['2#'][0];
			//$this->creatorsContactInfo=$iptc['2#'][0];
			//$this->rightsUsageTerms =	$iptc['2#'][0];
		}
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function getHeadline() {
		return $this->headline;
	}
	
	public function getDescription() {
		return $this->description;
	}
	
	public function getDescriptionWriter() {
		return $this->descriptionWriter;
	}
	
	public function getCreator() {
		return $this->creator;
	}
	
	public function getCreatorsJobtitle() {
		return $this->creatorJobtitle;
	}
		
	public function getCopyrightNotice() {
		return $this->copyrightNotice;
	}
	
	public function getKeywords() {
		return $this->keywords;
	}
	
	public function getCity() {
		return $this->city;
	}
	
	public function getProvince() {
		return $this->province;
	}
	
	public function getCountry() {
		return $this->country;
	}
	
	public function getInstructions() {
		return $this->instructions;
	}

	public function getIntellectualGenre() {
		return $this->intellectualGenre;
	}
	
	public function getSubjectCode() {
		return $this->subjectCode;
	}
	
	public function getDateCreated() {
		return $this->dateCreated;
	}
	
	public function getJobId() {
		return $this->jobId;
	}
	
	public function getCreditLine() {
		return $this->creditLine;
	}
	
	public function getSource() {
		return $this->source;
	}
	
	public function getCountryCode() {
		return $this->countryCode;
	}
	
	public function getSublocation() {
		return $this->sublocation;
	}
}
