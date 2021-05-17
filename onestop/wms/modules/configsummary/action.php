<?php
include_once "../../../itgmod/connect.php";

if(isset($_GET['action'])) {


    if ($_GET['action'] == "showdata") {

      $sql = "SELECT * FROM tb_request";
      $rs = rsQuery($sql);
      $data = array();
      $num = mysqli_num_fields($rs);

      while ($row = mysqli_fetch_array($rs)) {

        $arrCol = array();

          for($i=0;$i<$num;$i++){
            $field =  mysqli_fetch_field_direct($rs,$i);
            $namefield[$i] = $field->name;
            $arrCol[$namefield[$i]] = $row[$i];
          }
          array_push($data,$arrCol);
      }

      echo json_encode($data);
        //----------------- -remove_im- ---------------
    }

    else{
        echo "action Null.";
    }
}else{
    echo "Not action.";
}

?>
