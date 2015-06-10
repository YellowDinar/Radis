<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
include('direct.php');
$direct = new Direct();
// echo print_r($direct->request("GetRegions"));
// echo print_r($direct->request("GetClientInfo", array("timerlain-bikstudio")));
// $r = $direct->request('GetBannerPhrases', array(635300446, 635300450, 635300452));
// echo print_r($r)
// ini_set('date.timezone', 'Europe/Moscow');
// $current_date = explode(' ', date('Y-m-d H:i', mktime()));
// $current_date[1] = preg_replace("/\:\d\d/i", ":00", $current_date[1]);
// echo print_r($current_date);
// echo ;
// $files = glob("*.xml");
// echo count($files);
// for ($i=0;$i<count($files);$i++){
//     unlink($files[$i]);
//  }
// for($i = 0; $i < count($direct->request('GetReportList')->data); $i++) {
//     $direct->request('DeleteReport', $direct->request('GetReportList')->data[$i]->ReportID);
// }
// echo print_r($direct->request('GetReportList'))."<br>";
// // echo 0.14> 0;

// // echo "<br>";
// $leads = file('http://xn--80ajigieluo.xn--p1ai/%D0%B0%D0%BA%D1%86%D0%B8%D1%8F/app/getVizits.php');
// $leads = (string)$leads[count($leads)-1];
// $leads = json_decode($leads);
// if(count($leads) > 0) {
//     for($lead = 0, $leads_len = count($leads); $lead < $leads_len; $lead++) {
//         echo print_r($leads[$lead])."<br>";
//     }
// }
$token = '4e399a6e3fdb434197d4e90a8ec29e9c';
$date = date('Ymd');
$url = 'https://api-metrika.yandex.ru/stat/traffic/summary?oauth_token='.$token.'&id=30720158&date1='.$date.'&date2='.$date;
$result = file_get_contents($url);
echo print_r(explode(' ', $result))."<br>";
echo $url."<br>";
?>