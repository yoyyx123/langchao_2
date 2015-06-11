<?php


error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');



$ip = '127.0.0.1';
$user = 'root';
$passwd = 'root';
$db = 'langchao';


$con = mysql_connect($ip,$user,$passwd);
if (!$con){
  die('Could not connect: ' . mysql_error());
}
$db_selected = mysql_select_db($db, $con);

$result = mysql_query("SELECT * FROM ldb_biil_order_list where `rel_transportation` is Null or `rel_hotel` is Null or `rel_food` is Null or `rel_other` is Null");
while($row = mysql_fetch_array($result)){
    $id = $row['id'];
    if ($row['rel_transportation'] === Null){
        $sql = "update ldb_biil_order_list set `rel_transportation`= ".$row['transportation_fee']." where `id`=".$id;
        mysql_query($sql);
        error_log($sql."\n",3,"billorder.log");
    }
    if ($row['rel_hotel'] === Null){
        $sql = "update ldb_biil_order_list set `rel_hotel`= ".$row['hotel_fee']." where `id`=".$id;
        mysql_query($sql);
        error_log($sql."\n",3,"billorder.log");
    }
    if ($row['rel_food'] === Null){
        $sql = "update ldb_biil_order_list set `rel_food`= ".$row['food_fee']." where `id`=".$id;
        mysql_query($sql);
        error_log($sql."\n",3,"billorder.log");
    }
    if ($row['rel_other'] === Null){
        $sql = "update ldb_biil_order_list set `rel_other`= ".$row['other_fee']." where `id`=".$id;
        mysql_query($sql);
        error_log($sql."\n",3,"billorder.log");
    }
    //print_r($row);
}


mysql_close($con);
?>