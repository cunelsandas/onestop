<?php

include_once "../itgmod/connect.php";


if(isset($_POST['view'])){

// $con = mysqli_connect("localhost", "root", "", "notif");

if($_POST["view"] != '')
{
    $update_query = "UPDATE tb_notification SET allstatus = 1 WHERE allstatus=0";
    rsQuery($update_query);
}

$query = "SELECT * FROM tb_notification ORDER BY id DESC LIMIT 5";
$result = rsQuery($query);
$output = '';
if(mysqli_num_rows($result) > 0)
{
 while($row = mysqli_fetch_array($result))
 {
   $midid = $row['modid'];
   $modname = FindRS("SELECT * FROM tb_mod WHERE modid = '$midid'",modtype);

   $output .= '
   <li>
   <a href="main.php?_mod='.$modname.'&_modid='.$midid.'">
   <strong>'.$row['subject'].'</strong><br />
   <small><em>'.$row["detail"].'</em></small>
   </a>
   </li>
   ';

 }

}else{
     $output .= '
     <li><a href="#" class="text-bold text-italic">No Noti Found</a></li>';
}



$status_query = "SELECT * FROM tb_notification WHERE allstatus=0";
$result_query = rsQuery($status_query);
$count = mysqli_num_rows($result_query);
$data = array(
    'notification' => $output,
    'unseen_notification'  => $count
);

echo json_encode($data);

}

?>
