# Joomla Gallery

## Changelog

### 1.0.0-beta.2
- Replaced call of mime_content_type function with use of Fileinfo extension.
	- mime_content_type is not available in PHP 5.6 and Fileinfo is available from PHP 5.3.

### 1.0.0-beta.1
- Fixed issue with reading IPTC data if key does not exist.
- Fixed issue with backlink removal code.
- Show child folders and photos div container only if child folders or photos are available.
- Changed "powered by" message and set link to nofollow. 
- Added "Fluidbox" as alternative to the "Shutter Reloaded" image viewer.
	- Changes in the Gallery View were necessary. If you have overridden this view, you have to adjust it.
- Made folder caption translatable.
- Implemented option to reverse the order of the photos.

### 1.0.0-alpha.9
- added support for the native Joomla update function

### 1.0.0-alpha.8
- fixed an issue with the backing removal code
- fixed a routing issue
- fixed lazy loading issue
- refactored to use native Joomla cache for thumbnails and preview images
- the protection of the images with a htaccess file is now optional

### 1.0.0-alpha.7
- gallery is now compatible with Joomla 3

### 1.0.0-alpha.6
- core htaccess hack is no longer needed
- fixed lightbox if mod_rewrite is not used

### 1.0.0-alpha.5
- added remove backlink code
- one bug fix

### 1.0.0-alpha.4
- added robots noindex for category pages
- added support for name converter plugins
- parameters for width/height of thumbnails and resized preview photos
- support for iptc information (show title and description in shutterbox)
- removed capty -> always show folder name (for usability reasons)
- show folders and photos in one folder at the same time

### 1.0.0-alpha.3
- Changed license from GPL to AGPL
- Piwik will track the clicks (next/previous) in the lightbox
- Added detection of non existing paths
- JQuery could be loaded optional
- Added a backlink to webguerilla.net (Could be deactivated in the settings)
- Added support for lazy loading (must be activated in the settings)
- Better error handling

### 1.0.0-alpha.2
- important bug fix

### 1.0.0-alpha.1
- added index.html to all folders

### 1.0.0-alpha
- initial release
