<?php


error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');


require_once './langchao/libraries/PHPExcel.php';

require_once './langchao/libraries/PHPExcel/IOFactory.php';



function get_code($last_code){
    $last_num = intval($last_code);
    $code = $last_num+1;
    $len = strlen(intval($code));
    if($len<3){
        for($i=0;$i<(3-$len);$i++){
            $code = "0".$code;
        }
    }
    return $code;
}


$ip = 'localhost';
$user = 'root';
$passwd = 'root';
$db = 'langchao';


$con = mysql_connect($ip,$user,$passwd);
if (!$con){
  die('Could not connect: ' . mysql_error());
}
$db_selected = mysql_select_db($db, $con);

$result = mysql_query("SELECT * FROM ldb_member order by `code` desc limit 1");
$last_code = false;
while($row = mysql_fetch_array($result)){
    $last_code =  $row['code'];
}
if($last_code){
    $code = get_code($last_code);
}else{
    $code = '001';
}

$filePath = 'member.xlsx'; 

$PHPExcel = new PHPExcel(); 

/**默认用excel2007读取excel，若格式不对，则用之前的版本进行读取*/ 
$PHPReader = new PHPExcel_Reader_Excel2007(); 
if(!$PHPReader->canRead($filePath)){ 
$PHPReader = new PHPExcel_Reader_Excel5(); 
if(!$PHPReader->canRead($filePath)){ 
echo 'no Excel'; 
return ; 
} 
} 

/**读取excel文件中的第一个工作表*/ 
$PHPExcel = $PHPReader->load($filePath); 

$currentSheet = $PHPExcel->getSheet(1); 
$allColumn = $currentSheet->getHighestColumn();
$allRow = $currentSheet->getHighestRow();
for($currentRow = 2;$currentRow <= $allRow;$currentRow++){ 
    for($currentColumn= 'B';$currentColumn<= $allColumn; $currentColumn++){ 
    $val = $currentSheet->getCellByColumnAndRow(ord($currentColumn) - 65,$currentRow)->getValue();/**ord()将字符转为十进制数*/ 

    //$content[$currentRow][] = iconv('gb2312','utf-8', $val);
    $content[$currentRow][] = $val;
    }
}

foreach($content as $key=>$value){
    $name = $value[0];
    $tmp_d = $value[1];
    $tmp = explode("、",$tmp_d);
    foreach($tmp as $k=>$v){
        if($v == "全部"){
            $department_id = 'all';
        }else{
            $result = mysql_query("SELECT id FROM ldb_setting_list where `type`='department' and name = '".$v."'",$con);
            $row = mysql_fetch_row($result);
            $department_id = $row[0];        
        }
        $sql = "insert into ldb_event_type_list (`name`,`department_id`) values ('".$name."','".$department_id."')";
        mysql_query($sql);
        echo $sql."\n";
        $err = $sql."\n";
        error_log($err,3,'event.log');
    }


}





mysql_close($con);