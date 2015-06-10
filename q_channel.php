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
$data = $db->getTable($link, "channel");
?>
<table>
<tr>
    <td>channel_id</td>
    <td>channel_value</td>
</tr>
<?php for($i = 0, $data_len = count($data); $i < $data_len; $i++) { ?>
<tr>
    <td><?php echo $data[$i]['id'] ?></td>
    <td><?php echo $data[$i]['value'] ?></td>
</tr>
<?php } ?>
</table>
</body>
</html>