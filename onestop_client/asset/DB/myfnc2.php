<?php

function Connect2()
{
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

function Insert($table, $data)
{
    $connect = Connect2();
    $fields = "";
    $values = "";
    $i = 1;
    foreach ($data as $key => $val) {
        if ($i != 1) {
            $fields .= ", ";
            $values .= ", ";
        }
        $val = Escape($val);
        $fields .= "$key";
        $values .= "'$val'";
        $i++;
    }
    $sql = "INSERT INTO $table ($fields) VALUES ($values)";
    if ($connect->query($sql)) {
        return true;
    } else {
        die("SQL Error: <br>" . $sql . "<br>" . $connect->error);
        return false;
    }
}


function Update($table, $id, $fields)
{
    $connect = Connect2();
    $set = '';
    $x = 1;
    foreach ($fields as $name => $value) {
        $value = Escape($value);
        $set .= "{$name} = '{$value}'";
        if ($x < count($fields)) {
            $set .= ',';
        }
        $x++;
    }

    $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";

    if ($connect->query($sql)) {
        return true;
    } else {
        return false;
    }
}

function delete($table, $where)
{
    $db = Connect2();

    $sql = "DELETE FROM $table WHERE $where";
    if ($db->query($sql)) {
        return true;
    } else {
        die("SQL Error: <br>" . $sql . "<br>" . $db->error);
        return false;
    }
}

function result_array($sql)
{
    $con = Connect2();
    $data = [];
    $result = $con->query($sql) or die($con->error);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $data[] = $row;
    };
    return $data;
}

function result_row($sql)
{
    $con = Connect2();
    $result = $con->query($sql) or die($con->error);
    $data = $result->fetch_array(MYSQLI_ASSOC);
    return $data;
}

function Json($data)
{
    $Encode = json_encode($data);
    echo $Encode;
}

function Login($user, $pass)
{
    $sql = 'SELECT * FROM tb_citizen WHERE personid = \'' . Escape($user) . '\'';
    $data = result_array($sql);
    if ($data != []) {
        if ($pass == $data[0]['password']) {
            return $data;
        } else {
            return false;
        }
    }
    return false;
}

function DateB($strDate)
{
    if ($strDate != '') {
        list ($y, $m, $d) = explode('-', $strDate);
        $dob = sprintf("%02d/%02d/%04d", $d, $m, $y + 543);
        return $dob;
    }
}

function DateThaiNa($strDate)
{
    if ($strDate != '') {
        $strMonthCut = Array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
        list ($y, $m, $d) = explode('-', $strDate);
        $strMonthThai = $strMonthCut[number_format($m)];
        $dob = sprintf("%02d $strMonthThai %04d", $d, $y + 543);

        return $dob;
    }
//    return "$strDay $strMonthThai $strYear"; //, $strHour:$strMinute";
}

function ExpoldDate($date)
{
    if ($date != '') {
        $Date = explode('/', $date);
        return $Date[2] - 543 . '-' . $Date[1] . '-' . $Date[0];
    }
    return '0000-00-00';

}

function CheckSave($check)
{
    return ($check == 1 ? 1 : 0);
}

function CheckPersonId2($personID)
{
    if ($personID != '' && strlen($personID) == 13) {
        $rev = strrev($personID); // reverse string ¢Ñé¹·Õè 0 àµÃÕÂÁµÑÇ
        $total = 0;
        for ($i = 1; $i < 13; $i++) //
        {
            $mul = $i + 1;
            $count = $rev[$i] * $mul; //
            $total = $total + $count; //
        }
        $mod = $total % 11; //
        $sub = 11 - $mod; //
        $check_digit = $sub % 10; //Check Digit

        if ($rev[0] == $check_digit) { //
            return "true"; ///
        } else {
            return "false"; //
        }
    }
    return "false";
}

function CreateArray($NoArray, $post)
{
    $data = [];
    foreach ($post as $key => $item) {
        if (!in_array($key, $NoArray)) {
            $data[$key] = $item;
        }
    }
    return $data;
}

function CreateInArray($InArray, $post)
{
    $data = [];
    foreach ($post as $key => $item) {
        if (in_array($key, $InArray)) {
            $data[$key] = $item;
        }
    }
    return $data;
}

// for jpg || jpeg
function resize_imagejpg($file, $w = 640, $watermark = '', $fontDir)
{
    ini_set("memory_limit", "1024M");
    ini_set("upload_max_filesize", "300M");
    set_time_limit(0);
    list($width, $height) = getimagesize($file);
    if ($width < $w) {
        $w = $width;
    }
    $h = round($w * $height / $width);
    $src = imagecreatefromjpeg($file);

    $scale = $width / $w;
    $fontsize = 60 * $scale;
    $textposition = $fontsize * 1.15;
    $font = $fontDir;
    $textcolor = imagecolorallocatealpha($src, 245, 245, 245, 75);
    imagettftext($src, $fontsize, 0, $textposition, $textposition, $textcolor, $font, $watermark);
    $dst = imagecreatetruecolor($w, $h);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $w, $h, $width, $height);
    return $dst;
}

// for png
function resize_imagepng($file, $w = 640, $watermark = '', $fontDir)
{
    list($width, $height) = getimagesize($file);
    if ($width < $w) {
        $w = $width;
    }
    $h = round($w * $height / $width);
    $src = imagecreatefrompng($file);

    $scale = $width / $w;
    $fontsize = 60 * $scale;
    $textposition = $fontsize * 1.15;
    $font = $fontDir;
    $textcolor = imagecolorallocatealpha($src, 245, 245, 245, 75);
    imagettftext($src, $fontsize, 0, $textposition, $textposition, $textcolor, $font, $watermark);

    $dst = imagecreatetruecolor($w, $h);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $w, $h, $width, $height);
    return $dst;
}

// for gif
function resize_imagegif($file, $w = 640, $watermark = '', $fontDir)
{
    list($width, $height) = getimagesize($file);
    if ($width < $w) {
        $w = $width;
    }
    $h = round($w * $height / $width);
    $src = imagecreatefromgif($file);

    $scale = $width / $w;
    $fontsize = 60 * $scale;
    $textposition = $fontsize * 1.15;
    $font = $fontDir;
    $textcolor = imagecolorallocatealpha($src, 245, 245, 245, 75);
    imagettftext($src, $fontsize, 0, $textposition, $textposition, $textcolor, $font, $watermark);

    $dst = imagecreatetruecolor($w, $h);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $w, $h, $width, $height);
    return $dst;
}

function CreateArrayFile($File, $TableName, $dri, $Fileid, $width, $watermark, $fontDir)
{
    $i = 1;
    $file = [];
    $file5 = [];
    $fontDir = __DIR__ . '\angsaz.ttf';
    foreach ($File as $key => $value) {
        foreach ($value as $id => $item) {
            if ($item == 'name' && $file[$key]['name'] != '') {
                $exten = explode('.', $file[$key]['name']);
                $file[$key]['name'] = $TableName . '_' . $Fileid . '_' . $key . '.' . $exten[1];
                if ($exten[1] == 'pdf') {
                    move_uploaded_file($file[$key]['tmp_name'], $dri . $file[$key]['name']);
                } elseif ($exten[1] == 'jpg' || $exten[1] == 'jpeg') {
                    $dst = resize_imagejpg($file[$key]['tmp_name'], $width, $watermark, $fontDir);
                    imagejpeg($dst, $dri . $file[$key]['name']);
                } elseif ($exten[1] == 'gif') {
                    $dst = resize_imagegif($file[$key]['tmp_name'], $width, $watermark, $fontDir);
                    imagejpeg($dst, $dri . $file[$key]['name']);
                } elseif ($exten[1] == 'png') {
                    $dst = resize_imagepng($file[$key]['tmp_name'], $width, $watermark, $fontDir);
                    imagejpeg($dst, $dri . $file[$key]['name']);
                }
            }
            $file[$key][$id] = $item;
        }
        $i++;
    }
    return $file;
}

function getAge2($birthday)
{
    $birthdate = explode('-', $birthday);
    $dateOfBirth = $birthdate[2] . '-' . $birthdate[1] . '-' . $birthdate[0];
    $today = date("Y-09-30");
    $diff = date_diff(date_create($dateOfBirth), date_create($today));
    return $diff->format('%y');
}

function getMouth($mouth)
{
    $thai_month_arr = array(
        "0" => "",
        "1" => "มกราคม",
        "2" => "กุมภาพันธ์",
        "3" => "มีนาคม",
        "4" => "เมษายน",
        "5" => "พฤษภาคม",
        "6" => "มิถุนายน",
        "7" => "กรกฎาคม",
        "8" => "สิงหาคม",
        "9" => "กันยายน",
        "10" => "ตุลาคม",
        "11" => "พฤศจิกายน",
        "12" => "ธันวาคม"
    );
    return $thai_month_arr[$mouth];
}

function getSumMouth($mouth, $year)
{
    $sql = 'SELECT SUM(amount) AS amount FROM tb_welfare_pay WHERE paymonth = ' . $mouth . ' AND year = ' . $year . ' AND status = 2';
    $data = result_row($sql);
    return $data['amount'];
}

function find_amount_order($person, $year)
{
    $sqlYear = 'SELECT * FROM tb_welfare WHERE year =' . $year;
    $year = result_row($sqlYear);
    $sql = 'SELECT * FROM tb_citizen WHERE personid = ' . $person;
    $data = result_row($sql);
    $calage = getAge2($data['birthdate']);
    if ($calage >= 90) {
        $olderpay = $year['older90'];
    } elseif ($calage >= 80 && $calage < 90) {
        $olderpay = $year['older80'];
    } elseif ($calage >= 70 && $calage < 80) {
        $olderpay = $year['older70'];
    } elseif ($calage >= 60 && $calage < 70) {
        $olderpay = $year['older60'];
    } else {
        $olderpay = 0;
    }
    return $olderpay;
}

function Escape($string)
{
    return mysqli_real_escape_string(connect(), $string);
}

function fileName($filename)
{
    $ii = explode('_', $filename, 4);
    $jj = explode('.', $ii[3]);
    $file = '';
    if ($jj[0] == 'personidfile') {
        $file = 'สำเนาบัตรประชาชน';
    } elseif ($jj[0] == 'addressid') {
        $file = 'สำเนาทะเบียนบ้าน';
    } elseif ($jj[0] == 'bank') {
        $file = 'สำเนาสมุดเงินฝาก';
    } elseif ($jj[0] == 'authority') {
        $file = 'หนังสือมอบอำนาจ';
    } elseif ($jj[0] == 'authority-personid') {
        $file = 'สำเนาบัตรประชาชน ผู้รับมอบอำนาจ';
    } elseif ($jj[0] == 'authority-address') {
        $file = 'สำเนาบัตรทะเบียนบ้านผู้รับมอบอำนาจ';
    } elseif ($jj[0] == 'handicapid') {
        $file = 'สำเนาบัตรคนพิการ';
    } elseif ($jj[0] == 'aids') {
        $file = 'ใบรับรองแพทย์ยืนยันว่าป่วยเป็นโรคเอดส์จริง';
    }
    echo $file;
}

connect()->close();
