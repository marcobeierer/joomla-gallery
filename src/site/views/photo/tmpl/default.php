<?php
// Licensed under the AGPL v3
// Copyright by Marco Beierer

defined('_JEXEC') or die('Restricted access');
?>
<div id="gallery">
	<h1><?php // echo $this->title; ?></h1>
	
	<a href="<?php echo JRoute::_('index.php?option=com_gallery&path=' . $this->photo->getFolder()->getFolderPath()); ?>">
		<img src="<?php echo $this->photo->getResizedURL(); ?>" />
	</a>
</div>
