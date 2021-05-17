<?php
/**
 * Created by PhpStorm.
 * User: Programmer-ITG
 * Date: 12/9/2017
 * Time: 9:30 AM
 */
function BackendLogin($user, $pass)
{
    $sql = 'SELECT * FROM tb_user WHERE username = \'' . $user . '\'';
    $data = result_array($sql);
    if ($data != []) {
        if ($pass == $data[0]['pwfix']) {
            return $data;
        } else {
            return false;
        }
    }
    return false;
}

if (isset($_POST['login'])) {
    if ($data = BackendLogin($_POST['user'], $_POST['password'])) {
        $_SESSION['BID'] = $data[0]['userid'];
        echo '<script>window.location.href = \'backend.php?r=index\';</script>';
    } else {
        session_destroy();
        echo '<script>window.location.href = \'backend.php\';</script>';
    }
}
if (isset($_POST['btnSave'])) {
    $No = [
        'btnSave',
        'id',
        'year',
        'olderpay',
        'handicap',
        'aids',
        'receivetype',
    ];
    if (isset($_GET['id'])) {
        $_POST['birthdate'] = ExpoldDate($_POST['birthdate']);
        $_POST['newcitizendate'] = ExpoldDate($_POST['newcitizendate']);
        $_POST['welfare_older'] = CheckSave(isset($_POST['welfare_older']));
        $_POST['welfare_handicap'] = CheckSave(isset($_POST['welfare_handicap']));
        $_POST['welfare_aids'] = CheckSave(isset($_POST['welfare_aids']));
        $_POST['handicap_eye'] = CheckSave(isset($_POST['handicap_eye']));
        $_POST['handicap_ear'] = CheckSave(isset($_POST['handicap_ear']));
        $_POST['handicap_body'] = CheckSave(isset($_POST['handicap_body']));
        $_POST['handicap_mind'] = CheckSave(isset($_POST['handicap_mind']));
        $_POST['handicap_brain'] = CheckSave(isset($_POST['handicap_brain']));
        $_POST['handicap_learn'] = CheckSave(isset($_POST['handicap_learn']));
        $_POST['handicap_ortistic'] = CheckSave(isset($_POST['handicap_ortistic']));
        $_POST['status'] = 1;
        $data = CreateArray($No, $_POST);
        $update = Update('tb_citizen', $_GET['id'], $data);

        $today = date('Y-m-d');
        $dataIn = [
            'receivetype' => isset($_POST['receivetype']) ? $_POST['receivetype'] : '',
            'year' => $_POST['year'],
            'personid' => $_POST['personid'],
            'status' => 1,
            'requestdate' => $today,
            'process'=> 0,
        ];
        if (isset($_POST['aids'])) {
            $dataIn['type'] = 3;
            $dataIn['amount'] = $_POST['aids'];
            Insert('tb_welfare_request', $dataIn);
        }
        if (isset($_POST['handicap'])) {
            $dataIn['type'] = 2;
            $dataIn['amount'] = $_POST['handicap'];
            Insert('tb_welfare_request', $dataIn);
        }
        if (isset($_POST['olderpay'])) {
            $dataIn['type'] = 1;
            $dataIn['amount'] = $_POST['olderpay'];
            Insert('tb_welfare_request', $dataIn);
        }
        if ($update) {
            $MasterID = $_GET['id'];
            $TableName = 'tb_citizen';
            $foder = 'welfare';
            $dri = '../' . $gloUploadPath . '/' . $foder . '/';
            $font = '../wms/font/angsaz.ttf';
            $file = CreateArrayFile($_FILES, $TableName, $dri, $MasterID, 640, '', $font);
            $i = 0;
            if ($file) {
                foreach ($file as $value) {
                    $FileName[$i]['filename'] = $value['name'];
                    $FileName[$i]['masterid'] = $MasterID;
                    $FileName[$i]['tablename'] = $TableName;
                    if ($value['name'] != '') {
                        Insert('filename', $FileName[$i]);
                    }
                    $i++;
                }
            }
        }
        echo '<script>alert(\'บันทึกข้อมูลสำเร็จ\');window.location.href=(\'backend.php?r=add&id=' . $_GET['id'] . '\')' . '</script > ';
    } else {
        $_POST['birthdate'] = ExpoldDate($_POST['birthdate']);
        $_POST['newcitizendate'] = ExpoldDate($_POST['newcitizendate']);
        $data = CreateArray($No, $_POST);
        $insert = Insert('tb_citizen', $data);
        echo '<script>alert(\'บันทึกข้อมูลสำเร็จ\');window.location.href=(\'backend.php?r=view\')</script > ';
    }

}