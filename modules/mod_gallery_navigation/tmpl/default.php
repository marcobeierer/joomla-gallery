<?php
defined('_JEXEC') or die('Restricted access');
?>

<div id="mod_gallery_navigation">
<?php if ($previousFolder != '') { ?>
	<div class="previous">
		<?php echo JText::_('Previous Folder'); ?>: 
		<a href="<?php echo $hrefPreviousFolder; ?>"><?php echo $previousFolder; ?></a>
	</div>
<?php } if ($nextFolder != '') { ?>
	<div class="next pull-right">
		<?php echo JText::_('Next Folder'); ?>:
		<a href="<?php echo $hrefNextFolder; ?>"><?php echo $nextFolder; ?></a>
	</div>
<?php } ?>
</div>
