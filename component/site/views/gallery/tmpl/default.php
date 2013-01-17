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
					<img src="<?php echo $photo->getThumbnailURL(); ?>" />
				</a>
			</div>
		<?php } ?>
		<div class="clear"></div>
	</div>
	<?php } ?>
	<?php if ($this->showBacklink) { ?>
	<div>
		<small>Powered by <a href="http://webguerilla.net/projects/joomla-gallery">Joomla Gallery</a></small>
	</div>
	<?php } ?>
</div>