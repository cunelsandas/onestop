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

                  $sql = "INSERT INTO $table(id,name,tel,email,number,province,amphur,district,moo,num_home,start_date,end_date,for_work,location,lat,lng,post_ip,status,active)
                  Values('','" .$_POST['frm_name']. "','" .$_POST['frm_tel']. "','" .$_POST['frm_email']. "','" .$_POST['frm_number']. "','" .$_POST['frm_province']. "','" .$_POST['frm_amphur']. "'
                    ,'" .$_POST['frm_district']. "','" .$_POST['frm_moo']. "','" .$_POST['frm_numhome']. "'
                  ,'" .$_POST['frm_date_str']. "','" .$_POST['frm_date_end']. "','" .$_POST['frm_for']. "','" .$_POST['frm_location']. "'
                  ,'" .$_POST['frm_lat']. "','" .$_POST['frm_lng']. "','" .$_SERVER['REMOTE_ADDR']. "','1','1')";
                  $rs = rsQuery($sql);

                  $sql2 = "SELECT * FROM $table ORDER BY id DESC LIMIT 0,1";
                  $rss = rsQuery($sql2);
                  $num = mysqli_fetch_array($rss);
                  $lid = $num['id'];
                  $date = date("Y-m-d H:i:s");
                  $receiveno = "400" . $lid;

                for($i=0; $i<count($_POST['frm_ojb']); $i++){
                  $ojb_id = $_POST['frm_ojb'][$i];
                  $num_ojb = $_POST['frm_num'][$i];
                  $sql3 = "INSERT INTO tb_khruphan_obj(id,object_name,num_object,khruphan_id)
                  Values('','" .$ojb_id. "','" .$num_ojb. "','" .$lid. "')";
                  $rs = rsQuery($sql3);
                }

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
                      echo "<script>alert('มีข้อผิดพลาดในการส่งเรื่องค่ะ'); </script>" ;
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
                                echo "<script>alert('มีข้อผิดพลาดจากการอัพรูปภาพ.'); </script>";
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
                  <!-- Break -->
                  <div class="col-12 col-12-xsmall">
                    <h3>ข้อมูลผู้แจ้ง</h3>
                  </div>
                  <div class="col-6 col-12-xsmall">
                    <input type="text" name="frm_name" id="frm_name" value="" placeholder="ชื่อ-สกุล" />
                  </div>
                  <div class="col-6 col-12-xsmall">
                    <input type="text" name="frm_tel" id="frm_tel" value="" placeholder="โทรศัพท์" onkeyup="autoTab2(this,2)"/>
                  </div>
                  <div class="col-6 col-12-xsmall">
                    <input type="email" name="frm_email" id="frm_email" value="" placeholder="อีเมล" />
                  </div>
                  <!-- Break -->
                  <!-- Break -->
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
                    <input type="text" name="frm_moo" id="frm_moo" value="" placeholder="หมู่ที่" />
                  </div>
                  <div class="col-2 col-12-xsmall">
                    <input type="text" name="frm_numhome" id="frm_numhome" value="" placeholder="บ้านเลขที่" />
                  </div>
                  <!-- Break -->

                  <!-- Break -->
                  <div class="col-6 col-12-xsmall">
                    <label>เลขบัตรประชาชน</label>
                    <input type="text" name="frm_number" id="frm_number" placeholder="เลขบัตรประชาชน" onKeyPress="CheckNum()" onkeyup="autoTab2(this,1)"></input>
                  </div>
                  <div class="col-6 col-12-xsmall">
                    <label>แนบไฟล์บัตรประชาชน</label>
                    <input type="file" name="frm_image[]" id="frm_image[]" ></input>
                  </div>
                  <!-- Break -->

                  <!-- Break -->
                  <div class="col-12 col-12-xsmall">
                    <label>มีความประสงค์ขอยืมครุภัณฑ์ ประเภท</label>
                  </div>
                  <div class="col-4 col-12-small">
                      <select name="frm_ojb[0]" id="frm_ojb[0]">
                        <option value="">- กรุณาเลือก -</option>
                      <?php
                        $sql = "SELECT * FROM tb_object";
                        $rs = rsQuery($sql);
                        while ($row = mysqli_fetch_array($rs)) {
                          echo "<option value=".$row['object'].">".$row['object']."</option>";
                        }
                      ?>
                      </select>
                  </div>
                  <div class="col-2 col-12-xsmall">
                    <input type="text" name="frm_num[0]" id="frm_num[0]" placeholder="จำนวน"/>
                  </div>
                  <div class="col-12 col-12-small" style="padding:0px"></div>

                  <div class="col-4 col-12-small">
                    <select name="frm_ojb[1]" id="frm_ojb[1]">
                      <option value="">- กรุณาเลือก -</option>
                    <?php
                      $sql = "SELECT * FROM tb_object";
                      $rs = rsQuery($sql);
                      while ($row = mysqli_fetch_array($rs)) {
                        echo "<option value=".$row['object'].">".$row['object']."</option>";
                      }
                    ?>
                    </select>
                  </div>
                  <div class="col-2 col-12-xsmall">
                    <input type="text" name="frm_num[1]" id="frm_num[1]" placeholder="จำนวน"/>
                  </div>
                  <div class="col-12 col-12-small" style="padding:0px"></div>

                  <div class="col-4 col-12-small">
                    <input type="text" name="frm_ojb[2]" id="frm_ojb[2]" placeholder="อื่น ๆ"/>
                  </div>
                  <div class="col-2 col-12-xsmall">
                    <input type="text" name="frm_num[2]" id="frm_num[2]" placeholder="จำนวน"/>
                  </div>
                  <div class="col-12 col-12-small" style="padding:0px"></div>
                  <!-- Break -->


                  <!-- Break -->
                  <div class="col-12 col-12-small" style="padding:0px"></div>
                  <div class="col-6 col-12-xsmall">
                    <label>วันที่มารับ</label>
                    <input type="date" name="frm_date_str" id="frm_date_str" value="<?php echo date("Y-m-j"); ?>"/>
                  </div>
                  <div class="col-6 col-12-xsmall">
                    <label>วันที่นำส่งคืน</label>
                    <input type="date" name="frm_date_end" id="frm_date_end" />
                  </div>
                  <!-- Break -->

                  <!-- Break -->
                  <div class="col-6 col-12-xsmall">
                    <input type="text" name="frm_for" id="frm_for" placeholder="เพื่อนำไปใช้ในงาน"/>
                  </div>
                  <div class="col-6 col-12-xsmall">
                    <input type="text" name="frm_location" id="frm_location" placeholder="จัดอยู่ที่"/>
                  </div>
                  <!-- Break -->




                  <!-- Break -->
                  <div class="col-12 col-12-xsmall">
                    <h3>แผนที่จัดงาน</h3>
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

                  <!-- Break -->
                  <input type="hidden" name="frm_lat" id="frm_lat"/>
                  <input type="hidden" name="frm_lng" id="frm_lng"/>
                  <!-- Break -->


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

        function checkID(id) {
        var cid = id.replace(/-/g, '');
        if(cid.length != 13) return false;
        for(i=0, sum=0; i < 12; i++)
        sum += parseFloat(cid.charAt(i))*(13-i); if((11-sum%11)%10!=parseFloat(cid.charAt(12)))
        return false; return true;
      }

        function validate() {

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
           if( document.myForm.frm_number.value == "" ) {
              alert( "กรุณากรอก เลขบัตรประชาชน!" );
              document.myForm.frm_number.focus() ;
              return false;
           }else {
             if(!checkID(document.myForm.frm_number.value)){
             alert('รหัสประชาชนไม่ถูกต้อง');
             document.myForm.frm_number.focus() ;
             return false;
           }
           }
           if( document.myForm.frm_date_str.value == "" ) {
              alert( "กรุณาเลือก วันที่มารับ!" );
              document.myForm.frm_date_str.focus() ;
              return false;
           }
           if( document.myForm.frm_date_end.value == "" ) {
              alert( "กรุณาเลือก วันที่นำส่งคืน!" );
              document.myForm.frm_date_end.focus() ;
              return false;
           }
           if( document.myForm.frm_for.value == "" ) {
              alert( "กรุณากรอก จุดประสงค์ในการใช้งาน!" );
              document.myForm.frm_for.focus() ;
              return false;
           }
           if( document.myForm.frm_location.value == "" ) {
              alert( "กรุณากรอก สถานที่ในการรับบริการ!" );
              document.myForm.frm_location.focus() ;
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


        <!-- รหัสบัตรประชาชน -->
            <script type="text/javascript">
            function autoTab2(obj,typeCheck){
                /* กำหนดรูปแบบข้อความโดยให้ _ แทนค่าอะไรก็ได้ แล้วตามด้วยเครื่องหมาย
                หรือสัญลักษณ์ที่ใช้แบ่ง เช่นกำหนดเป็น  รูปแบบเลขที่บัตรประชาชน
                4-2215-54125-6-12 ก็สามารถกำหนดเป็น  _-____-_____-_-__
                รูปแบบเบอร์โทรศัพท์ 08-4521-6521 กำหนดเป็น __-____-____
                หรือกำหนดเวลาเช่น 12:45:30 กำหนดเป็น __:__:__
                ตัวอย่างข้างล่างเป็นการกำหนดรูปแบบเลขบัตรประชาชน
                */
                    if(typeCheck==1){
                        var pattern=new String("_-____-_____-__-_"); // กำหนดรูปแบบในนี้
                        var pattern_ex=new String("-"); // กำหนดสัญลักษณ์หรือเครื่องหมายที่ใช้แบ่งในนี้    
                    }else{
                        var pattern=new String("___-___-____"); // กำหนดรูปแบบในนี้
                        var pattern_ex=new String("-"); // กำหนดสัญลักษณ์หรือเครื่องหมายที่ใช้แบ่งในนี้                
                    }
                    var returnText=new String("");
                    var obj_l=obj.value.length;
                    var obj_l2=obj_l-1;
                    for(i=0;i<pattern.length;i++){          
                        if(obj_l2==i && pattern.charAt(i+1)==pattern_ex){
                            returnText+=obj.value+pattern_ex;
                            obj.value=returnText;
                        }
                    }
                    if(obj_l>=pattern.length){
                        obj.value=obj.value.substr(0,pattern.length);          
                    }
            }
         
            function CheckNum(){
                    if (event.keyCode < 48 || event.keyCode > 57){
                          event.returnValue = false;
                        }
                }
            </script>
