<?php
  $modname=FindRS("select * from tb_mod where modtype='$mod'",modname);
  $modid=FindRS("select * from tb_mod where modtype='$mod'",modid);
  $table=FindRS("select * from tb_mod where modtype='$mod'",tablename);
  $folder =FindRS("select * from tb_mod where modtype='$mod'",foldername);

  $part = "fileupload/".$folder."/";

  if(isset($_POST['Submit'])) {

    /*$province=FindRS("SELECT * FROM province WHERE PROVINCE_ID=".$_POST['frm_province'],PROVINCE_NAME);
    $amphur=FindRS("SELECT * FROM amphur WHERE AMPHUR_ID=".$_POST['frm_amphur'],AMPHUR_NAME);
    $district=FindRS("SELECT * FROM district WHERE DISTRICT_ID=".$_POST['frm_district'],DISTRICT_NAME);
    $moo = $_POST['frm_moo'];
*/
      $check = getimagesize($_FILES["frm_image"]["tmp_name"][0]);

                  $sql = "INSERT INTO tb_waste(id,name,tel,email,province,amphur,district,moo,home,num_home1,typehome_id,num_home2,num_bin,lat,lng,post_ip,status,active)
                  Values('','" .$_POST['frm_name']. "','" .$_POST['frm_tel']. "','" .$_POST['frm_email']. "','" .$_POST['frm_province']. "','" .$_POST['frm_amphur']. "'
                    ,'" .$_POST['frm_district']. "','" .$_POST['frm_moo']. "','" .$_POST['frm_home1']. "'
                  ,'" .$_POST['frm_num_home1']. "','" .$_POST['type_home']. "','" .$_POST['frm_num_home2']. "','" .$_POST['frm_bin']. "'
                ,'" .$_POST['frm_lat']. "','" .$_POST['frm_lng']. "','" .$_SERVER['REMOTE_ADDR']. "','1','1')";
                  $rs = rsQuery($sql);


                  $sql2 = "SELECT * FROM $table ORDER BY id DESC LIMIT 0,1";
                  $rss = rsQuery($sql2);
                  $num = mysqli_fetch_array($rss);
                  $lid = $num['id'];
                  $date = date("Y-m-d H:i:s");
                  $receiveno = "100" . $lid;

                  $sql = "INSERT INTO tb_request(id,table_name,master_id,modid,receiveno,datein)
                  Values('','" .$table. "','" .$lid. "','" .$modid. "','" .$receiveno. "','" .$date. "')";
                  $rs = rsQuery($sql);

                  $sql = "INSERT INTO tb_notification(id,subject,detail,modid,master_id,allstatus,substatus)
                  Values('','" .$_POST['frm_name']. "','" .$modname. "','" .$modid. "','" .$lid. "','0','0')";
                  $rs = rsQuery($sql);

                  include_once("itgmod/sent_email.php");

                  if ($rs) {
                      echo "<script>alert('???????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????  ?????????????????????????????????????????????????????? : ".$receiveno."');window.location.href='index.php';</script>";
                  }else{
                      echo "<script>alert('Err'); </script>" ;
                }


                if ($check !== false){

                            $sql2 = "SELECT * FROM tb_waste ORDER BY id DESC LIMIT 0,1";
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
                    <h3>???????????????????????????????????????</h3>
                  </div>
                  <div class="col-6 col-12-xsmall">
                    <input type="text" name="frm_name" id="frm_name" value="" placeholder="????????????-????????????" />
                  </div>
                  <div class="col-6 col-12-xsmall">
                    <input type="text" name="frm_tel" id="frm_tel" value="" placeholder="????????????????????????" />
                  </div>
                  <div class="col-6 col-12-xsmall">
                    <input type="text" name="frm_email" id="frm_email" value="" placeholder="???????????????" />
                  </div>
                  <div class="col-12 col-12-xsmall">
                    <h3>?????????????????????</h3>
                  </div>
                  <div class="col-3 col-12-xsmall">
                    <select name="frm_province" id="frm_province">
                      <option value="">- ????????????????????? -</option>
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
                      <option value="">- ??????????????? -</option>
                    </select>
                  </div>
                  <div class="col-3 col-12-xsmall">
                    <select name="frm_district" id="frm_district">
                      <option value="">- ???????????? -</option>
                    </select>
                  </div>
                  <div class="col-3 col-12-xsmall">
                    <input type="text" name="frm_moo" id="frm_moo" value="" placeholder="?????????????????????" />
                  </div>
                  <!-- Break -->
                  <div class="col-12 col-12-xsmall">
                    <label>??????????????????????????????????????? ????????????????????????????????????????????????????????????????????????????????? <?php echo $customer_name; ?></label>
                  </div>
                  <!-- Break -->
                  <div class="col-2 col-12-small">
                    1. <input type="checkbox" value="1" id="frm_home1" name="frm_home1"/>
                    <label for="frm_home1">????????????</label>
                  </div>
                  <div class="col-2 col-12-small" style="padding-top:25px">
                    <select name="frm_num_home1" id="frm_num_home1">
                      <option value="">- ??????????????? -</option>
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
                    </select>
                  </div>
                  <div class="col-12 col-12-small" style="padding:0px"></div>
                  <div class="col-2 col-12-small">
                    2. <input type="radio" id="type_home1" value="1" name="type_home"/>
                    <label for="type_home1">????????????????????????</label>
                  </div>
                  <div class="col-2 col-12-small">
                    <input type="radio" id="type_home2" value="2" name="type_home"/>
                    <label for="type_home2">????????????????????????</label>
                  </div>
                  <div class="col-2 col-12-small">
                    <input type="radio" id="type_home3" value="3" name="type_home"/>
                    <label for="type_home3">??????????????????????????????</label>
                  </div>
                  <div class="col-2 col-12-small">
                    <input type="radio" id="type_home4" value="4" name="type_home"/>
                    <label for="type_home4">???????????????????????????</label>
                  </div>
                  <div class="col-2 col-12-small" style="padding-top:25px">
                    <select name="frm_num_home2" id="frm_num_home2">
                      <option value="">- ??????????????? -</option>
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
                    </select>
                  </div>
                  <!-- Break -->
                  <div class="col-4 col-12-xsmall">
                    <select name="frm_bin" id="frm_bin">
                      <option value="">- ????????????????????????????????? -</option>
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
                    </select>
                  </div>
                  <!-- Break -->
                  <div class="col-12 col-12-xsmall">
                    <label>???????????????????????????????????????????????????????????????????????????</label>
                    <input type="file" name="frm_image[]" id="frm_image[]" multiple></input>
                  </div>
                  <!-- Break -->



                  <div class="col-12 col-12-xsmall">
                    <div class="row">
                        <div class="col-4">
                        </div>
                        <div class="col-4">
                          <input class="form-control" type="text" name="mapsearch" placeholder="????????????????????????????????????" id="mapsearch">
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

           if( document.myForm.frm_name.value == "" ) {
              alert( "??????????????????????????? ????????????-????????????!" );
              document.myForm.frm_name.focus() ;
              return false;
           }
           if( document.myForm.frm_tel.value == "" ) {
              alert( "??????????????????????????? ??????????????????????????????????????? !" );
              document.myForm.frm_tel.focus() ;
              return false;
           }
           if( document.myForm.frm_email.value == "" ) {
              alert( "??????????????????????????? ???????????????!" );
              document.myForm.frm_email.focus() ;
              return false;
           }
           if( document.myForm.frm_province.value == "" ) {
              alert( "?????????????????????????????? ?????????????????????!" );
              document.myForm.frm_province.focus() ;
              return false;
           }
           if( document.myForm.frm_amphur.value == "" ) {
              alert( "?????????????????????????????? ???????????????!" );
              document.myForm.frm_amphur.focus() ;
              return false;
           }
           if( document.myForm.frm_district.value == "" ) {
              alert( "?????????????????????????????? ????????????!" );
              document.myForm.frm_district.focus() ;
              return false;
           }
           if( document.myForm.frm_moo.value == "" ) {
              alert( "??????????????????????????? ?????????????????????!" );
              document.myForm.frm_moo.focus() ;
              return false;
           }
           if( document.myForm.frm_bin.value == "" ) {
              alert( "??????????????????????????????????????? ?????????????????????????????????!" );
              document.myForm.frm_bin.focus() ;
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
