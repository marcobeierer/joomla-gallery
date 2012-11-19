<?php
defined('_JEXEC') or die('Restricted access');
?>
<h2><?php // echo $this->title; ?></h2>

<a href="<?php echo JRoute::_('index.php?option=com_gallery&path=' . $this->photo->getFolder()->getFolderPath()); ?>">
	<img src="<?php echo $this->photo->getResizedURL(); ?>" />
</a>