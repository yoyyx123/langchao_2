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

$PHPExcel = $PHPReader->load($filePath); 


/**读取excel文件中的第一个工作表*/ 
$currentSheet = $PHPExcel->getSheet(0); 
$allColumn = $currentSheet->getHighestColumn();
$allRow = $currentSheet->getHighestRow();
for($currentRow = 2;$currentRow <= $allRow;$currentRow++){ 
    for($currentColumn= 'C';$currentColumn<= $allColumn; $currentColumn++){ 
    $val = $currentSheet->getCellByColumnAndRow(ord($currentColumn) - 65,$currentRow)->getValue();/**ord()将字符转为十进制数*/ 

    //$content[$currentRow][] = @iconv('utf-8','gb2312', str_replace('\n','',$val));
    $content[$currentRow][] = str_replace('\n','',$val);
    }
}
foreach($content as $key=>$value){
    $name = $value[0];
    $short_name = $value[1];
    $result = mysql_query("SELECT id FROM ldb_setting_list where `type`='city' and name = '".$value[2]."'",$con);
    $row = mysql_fetch_row($result);
    $city = $row[0];
    $result = mysql_query("SELECT id FROM ldb_setting_list where `type`='membertype' and name = '".$value[3]."'",$con);
    $row = mysql_fetch_row($result);
    $member_type = $row[0];
    $addr = $value[4];
    $sql = "insert into ldb_member (`code`,`name`,`short_name`,`city`,`member_type`,`addr`) values ('".$code."','".$name."','".$short_name."','".$city."','".$member_type."','".$addr."')";
    mysql_query($sql);
    $code = get_code($code);
    echo $sql."/n";
    $err = $sql."/n";
    error_log($err,3,'member.log');


}






mysql_close($con);