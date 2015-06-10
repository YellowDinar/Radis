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
$data = $db->getTable($link, "area");
?>
<table>
<tr>
    <td>area_id</td>
    <td>area_value</td>
    <td>area_type</td>
</tr>
<?php for($i = 0, $data_len = count($data); $i < $data_len; $i++) { ?>
<tr>
    <td><?php echo $data[$i]['id'] ?></td>
    <td><?php 
        if ($data[$i]['value']=='context') {
            echo "РСЯ";
        } else {
            echo "Поиск";
        } ?></td>
    <td><?php echo $data[$i]['type'] ?></td>
</tr>
<?php } ?>
</table>
</body>
</html>