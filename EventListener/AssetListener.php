<?php
namespace TagYourPhotosBundle\EventListener;

use Pimcore\Event\Model\ElementEventInterface;
use Pimcore\Event\Model\DataObjectEvent;
use Pimcore\Event\Model\AssetEvent;
use Pimcore\Event\Model\DocumentEvent;
use Pimcore\Log\ApplicationLogger;
use Pimcore\Controller\FrontendController;
use Pimcore\Model\Element\Tag;
use Pimcore\Tool\Frontend;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use TagYourPhotosBundle\Helper;

class AssetListener
{
    /**
     * @var ApplicationLogger
     */
    private $logger;

    public function __construct(ApplicationLogger $logger)
    {
        $this->logger = $logger;
    }

	public function onPostAdd(ElementEventInterface $e)
    {
        if($e instanceof AssetEvent) {
			$asset= $e->getAsset();
						
			if ($asset->getType() == "image") {
                $tagging = new Helper\Tagging();
                $tagging->setLogger($this->logger);
                $tagging->tagAsset($asset);
			}
        }
    }
}