<?php defined('_JEXEC') or die('Restricted access'); ?>
<h1>Install Instructions</h1>
<ol style="font-size: 16px;">
	<li><p>Modify line 68 of your .htaccess file (<code>RewriteCond %{REQUEST_URI} /component/|(/[^.]*|\.(php|html?|feed|pdf|vcf|raw))$ [NC]</code>) if you are using SEF URL's and add <code>|jpg</code> to the rewrite condition. The line should look like this: <code>RewriteCond %{REQUEST_URI} /component/|(/[^.]*|\.(php|html?|feed|pdf|vcf|raw|jpg))$ [NC]</code>. Otherwise no images would be shown.</p></li>
	<li><p>Create a new menu item for the gallery and set the path to the gallery (relative to your Joomla root folder) in the menu settings.</p></li>
	<li><p>Access the menu item through the front-end (your website) or create a folder named "photos" in your gallery path. In the first case, the folder "photos" is automatically generated.</p></li>
	<li><p>Upload some JPG photos to the folder "photos". You could do this through the Joomla media manager or via FTP. You are free to choose your own folder structure to organise your photos. The original photos shouldn't be to large, because the PHP memory limit would maybe exceeded when generating the preview photos or thumbnails for large photos. A maximum width and height of about 1600x1600 pixels should work fine.</p></li>
	<li><p>Access the gallery via the front-end. The first call of each folder could take some time because the preview photos and thumbnails are just generated.</p></li>
</ol>