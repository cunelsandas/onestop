<?php


//ตัวแปรเก็บข้อมูลลูกค้า
$gloUploadPath = "fileupload";
$customer_name = "บริษัท ไอ.ที.โกลโบล จำกัด";
$customer_tambon = "หนองควาย";
$customer_amphur = "หางดง";
$customer_province = "เชียงใหม่";
$customer_postcode = "50140";
$customer_address = "";
$customer_tel = "+66 53 441700 , +66 86 4314547";
$customer_fax = "+66 53 453214";
$customer_email= "itg007@hotmail.com";
$facebook = "https://www.facebook.com/profile.php?id=100007830817150";

$address = "ตำบน ".$customer_tambon." อำเภอ ".$customer_amphur." จังหวัด ".$customer_province." ".$customer_postcode;

$maindomainname = "onestop.itglobal.co.th";         //domain หลัก (หน้าเว็ปเทศบาล)
$domainname = "onestop.itglobal.co.th";            // (หน้าเว็ป ONE STOP SERVICE)  ไม่ต้องมี www
$nayok_position = "นายกเทศมนตรีตำบลดอนแก้ว";
$nayok_name = "นายพัทธนันท์ ทองยศ";

$palad_position = "หัวหน้าสำนักปลัด";
$palad_name = "นายบัญชา ตั้งพีรธรม";

$lat_main = "18.76991";
$lng_main = "98.97723";

$g_user = "root";
$g_pw = '12345678';
$g_db = "c11maehia";

function connect() {
    $server="localhost";
    $user="root";
    $pw='^_^Itg46@_@';
    $db="c1onestopitglobal";

    $conn = mysqli_connect($server, $user, $pw, $db);

    /*
     * This is the "official" OO way to do it,
     * BUT $connect_error was broken until PHP 5.2.9 and 5.3.0.
     */

    if ($conn->connect_error) {
        die('Connect Error (' . $conn->connect_errno . ') '. $conn->connect_error);
    }
    return $conn;
}

include_once("myfnc.php");


error_reporting(E_ERROR | E_PARSE);


?>
