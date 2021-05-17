<?php
    include_once "../itgmod/connect.php";

    $id = $_POST['id'];

    $json = array();
    $sqlQuery = "SELECT * FROM tbl_events WHERE id =  $id";
    $rs = rsQuery($sqlQuery);

    $eventArray = array();
    while ($row = mysqli_fetch_assoc($rs)) {
        array_push($eventArray, $row);
        if ($row['start'] != "") {
          array_push($eventArray, DateThai($row['start']));
        }
        if ($row['end'] != "") {
          array_push($eventArray, DateTimeThai($row['end']));
        }
    }

    $sqlQuery = "SELECT * FROM tbl_detail_events WHERE tbl_event_id =  $id";
    $rs = rsQuery($sqlQuery);

    while ($row = mysqli_fetch_assoc($rs)) {
        array_push($eventArray, $row);
    }

    //echo $id;
    echo json_encode($eventArray);
?>
