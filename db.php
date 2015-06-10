<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
class Database {

    private $hostname = "localhost";
    private $name = "root";
    private $password = "Kazan2013";
    private $dbName = "svai-rt";

    public function auth() {
        $link = mysqli_connect(
            $this->hostname,
            $this->name,
            $this->password,
            $this->dbName
        );
        mysqli_set_charset($link, "utf8");
        if (!$link) {
            printf("Невозможно подключиться к базе данных. Код ошибки: %s\n", mysqli_connect_error());
            exit;
        }

        return $link;
    }

    public function truncateTable($link, $tableName) {
        $query_to_db = "TRUNCATE TABLE '$tableName';";
        $result = mysqli_query($link, $query_to_db);
    }
    
    public function getRegion($link, $id) {
        $query_to_db = "SELECT value FROM region WHERE id='$id';";
        if ($result = mysqli_query($link, $query_to_db)) {
            $res = array();
            while($row = mysqli_fetch_assoc($result) ){
                array_push($res, $row);
            }
        } else {
            echo "problem!";
        }

        return $res;
    }
    
    public function getSiteId($link, $value) {
        $query_to_db = "SELECT id FROM site WHERE value='$value';";
        if ($result = mysqli_query($link, $query_to_db)) {
            $res = array();
            while($row = mysqli_fetch_assoc($result) ){
                array_push($res, $row);
            }
        } else {
            echo "problem!";
        }

        return $res;
    }
    
    public function getKeyValue($link, $id) {
        $query_to_db = "SELECT phrase FROM `key` WHERE id='$id';";
        if ($result = mysqli_query($link, $query_to_db)) {
            $res = array();
            while($row = mysqli_fetch_assoc($result) ){
                array_push($res, $row);
            }
        } else {
            echo "problem!";
        }

        return $res;
    }
    
    
    
    public function getAreaId($link, $area, $area_type) {
        $query_to_db = "SELECT id FROM `area` WHERE value='$area' AND type='$area_type';";
        if ($result = mysqli_query($link, $query_to_db)) {
            $res = array();
            while($row = mysqli_fetch_assoc($result) ){
                array_push($res, $row);
            }
        } else {
            echo "problem!";
        }

        return $res;
    }
    
    public function insertCampaigns($link, $value, $yaId) {
        $query_to_db = "INSERT INTO campaign (id, value) VALUES ('$yaId', '$value');";
        $result = mysqli_query($link, $query_to_db);
    }
    
    public function insertMainTable($link, $key_id, $area_id, $shows, $clicks, $sum, $source_id, $leads, $date, $time) {
        $query_to_db = "INSERT INTO `uniq_keys`(`key_id`, `area_id`, `shows`, `clicks`, `sum`, `source_id`, `leads`, `date`, `time`) VALUES ('$key_id','$area_id','$shows','$clicks','$sum','$source_id','$leads','$date','$time')";
        $result = mysqli_query($link, $query_to_db);
    }
    
    public function insertSites($link, $value) {
        $query_to_db = "INSERT INTO site (value) VALUES ('$value');";
        $result = mysqli_query($link, $query_to_db);
    }
    // INSERT INTO key (phrase, banner, region, campaign, channel, site) VALUES ("сваи", 31, "РТ", 123, 1, 1)
    public function insertKeys($link, $id, $phrase, $banner, $region, $campaign, $channel, $site) {
        $query_to_db = "INSERT INTO `key` (id, phrase, banner, region, campaign, channel, site) VALUES ('$id', '$phrase', '$banner', '$region', '$campaign', '$channel', '$site');";
        $result = mysqli_query($link, $query_to_db);
        return $result;
    }
    
    public function insertArea($link, $value, $type) {
        $query_to_db = "INSERT INTO `area` (value, type) VALUES ('$value', '$type');";
        $result = mysqli_query($link, $query_to_db);
        return $result;
    }

    public function getCampaigns($link) {
        $query_to_db = "SELECT id FROM campaign";
        if ($result = mysqli_query($link, $query_to_db)) {
            $res = array();
            while($row = mysqli_fetch_assoc($result) ){
                array_push($res, $row);
            }
        } else {
            echo "problem!";
        }

        return $res;
    }
    
    public function getDelta($link ,$key_id, $area_id, $source_id, $date) {
        $query_to_db = "SELECT SUM( shows ) sum_shows, SUM( clicks ) sum_clicks, SUM( sum ) sum_sum, SUM( leads ) sum_leads, SUM( profit ) sum_profit FROM  `uniq_keys`  WHERE key_id ='$key_id' AND area_id ='$area_id' AND source_id ='$source_id' AND date='$date'";
        if ($result = mysqli_query($link, $query_to_db)) {
            $res = array();
            while($row = mysqli_fetch_assoc($result) ){
                array_push($res, $row);
            }
        } else {
            echo "problem!";
        }

        return $res;
    }
    
    public function getKeys($link) {
        $query_to_db = "SELECT * FROM `key`";
        if ($result = mysqli_query($link, $query_to_db)) {
            $res = array();
            while($row = mysqli_fetch_assoc($result) ){
                array_push($res, $row);
            }
        } else {
            echo "problem!";
        }

        return $res;
    }
    
    public function getArea($link) {
        $query_to_db = "SELECT id FROM `area`";
        if ($result = mysqli_query($link, $query_to_db)) {
            $res = array();
            while($row = mysqli_fetch_assoc($result) ){
                array_push($res, $row);
            }
        } else {
            echo "problem!";
        }

        return $res;
    }

    public function getIdFromTables($link, $value, $table) {
        $query_to_db = "SELECT id FROM ".$table." WHERE value='$value'";
        if ($result = mysqli_query($link, $query_to_db)) {

            $res = array();
            while($row = mysqli_fetch_assoc($result) ){
                array_push($res, $row);
            }
        } else {
            echo "problem!";
        }

        return $res;
    }
    
    public function getTable($link, $table) {
        $query_to_db = "SELECT * FROM `".$table."`";
        if ($result = mysqli_query($link, $query_to_db)) {
            $res = array();
            while($row = mysqli_fetch_assoc($result) ){
                array_push($res, $row);
            }
        } else {
            echo "problem!";
        }
        return $res;
    }

    public function getClientId($link) {
        $query_to_db = "SELECT id FROM vizit ORDER BY id DESC LIMIT 1";
        if ($result = mysqli_query($link, $query_to_db)) {
            $res = array();
            while($row = mysqli_fetch_assoc($result) ){
                array_push($res, $row);
            }
        } else {
            echo "problem!";
        }

        return $res;
    }

}

?>