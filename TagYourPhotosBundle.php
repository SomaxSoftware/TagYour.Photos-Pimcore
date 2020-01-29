<?php

namespace TagYourPhotosBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;

class TagYourPhotosBundle extends AbstractPimcoreBundle
{
    /**
     * {@inheritdoc}
     */
    protected function getComposerPackageName()
    {
        return 'somaxsoftware/tagyourphotos';
    }

    public function getVersion()
    {
        return sprintf('%s', 'v0.0.7');
    }

    public function getJsPaths()
    {
        return [
            '/bundles/tagyourphotos/js/pimcore/startup.js'
        ];
    }

    public function getCssPaths()
    {
        return [
            '/bundles/tagyourphotos/css/icons.css'
        ];
    }

    public function getAdminIframePath()
    {
        return '/tag_your_photos_config';
    }
}