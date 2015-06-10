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
$data = $db->getTable($link, "key");
?>
<table>
<tr>
    <td>key_id</td>
    <td>phrase</td>
    <td>banner_id</td>
    <td>region_id</td>
    <td>campaign_id</td>
    <td>channel_id</td>
    <td>site_id</td>
</tr>
<?php for($i = 0, $data_len = count($data); $i < $data_len; $i++) { ?>
<tr>
    <td><?php echo $data[$i]['id'] ?></td>
    <td><?php echo $data[$i]['phrase'] ?></td>
    <td><?php echo $data[$i]['banner'] ?></td>
    <td><?php echo $data[$i]['region'] ?></td>
    <td><?php echo $data[$i]['campaign'] ?></td>
    <td><?php echo $data[$i]['channel'] ?></td>
    <td><?php echo $data[$i]['site'] ?></td>
</tr>
<?php } ?>
</table>
</body>
</html>