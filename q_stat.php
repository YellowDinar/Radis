<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
include('db.php');
$db = new Database();
$link = $db->auth();
$data = $db->getTable($link, "uniq_keys");
?>
<table>
<tr>
    <td>key_id</td>
    <td>area_id</td>
    <td>stat_shows</td>
    <td>stat_clicks</td>
    <td>stat_sum</td>
    <td>source_id</td>
    <td>stat_leads</td>
    <td>stat_profit</td>
    <td>stat_date</td>
    <td>stat_time</td>
</tr>
<?php for($i = 0, $data_len = count($data); $i < $data_len; $i++) { ?>
<tr>
    <td><?php echo $data[$i]['key_id'] ?></td>
    <td><?php echo $data[$i]['area_id'] ?></td>
    <td><?php echo $data[$i]['shows'] ?></td>
    <td><?php echo $data[$i]['clicks'] ?></td>
    <td><?php echo $data[$i]['sum'] ?></td>
    <td><?php echo $data[$i]['source_id'] ?></td>
    <td><?php echo $data[$i]['leads'] ?></td>
    <td><?php echo $data[$i]['profit'] ?></td>
    <td><?php echo $data[$i]['date'] ?></td>
    <td><?php echo $data[$i]['time'] ?></td>
</tr>
<?php } ?>
</table>
</body>
</html>