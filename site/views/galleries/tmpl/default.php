<?php
defined('_JEXEC') or die('Restricted access');
?>
<div id="gallery">
	<div id="folders" class="container">
		<?php foreach($this->galleryFolders as $galleryFolder) { ?>
			<?php JFactory::getApplication()->getParams()->set('gallery_path', $galleryFolder->menuItemParams->get('gallery_path')); // TODO dont do this at home // bad hack ?>
			<div class="gallery_item">
				<a href="<?php  echo JRoute::_('index.php?option=com_gallery&view=gallery&Itemid=' . $galleryFolder->menuItem->id); ?>">
					<img class="caption" alt="<?php echo $galleryFolder->menuItem->title; ?>" src="<?php echo $galleryFolder->getPreviewPhoto()->getThumbnailURL(); ?>" />
				</a>
			</div>
		<?php } ?>	
		<div class="clear"></div>
	</div>
</div>