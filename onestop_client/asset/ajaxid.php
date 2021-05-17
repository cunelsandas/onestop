<?php
/**
 * Created by PhpStorm.
 * User: Programmer-ITG
 * Date: 12/6/2017
 * Time: 9:04 AM
 */
include '../itgmod/connect.inc.php';
include 'DB/myfnc2.php';
$id = Escape($_POST['id']);
$chk ='false';
$sql = 'SELECT * FROM tb_citizen WHERE personid =\''.$id.'\'';
$data = result_array($sql);
if ($id != ''){
    $chk = CheckPersonId2($id);
}
$result = [
    'data' => $data,
    'chk' => $chk,
];

echo json_encode($result);