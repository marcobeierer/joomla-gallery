<?php
defined('_JEXEC') or die('Restricted access');
?>
<h2><?php echo $this->title; ?></h2>
<ul>
	<?php foreach($this->folders as $folder) { ?>
		<li>
			<a href="<?php echo JRoute::_('index.php?option=com_gallery&path=' . $folder->path); ?>">
				<img src="<?php echo $folder->previewPhoto; ?>" />
			</a>
		</li>
	<?php } ?>

</ul>

<ul>
	<?php foreach($this->photos as $photo) { ?>
		<li><img src="<?php echo $photo; ?>" /></li>
	<?php } ?>
</ul>