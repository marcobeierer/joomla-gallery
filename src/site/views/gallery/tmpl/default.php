<?php
defined('_JEXEC') or die('Restricted access');
?>
<div id="gallery">
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
	<div id="photos">
		<?php foreach($this->photos as $photo) { ?>
			<div class="gallery_item photo">		
				<a class="shutterset" 
					href="<?php echo $photo->getResizedURL(); ?>"
					title="<?php echo $photo->getIptcInfo()->getDescription(); ?>"
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
	<?php if ($this->showBacklink) { ?>
	<div id="backlink">
		<small>Powered by <a href="http://webguerilla.net/projects/joomla-gallery">Gallery</a> from <a href="http://webguerilla.net">webguerilla.net</a></small>
	</div>
	<?php } ?>
</div>