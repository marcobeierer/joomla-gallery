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
						<img class="lazy" 
							alt="<?php echo $childFolder->getReadableFolderName(); ?>" 
							data-original="<?php echo $childFolder->getRandomPhoto()->getThumbnailURL(); ?>" 
							src="media/com_gallery/images/placeholder.png" 
							style="width: <?php echo $this->thumbnailSize; ?>px; height: <?php echo $this->thumbnailSize; ?>px;"
						/>
					<?php } else { ?>
						<img class="" 
							alt="<?php echo $childFolder->getReadableFolderName(); ?>" 
							src="<?php echo $childFolder->getRandomPhoto()->getThumbnailURL(); ?>" 
							style="width: <?php echo $this->thumbnailSize; ?>px; height: <?php echo $this->thumbnailSize; ?>px;"
						/>
					<?php } ?>
				</a>
				<div class="caption">
					<p><?php echo $childFolder->getReadableFolderName(); ?></p>
				</div>
			</div>
		<?php } ?>	
		<div class="clear"></div>
	</div>
	<?php } else if (count($this->photos) > 0) { ?>
	<div id="photos">
		<?php foreach($this->photos as $photo) { ?>
			<div class="gallery_item">		
				<a class="shutterset" 
					href="<?php echo $photo->getResizedURL(); ?>"
					title="<?php echo $photo->getIptcInfo()->getDescription(); ?>"
				>
					<?php if ($this->useLazyLoading) { ?>
						<img class="<?php if ($photo->getIptcInfo()->getHeadline() != null) { ?>caption <?php } ?>lazy" 
							data-original="<?php echo $photo->getThumbnailURL(); ?>" 
							src="media/com_gallery/images/placeholder.png" 
							style="width: <?php echo $this->thumbnailSize; ?>px; height: <?php echo $this->thumbnailSize; ?>px;"
							alt="<?php echo $photo->getIptcInfo()->getHeadline(); ?>"
						/>
					<?php } else { ?>
						<img class="<?php if ($photo->getIptcInfo()->getHeadline() != null) { ?>caption <?php } ?>"
							src="<?php echo $photo->getThumbnailURL(); ?>"	
							style="width: <?php echo $this->thumbnailSize; ?>px; height: <?php echo $this->thumbnailSize; ?>px;"
							alt="<?php echo $photo->getIptcInfo()->getHeadline(); ?>"
						/>
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