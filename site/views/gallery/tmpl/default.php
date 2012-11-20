<?php
defined('_JEXEC') or die('Restricted access');
?>
<div id="gallery">
	<h1><?php // echo $this->title; ?></h1>
	<h2>Folders</h2>
	<div id="folders" class="container">
		<?php
		foreach($this->childFolders as $childFolder) {
	
			$previewPhoto = $childFolder->getPreviewPhoto();
			if ($previewPhoto != null) { // TODO in view.html
		?>
				<div class="gallery_item">
					<a href="<?php echo JRoute::_('index.php?option=com_gallery&path=' . $childFolder->getFolderPath()); ?>">
						<img src="<?php  echo $previewPhoto->getThumbnailURL(); ?>" />
					</a>
				</div>
		<?php
			}
		}
		?>
	
	</div>
	
	<h2>Photos</h2>
	<div id="photos" class="container">
		<?php foreach($this->photos as $photo) { ?>
			<div class="gallery_item">
				<a class="shutterset" href="<?php echo $photo->getResizedURL(); ?>">
				<!--<a class="shutter" href="<?php echo JRoute::_('index.php?option=com_gallery&view=photo&path=' . $photo->getFolder()->getFolderPath() . '&filename=' . $photo->getFilename()); ?>">-->
					<img src="<?php echo $photo->getThumbnailURL(); ?>" />
				</a>
			</div>
		<?php } ?>
	</div>
</div>