<?php
  $modname=FindRS("select * from tb_mod where modtype='$mod'",modname);
  $modid=FindRS("select * from tb_mod where modtype='$mod'",modid);
  $table=FindRS("select * from tb_mod where modtype='$mod'",tablename);
  $folder =FindRS("select * from tb_mod where modtype='$mod'",foldername);

  $part = "fileupload/".$folder."/";
	$point_no="5";


  if(isset($_POST['Submit'])) {

    /*$province=FindRS("SELECT * FROM province WHERE PROVINCE_ID=".$_POST['frm_province'],PROVINCE_NAME);
    $amphur=FindRS("SELECT * FROM amphur WHERE AMPHUR_ID=".$_POST['frm_amphur'],AMPHUR_NAME);
    $district=FindRS("SELECT * FROM district WHERE DISTRICT_ID=".$_POST['frm_district'],DISTRICT_NAME);
    $moo = $_POST['frm_moo'];
*/

$check = getimagesize($_FILES["frm_image"]["tmp_name"][0]);

  $date=date('Y-m-d');
  $date_create=date('Y-m-d H:i:s');

  $name=$_POST['frm_name'];
  $tel=$_POST['frm_tel'];
  $email=$_POST['frm_email'];
  $add_address=$_POST['frm_numhome'];
  $add_moo=$_POST['frm_moo'];
  $add_tambol=$_POST['frm_district'];
  $add_amphur=$_POST['frm_amphur'];
  $add_province=$_POST['frm_province'];


  $moo=$_POST['frm_moo2'];
  $remark=$_POST['frm_details'];

  $subject=$_POST['frm_subject'];
  $post_ip=$_SERVER['REMOTE_ADDR'];
  $lat=$_POST['frm_lat'];
  $lng=$_POST['frm_lng'];

  for($i=1;$i<=$point_no;$i++){
      if($i==$point_no){
        $end="";
      }else{
        $end=";";
      }
      $m.=$_POST['p'.$i].$end;
  }

  $stradd="insert into $table(date,datecreate
  ,name,tel,email,num_home,moo,district,amphur,province,subject,moo2
  ,fix_with_code,remark,post_ip,status,active,result,datefinish,lat,lng)
  values('$date','$date_create'
  ,'$name','$tel','$email','$add_address','$add_moo','$add_tambol','$add_amphur','$add_province','$subject','$moo'
  ,'$m','$remark','$post_ip','1','1','','0000-00-00','$lat','$lng')";
  $rs=rsQuery($stradd);

  $sql2 = "SELECT * FROM $table ORDER BY id DESC LIMIT 0,1";
  $rss = rsQuery($sql2);
  $num = mysqli_fetch_array($rss);
  $lid = $num['id'];
  $date = date("Y-m-d H:i:s");
  $receiveno = "800" . $lid;

  $sql = "INSERT INTO tb_request(id,table_name,master_id,modid,receiveno,datein)
  Values('','" .$table. "','" .$lid. "','" .$modid. "','" .$receiveno. "','" .$date. "')";
  $rs = rsQuery($sql);

  $sql = "INSERT INTO tb_notification(id,subject,detail,modid,master_id,allstatus,substatus)
  Values('','" .$_POST['frm_name']. "','" .$modname. "','" .$modid. "','" .$lid. "','0','0')";
  $rs = rsQuery($sql);

  include_once("itgmod/sent_email.php");

  if ($rs) {
      echo "<script>alert('เรื่องของคุณได้ถูกส่งไปยังผุ้ที่เกี่ยวข้องแล้วค่ะ  เลขคำร้องของคุณคือ : ".$receiveno."');window.location.href='index.php';</script>";
  }else{
      echo "<script>alert('Err'); </script>" ;
}



if ($check !== false){

            $sql2 = "SELECT * FROM $table ORDER BY id DESC LIMIT 0,1";
            $rss = rsQuery($sql2);
            $num = mysqli_fetch_array($rss);
            $lid = $num['id'];
            $date = date("Y-m-d H:i:s");

        for($i=0; $i<count($_FILES['frm_image']['name']); $i++){

            $filename = $_FILES["frm_image"]["name"][$i];
            $ext = end(explode(".",$filename));
            $newname = $table.'_'.$lid.'_'.$i.'.'.$ext;
            $filetmp = $_FILES["frm_image"]["tmp_name"][$i];
            $filetype = $_FILES["frm_image"]["type"][$i];
            $filepath = $part.$newname;

            if (move_uploaded_file($filetmp,$filepath)) {

                $sql = "INSERT INTO files_image(id,table_name,master_id,file_name,edit_time)
                VALUES ('','".$table."','".$lid."','".$newname."','".$date."')";
                $rs = rsQuery($sql);

            } else {
                echo "<script>alert('Image not upload.'); </script>";
            }
        }
    }

      /*$check = getimagesize($_FILES["frm_image"]["tmp_name"][0]);

                $sql = "INSERT INTO $table(id,name,tel,email,province,amphur,district,moo,num_home,type_tree,num_tree,location,lat,lng,status,active)
                Values('','" .$_POST['frm_name']. "','" .$_POST['frm_tel']. "','" .$_POST['frm_email']. "','" .$_POST['frm_province']. "','" .$_POST['frm_amphur']. "'
                  ,'" .$_POST['frm_district']. "','" .$_POST['frm_moo']. "','" .$_POST['frm_numhome']. "'
                ,'" .$_POST['frm_typetree']. "','" .$_POST['frm_numtree']. "','" .$_POST['frm_location']. "'
                ,'" .$_POST['frm_lat']. "','" .$_POST['frm_lng']. "','1','1')";
                $rs = rsQuery($sql);

                  $sql2 = "SELECT * FROM $table ORDER BY id DESC LIMIT 0,1";
                  $rss = rsQuery($sql2);
                  $num = mysqli_fetch_array($rss);
                  $lid = $num['id'];
                  $date = date("Y-m-d H:i:s");

                  $sql = "INSERT INTO tb_request(id,table_name,master_id,modid,receiveno,datein)
                  Values('','" .$table. "','" .$lid. "','" .$modid. "','700" .$lid. "','" .$date. "')";
                  $rs = rsQuery($sql);

                  if ($rs) {
                      echo "<script>alert('เรื่องของคุณได้ถูกส่งไปยังผุ้ที่เกี่ยวข้องแล้วค่ะ');window.location.href='index.php?_mod=" . $_GET['_mod'] . "';</script>";
                  }else{
                      echo "<script>alert('Err'); </script>" ;
                }


                if ($check !== false){

                            $sql2 = "SELECT * FROM $table ORDER BY id DESC LIMIT 0,1";
                            $rss = rsQuery($sql2);
                            $num = mysqli_fetch_array($rss);
                            $lid = $num['id'];
                            $date = date("Y-m-d H:i:s");

                        for($i=0; $i<count($_FILES['frm_image']['name']); $i++){

                            $filename = $_FILES["frm_image"]["name"][$i];
                            $ext = end(explode(".",$filename));
                            $newname = $table.'_'.$lid.'_'.$i.'.'.$ext;
                            $filetmp = $_FILES["frm_image"]["tmp_name"][$i];
                            $filetype = $_FILES["frm_image"]["type"][$i];
                            $filepath = $part.$newname;

                            if (move_uploaded_file($filetmp,$filepath)) {

                                $sql = "INSERT INTO files_image(id,table_name,master_id,file_name,edit_time)
                                VALUES ('','".$table."','".$lid."','".$newname."','".$date."')";
                                $rs = rsQuery($sql);

                            } else {
                                echo "<script>alert('Image not upload.'); </script>";
                            }
                        }
                    }*/

  }
  ?>


<style>
    #map2 {
        height: 400px;
        width: 100%;
    }
</style>

<!-- Heading -->
  <div id="heading" >
    <h1><?php echo $modname; ?></h1>
  </div>

<!-- Main -->
  <section id="main" class="wrapper">
    <div class="inner">
      <div class="content">

        <div class="row">
          <div class="col-12 col-12-medium">

              <form method="post" action="#" onsubmit="return(validate());" name="myForm" enctype="multipart/form-data">
                <div class="row gtr-uniform">

                  <div class="col-12 col-12-xsmall">
                    <h3>ต้องการแจ้งเรื่อง</h3>
                  </div>
                  <div class="col-6 col-12-xsmall">
                    <input type="text" name="frm_subject" id="frm_subject" value="<?php echo $modname ?>" placeholder="เรื่อง" />
                  </div>
                  <div class="col-12 col-12-xsmall">
                    <h3>ข้อมูลผู้แจ้ง</h3>
                  </div>
                  <div class="col-6 col-12-xsmall">
                    <input type="text" name="frm_name" id="frm_name" value="" placeholder="ชื่อ-สกุล" />
                  </div>
                  <div class="col-6 col-12-xsmall">
                    <input type="text" name="frm_tel" id="frm_tel" value="" placeholder="โทรศัพท์" />
                  </div>
                  <div class="col-6 col-12-xsmall">
                    <input type="email" name="frm_email" id="frm_email" value="" placeholder="อีเมล" />
                  </div>
                  <div class="col-12 col-12-xsmall">
                    <h3>ที่อยู่</h3>
                  </div>
                  <div class="col-3 col-12-xsmall">
                    <select name="frm_province" id="frm_province">
                      <option value="">- จังหวัด -</option>
                    <?php
                      $sql = "SELECT * FROM province";
                      $rs = rsQuery($sql);
                      while ($row = mysqli_fetch_array($rs)) {
                        echo "<option value=".$row['PROVINCE_ID'].">".$row['PROVINCE_NAME']."</option>";
                      }
                    ?>
                    </select>
                  </div>
                  <div class="col-3 col-12-xsmall">
                    <select name="frm_amphur" id="frm_amphur">
                      <option value="">- อำเภอ -</option>
                    </select>
                  </div>
                  <div class="col-2 col-12-xsmall">
                    <select name="frm_district" id="frm_district">
                      <option value="">- ตำบล -</option>
                    </select>
                  </div>
                  <div class="col-2 col-12-xsmall">
                    <select name="frm_moo" id="frm_moo">
                      <option value="">- หมู่ที่ -</option>
                    <?php
                      for ($i=1; $i <= 10; $i++) {
                        echo "<option value=".$i.">".$i."</option>";
                      }
                    ?>
                    </select>
                  </div>
                  <!-- Break -->
                  <div class="col-2 col-12-xsmall">
                    <input type="text" name="frm_numhome" id="frm_numhome" value="" placeholder="บ้านเลขที่" />
                  </div>
                  <!-- Break -->


                  <!-- Break -->
                  <div class="col-12 col-12-xsmall">
                    <label>มีความประสงค์ให้<?php echo $customer_name; ?> ซ่อมแซมไฟฟ้าสาธารณะ</label>
                  </div>
                  <!-- Break -->

                  <!-- Break -->
                  <div class="col-3 col-12-xsmall">
                    <select name="frm_moo2" id="frm_moo2">
                      <option value="">- หมู่ที่ -</option>
                    <?php
                      for ($i=1; $i <= 10; $i++) {
                        echo "<option value=".$i.">".$i."</option>";
                      }
                    ?>
                    </select>
                  </div>
                  <!-- Break -->

                  <!-- Break -->
                  <div class="col-12 col-12-xsmall">
                    <label>รหัสเสาไฟฟ้า สถานที่หรือจุดอ้างอิง (กรณีไม่ทราบรหัสเสา)</label>
                  </div>
                  <!-- Break -->

                  <!-- Break -->
                  <div class="col-6 col-12-xsmall">
                    <input type="text" name="p1" id="p1" value="" placeholder="จุดที่ 1" />
                  </div>
                  <div class="col-6 col-12-xsmall">
                    <input type="text" name="p2" id="p2" value="" placeholder="จุดที่ 2" />
                  </div>
                  <div class="col-6 col-12-xsmall">
                    <input type="text" name="p3" id="p3" value="" placeholder="จุดที่ 3" />
                  </div>
                  <div class="col-6 col-12-xsmall">
                    <input type="text" name="p4" id="p4" value="" placeholder="จุดที่ 4" />
                  </div>
                  <div class="col-6 col-12-xsmall">
                    <input type="text" name="p5" id="p5" value="" placeholder="จุดที่ 5" />
                  </div>
                  <!-- Break -->

                  <!-- Break -->
                  <div class="col-12 col-12-xsmall">
                    <textarea  name="frm_details" id="frm_details" value="" placeholder="หมายเหตุ (รายละเอียดเพิ่มเติม)" ></textarea>
                  </div>
                  <!-- Break -->


                  <!-- Break -->
                  <div class="col-12 col-12-xsmall">
                    <label>รูปสถานที่ประกอบการแจ้ง </label>
                    <input type="file" name="frm_image[]" id="frm_image[]" multiple></input>
                  </div>
                  <!-- Break -->


                  <!-- Break -->
                  <div class="col-12 col-12-xsmall">
                    <label> พิกัดประกอบการแจ้ง</label>
                  </div>
                  <!-- Break -->
                  <div class="col-12 col-12-xsmall">
                    <div class="row">
                        <div class="col-4">
                        </div>
                        <div class="col-4">
                          <input class="form-control" type="text" name="mapsearch" placeholder="ค้นหาสถานที่" id="mapsearch">
                        </div>
                        <div class="col-4">
                        </div>
                      </div>
                    </div>

                    <div class="col-12 col-12-xsmall" style="padding: 0px; border: solid 1px; border-color: rgba(0, 0, 0, 0.25); margin: 10px 0px 10px 40px;">
                    <div id="map2"></div>
                  </div>
                  <!-- Break -->

                  <input type="hidden" name="frm_lat" id="frm_lat"/>
                  <input type="hidden" name="frm_lng" id="frm_lng"/>

                  <div class="col-12" >
                    <ul class="actions">
                      <li><input type="submit" name="Submit" value="Submit Form" class="primary" /></li>
                      <li><input type="reset" value="Reset" /></li>
                    </ul>
                  </div>
                </div>
              </form>


          </div>
        </div>

        </div>
    </div>
  </section>



  <script type = "text/javascript">

        function validate() {

          if( document.myForm.frm_subject.value == "" ) {
             alert( "กรุณากรอก เรื่องที่ต้องการแจ้ง!" );
             document.myForm.frm_subject.focus() ;
             return false;
          }
           if( document.myForm.frm_name.value == "" ) {
              alert( "กรุณากรอก ชื่อ-สกุล!" );
              document.myForm.frm_name.focus() ;
              return false;
           }
           if( document.myForm.frm_tel.value == "" ) {
              alert( "กรุณากรอก เบอร์โทรศัพท์ !" );
              document.myForm.frm_tel.focus() ;
              return false;
           }
           if( document.myForm.frm_email.value == "" ) {
              alert( "กรุณากรอก อีเมล!" );
              document.myForm.frm_email.focus() ;
              return false;
           }
           if( document.myForm.frm_province.value == "" ) {
              alert( "กรุณาเลือก จังหวัด!" );
              document.myForm.frm_province.focus() ;
              return false;
           }
           if( document.myForm.frm_amphur.value == "" ) {
              alert( "กรุณาเลือก อำเภอ!" );
              document.myForm.frm_amphur.focus() ;
              return false;
           }
           if( document.myForm.frm_district.value == "" ) {
              alert( "กรุณาเลือก ตำบล!" );
              document.myForm.frm_district.focus() ;
              return false;
           }
           if( document.myForm.frm_moo.value == "" ) {
              alert( "กรุณากรอก หมู่ที่!" );
              document.myForm.frm_moo.focus() ;
              return false;
           }
           if( document.myForm.frm_numhome.value == "" ) {
              alert( "กรุณากรอก บ้านเลขที่!" );
              document.myForm.frm_numhome.focus() ;
              return false;
           }


           if( document.myForm.frm_moo2.value == "" ) {
              alert( "กรุณาเลือก หมู่ที่ เกิดเหตุ!" );
              document.myForm.frm_moo2.focus() ;
              return false;
           }

           var p1 = document.myForm.p1.value;
           var p2 = document.myForm.p2.value;
           var p3 = document.myForm.p3.value;
           var p4 = document.myForm.p4.value;
           var p5 = document.myForm.p5.value;

           if( p1 == "" && p2 == "" && p3 == "" && p4 == "" && p5 == "" ) {
              alert( "กรุณากรอก รหัสเสา สถานที่หรือจุดอ้างอิง!" );
              document.myForm.p1.focus() ;
              return false;
           }
           if( document.myForm.frm_details.value == "" ) {
              alert( "กรุณากรอก รายละเอียด!" );
              document.myForm.frm_details.focus() ;
              return false;
           }


           return( true );
        }

  </script>


  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDg49SZLUZdLu8KQ80fEAPJkbdBUqyN-vw&callback=initMap&libraries=places" ></script>
  <script>
      function initMap(){
          myLatLng = {lat: <?php echo $lat_main; ?>, lng: <?php echo $lng_main; ?>};
          var map = new google.maps.Map(document.getElementById('map2'), {
              center: myLatLng,
              zoom: 15
          });

          var marker = new google.maps.Marker({
              position: myLatLng,
              map: map,
              draggable:true
          });

          google.maps.event.addListener(marker,'dragend',function () {
              var lat = marker.getPosition().lat();
              var lng = marker.getPosition().lng();

              document.getElementById("frm_lat").value = lat.toFixed(5);
              document.getElementById("frm_lng").value = lng.toFixed(5);

          });

          var searchBox = new google.maps.places.SearchBox(document.getElementById('mapsearch'));

          google.maps.event.addListener(searchBox, 'places_changed',function () {
              var places = searchBox.getPlaces();

              var bounds = new google.maps.LatLngBounds();
              var i, place;
              for(i=0;place=places[i];i++){
                  console.log(places);
                  bounds.extend(place.geometry.location);
                  marker.setPosition(place.geometry.location);
                  var item_lat = place.geometry.location.lat();
                  var item_lng = place.geometry.location.lng();
              }

              document.getElementById("frm_lat").value = item_lat.toFixed(5);
              document.getElementById("frm_lng").value = item_lng.toFixed(5);

              google.maps.event.addListener(marker,'dragend',function () {
                  var lat = marker.getPosition().lat();
                  var lng = marker.getPosition().lng();

                  document.getElementById("frm_lat").value = lat.toFixed(5);
                  document.getElementById("frm_lng").value = lng.toFixed(5);
              });

              map.fitBounds(bounds);
              map.setZoom(15);

          });
      }

  </script>



  <script src="js/jquery-3.3.1.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#frm_province').change(function() {
                    $.ajax({
                        type: 'POST',
                        data: {data: $(this).val()},
                        url: 'modules/test/select.php',
                        success: function(data) {
                            $('#frm_amphur').html(data);
                        }
                    });
                    return false;
                });

                $('#frm_amphur').change(function() {
                    $.ajax({
                        type: 'POST',
                        data: {data2: $(this).val()},
                        url: 'modules/test/select.php',
                        success: function(data) {
                            $('#frm_district').html(data);
                        }
                    });
                    return false;
                });

            });
        </script>
