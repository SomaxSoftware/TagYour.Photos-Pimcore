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
use TagYourPhotosBundle\Helper\TaggingConfig;
use Pimcore\Log\ApplicationLogger;

/**
 * @Route("/tag_your_photos_config")
 */
class ConfigController extends FrontendController
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $logger = $this->get(ApplicationLogger::class);

        $this->view->config = TaggingConfig::read();
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/save")
     */
    public function saveAction(Request $request)
    {
        $logger = $this->get(ApplicationLogger::class);

        TaggingConfig::save([
            'applicationKey' => $request->get('applicationKey', TaggingConfig::DEFAULT_APPLICATIONKEY),
            'language' => $request->get('language', TaggingConfig::DEFAULT_LANGUAGE),
            'labels' => $request->get('labels', TaggingConfig::DEFAULT_LABELS),
            'landmarks' => $request->get('landmarks', TaggingConfig::DEFAULT_LANDMARKS),
            'location' => $request->get('location', TaggingConfig::DEFAULT_LOCATION),
            'probabilityLabels' => $request->get('probabilityLabels', TaggingConfig::DEFAULT_PROBABILITYLABELS),
            'probabilityLandmarks' => $request->get('probabilityLandmarks', TaggingConfig::DEFAULT_PROBABILITYLANDMARKS),
            'thumbnailDefinition' => $request->get('thumbnailDefinition', TaggingConfig::DEFAULT_THUMBNAILDEFINITION)
        ], true);

        return $this->json(['success' => true, 'data' => TaggingConfig::read()]);
    }
}