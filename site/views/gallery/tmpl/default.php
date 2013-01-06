<?php
defined('_JEXEC') or die('Restricted access');
?>
<div id="gallery">
	<?php if (count($this->childFolders) > 0) { ?>
	<div id="folders">
		<?php foreach($this->childFolders as $childFolder) { ?>
			<div class="gallery_item">
				<a href="<?php  echo JRoute::_('index.php?option=com_gallery&path=' . $childFolder->getFolderPath()); ?>">
					<img class="caption" alt="<?php echo $childFolder->getReadableFolderName(); ?>" src="<?php echo $childFolder->getPreviewPhoto()->getThumbnailURL(); ?>" />
				</a>
			</div>
		<?php } ?>	
		<div class="clear"></div>
	</div>
	<?php } else if (count($this->photos) > 0) { ?>
	<div id="photos">
		<?php foreach($this->photos as $photo) { ?>
			<div class="gallery_item">
				<a class="shutterset" href="<?php echo $photo->getResizedURL(); ?>">
				<!--<a class="shutter" href="<?php echo JRoute::_('index.php?option=com_gallery&view=photo&path=' . $photo->getFolder()->getFolderPath() . '&filename=' . $photo->getFilename()); ?>">-->
					<img src="<?php echo $photo->getThumbnailURL(); ?>" />
				</a>
			</div>
		<?php } ?>
		<div class="clear"></div>
	</div>
	<?php } ?>
</div>