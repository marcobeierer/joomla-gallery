<?php
defined('_JEXEC') or die('Restricted access');
?>

<div id="mod_gallery_navigation" class="row-fluid">
	<div class="previous span5">
		<?php if ($previousFolder != '') { ?>
			<?php echo JText::_('PREVIOUS_FOLDER'); ?>: 
			<a href="<?php echo $hrefPreviousFolder; ?>"><?php echo $previousFolder; ?></a>
		<?php } ?>
	</div>
	<div class="up span2">
		<?php if ($oneLayerUp) { ?>
			<a href="<?php echo $hrefOneLayerUp; ?>"><?php echo JText::_('ONE_LAYER_UP'); ?></a>
		<?php } ?>
	</div>
	<div class="next span5">
		<?php if ($nextFolder != '') { ?>
			<?php echo JText::_('NEXT_FOLDER'); ?>:
			<a href="<?php echo $hrefNextFolder; ?>"><?php echo $nextFolder; ?></a>
		<?php } ?>
	</div>
</div>
