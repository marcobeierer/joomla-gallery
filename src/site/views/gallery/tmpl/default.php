<?php
defined('_JEXEC') or die('Restricted access');
?>
<div id="gallery">
	<?php if (count($this->childFolders) > 0) { ?>
	<div id="folders">
		<?php foreach($this->childFolders as $childFolder) { ?>
			<div class="gallery_item">
				<a href="<?php echo JRoute::_('index.php?option=com_gallery&path=' . $childFolder->getFolderPath()); ?>">
					<?php if ($this->useLazyLoading) { ?>
						<img class="caption lazy" 
							alt="<?php echo $childFolder->getReadableFolderName(); ?>" 
							data-original="<?php echo $childFolder->getRandomPhoto()->getThumbnailURL(); ?>" 
							src="media/com_gallery/images/placeholder.png" 
						/>
					<?php } else { ?>
						<img class="caption lazy" 
							alt="<?php echo $childFolder->getReadableFolderName(); ?>" 
							src="<?php echo $childFolder->getRandomPhoto()->getThumbnailURL(); ?>" 
						/>
					<?php } ?>
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
					<?php if ($this->useLazyLoading) { ?>
						<img class="lazy" 
							data-original="<?php echo $photo->getThumbnailURL(); ?>" 
							src="media/com_gallery/images/placeholder.png" 
						/>
					<?php } else { ?>
						<img src="<?php echo $photo->getThumbnailURL(); ?>"	/>
					<?php } ?>
				</a>
			</div>
		<?php } ?>
		<div class="clear"></div>
	</div>
	<?php } ?>
	<?php if ($this->showBacklink) { ?>
	<div id="backlink">
		<small>Powered by <a href="http://webguerilla.net/projects/joomla-gallery">Gallery</a> from <a href="http://webguerilla.net">webguerilla.net</a></small>
	</div>
	<?php } ?>
</div>