<?php


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