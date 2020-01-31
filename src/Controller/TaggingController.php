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

namespace TagYourPhotosBundle\Controller;

use Pimcore\Controller\FrontendController;
use Pimcore\Bundle\AdminBundle\Controller\AdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Pimcore\Controller\Configuration\ResponseHeader;
use Symfony\Component\Routing\Annotation\Route;
use Pimcore\Log\ApplicationLogger;
use TagYourPhotosBundle\Helper;
use Pimcore\Model\Asset;

/**
 * @Route("/tagyourphotos/tagging")
 */
class TaggingController extends FrontendController
{
    /**
     * @Route("/autotag")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function autotagAction(Request $request) {
        $logger = $this->get(ApplicationLogger::class);

        $assetId = $request->get('id');

        $asset = Asset::getById($assetId);

        if ($asset->getType() == "image") {
            $tagging = new Helper\Tagging();
            $tagging->setLogger($logger);
            $statusCode = $tagging->tagAsset($asset);
        }

        return $this->json(['statusCode' => $statusCode]);
    }
}