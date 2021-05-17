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

$sqlm = "SELECT * FROM tb_request ORDER BY id DESC";


if(isset($_POST['btn_search'])) {

  if ($_POST['frm_type'] != "" && $_POST['date_str'] == "" && $_POST['date_end'] == "") {

    $sqlm = "SELECT * FROM tb_request WHERE modid = ".$_POST['frm_type']." ORDER BY id DESC";

  }elseif ($_POST['frm_type'] != "" && $_POST['date_str'] != "" && $_POST['date_end'] == "") {

    $sqlm = "SELECT * FROM tb_request WHERE modid = ".$_POST['frm_type']." AND datein LIKE '".$_POST['date_str']."%'  ORDER BY id DESC";

  }elseif ($_POST['frm_type'] != "" && $_POST['date_str'] != "" && $_POST['date_end'] != "") {

    $sqlm = "SELECT * FROM tb_request WHERE modid = ".$_POST['frm_type']." AND datein BETWEEN '".$_POST['date_str']."%' AND '".$_POST['date_end']."%'  ORDER BY id DESC";

  }elseif ($_POST['frm_type'] == "" && $_POST['date_str'] != "" && $_POST['date_end'] == "") {

    $sqlm = "SELECT * FROM tb_request WHERE datein LIKE '".$_POST['date_str']."%' ORDER BY id DESC";

  }elseif ($_POST['frm_type'] == "" && $_POST['date_str'] != "" && $_POST['date_end'] != "") {

    $sqlm = "SELECT * FROM tb_request WHERE datein BETWEEN '".$_POST['date_str']."%' AND '".$_POST['date_end']."%'  ORDER BY id DESC";

  }

}elseif (isset($_POST['btn_default'])) {

  $sqlm = "SELECT * FROM tb_request ORDER BY id DESC";

}

$rsm = rsQuery($sqlm);
$num = mysqli_num_rows($rsm);
$n=1;

?>

<style>
    #map2 {
        height: 400px;
        width: 100%;
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

<div class="content" name="content">
    <div class="col-md-12">
      <h1><?php echo $modname; ?></h1>
      <div class="panel panel-default">
        <div class="panel-body">

      <form name="frm_search" method="post" action="#" enctype="multipart/form-data">

          <div  class="col-md-12 col-sm-12">
          <div  class="col-md-6 col-sm-6"></div>
          <div  class="col-md-3 col-sm-3" style="padding: 10px">
            <select class="form-control" name="frm_type" id="frm_type">
              <option value="">- ประเภท -</option>
              <?php $sql = "SELECT * FROM tb_mod WHERE groupid = 1 ORDER BY listno";
              $rs = rsQuery($sql);
              while ($row = mysqli_fetch_array($rs)) {
                echo '<option value='.$row['modid'].'>'.$row['modname'].'</option>';
              }
              ?>
            </select>
          </div>
          <div  class="col-md-3 col-sm-3" style="padding: 10px">
            <select class="form-control" name="frm_status" id="frm_status">
              <option value="">- สถานะ -</option>
              <?php $sql = "SELECT * FROM tb_status ORDER BY id";
              $rs = rsQuery($sql);
              while ($row = mysqli_fetch_array($rs)) {
                echo '<option value='.$row['id'].'>'.$row['status'].'</option>';
              }
              ?>
            </select>
          </div>
          </div>

          <div  class="col-md-12 col-sm-12">
            <div  class="col-md-6 col-sm-6"></div>

              <div class="form-group col-md-3 col-sm-3">
                <label for="date_str">ระหว่างวันที่:</label>
                <input type="date" name="date_str" class="form-control" id="date_str">
              </div>
              <div class="form-group col-md-3 col-sm-3">
                <label for="date_end">ถึง:</label>
                <input type="date" name="date_end" class="form-control" id="date_end">
              </div>
          </div>
      <div  class="col-md-12 col-sm-12" style="margin-bottom: 20px; text-align:right;">
        <div  class="col-md-9 col-sm-9"></div>
        <div class="form-group col-md-2 col-sm-2">
          <input class="btn btn-default" type="submit" name="btn_default" id="btn_default" value="ดูข้อมูลทั้งหมด">
        </div>
        <div class="form-group col-md-1 col-sm-1">
          <input class="btn btn-success" type="submit" name="btn_search" id="btn_search" value="ค้นหา">
        </div>
        </div>
        </form>


        <div  class="col-md-12">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>ชื่อผู้แจ้ง</th>
                    <th>ประเภทคำร้อง</th>
                    <th>สถานะการดำเนินงาน</th>
                    <th>วันที่แจ้ง</th>
                    <th>###</th>
                </tr>
                </thead>
                <tbody>
              <?php

              $data = array();
              $arrCol = array();

                  while ($row = mysqli_fetch_array($rsm)) {

                    $sqll = "SELECT * FROM ".$row['table_name']." WHERE id =".$row['master_id'];

                    if ($_POST['frm_status'] != "") {
                      $sqll = "SELECT * FROM ".$row['table_name']." WHERE id = ".$row['master_id']." AND status = ".$_POST['frm_status'];
                    }

                    $rss = rsQuery($sqll);
                    $roww = mysqli_fetch_array($rss);

                    if ($roww['id'] != "") {

                    $status = FindRS("SELECT * FROM tb_status WHERE id=".$roww['status'],"status");
                    $modname = FindRS("SELECT * FROM tb_mod WHERE modid=".$row['modid'],"modname");
                    $modtype = FindRS("SELECT * FROM tb_mod WHERE modid=".$row['modid'],"modtype");
                    $color = FindRS("SELECT * FROM tb_mod WHERE modid=".$row['modid'],"color");
                    $modid = $row['modid'];

                    $arrCol[modid] = $modid;
                    $arrCol[modname] = $modname;
                    $arrCol[modtype] = $modtype;
                    $arrCol[master_id] = $roww['id'];
                    $arrCol[name] = $roww['name'];
                    $arrCol[tel] = $roww['tel'];
                    $arrCol[email] = $roww['email'];
                    $arrCol[lat] = $roww['lat'];
                    $arrCol[lng] = $roww['lng'];
                    $arrCol[status] = $status;
                  array_push($data,$arrCol);

                  if ($roww['status'] == 1) {
                    $rowcolor = "#FEE2CB";
                  }elseif ($roww['status'] == 2) {
                    $rowcolor = "#B1F9BF";
                  }else {
                    $rowcolor = "#FFFFFF";
                  }

                    echo '<tr style="background-color:'.$rowcolor.'">
                            <td>'.$n.'</td>
                            <td>'.$roww['name'].'</td>
                            <td>'.$modname.'</td>
                            <td>'.$status.'</td>
                            <td>'.$row["datein"].'</td>
                            <td style="text-align:center;">
                                <a class="btn btn-success" href="main.php?_mod='.$modtype.'&_modid='.$modid.'&type=View&id='.$row["master_id"].'"><i class="fas fa-eye"></i></a>
                            </td>
                          </tr>';


                            $lat[$n] = $roww['lat'];
                            $lng[$n] =$roww['lng'];

                          $n++;
                  }

                }


                ?>


                </tbody>
            </table>
        </div>

</div>
</div>
    </div>

    <div class="col-md-12">
      <div style="margin:20px 0px 20px 0px; border: 1px solid #ddd;">
        <div id="map2"></div>
      </div>
    </div>

    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="col-md-6">
            <p>คำร้องจัดเก็บขยะมูลฝอย : <img src="images/marker/black.png" /></p>
            <p>คำร้องขอสนับสนุนน้ำอุปโภค-บริโภค : <img src="images/marker/cyan.png" /></p>
            <p>ยืมครุภัณฑ์ : <img src="images/marker/green.png" /></p>
            <p>ร้องเรียนร้องทุกข์ : <img src="images/marker/orange.png" /></p>
          </div>
          <div class="col-md-6">
            <p>คำร้องขออนุญาตโฆษณา : <img src="images/marker/pink.png" /></p>
            <p>แจ้งไฟฟ้าชำรุด : <img src="images/marker/red.png" /></p>
            <p>แจ้งสาธารณูปโภคชำรุด : <img src="images/marker/yellow.png" /></p>
            <p>คำร้องขอตัดต้นไม้ : <img src="images/marker/pea.png" /></p>
          </div>
        </div>
      </div>
    </div>


<?php

if(!isset($_POST['btn_search'])) {
  echo '<div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="col-md-12">
          <canvas id="pie-chart" ></canvas>
        </div>
      </div>
    </div>
  </div>';
}

?>



</div>

<script>

var width = screen.width;
var height = screen.height;

if (width < "480") {
  document.getElementById('pie-chart').setAttribute('width', '100');
  document.getElementById('pie-chart').setAttribute('height', '100');
}else if (width < "980") {
  document.getElementById('pie-chart').setAttribute('width', '200');
  document.getElementById('pie-chart').setAttribute('height', '200');
}else{
  document.getElementById('pie-chart').setAttribute('width', '800');
  document.getElementById('pie-chart').setAttribute('height', '350');
}

 //document.getElementById('pie-chart').setAttribute('width', '800')

</script>


<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDg49SZLUZdLu8KQ80fEAPJkbdBUqyN-vw&callback=initMap&libraries=places" ></script>
<script>
    function initMap(){
        myLatLng = {lat: 18.76991, lng: 98.97723};
        var map = new google.maps.Map(document.getElementById('map2'), {
            center: myLatLng,
            zoom: 18
        });

        var infowindow = new google.maps.InfoWindow();
        var marker;


        <?php

              for ($i=0; $i < count($lat) ; $i++) {

                if ($data[$i][modid] == "64") {
                  $locolor = "black";
                }elseif ($data[$i][modid] == "67") {
                  $locolor = "cyan";
                }elseif ($data[$i][modid] == "68") {
                  $locolor = "green";
                }elseif ($data[$i][modid] == "69") {
                  $locolor = "orange";
                }elseif ($data[$i][modid] == "71") {
                  $locolor = "pea";
                }elseif ($data[$i][modid] == "70") {
                  $locolor = "pink";
                }elseif ($data[$i][modid] == "72") {
                  $locolor = "red";
                }elseif ($data[$i][modid] == "73") {
                  $locolor = "yellow";
                }/*elseif ($data[$i][modid] == "67") {
                  $locolor = "purple";
                }*/

                if ($data[$i][lat] != "") {
                  echo 'marker = new google.maps.Marker({
                    position: new google.maps.LatLng('.$data[$i][lat].','.$data[$i][lng].'),
                    map: map,
                    icon: {
                        url: "images/marker/'.$locolor.'.png"
                      }
                    });';

          ?>
            google.maps.event.addListener(marker, 'click', (
              function(marker) {
                return function() {

                  /*if(locations[i].type == "Food"){
                      marker.setIcon("url");
                  }else if(locations[i].type == "Shopping"){
                      marker.setIcon("url");
                  }*/

                  infowindow.setContent('<div id="content">'+
                    '<div id="siteNotice">'+
                    '</div>'+
                    '<h3 id="firstHeading" class="firstHeading"><?php echo $data[$i][modname]; ?></h3>'+
                    '<div id="bodyContent">'+
                    '<p><b>ผู้แจ้ง : <?php echo $data[$i][name]; ?></b>, Tel: <?php echo $data[$i][tel]; ?>, E-mail: <?php echo $data[$i][email]; ?></p>'+
                    '<p>Link: <a href="main.php?_mod=<?php echo $data[$i][modtype]; ?>&_modid=<?php echo $data[$i][modid]; ?>&type=View&id=<?php echo $data[$i][master_id];?>">'+
                    'รายละเอียดเพิ่มเติม</a></p>'+
                    '</div>'+
                    '</div>');
                infowindow.open(map, marker);
                }
            }
      )
        (marker));


          <?php
          }
        }
          ?>




        google.maps.event.addListener(marker,'dragend',function () {
            var lat = marker.getPosition().lat();
            var lng = marker.getPosition().lng();

            document.getElementById("frm_lat").value = lat.toFixed(5);
            document.getElementById("frm_lng").value = lng.toFixed(5);

        });


    }


</script>

<script>

<?php

  $advt = 0;
  $ask = 0;
  $electric = 0;
  $help_maps = 0;
  $infrastructure = 0;
  $khruphan = 0;
  $tree = 0;
  $waste = 0;
  $water = 0;

      for ($i=0; $i < count($data) ; $i++) {

        switch ($data[$i][modtype]) {
          case 'advt':
            $advt++;
            break;

            case 'ask':
              $ask++;
              break;

              case 'electric':
                $electric++;
                break;

                case 'helpme_map':
                  $help_maps++;
                  break;

                  case 'infrastructure':
                    $infrastructure++;
                    break;

                    case 'khruphan':
                     $khruphan++;
                      break;

                      case 'tree':
                       $tree++;
                        break;

            case 'waste':
              $waste++;
              break;

              case 'water':
                $water++;
                break;



          default:
            // code...
            break;
        }

      }

?>

new Chart(document.getElementById("pie-chart"), {
      type: 'pie',
      data: {
        labels: ["คำร้องขออนุญาตโฆษณา", "คำขอข้อมูลข่าวสาร", "แจ้งไฟฟ้าชำรุด", "ร้องเรียนร้องทุกข์", "แจ้งสาธารณูปโภคชำรุด"
      , "ยืมครุภัณฑ์", "คำร้องขอตัดต้นไม้", "คำร้องจัดเก็บขยะมูลฝอย", "คำร้องขอสนับสนุนน้ำอุปโภค-บริโภค"],
        datasets: [{
          label: "Population (millions)",
          backgroundColor: ["#ffb3e6", "#eeccff","#ff8080","#ffcc80","#ffffb3","#00b300","#99ff99","#d9d9d9","#ccffff"],
          data: [<?php echo $advt.",".$ask.",".$electric.",".$help_maps.",".$infrastructure.",".$khruphan.",".$tree.",".$waste.",".$water; ?>]
        }]
      },
      options: {
        title: {
          display: true,
          text: 'สถิติการยื่นคำร้องของประชาชน'
        }
      }
  });

</script>
