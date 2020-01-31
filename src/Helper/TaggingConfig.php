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

namespace TagYourPhotosBundle\Helper;

use Pimcore\File;

class TaggingConfig
{
    const DEFAULT_APPLICATIONKEY = '';
    const DEFAULT_LANGUAGE = 'de';
    const DEFAULT_LABELS = true;
    const DEFAULT_LANDMARKS = true;
    const DEFAULT_LOCATION = true;
    const DEFAULT_PROBABILITYLABELS = 0.6;
    const DEFAULT_PROBABILITYLANDMARKS = 0.6;
    const DEFAULT_THUMBNAILDEFINITION = 'content';

    public static function read()
    {
        $config = [
            'applicationKey' => self::DEFAULT_APPLICATIONKEY,
            'language' => self::DEFAULT_LANGUAGE,
            'labels' => self::DEFAULT_LABELS,
            'landmarks' => self::DEFAULT_LANDMARKS,
            'location' => self::DEFAULT_LOCATION,
            'probabilityLabels' => self::DEFAULT_PROBABILITYLABELS,
            'probabilityLandmarks' => self::DEFAULT_PROBABILITYLANDMARKS,
            'thumbnailDefinition' => self::DEFAULT_THUMBNAILDEFINITION
        ];

        $filename = self::getConfigFilename();
        if (file_exists($filename)) {
            $tmp = require $filename;
            if (is_array($tmp)) {
                $config = array_merge($config, $tmp);
            }
        }

        return $config;
    }

    public static function save(array $data, bool $overwrite)
    {
        $filename = self::getConfigFilename();
        if (!file_exists($filename) || $overwrite) {
            File::put($filename, to_php_data_file_format($data));
        }
    }

    private static function getConfigFilename()
    {
        return PIMCORE_CONFIGURATION_DIRECTORY . '/tagyour.photos-config.php';
    }
}