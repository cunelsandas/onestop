
<?php
$id = $_GET['id'];
$sql = 'SELECT * FROM '.$tablename.' WHERE id = '.$id;
$rs = rsQuery($sql);
$row = mysqli_fetch_array($rs);

$withcode=explode(';',$row['fix_with_code']);

//------------------------------------------------------

$type=FindRS("SELECT * FROM tb_infrastructure_type WHERE id=".$row['type'],name);

//------------------------------------------------------
$receiveno = FindRS("SELECT * FROM tb_request WHERE table_name='$tablename' AND master_id = '$id'",receiveno);
$datein = FindRS("SELECT * FROM tb_request WHERE table_name='$tablename' AND master_id = '$id'",datein);
//------------------------------------------------------
$province=FindRS("SELECT * FROM province WHERE PROVINCE_ID=".$row['province'],PROVINCE_NAME);
$amphur=FindRS("SELECT * FROM amphur WHERE AMPHUR_ID=".$row['amphur'],AMPHUR_NAME);
$district=FindRS("SELECT * FROM district WHERE DISTRICT_ID=".$row['district'],DISTRICT_NAME);
$moo = $row['moo'];
$numhome  = $row['num_home'];

require ('lib/gPoint.php');
$myHome = new gPoint();	// Create an empty point
$myHome->setLongLat($row['lat'], $row['lng']);	// I live in sunny California :-)
$myHome->convertLLtoTM();

$addrass = $numhome." หมู่ที่ ".$moo." ตำบล ".$district." อำเภอ ".$amphur." จังหวัด ".$province;
//------------------------------------------------------
if(isset($_POST['btadd'])) {

    $date=date('Y-m-d');
    $date_create=date('Y-m-d H:i:s');

    $status=$_POST['f_status'];
    $datefinish=$_POST['datefinish'];
    $officer=$_POST['cboofficer'];
    $result=$_POST['txtresult'];

    //$stradd="insert into $tablename(date,datecreate,name,telephone,email,add_address,add_moo,add_tambol,add_amphur,add_province,subject,moo,fix_with_code,remark,post_ip,status,active,result) values('$date','$date_create','$name','$tel','$email','$add_address','$add_moo','$add_tambol','$add_amphur','$add_province','$subject','$moo','$m','$remark','$post_ip','0','$ac','$result')";
    $stradd="Update $tablename SET status='$status',result='$result',datefinish='$datefinish',officer='$officer' Where id=".$id;
    $rs=rsQuery($stradd);



    if($rs){
      echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
    }


/*
    $sql = "UPDATE $tablename SET status=".$_POST['f_status']." WHERE id=".$id;

    if (rsQuery($sql)) {
      echo "<script>alert('บันทึกข้อมูลเรียบร้อยค่ะ !'); window.location.href='main.php?_mod=".$mod."&_modid=".$modid."';</script>";
    }
*/
}
?>

<style>
    #map2 {
        height: 400px;
        width: 100%;
    }
</style>

<link type="text/css" rel="stylesheet" href="css/style_image.css">
<link rel="stylesheet" href="css/hes-gallery.css">

<div class="container">
  <div class="col-md-12">
    <h1 style="text-align:center"><?php echo $modname; ?></h1>
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="col-md-6 col-sm-12">
        <h4><u>ข้อมูลผู้แจ้ง</u></h4>
        <p> เลขที่คำร้อง : <?php echo $receiveno ?> </p>
        <p> วันที่แจ้ง &nbsp;&nbsp;&nbsp;&nbsp;: <?php echo DateTimeThai($datein) ?> </p>
        <p> ชื่อผู้แจ้ง &nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $row['name'] ?> </p>
        <p> อีเมล &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $row['email'] ?> </p>
        <p> โทรศัพท์ &nbsp;&nbsp;&nbsp;: <?php echo $row['tel'] ?> </p>
        <p> ที่อยู่ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $addrass ?></p>
      </div>
      <div class="col-md-6 col-sm-9">
      <h4><u>รายละเอียด</u></h4>

      <p> มีความประสงค์ให้ตรวจสอบสาธารณูปโภค </p>
      <p> เรื่อง  &nbsp;&nbsp;&nbsp;: <?php echo $row['subject']; ?></p>
      <p> ประเภท  &nbsp;&nbsp;&nbsp;: <?php echo $type; ?></p>
      <p> หมู่  &nbsp;&nbsp;&nbsp;: <?php echo $row['moo2']; ?></p>
    </BR>
      <p> รายละเอียด &nbsp;&nbsp;&nbsp;:  <?php echo $row['detail']; ?></p>

    </div>
</div>
</div>
  </div>







  <?php
  $sqls  =  "select * from files_image where table_name='$tablename' and master_id='$id' ";
  $rss = rsQuery($sqls);
  $num = mysqli_num_rows($rss);
  $count = 1;
  if ($num > 0){

  ?>
  <div class="col-md-12" style="text-align:center">
      <h2>รูปภาพ</h2>
      <p>(คลิกที่รูปภาพ เพื่อแสดง)</p>
  </div>

  <div class="col-md-12" style="text-align:center">
    <div class="hes-gallery">
            <?php

            while ($rows = mysqli_fetch_array($rss)){
                echo "<div style='height: 200px ; margin-top: 10px'>";
                echo "<img class=\"hover-shadow cursor\" alt=\"image".$count."\" style=\"border: 1px solid #ddd; border-radius: 4px;
            padding: 5px; width: 100%; height:180px;\"  src=".$part.$rows['file_name'].">";
                echo "</div>";
                $count++;
            }
            ?>
    </div>
</div>
<?php }?>

<?php  if ($row['lat'] != 0){ ?>
  <div class="col-md-12" style="text-align:center">
      <h2 style="margin:20px 0px 10px 0px;" >แผนที่</h2>
      <?php $myHome->printUTM(); echo " Latitude : ".$row['lat']."  Longitude : ".$row['lng'];?>
  </div>
  <div class="col-md-12">
    <div style="border: 1px solid #ddd;">
      <div id="map2"></div>
    </div>
    </div>
<?php }?>




<form name="form_help" id="form_help" method="POST" action="" enctype="multipart/form-data">

  <div class="col-md-12" style="margin:20px 0px 0px 0px;">
    <h1 style="text-align:center">การดำเนินงาน</h1>
    <div class="panel panel-default">
      <div class="panel-body">

<div class="col-md-6">
    <div class="row">

            <div class="col-md-12"  style="margin-bottom: 20px">
                <label for="f_status"><b>สถานะงาน</b></label>
                <select id="f_status" name="f_status" class="form-control">
                    <?php
                      $selected = $row['status'];
                      $sqls = "select * from tb_status";
                      $rss = rsQuery($sqls);
                      while ($rows = mysqli_fetch_array($rss)) {
                        ?>
                        <option <?php if($selected == $rows['id']){echo("selected");}?> value="<?php echo $rows['id']; ?>"><?php echo $rows['status']; ?></option>

                        <?php
                      }
                    ?>
                </select>
            </div>

            <div class="col-md-12" style="margin-bottom: 20px">
                <label for="f_status"><b>ผลการดำเนินการ</b></label>
                <textarea class="form-control" rows="4" name="txtresult"><?php echo $row['result']; ?></textarea>
            </div>



</div>
</div>

<div class="col-md-6">
    <div class="row">
      <div class="col-md-12"  style="margin-bottom: 20px">
        <label for="cboofficer">เจ้าหน้าที่ผู้ดำเนินการ</label>
        <input class="form-control" type="text" name="cboofficer" value="<?php echo $row['officer'];?>">
      </div>

      <div class="col-md-12"  style="margin-bottom: 20px">
      <label>วันที่ดำเนินการเสร็จ</label>
      <input class="form-control" type="date" name="datefinish" id="datefinish" value="<?php echo $row['datefinish'];?>">
      </div>



</div>
</div>


</div>
  </div>

<div class="col-md-12" style="margin-bottom: 50px">
<button class="btn btn-info" type="submit" name="btadd">บันทึก</button>&nbsp;&nbsp;
<a class="btn btn-default"  href="<?php echo $foderreport; ?>report.php?id=<?php echo $row['id'];?>" target="_Blank">พิมพ์คำร้อง</a>&nbsp;&nbsp;
</div>
</form>

</div>
</div>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDg49SZLUZdLu8KQ80fEAPJkbdBUqyN-vw&callback=initMap&libraries=places" ></script>

<script>
    function initMap(){


        myLatLng = {lat: <?php echo $row['lat']; ?>, lng: <?php echo $row['lng']; ?>};
        var map = new google.maps.Map(document.getElementById('map2'), {
            center: myLatLng,
            zoom: 18
        });

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            //draggable:true
        });

        google.maps.event.addListener(marker,'dragend',function () {
            var lat = marker.getPosition().lat();
            var lng = marker.getPosition().lng();

            document.getElementById("frm_lat").value = lat.toFixed(5);
            document.getElementById("frm_lng").value = lng.toFixed(5);

        });


    }

</script>

<script src="js/hes-gallery.js"></script>
<script>
  HesGallery.setOptions({
          disableScrolling: false,
          hostedStyles: false,
          animations: true,
          minResolution: 1000,

          showImageCount: true,
          wrapAround: true
      });
</script>
