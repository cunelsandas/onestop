<?php

include_once "../itgmod/connect.php";


if(isset($_POST['view'])){

// $con = mysqli_connect("localhost", "root", "", "notif");

if($_POST["view"] != '')
{
    $update_query = "UPDATE tb_notification SET substatus = 1 WHERE modid = ".$_POST['view']." AND substatus=0";
    rsQuery($update_query);
}

$data = array();
$n = 0;

$sql1 = "SELECT * FROM tb_mod WHERE groupid = 1 ORDER BY listno";
$rs1 = rsQuery($sql1);
while ($row = mysqli_fetch_array($rs1)) {

  $modid = $row['modid'];
  $modtype = $row['modtype'];

  $status_query = "SELECT * FROM tb_notification WHERE modid = $modid AND substatus=0";
  $result_query = rsQuery($status_query);
  $count = mysqli_num_rows($result_query);
  $roww = mysqli_fetch_array($result_query);
  $id = $roww['master_id'];

  $data[$n] = array(
      'no' => $n,
      'modtype'  => $modtype,
      'modid'  => $modid,
      'master_id' => $id,
      'count' => $count
  );

$n++;

}

echo json_encode($data);

}

?>
