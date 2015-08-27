<?php
// Licensed under the AGPL v3
// Copyright by Marco Beierer

defined('_JEXEC') or die('Restricted access');
?>
<div id="gallery">
	<?php if ($this->childFoldersCount > 0): ?>
	<div id="folders">
		<?php foreach($this->childFolders as $childFolder) { ?>
			<div class="gallery_item folder">
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
					<div class="caption">
						<p><?php echo $childFolder->getReadableFolderName(); ?></p>
					</div>
				</a>
				
			</div>
		<?php } ?>	
		<div class="clear"></div>
	</div>
	<?php endif; ?>
    <?php if ($this->photosCount > 0): ?>
	<div id="photos">
		<?php foreach($this->photos as $photo) { ?>
			<div class="gallery_item photo">		
				<a class="shutterset" 
					href="<?php echo $photo->getResizedURL(); ?>"
					title="<?php echo $photo->getLightboxDescription(); ?>"
				>
					<?php if ($this->useLazyLoading) { ?>
						<img class="lazy" 
							data-original="<?php echo $photo->getThumbnailURL(); ?>" 
							src="media/com_gallery/images/placeholder.png" 
							style="width: <?php echo $this->thumbnailSize; ?>px; height: <?php echo $this->thumbnailSize; ?>px;"
							alt="<?php echo $photo->getIptcInfo()->getDescription(); ?>"
							title="<?php echo $photo->getIptcInfo()->getTitle(); ?>"
						/>
					<?php } else { ?>
						<img class=""
							src="<?php echo $photo->getThumbnailURL(); ?>"	
							style="width: <?php echo $this->thumbnailSize; ?>px; height: <?php echo $this->thumbnailSize; ?>px;"
							alt="<?php echo $photo->getIptcInfo()->getDescription(); ?>"
							title="<?php echo $photo->getIptcInfo()->getTitle(); ?>"
						/>
					<?php } ?>
				</a>
			</div>
		<?php } ?>
		<div class="clear"></div>
	</div>
	<?php endif; ?>
	<?php if ($this->showBacklink) { ?>
	<div id="backlink">
		<p><small>Powered by the <a href="https://www.marcobeierer.com/joomla-extensions/gallery" rel="nofollow">Gallery extension for Joomla</a>.</small></p>
	</div>
	<?php } ?>
</div>
