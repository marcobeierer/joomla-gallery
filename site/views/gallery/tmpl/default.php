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
		<li><img src="<?php echo $photo->getThumbnailURL(); ?>" /></li>
	<?php } ?>
</ul>
