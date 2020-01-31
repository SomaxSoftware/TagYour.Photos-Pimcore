<?php
/**
 * TagYour.Photos
 *
 * This source file is available under the following license:
 * - GNU General Public License version 3 (GPLv3)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Somax Software UG (haftungsbeschränkt)
 */

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
        return sprintf('%s', 'v0.1.0');
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