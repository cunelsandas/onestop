<?php
include_once "../../../itgmod/connect.php";

$mod_id =  $_GET["_modid"] ;
$id =  $_GET["id"] ;
$modname=FindRS("select modname from tb_mod where modid=$mod_id","modname");
$tablename=FindRS("select tablename from tb_mod where modid=$mod_id","tablename");

$path_image = "../../../fileupload/tree/";




if(isset($_POST['action'])) {

    //----------------- -Delete- ---------------

    if ($_POST['action'] == "remove_file") {

        $sqls = "select * from $tablename where id = " . $_POST['id'];
        $rss = rsQuery($sqls);
        $row1 = mysqli_fetch_array($rss);

        $sql = "delete from $tablename where id =" . $_POST['id'];
        $rs = rsQuery($sql);

        $sql = "delete from tb_request where master_id =" . $_POST['id'] . " and table_name = '".$tablename."'";
        $rs = rsQuery($sql);

        //$sql2 = "delete from files_image where master_id = ".$_POST['id']." and table_name = '". $tablename."'";
        $sql2 = "select * from files_image where master_id = ".$_POST['id']." and table_name = '". $tablename."'";
        $rs2  = rsQuery($sql2);


        while ($row2 = mysqli_fetch_array($rs2)) {
            $path = $path_image.$row2['file_name'];
            unlink($path);
            $sql = "delete from files_image where master_id = ".$_POST['id']." and table_name = '". $tablename."'";
            $rs = rsQuery($sql);
        };

        echo "ลบข้อมูลเรียบร้อยแล้วค่ะ!";

        //----------------- -remove_im- ---------------
    }

    else{
        echo "action Null.";
    }
}else{
    echo "Not action.";
}
?>
