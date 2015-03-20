# Joomla Gallery

## Introduction

The Gallery component is a minimalistic and completely file-based photo gallery for Joomla 2.5 and Joomla 3. File-based means that there is no need for a database and you could manage all your photos in just one place: the file system. The gallery is really simple to use: When you are creating a gallery, just upload your photos to the gallery folder and the whole gallery is automatically created.

The Joomla Gallery extension is the indirect successor of the [Photoblog](https://webguerilla.net/projects/photoblog) component.

## Demo

You could find a [demo of the "Gallery"](https://webguerilla.net/demos/gallery) component in the "Demos" section of my website.

## License

The "Gallery" component for Joomla 2.5 is published under the GNU AGPL v3 license. See http://www.gnu.org/licenses/agpl-3.0.html for more details.

## System Requirements

To run the Gallery on your Joomla! installation your server should satisfy the system requirements below:

- PHP 5.3
- Apache webserver
- MySQL 5

Maybe you are able to launch the component on other systems (e.g. running with MySQL 4), but I only have tested this configuration.

## Download

- [Gallery 1.0.0-alpha.7 (tar)](https://webguerilla.net/files/gallery/com_gallery-1.0.0-alpha.7.tar.gz)
- [Gallery 1.0.0-alpha.7 (zip)](https://webguerilla.net/files/gallery/com_gallery-1.0.0-alpha.7.zip)

## Install Instructions

1. Download the component archive file from the links above.

2. Install the package "com_gallery-x.x.x.tar.gz" through the Joomla extensions manager.

3. Create a new menu item for the gallery and set the path to the gallery (relative to your Joomla root folder) in the menu settings.

4. Access the menu item through the front-end (your website) or create a folder named "photos" in your gallery path. In the first case, the folder "photos" is automatically generated.

5. Upload some JPG photos to the folder "photos". You could do this through the Joomla media manager or via FTP. You are free to choose your own folder structure to organise your photos. The original photos shouldn't be to large, because the PHP memory limit would maybe exceeded when generating the preview photos or thumbnails for large photos. A maximum width and height of about 1600x1600 pixels should work fine.

6. Access the gallery via the front-end. The first call of each folder could take some time because the preview photos and thumbnails are just generated.

*Note: Breadcrumbs are used as navigation. So if you like to use navigation, you have to add a breadcrumbs module!*

## Changelog

### 1.0.0-alpha

- initial release

### 1.0.0-alpha.1

- added index.html to all folders

### 1.0.0-alpha.2

- important bug fix

### 1.0.0-alpha.3

- Changed license from GPL to AGPL
- Piwik will track the clicks (next/previous) in the lightbox
- Added detection of non existing paths
- JQuery could be loaded optional
- Added a backlink to webguerilla.net (Could be deactivated in the settings)
- Added support for lazy loading (must be activated in the settings)
- Better error handling

### 1.0.0-alpha.4

- added robots noindex for category pages
- added support for name converter plugins
- parameters for width/height of thumbnails and resized preview photos
- support for iptc information (show title and description in shutterbox)
- removed capty -> always show folder name (for usability reasons)
- show folders and photos in one folder at the same time

### 1.0.0-alpha.5

- added remove backlink code
- one bug fix

### 1.0.0-alpha.6

- core htaccess hack is no longer needed
- fixed lightbox if mod_rewrite is not used

### 1.0.0-alpha.7

- gallery is now compatible with Joomla 3

### 1.0.0-alpha.8

- fixed an issue with the backing removal code
- fixed a routing issue
- fixed lazy loading issue
- refactored to use native Joomla cache for thumbnails and preview images
- the protection of the images with a htaccess file is now optional

## Known Bugs

- It is not possible to use the gallery as front page.

## Report Bugs

Please report bugs directly on GitHub with the provided functions. It would be really nice if you could report all bugs you will find in the gallery.
