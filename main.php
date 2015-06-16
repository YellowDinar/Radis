<?php
// 30720158 metrika
ini_set('date.timezone', 'Europe/Moscow');
ini_set('max_execution_time', 1000);
include('direct.php');
include('db.php');
$direct = new Direct();
$db = new Database();
$link = $db->auth();
// echo print_r($direct->request('CreateNewReport', $params));
// echo print_r($get_report = $direct->request('GetReportList')).'<br>';
// $direct->request('DeleteReport', 286981764     );
    // $yesterday = date('Y-m-d', mktime(0, 0, 0, date("m")  , date("d")-1, date("Y")));
    $leads = file('http://xn--80ajigieluo.xn--p1ai/%D0%B0%D0%BA%D1%86%D0%B8%D1%8F/app/getVizits.php');
    $leads = (string)$leads[count($leads)-1];
    $leads = json_decode($leads);
    
    $today = date('Y-m-d');
    $campaigns = $db->getCampaigns($link);
    
    for($c = 0, $c_len = count($campaigns); $c < 2; $c++) {
        $params = array(
            'CampaignID' => $campaigns[$c]['id'],
            'StartDate' => $today,
            'EndDate' => $today,
            'GroupByColumns' => array(
              'clPage',
              'clPhrase',
              'clBanner'
            ),
            'Filter' => array(
                'PageType' => 'all'
            ),
            'TypeResultReport' => 'xml',
            'CompressReport' => 0
        );
        $direct->request('CreateNewReport', $params);
        sleep(3);
        while(strcmp($direct->request('GetReportList')->data[0]->StatusReport, "Done") != 0) {
            echo 'Нет';
        }
        $report = $direct->request('GetReportList')->data[0];
        echo 'Готово<br>';
        $file = getFile($report->Url);
        // echo $file.'<br>';
        $direct->request('DeleteReport', $report->ReportID);
        // $direct->request('DeleteReport', $direct->request('GetReportList')->data[$i]->ReportID);
        echo '<br>----------------------------------------------------------<br>';
    }
    // echo print_r($direct->request('GetReportList'));
    $files = glob("*.xml");
    $file_len = count($files);
    // echo "<br>".$file_len."<br>";
    for($file = 0; $file < $file_len; $file++) {
        if (file_exists($files[$file])) {
            // echo "Exist<br>";
            $xml = simplexml_load_file($files[$file]);
            // echo print_r($xml)."<br>";
            $rows = $xml->stat->row;
            for($row = 0, $rows_len = count($rows); $row < $rows_len; $row++) {
                if(count($rows[$row]->attributes()) == 8 && $rows[$row]->attributes()[6][0] > 0){
                    // echo print_r($rows[$row]->attributes())."<br>";
                    $key = $rows[$row]->attributes()[1][0]; // id key
                    $key_value = $db->getKeyValue($link, $key);
                    $key_value = $key_value[0]['phrase'];
                    echo $key_value;
                    $area = $rows[$row]->attributes()[3][0]; // area
                    $area_type = $rows[$row]->attributes()[4][0]; // area type
                    $sum = $rows[$row]->attributes()[5][0]; // sum
                    $shows = $rows[$row]->attributes()[6][0]; // shows
                    $cliks = $rows[$row]->attributes()[7][0]; // cliks

                    $db->insertArea(
                        $link,
                        $area,
                        $area_type    
                    );
                    
                    $current_date = explode(' ', date('Y-m-d H:i', mktime()));
                    $current_date[1] = preg_replace("/\:\d\d/i", ":00", $current_date[1]);
                    
                    $area_id = $db->getAreaId($link, $area, $area_type);
                    $area_id = $area_id[0]['id'];
                    
                    // Shows
                    if($shows>1) {
                        $shows1 = intval($shows / 2);
                        $shows2 = $shows - $shows1;
                    } else {
                        $shows1 = 1;
                        $shows2 = 0;
                    }
                    
                    // Cliks
                    if($cliks > 0) {
                        if($cliks > 1) {
                            $cliks1 = intval($cliks / 2);
                            $cliks2 = $cliks - $cliks1;
                        } else {
                            $cliks1 = 1;
                            $cliks2 = 0;    
                        }
                    } else {
                        $cliks1 = 0;
                        $cliks2 = 0;
                    }
                    
                    // Sum
                    if($sum > 0) {
                        echo "sum > 0<br>";
                        echo intval($sum/2);
                        echo $sum%2;
                        echo "<br>";
                        $sum1 = $sum / 2;
                        $sum2 = $sum - $sum1;
                    } else {
                        $sum1 = 0;
                        $sum2 = 0;
                    }
                    
                    $leads1 = 0;
                    $leads2 = 0;
                    
                    // if(count($leads) > 0) {
                    //     for($lead = 0, $leads_len = count($leads); $lead < $leads_len; $lead++) {
                            
                    //         if(strcmp($leads[$lead][1], $area) == 0 && strcmp($leads[$lead][2], $key_value) == 0) {
                    //             echo "YES<br>";
                    //             if(strcmp($leads[$lead][3], "Заявка") == 0) {
                    
                    //                 $leads2++;
                    //             } elseif(strcmp($leads[$lead][3], "Звонок") == 0) {
                    //                 $leads1++;
                    //             }
                    //         }
                    //         echo print_r($leads[$lead])."<br>";
                    //     }
                    // }
                    
                    echo $key.", ".$area_id.", ".$shows."(".$shows1.", ".$shows2.")".", ".$cliks."(".$cliks1.", ".$cliks2.")".", ".$sum."(".$sum1.", ".$sum2.")".", "."leads"."(".$leads1.", ".$leads2.")".", ".$current_date[0].", ".$current_date[1];
                    // echo "Leads: ".$lead2;
                    echo "<br>";
                    
                    // $delta1 = $db->getDelta($link ,$key, $area_id, 1, $current_date[0]);
                    // $delta1 = $delta1[0];
                    // $delta2 = $db->getDelta($link ,$key, $area_id, 2, $current_date[0]);
                    // $delta2 = $delta2[0];
                    // echo "<br>_______________________________________________________________________________________________________________________________________________<br>";
                    // // 
                    // // echo print_r($db->getDelta($link ,$key, $area_id, 2, $current_date[0]))."<br>";
                    echo $db->insertMainTable($link, $key, $area_id, $shows1-$delta1['sum_shows'], $cliks1-$delta1['sum_clicks'], $sum1-$delta1['sum_sum'], 1, $leads1-$delta1['sum_leads'], $current_date[0], $current_date[1]);
                    echo $db->insertMainTable($link, $key, $area_id, $shows2-$delta2['sum_shows'], $cliks2-$delta2['sum_clicks'], $sum2-$delta2['sum_sum'], 2, $leads2-$delta2['sum_leads'], $current_date[0], $current_date[1]);
                }
                
                
            }
        } else {
            exit('Не удалось открыть файл test.xml.');
        }
        unlink($files[$file]);
    }


// id = 
// echo print_r($direct->request('DeleteReport', 286744669));
// $url = $direct->request('GetReportList')->data[0]->Url;
// getFile($url);
function getFile($url) {
    if (!empty($url))
    {
 
    $file = basename($url);
    if (file_get_contents($url))
    {
    $content = file_get_contents($url);
    $f = fopen( "$file", "w" );
    if (fwrite( $f, $content ) === FALSE)
    {
    echo "not write in file";
    exit;
    }
    else {  
            chmod($file, 0777);
            fclose( $f );
        }
    }
    else echo "not download file";
    }
    return $file;
}