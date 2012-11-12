<?php
defined('_JEXEC') or die('Restricted access');
?>
<ul>
	<?php foreach($this->photos as $photo) { ?>
		<li><img src="<?php echo $photo; ?>" /></li>
	<?php } ?>
</ul>