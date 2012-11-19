<?php
defined('_JEXEC') or die('Restricted access');
?>
<h2><?php // echo $this->title; ?></h2>
<ul>
	<?php
	foreach($this->childFolders as $childFolder) {

		$previewPhoto = $childFolder->getPreviewPhoto();
		if ($previewPhoto != null) { // TODO in view.html
	?>
			<li>
				<a href="<?php echo JRoute::_('index.php?option=com_gallery&path=' . $childFolder->getFolderPath()); ?>">
					<img src="<?php  echo $previewPhoto->getThumbnailURL(); ?>" />
				</a>
			</li>
	<?php
		}
	}
	?>

</ul>

<ul>
	<?php foreach($this->photos as $photo) { ?>
		<li>
			<a href="<?php echo JRoute::_('index.php?option=com_gallery&view=photo&path=' . $photo->getFolder()->getFolderPath() . '&filename=' . $photo->getFilename()); ?>">
				<img src="<?php echo $photo->getThumbnailURL(); ?>" />
			</a>
		</li>
	<?php } ?>
</ul>
