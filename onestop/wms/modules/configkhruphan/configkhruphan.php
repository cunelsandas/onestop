<?php

$mod = $_GET["_mod"] ;
$modid = $_GET['_modid'];
$modname=FindRS("select modname from tb_mod where modid=$modid","modname");
$tablename=FindRS("select tablename from tb_mod where modid=$modid","tablename");
$folder =FindRS("select foldername from tb_mod where modid=$modid","foldername");

$modpath =FindRS("select modpath from tb_mod where modid=$modid","modpath");
$pathmod =FindRS("select wms_path from tb_modpath where id=$modpath","wms_path");
$fdmod = explode("/", $pathmod);
$foldermod = $fdmod[0]."/".$fdmod[1]."/";
$foderreport = "report/".$fdmod[1]."/";

empty($_GET['type'])?$type="":$type=$_GET['type'];


$part = "../fileupload/".$folder."/";

if($type == "Add") {
    include "view.php";
    }else if ($type == "View"){
    include "configkhruphan_view.php";
}else {

if(isset($_POST['btn_khru'])) {
  $sql = "INSERT INTO tb_object(id,object)
  Values('','" .$_POST['frm_khru']. "')";
  $rs = rsQuery($sql);
  if ($rs) {
    echo "<script>alert('เพิ่มข้อมูล ครุภัณฑ์ เรียบร้อยแล้วค่ะ!');window.location.href='main.php?_mod=".$mod."&_modid=".$modid."'; </script>";
  }
}


?>

<div class="content" name="content">
    <div class="col-md-12">
      <h1><?php echo $modname;?></h1>
      <div style="text-align: right; margin: 20px"><button type="button" class="btn btn-secondary btn-lg" data-toggle="modal" data-target="#Modal">เพิ่มครุภัณฑ์</button></div>
      <div class="panel panel-default">
        <div class="panel-body">
        <div  class="col-md-12">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>ชื่อผู้แจ้ง</th>
                    <th>สถานะ</th>
                    <th>จัดการข้อมูล</th>
                </tr>
                </thead>
                <tbody>

                  <?php
                  $sql = "SELECT * FROM $tablename ORDER BY id DESC";
                  $rs = rsQuery($sql);
                  $n=1;

                  while ($row = mysqli_fetch_array($rs)){
                    $status = FindRS("select * from tb_status where id=".$row['status'],"status");
                      echo '<tr>
                              <td style="width:10%">'.$n.'</td>
                              <td style="width:50%">'.$row["name"].'</td>
                              <td style="width:20%">'.$status.'</td>
                              <td style="width:20%">
                              <a class="btn btn-success" href="main.php?_mod='.$mod.'&_modid='.$modid.'&type=View&id='.$row["id"].'"><i class="fas fa-eye"></i></a>
                              <a class="btn btn-danger" onclick="btn_delete('.$row["id"].')"><i class="fas fa-trash-alt"></i></a>
                              </td>
                            </tr>';
                      $n++;
                  }
                  ?>

                </tbody>
            </table>
        </div>
</div>
</div>
    </div>

</div>



<!-- Modal -->
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มครุภัณฑ์</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="myForm" name="myForm" action="#" enctype="multipart/form-data" onsubmit="return(validate());">
        <input type="text" class="form-control" id="frm_khru" name="frm_khru" placeholder="ชื่อครุภัณฑ์">

        <table class="table table-striped" name="table_object" id="table_object">
  <thead>
    <tr>
      <th scope="col" style="text-align: center;">#</th>
      <th scope="col" style="text-align: center;">ชื่อครุภัณฑ์</th>
      <th scope="col" style="text-align: center;">จัดการ</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $sql = "SELECT * FROM tb_object ORDER BY id";
    $rs = rsQuery($sql);
    $n=1;

    while ($row = mysqli_fetch_array($rs)){
        echo '<tr>
                <td scope="row" style="text-align: center;">'.$n.'</td>
                <td align="center">'.$row['object'].'</td>
                <td align="center">
                    <a class="btn btn-danger" onclick="btn_delete_obj('.$row["id"].')">ลบ</a>
                </td>
              </tr>';
        $n++;
    }
    ?>
  </tbody>
</table>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        <button type="submit" class="btn btn-primary" name="btn_khru">ตกลง</button>
      </form>
      </div>
    </div>
  </div>
</div>

<?php } ?>

<script type = "text/javascript">

function btn_delete(id) {
    var action = "remove_khruphan";
    if(confirm("ต้องการลบข้อมูลหรือไม่")){
        $.ajax({
            url : "../itgmod/action.php?_modid=<?php echo $modid ?>",
            method : "POST",
            data : {
                action : action,
                id : id
            },
            success: function (data) {
                alert(data);
                $("#example").load(location.href + " #example");
            },error: function (data){
              alert(url);
            }
        });
    }else {
        return false;
    }
}

function btn_delete_obj(id) {
    var action = "remove_file_khruphan_ojb";
    if(confirm("ต้องการลบข้อมูลหรือไม่")){
        $.ajax({
            url : "../itgmod/action.php?_modid=<?php echo $modid ?>",
            method : "POST",
            data : {
                action : action,
                id : id
            },
            success: function (data) {
                alert(data);
                $('#Modal').modal('hide');
                $("#table_object").load(location.href + " #table_object");
            },error: function (data){
              alert(url);
            }
        });
    }else {
        return false;
    }
}

function validate() {

   if( document.myForm.frm_khru.value == "" ) {
      alert( "กรุณากรอก ชื่อครุภัณฑ์!" );
      document.myForm.frm_khru.focus() ;
      return false;
   }

   return( true );
}

</script>
