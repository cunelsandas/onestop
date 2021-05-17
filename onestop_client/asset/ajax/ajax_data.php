<?php

/**
 * Created by PhpStorm.
 * User: Programmer-ITG
 * Date: 12/9/2017
 * Time: 10:38 AM
 */
include_once('../DB/myfnc2.php');
include_once('../../itgmod/connect.inc.php');
if (isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'Point' :
            Point();
            break;
        case 'accept' :
            accept();
            break;
        case 'cancel' :
            cancel();
            break;
        case 'SearchID' :
            SearchID();
            break;
        case 'SPerson' :
            SearchPerson();
            break;
        case 'PointPay' :
            PointPay();
            break;
        case 'Pay' :
            Pay();
            break;
        case 'FindFile' :
            FindFile();
            break;
        case 'Receivetype' :
            Receivetype();
            break;
        case 'Chart' :
            Chart();
            break;
        case 'FindType' :
            FindType();
            break;
        case 'un' :
            un();
            break;
        case 'Process' :
            Process();
            break;
        case 'findWelfare' :
            findWelfare();
            break;
        case 'NoImg' :
            NoImg();
            break;
        case 'WelfareAdd' :
            WelfareAdd();
            break;
    }
}
function WelfareAdd()
{
    function is($is)
    {
        return $is != '' ? $is : 0;
    }

    $data = $_POST['Data'][0];
    $data = [
        'year' => Escape($data['WfYear']),
        'birthdate' => Escape($data['WfDate']),
        'older60' => is(Escape($data['WfOld60'])),
        'older70' => is(Escape($data['WfOld70'])),
        'older80' => is(Escape($data['WfOld80'])),
        'older90' => is(Escape($data['WfOld90'])),
        'handicap' => is(Escape($data['WfHandicap'])),
        'aids' => is(Escape($data['WfAids'])),
    ];
    Insert('tb_welfare', $data);
    return Json($data);
}

function findWelfare()
{
    $sql = 'SELECT * FROM tb_welfare ORDER BY year';
    $data = result_array($sql);
    return Json($data);
}

// todo AJAX เอกสารไม่ถูกต้อง
function NoImg()
{
    $today = date('Y-m-d');
    $text = Escape($_POST['text']);
    $id = Escape($_POST['ID']);
    $data = [
        'status' => 4,
        'confirmdate' => $today,
        'detail' => $text,
    ];
    $update = Update('tb_welfare_request', $id, $data);
    if ($update) {
        return Json('ok');
    }
}

// todo ประมวลเบี้ยข้ามปี
function Process()
{
    $POST = $_POST;
    $Year = Escape($POST['Year']);
    $Type = Escape($POST['Type']);
    $Moo = Escape($POST['Moo']);
    $today = date('Y-m-d');
    $YearAgo = $Year - 1;
    $sql = 'SELECT *,a.id AS ID FROM tb_welfare_request a 
              INNER JOIN tb_citizen b on a.personid = b.personid 
                WHERE a.status = 2 
                AND a.process != 1  
                AND b.status = 1 
                AND a.year = \'' . $YearAgo . '\'
                AND b.moo = \'' . $Moo . '\'
                AND a.type = \'' . $Type . '\'';

    $dataa = result_array($sql);
    $result = [];
    if ($dataa != []) {
        foreach ($dataa as $key => $value) {
            $data[$key]['personid'] = $value['personid'];
            $data[$key]['amount'] = $value['amount'];
            $data[$key]['type'] = $value['type'];
            $data[$key]['year'] = $Year;
            $data[$key]['requestdate'] = $today;
            $data[$key]['receivetype'] = $value['receivetype'];
            $data[$key]['status'] = 2;
            $data[$key]['confirmdate'] = $today;
            $data[$key]['paymonth'] = 1;
            $data[$key]['process'] = 0;
            if ($data[$key]['type'] == 1) {
                $amount = find_amount_order($value['personid'], $Year);
                $data[$key]['amount'] = $amount;
            }
            $Insert = Insert('tb_welfare_request', $data[$key]);
            $Update = Update('tb_welfare_request', $value['ID'], ['process' => 1]);
        }

        $result = [
            'dataa' => $dataa,
            '$data' => $data,
        ];
    }
//    $result['sql'] = $sql;
    echo json_encode($result);
}

// todo แสดงจำนวนผู้ขอขึ้นทะเบียนเบี้ย
function Point()
{
    $Name = Escape($_POST['Name']);
    $Year = Escape($_POST['Year']);

    if ($Name == 'Order') {
        $type = 1;
    } elseif ($Name == 'handicap') {
        $type = 2;
    } else {
        $type = 3;
    }
    $sql = 'SELECT DISTINCT a.id,a.id AS PID,b.id AS Uid ,CONCAT(b.name,\' \',b.surname) AS userid, a.*,b.*,c.* FROM tb_welfare_request a LEFT JOIN tb_citizen b ON a.personid = b.personid LEFT JOIN tb_welfare_receivetype c ON a.receivetype = c.id WHERE (a.status = 1 OR a.status = 4) AND a.type = ' . $type . ' AND a.year = \'' . $Year . '\'';
    $data = result_array($sql);
    $result = [
        'data' => $data,
    ];
    echo json_encode($result);
}

// todo AJAX ข้อมูลรายชื่อผู้ได้รับเบี้ยตามหมู่ เดือน ปี ประเภท
function PointPay()
{
    $type = Escape($_POST['Type']);
    $data = Escape($_POST['data']);
    $moo = Escape($_POST['Moo']);
    $year = Escape($_POST['Year']);
    $month = Escape($_POST['Month']);

    $sql = 'SELECT DISTINCT a.id,a.id AS PID,CONCAT(b.name,\' \',b.surname) AS userid,a.*,b.*,c.* 
              FROM tb_welfare_request a 
                INNER JOIN tb_citizen b ON a.personid = b.personid 
                INNER JOIN tb_welfare_receivetype c ON a.receivetype = c.id 
                  WHERE a.status = 2 
                  AND a.type = ' . $type . ' 
                  AND a.year = \'' . $year . '\' 
                  AND a.paymonth = ' . $month;
    $sql .= ' AND (b.name LIKE \'%' . $data . '%\' OR b.personid LIKE \'%' . $data . '%\' OR c.name LIKE \'%' . $data . '%\') AND b.moo = ' . $moo;
    $data = result_array($sql);
    echo json_encode($data);
}

// todo อนุมัติการขอขึ้นทะเบียน
function accept()
{
    $today = date('Y-m-d');
    $m = date('m');
    $Id = Escape($_POST['ID']);
    $PersonId = Escape($_POST['PersonId']);
    $data = [
        'detail' => '',
        'status' => 2,
        'confirmdate' => $today,
        'paymonth' => $m,
    ];
    $update = Update('tb_welfare_request', $Id, $data);
    if ($update) {
        echo json_encode('ok');
    }
}

// todo ยกเลิกอนุมัติการขอขึ้นทะเบียน
function cancel()
{
    $today = date('Y-m-d');
    $Id = Escape($_POST['Id']);
    $data = [
        'detail' => Escape($_POST['detail']),
        'status' => 3,
        'confirmdate' => $today,
    ];
    $update = Update('tb_welfare_request', $Id, $data);
    if ($update) {
        echo json_encode('ok');
    }
}

// todo check เลขบัตรประชาชน
function SearchID()
{
    $id = Escape($_POST['id']);
    $chk = 'false';
    $result = [];
    $sql = 'SELECT * FROM tb_citizen WHERE personid =\'' . $id . '\'';
    $data = result_array($sql);
    if ($id != '') {
        $chk = CheckPersonId2($id);
    }
    if ($data == []) {
        $result = [
            'data' => $data,
            'chk' => $chk,
        ];
    }
    echo json_encode($result);
}

function SearchPerson()
{
    $data = Escape($_POST['data']);
    $Moo = Escape($_POST['moo']);
    $sql = 'SELECT * FROM tb_citizen WHERE (personid LIKE \'%' . $data . '%\' OR name LIKE \'%' . $data . '%\' OR surname LIKE \'%' . $data . '%\') AND moo = \'' . $Moo . '\' LIMIT 10';
    $data = result_array($sql);
    $result['data'] = $data;
    echo json_encode($result);
}

// todo AJAX จ่ายเงิน
function Pay()
{
    $today = date('Y-m-d');
    $post = $_POST['data'];
    $y = 0;
    $m = 0;
    foreach ($post as $key => $item) {
        $m = $item['paymonth'] + 1;
        $paymonth = $m;
        if ($m == 13) {
            $paymonth = 12;
        }

        $data[$key] = [
            'personid' => $item['personid'],
            'amount' => $item['amount'],
            'type' => $item['type'],
            'year' => $item['year'],
            'status' => 2,
            'paydate' => $today,
            'paymonth' => $item['paymonth'],
        ];
        Insert('tb_welfare_pay', $data[$key]);

        $dataUp[$key] = [
            'status' => 2,
            'process' => 0,
            'paymonth' => $m,
            'year' => $item['year'],
        ];
        Update('tb_welfare_request', $item['ID'], $dataUp[$key]);
    }
    echo json_encode($data);
}

//todo AJAX ค้นหารูปหน้า Index
function FindFile()
{
    $TabelName = 'tb_citizen';
    $sql = 'SELECT DISTINCT CONCAT(\'../fileupload/welfare/\',filename) AS filename,filename AS F FROM filename WHERE tablename = \'' . $TabelName . '\' AND masterid = \'' . Escape($_POST['Id']) . '\'';
    $data = result_array($sql);
    echo json_encode($data);
}

//todo AJAX รายงานวิธีการชำระเงิน
function Receivetype()
{
    $sql = 'SELECT DISTINCT a.personid,b.name,b.surname FROM tb_welfare_request a 
              INNER JOIN tb_citizen b ON a.personid = b.personid 
                WHERE a.receivetype = ' . Escape($_POST['Type']) .
        ' AND a.year = \'' . Escape($_POST['Year']) . '\'';
    $data = result_array($sql);
    echo json_encode($data);
}

//todo AJAX หาผลรวมทั้งปี
function SumofYear($year, $type)
{
    $sql = 'SELECT SUM(amount) AS Sum FROM tb_welfare_pay WHERE year = ' . $year . '  AND status = 2 AND type = ' . $type;
    $Sum = result_row($sql);
    return $Sum['Sum'];
}

//todo AJAX กราฟเปรียบเทียบ
function Chart()
{
    $SYear = Escape($_POST['SYear']);
    $LYear = Escape($_POST['LYear']);
    $sql = 'SELECT * FROM tb_welfare_pay WHERE year BETWEEN ' . $SYear . ' AND ' . $LYear . ' ORDER BY year';
    $list = result_array($sql);
    $sqlType = 'SELECT * FROM tb_welfare_type ORDER BY id';
    $Type = result_array($sqlType);
    $data = [];
    $sum = [];
    $ss = [];
    $year = '';
    $NumYear = [];
    $i = 0;
    $ArrayTest = [];

    foreach ($list as $key => $item) {
        if ($item['year'] != $year) {
            $year = $item['year'];
            $NumYear[$i] = $item['year'];
            $data['year'][$i] = $item['year'];
            foreach ($Type as $_key => $_Type) {
                $sum[$i][$_key] = SumofYear($year, $_Type['id']);
            }
            $i++;
        }
    }
    for ($i = 0; $i < count($Type); $i++) {
        for ($x = 0; $x < count($NumYear); $x++) {
            $ArrayTest[$i][$x] = $sum[$x][$i];
        }
        $ss = $ArrayTest;
    }
    $data['name'] = $Type;
    $data['sum'] = $sum;
    $data['ss'] = $ss;
    echo json_encode($data, JSON_NUMERIC_CHECK);
}

//todo AJAX ข้อมูลหน้ารายงานผู้ได้รับเบี้ย
function FindType()
{
    $Type = Escape($_POST['Type']);
    $Year = Escape($_POST['Year']);
    $sql = 'SELECT * FROM tb_welfare_request a 
              INNER JOIN tb_citizen b ON a.personid = b.personid 
                WHERE a.type = ' . $Type .
        ' AND a.year = \'' . $Year . '\'';
    $data = result_array($sql);
    echo json_encode($data);
}

//todo AJAX ลบรูป
function un()
{
    $link = Escape($_POST['p']);
    $link = explode('/', $link);
    $where = 'filename = \'' . $link[2] . '\'';
    $Unlink = explode('\\', __DIR__);
    $Unlink = $Unlink[0] . '\\' . $Unlink[1] . '\\' . $Unlink[2] . '\\' . $Unlink[3] . '\\' . $link[0] . '\\' . $link[1] . '\\' . $link[2];
    $Unlink = unlink($Unlink);
    if ($Unlink) {
        $delete = delete('filename', $where);
        echo json_encode('ok');
    }
}

?>