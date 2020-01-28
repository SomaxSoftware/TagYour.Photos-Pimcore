<?php

namespace TagYourPhotosBundle\Helper;

use Pimcore\Log\ApplicationLogger;
use Pimcore\Model\Element\Tag;

class Tagging
{
    const URL = 'https://srv.tagyour.photos/analyse_new';
    const SOFTWAREID = '95108129-740c-4202-8e5a-3b944b30dd5a';
    const SOFTWAREVERSION = '3.0.0';

    private $logger;
    private $config;

    public function __construct()
    {
        $this->config = TaggingConfig::read();
    }

    public function tagAsset($asset) {
        $statusCode = 0;

        if (($this->config['thumbnailDefinition']!="") && method_exists($asset, 'getThumbnail')) {
            $filePath = $asset->getThumbnail($this->config['thumbnailDefinition'])->getFileSystemPath();
        }else{
            $filePath = $asset->getFileSystemPath();
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::URL.'?'.$this->buildParams());
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->buildHeader());

        curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents($filePath));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        $decoded = json_decode($result);

        if ($decoded->statusCode==1){
            //LABELS
            $labels = $decoded->tagging->labels;
            foreach($labels as $label){
                if ($label->ranking>=($this->config['probabilityLabels']/100)) {
                    $tags = explode("|", $label->destinationLanguage);
                    $this->addTagsToAsset($tags, $asset);
                }
            }

            //LANDMARKS
            $landmarks = $decoded->tagging->landmarks;
            foreach($landmarks as $landmark){
                if ($landmark->ranking>=($this->config['probabilityLandmarks']/100)) {
                    $tags = explode("|", "Sehenswürdigkeiten" . "|" . $landmark->destinationLanguage);
                    $this->addTagsToAsset($tags, $asset);
                }
            }

            //LOCATION
            if ($decoded->tagging->location->country->sourceLanguage) {
                $location = $decoded->tagging->location;
                $tags = array();
                array_push($tags, "Standorte", $location->country->sourceLanguage, $location->state->sourceLanguage, $location->city->sourceLanguage, $location->district->sourceLanguage);
                $this->addTagsToAsset($tags, $asset);
            }

            $asset->setProperty('TagYour.Photos:Tagged', 'bool', true, false, false);
            $asset->save();
        } else {
            if (isset($this->logger)) {
                if ($decoded->statusCode == 9001) {
                    $this->logger->warning("Autotagging failed - wrong applicationkey");
                } else if ($decoded->statusCode == 9002) {
                    $this->logger->warning("Autotagging failed - no available imagecount");
                } else {
                    $this->logger->warning("Autotagging failed");
                };
            }
        }

        $statusCode = $decoded->statusCode;

        curl_close($ch);

        return $statusCode;
    }

    private function buildHeader()
    {
        return array(
            'typ-applicationkey: ' . $this->config['applicationKey'],
            'typ-softwareid: ' . self::SOFTWAREID,
            'typ-softwareversion: ' . self::SOFTWAREVERSION,
            'Content-Type: image/jpeg'
        );
    }

    private function buildParams()
    {
        $data = array (
            'destinationLanguage' => $this->config['language'],
            'labels' => $this->config['labels'],
            'landmarks' => $this->config['landmarks'],
            'locations' => $this->config['location'],
            'persons' => 'False'
        );
        $params = '';
        foreach($data as $key=>$value)
            $params .= $key.'='.$value.'&';

		return trim($params, '&');
    }

    private function getTagByNameAndParentId($name, $parentId, $create) {
        $listing = new \Pimcore\Model\Element\Tag\Listing();
        if (is_null($parentId)) {
            $listing->setCondition('name = ?', $name);
        }else{
            $listing->setCondition('name = ? AND parentId = ?', [$name, $parentId]);
        }
        $tags = $listing->load();

        if(sizeof($tags)==0) {
            $tag = null;
        }else{
            $tag = $tags[0];
        }

        if (is_null($tag) AND $create=true) {
            $tag = new \Pimcore\Model\Element\Tag();
            if (!is_null($parentId)) {
                $tag->setParentId($parentId);
            }
            $tag->setName($name);
            $tag->save();
        }
        return $tag;
    }

    private function addTagsToAsset($tags, $asset) {
        $parentId = null;
        foreach ($tags as $key=>$value) {
            $text = trim($value);

            if ($text!="") {
                $entry = $this->getTagByNameAndParentId($text, $parentId, true);

                $parentId = $entry->getId();

                \Pimcore\Model\Element\Tag::addTagToElement('asset', $asset->getId(), $entry);
            }
        }
    }
    public function setLogger($logger) {
        $this->logger = $logger;
    }
}