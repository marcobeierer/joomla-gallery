<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');

class FileController extends JController {
	
	private $gallery;
	
	function display() {
		
		$this->gallery = Gallery::getInstance();
		$this->handleFileRequest();
	}
	
	public function handleFileRequest() {

		$filepath = $this->gallery->getRequestPathWithFilename();
		if (file_exists($filepath)) {
			
			// open the file in a binary mode
			$fp = fopen($filepath, 'rb');
			
			// send the right headers
			header('Accept-Ranges: bytes');
			header('Content-Length: ' . filesize($filepath));
			header('Content-Type: ' . mime_content_type($filepath));
			//header('Cache-Control: public, min-fresh=3600, max-age=3600, s-maxage=3600, must-revalidate');
			
			// dump the picture and stop the script
			fpassthru($fp);
			fclose($fp);
		}
		exit;
	}
	
}

?>