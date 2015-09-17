<?php
// Licensed under the AGPL v3
// Copyright by Marco Beierer

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');

class FileController extends JControllerLegacy {
	
	private $gallery;
	
	function display($cachable = false, $urlparams = false) {
		
		$this->gallery = Gallery::getInstance();
		$this->handleFileRequest();
	}
	
	public function handleFileRequest() {

		$filepath = $this->gallery->getRequestPathWithFilename();
		if (file_exists($filepath)) {
			
			// open the file in a binary mode
			$fp = fopen($filepath, 'rb');

			$finfo = new finfo(FILEINFO_MIME_TYPE);
			$contentType = $finfo->file($filepath);

			// send the right headers
			header('Accept-Ranges: bytes');
			header('Content-Length: ' . filesize($filepath));
			header('Content-Type: ' . $contentType);
			//header('Cache-Control: public, min-fresh=3600, max-age=3600, s-maxage=3600, must-revalidate');
			
			// dump the picture and stop the script
			fpassthru($fp);
			fclose($fp);
		}
		exit; // TODO use return?;
	}
	
}

?>
