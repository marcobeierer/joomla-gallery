<?php defined('_JEXEC') or die('Restricted access'); ?>

<div id="mod_gallery_navigation">
	<ul class="menu">
		<?php if ($previousFolder != '') { ?>
		<li>
			<?php echo JText::_('PREVIOUS_FOLDER'); ?>: 
			<a href="<?php echo $hrefPreviousFolder; ?>"><?php echo $previousFolder; ?></a>
		</li>
		<?php } ?>
		
		<?php if ($oneLayerUp) { ?>
		<li>
			<a href="<?php echo $hrefOneLayerUp; ?>"><?php echo JText::_('ONE_LAYER_UP'); ?></a>
		</li>
		<?php } ?>
		
		<?php if ($nextFolder != '') { ?>
		<li>
			<?php echo JText::_('NEXT_FOLDER'); ?>:
			<a href="<?php echo $hrefNextFolder; ?>"><?php echo $nextFolder; ?></a>
		</li>
		<?php } ?>
	</ul>
</div>