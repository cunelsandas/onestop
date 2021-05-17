<?php
  $modname=FindRS("select * from tb_mod where modtype='$mod'",modname);

  if(isset($_POST['Submit'])) {
      $check = getimagesize($_FILES["frm_image"]["tmp_name"][0]);

      if ($check !== false){
        echo "<script>alert('IMG'); </script>" ;
              /*for($i=0; $i<count($_FILES['f_image']['name']); $i++){

                  $filename = $_FILES["frm_image"]["name"][$i];
                  $ext = end(explode(".",$filename));
                  $newname = "Help_Im_".$_POST['id'].'_'.$i.'.'.$ext;
                  $filetmp = $_FILES["frm_image"]["tmp_name"][$i];
                  $filetype = $_FILES["frm_image"]["type"][$i];
                  $filepath = "fileupload/im_help/".$newname;

                  if (move_uploaded_file($filetmp,$filepath)) {

                      $sql = "INSERT INTO tb_files_image(id_image,image_path,image_key) VALUES ('','".$filepath."','".$_POST['f_key']."')";
                      $rs = rsQuery($sql);
                  } else {
                      echo "<script>alert('Image not upload.'); </script>";
                  }
              }

          $sql = "INSERT INTO tb_help_maps(id,subject,detail,result,lat,lng,postby,address,email,datepost,ip,typewb,status,updatetime,image_key) Values('','" .$_POST['f_subject']. "','" .$_POST['f_detail']. "','','" .$_POST['f_lat']. "','" .$_POST['f_lng']. "','" .$_POST['f_name']. "','" .$_POST['f_address']. "','" .$_POST['f_email']. "','" .$_POST['f_dateInput']. "','" .$_SERVER['REMOTE_ADDR']. "','1','1','0','".$_POST['f_key']."')";
          $rs = rsQuery($sql);
              if ($rs) {
                  echo "<script>alert('เรื่องของคุณได้ถูกส่งไปยังผุ้ที่เกี่ยวข้องแล้วค่ะ');window.location.href='index.php?_mod=" . $_GET['_mod'] . "';</script>";

              }else{
                  echo "<script>alert('Err2'); </script>" ;
              }*/
          }else{
            echo "<script>alert('NOT IMG'); </script>" ;
                  $sql = "INSERT INTO tb_waste(id,name,tel,email,address,home,num_home1,typehome_id,num_home2,num_bin,lat,lng,status,active)
                  Values('','" .$_POST['f_subject']. "','" .$_POST['f_detail']. "','Result','" .$_POST['f_lat']. "','" .$_POST['f_lng']. "'
                    ,'" .$_POST['f_name']. "','" .$_POST['f_dateInput']. "','" .$_SERVER['REMOTE_ADDR']. "','2','2','0')";
                  $rs = rsQuery($sql);
                  if ($rs) {
                      echo "<script>alert('เรื่องของคุณได้ถูกส่งไปยังผุ้ที่เกี่ยวข้องแล้วค่ะ');window.location.href='index.php?_mod=" . $_GET['_mod'] . "';</script>";
                  }else{
                      echo "<script>alert('Err'); </script>" ;
                }
          }
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

              <form method="post" action="#" enctype="multipart/form-data">
                <div class="row gtr-uniform">
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
                    <input type="text" name="frm_email" id="frm_email" value="" placeholder="อีเมล" />
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
                      <option value="alpha">Option alpha</option>
                      <option value="beta">Option beta</option>
                    </select>
                  </div>
                  <div class="col-3 col-12-xsmall">
                    <select name="frm_district" id="frm_district">
                      <option value="">- ตำบล -</option>
                      <option value="alpha">Option alpha</option>
                      <option value="beta">Option beta</option>
                    </select>
                  </div>
                  <div class="col-3 col-12-xsmall">
                    <input type="text" name="frm_moo" id="frm_moo" value="" placeholder="หมู่ที่" />
                  </div>
                  <!-- Break -->
                  <div class="col-12 col-12-xsmall">
                    <label>มีความประสงค์ ขอรับบริการจัดเก็บขยะมูบฝอย เทศบาล.....</label>
                  </div>
                  <!-- Break -->
                  <div class="col-2 col-12-small">
                    1. <input type="checkbox" id="frm_home1" name="frm_home1"/>
                    <label for="frm_home1">บ้าน</label>
                  </div>
                  <div class="col-2 col-12-small" style="padding-top:25px">
                    <select name="frm_num_home1" id="frm_num_home1">
                      <option value="">- จำนวน -</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                      <option value="8">8</option>
                      <option value="9">9</option>
                      <option value="10">10</option>
                      <option value="11">11</option>
                      <option value="12">12</option>
                    </select>
                  </div>
                  <div class="col-12 col-12-small" style="padding:0px"></div>
                  <div class="col-2 col-12-small">
                    2. <input type="radio" id="type_home1" name="type_home"/>
                    <label for="type_home1">ห้องเช่า</label>
                  </div>
                  <div class="col-2 col-12-small">
                    <input type="radio" id="type_home2" name="type_home"/>
                    <label for="type_home2">บ้านเช่า</label>
                  </div>
                  <div class="col-2 col-12-small">
                    <input type="radio" id="type_home3" name="type_home"/>
                    <label for="type_home3">บ้านจัดสรร</label>
                  </div>
                  <div class="col-2 col-12-small">
                    <input type="radio" id="type_home4" name="type_home"/>
                    <label for="type_home4">อพาทเมนต์</label>
                  </div>
                  <div class="col-2 col-12-small" style="padding-top:25px">
                    <select name="frm_num_home2" id="frm_num_home2">
                      <option value="">- จำนวน -</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                      <option value="8">8</option>
                      <option value="9">9</option>
                      <option value="10">10</option>
                      <option value="11">11</option>
                      <option value="12">12</option>
                    </select>
                  </div>
                  <!-- Break -->
                  <div class="col-4 col-12-xsmall">
                    <select name="frm_bin" id="frm_bin">
                      <option value="">- จำนวนถังขยะ -</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                      <option value="8">8</option>
                      <option value="9">9</option>
                      <option value="10">10</option>
                      <option value="11">11</option>
                      <option value="12">12</option>
                    </select>
                  </div>
                  <!-- Break -->
                  <div class="col-12 col-12-xsmall">
                    <label>รูปภาพที่จะนำถังขยะไปตั้ง</label>
                    <input type="file" name="frm_image[]" id="frm_image[]" multiple></input>
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

                    <div class="col-12 col-12-xsmall">
                    <div id="map2"></div>
                  </div>
                  <!-- Break -->

                  <div class="col-2 col-12-small">
                    <input type="checkbox" id="active" name="active"/>
                    <label for="active">Active</label>
                  </div>
                  <!-- Break -->

                  <input type="text" name="frm_lat" id="frm_lat"/>
                  <input type="text" name="frm_lng" id="frm_lng"/>

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


  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDg49SZLUZdLu8KQ80fEAPJkbdBUqyN-vw&callback=initMap&libraries=places" ></script>
  <script>
      function initMap(){
          myLatLng = {lat: 18.76991, lng: 98.97723};
          var map = new google.maps.Map(document.getElementById('map2'), {
              center: myLatLng,
              zoom: 18
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
