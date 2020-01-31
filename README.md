# TagYour.Photos - Pimcore Autotagging
This bundle enables Pimcore autotagging for image assets. Your image assets will be tagged 
directly on upload or you can tag already uploaded assets with an autotagging function in the 
asset editor.

Autotagging analyzes the content of the images and determines suitable hierarchical tags. 
New tags are automatically created in the Pimcore tag configuration and are assigned to the images. 
TagYour.Photos analyzes objects, landmarks and location information.

## Install and enable TagYourPhotosBundle
To use the autotagging features you have to install this bundle with composer:

`COMPOSER_MEMORY_LIMIT=-1 composer require somaxsoftware/tagyourphotos`

After installation you can use Pimcore extension manager to activate and configure 
TagYourPhotosBundle.

![Enable TagYour.Photos bundle in Pimcore](https://bytebucket.org/tagyourphotos/tagyourphotos/raw/master/docs/EnableTagYourPhotosBundle.png)

## Configure TagYourPhotosBundle
To enable and test the autotagging feature you need an Application Key for TagYour.Photos. 
You can register this key on [www.tagyour.photos](https://www.tagyour.photos/kostenlos-testen1/).

![Configure TagYour.Photos bundle in Pimcore](https://bytebucket.org/tagyourphotos/tagyourphotos/raw/master/docs/ConfigureTagYourPhotosBundle.png)

The following configuration settings are available:

- **Application Key**: You can register for Application Key on our website.

- **Language**

    The language in which the tags are created and assigned. At the moment german but we are 
working on english tags.

- **Labels**

    Analysing the images for labels like cars, trees, butterflies etc.

- **Landmarks**

    Analysing the images for famous landmarks or places.

- **Location**

    Analysing the images for location information. Location information 
(Germany\Berlin...) is derived from recognized landmarks or places.

- **Probability Labels**
    
    Probability (50%-100%) from when labels are assigned to the images.

- **Probability Landmarks**

    Probability (50%-100%) from when landmarks or places are 
assigned to the images.

- **Thumbnail Definition**

    For performance reasons the autotagging is not working with the 
original images but with one of the pimcore thumbnail definitions.

## Autotagging with TagYourPhotosBundle
Autotagging will be processed directly on image upload. You can see the assigned tags in the 
asset editor.

![Created tags in Pimcore](https://bytebucket.org/tagyourphotos/tagyourphotos/raw/master/docs/CreatedTagsInAssetEditor.png)

If it is necessary to tag already existing images you can use the autotagging button 
in the right top corner of the asset editor.

![Configure TagYour.Photos bundle in Pimcore](https://bytebucket.org/tagyourphotos/tagyourphotos/raw/master/docs/AutotaggingInAssetEditor.png)

## Info
For further information please contact us:

Web: [www.tagyour.photos](https://www.tagyour.photos/)

Mail: [be@somax-software.de](mailto:be@somax-software.de)