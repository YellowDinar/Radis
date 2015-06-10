<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

include('direct.php');
include('db.php');

$db = new Database();
$link = $db->auth();

$db->truncateTable($link, 'campaign');

$direct = new Direct();

$clients_list = $direct->request("GetClientsList");
$clients_logins = array();
for ($i = 0; $i < count($clients_list->data); $i++) {
    array_push($clients_logins, $clients_list->data[$i]->Login);
}
//  получение кампаний
$params = array(
   'Logins' => $clients_logins,
   'Filter' => array(
      'IsActive' => array('Yes'),
      'StatusShow' => array('Yes'),
      'StatusModerate' => array('Yes'),
      'StatusArchive' => array('No'),
      'StatusActivating' => array('Yes')
   )
);
$campaigns_list = $direct->request("GetCampaignsListFilter", $params);
for ($i = 0; $i < count($campaigns_list->data); $i++) {
    $db->insertCampaigns($link, $campaigns_list->data[$i]->Name, $campaigns_list->data[$i]->CampaignID); //    Записываем кампанию в бд
}
?>