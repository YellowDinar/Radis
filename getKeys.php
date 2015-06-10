<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

include('direct.php');
include('db.php');

$db = new Database();
$link = $db->auth();

$direct = new Direct();

$CHANNEL_ID = 1; // ЯНДЕКС

$campaigns = $db->getCampaigns($link);
$count = count($campaigns);
if ($count > 0) {
    $cel = intval($count/10);
    $ost = $count%10;
    $k = 0;
    $banners = array();
    if ($cel > 0) {
        for($i = 0; $i < $cel; $i++) {
            $campaign_ids = array();
            $banners_array = array();
            for($campaign = 0+$k; $campaign < 10+$k; $campaign++) {
                array_push($campaign_ids, $campaigns[$campaign]['id']);
            }
            $k += 10;
            $banners_array = $direct->request("GetBanners", array(
                    'CampaignIDS' => $campaign_ids,
                    'Filter' => array(
                        'IsActive' => array('Yes'),
                        'StatusArchive' => array('No')
                    )
                )
            );
            array_push($banners, $banners_array);
        }
    }
    
    $campaign_ids = array();
    $banners_array = array();
    if($ost > 0) {
        while($ost > 0) {
            array_push($campaign_ids, array_pop($campaigns)['id']);
            $ost--;
        }
        $banners_array = $direct->request("GetBanners", array(
                    'CampaignIDS' => $campaign_ids,
                    'Filter' => array(
                        'IsActive' => array('Yes'),
                        'StatusArchive' => array('No')
                    )
                )
            );
        array_push($banners, $banners_array);
    }
    for($banners_array = 0, $banners_len = count($banners); $banners_array < $banners_len; $banners_array++) {
        $data = $banners[$banners_array]->data;
        for($banner = 0, $data_len = count($data); $banner < $data_len; $banner++) {
            $banner_id = $data[$banner]->BannerID;
            $campaign_id = $data[$banner]->CampaignID;
            $href = preg_replace("/(\?.*)|(\/\?.*)/i", "", $data[$banner]->Href);
            $db->insertSites($link, $href);
            $site_id = $db->getSiteId($link, $href)[0]['id'];
            $reg = $data[$banner]->Geo;
            echo $db->getRegion($link, $data[$banner]->Geo)[0]['value']."<br>";
            $phrases = $data[$banner]->Phrases;
            for($phrase = 0, $phrases_len = count($phrases); $phrase < $phrases_len; $phrase++) {
                $pattern = "/\s-.*/i";
                $value = preg_replace($pattern, "", $phrases[$phrase]->Phrase);
                $phrase_id = $phrases[$phrase]->PhraseID;
                $res = $db->insertKeys($link, $phrase_id, $value, $banner_id, $reg, $campaign_id, $CHANNEL_ID, $site_id);
                echo print_r($res)."'$phrase_id' '$value'<br>";
            }
        }
    }
} else {
    echo "Кампании не найдены!";
}

?>