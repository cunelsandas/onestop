<html>
<head>
    <title> คำร้องทุกข์ออนไลน์ </title>
    <meta name="Generator" content="EditPlus">
    <meta name="Author" content="">
    <meta name="Keywords" content="">
    <meta name="Description" content="">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <style>



        @import url(../../../font/thsarabunnew.css);
        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        hr {
  display: block;
  margin-top: 0.5em;
  margin-bottom: 0.5em;
  margin-left: auto;
  margin-right: auto;
  border-style: inset;
  border-width: 1px;
}


        .page {
            font-family:THSarabunNew,THBaijam,THK2DJuly8,THChakraPetch,THNiramitAS,Tahoma ,sans-serif;
            font-size:12px;
            width: 21cm;
            min-height: 29.7cm;
            padding: 2cm;
            margin: 1cm auto;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);

        }
        .subpage {

            padding: 0.5cm;

            height: 245mm;
            outline: 2cm;
            background:url("../../images/krut.jpg") no-repeat top center;
        }
        #thfont {
            font-family: THSarabunNew,Tahoma ,sans-serif;

        }
        #thfont table td{
            font-size:12px;
        }

        @page {

            size: A4;
            margin: 0;
        }
        @media print {


            .page {
                font-family:THSarabunNew,THBaijam,THK2DJuly8,THChakraPetch,THNiramitAS,Tahoma ,sans-serif;
                font-size:12px;
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
            .subpage {

                padding: 0.5cm;

                height: 240mm;
                outline: 2cm;
                /*background:url("http://www.sunpukwan.go.th/images/krut.jpg") no-repeat top center; */
            }
            #thfont {
                font-family:THSarabunNew,THBaijam,THK2DJuly8,THChakraPetch,THNiramitAS,Tahoma ,sans-serif;
                font-size:12px;
            }
            #thfont table td{
                font-size:12px;
            }
        }

    </style>
</head>
<body>

<?php
session_start();

include_once ("../../../itgmod/connect.php");


if (!isset($_GET['id'])) {
    echo "ไม่พบเลขที่คำร้อง ไม่สามารถแสดงผลได้";
    exit();
}

$code=trim($_GET['id']);
$result=rsQuery("Select * from tb_khruphan Where id=$code");
if (!$result) {
    echo "ไม่พบคำร้องเลขที่ ". $code;
}
else {

    $row = mysqli_fetch_assoc($result);

    // ออกเอกสารเป็นไอ.ที.โกลโบล อัพเดท status_print
    $receiveno = FindRS("SELECT * FROM tb_request WHERE table_name='tb_khruphan' AND master_id = '$code'",receiveno);
    $datein = FindRS("SELECT * FROM tb_request WHERE table_name='tb_khruphan' AND master_id = '$code'",datein);


    $id="คำร้องออนไลน์เลขที่ ".$row['id'];
    $datepost=DateThai($datein);
    $name=$row['name'];
    $tel=$row['tel'];
    $email=$row['email'];

    $home_type1=$row['home'];
    $home_type2=$row['typehome_id'];

    $home_type1 = $row['type_objact1'];
    if ($home_type1 == "1") {
      $chack1 = "../../images/icons/checked.png";
    }else {
      $chack1 = "../../images/icons/unchecked.png";
    }
    $home_type2 = $row['type_objact2'];
    if ($home_type2 == "1") {
      $chack2 = "../../images/icons/checked.png";
    }else {
      $chack2 = "../../images/icons/unchecked.png";
}
    $datework = DateThai($row['date']);
//------------------------------------------------------------------
    $province=FindRS("SELECT * FROM province WHERE PROVINCE_ID=".$row['province'],PROVINCE_NAME);
    $amphur=FindRS("SELECT * FROM amphur WHERE AMPHUR_ID=".$row['amphur'],AMPHUR_NAME);
    $district=FindRS("SELECT * FROM district WHERE DISTRICT_ID=".$row['district'],DISTRICT_NAME);
    $moo = $row['moo'];
    $numhome = $row['num_home'];

    $addrass = "บ้านเลขที่ ".$numhome." หมู่ที่ ".$moo." ตำบล ".$district." อำเภอ ".$amphur." จังหวัด ".$province;
    $addrass2 = " ตำบล ".$district." อำเภอ ".$amphur." จังหวัด ".$province;

//------------------------------------------------------------------

    $lat =$row['lat'];
    $lng =$row['lng'];

    $detail= "ข้าพเจ้า ".$name." อยู่".$addrass." หมายเลขโทรศัพท์ ".$row['tel']." &nbsp;อีเมล ".$row['email']."";

};


echo '<div class="page">
							<div>
							<div id="thfont">
							<table height="100%" width="100%" border="0">
								<tr>
								<td valign="top" width="100%" height="100%">
								<table width="100%" border="0">
								<caption style="padding: 20px"><h3> คำร้องขอยืมครุภัณฑ์ </h3></caption>
								<tr>
									<td width="50%"></td><td style="padding: 10px 0px 10px 0px;" align="right">'.$datepost.'</td>
								</tr>

								<tr>
									<td colspan="2">เรื่อง&nbsp;&nbsp;&nbsp;&nbsp; ขอยืมครุภัณฑ์ </td>
								</tr>
								<tr>
									<td colspan="2">เรียน&nbsp;&nbsp;&nbsp;&nbsp; นายก'.$customer_name.' </td>
								</tr>
                <tr>
									<td colspan="2">สิ่งที่ส่งมาด้วย &nbsp;&nbsp- สำเนาบัตรประจำตัวประชาชน / บัตรข้าราชกาล </td>
								</tr>


								<tr>
									<td colspan="2" style="text-align:justify">
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$detail.'
									</td>
								</tr>
								<tr>
									<td colspan="2"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                 &nbsp;&nbsp;&nbsp;&nbsp;
                  มีความประสงค์ขอยืมครุภัณฑ์ ประเภท
								</tr>';

$sqll = "select * from tb_khruphan_obj where khruphan_id = $code";
$rsl = rsQuery($sqll);

while ($rowl = mysqli_fetch_array($rsl)) {
  if ($rowl['object_name'] != "") {
    echo '<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img style="width: 20px;" src="../../images/icons/checked.png">&nbsp;&nbsp;'.$rowl['object_name'].'</td>
    <td>
    จำนวน&nbsp;&nbsp;.................'.$rowl['num_object'].'..................
    </td>
    </tr>';
  }
}
                /*<tr>
									<td align="center">
                  <img style="width: 20px;" src="'.$chack1.'"> อุปโภค
                  </td>
                  <td>
                  จำนวน.....................................
                  </td>
								</tr>*/



echo             '<tr>
									<td colspan="2"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                 &nbsp;&nbsp;&nbsp;&nbsp;เพื่อนำไปใช้ในงาน &nbsp;'.$row['for_work'].' ซึ่งจัดอยู่ที่ '.$row['location'].'
                 โดยจะมารับ'.DateThai($row['start_date']).' และจะนำมาส่งคืนในสภาพเรียบร้อย/สภาพเดิมใน'.DateThai($row['end_date']).'
                 หากเกิดกรณีชำรุดเสียหายข้าพเจ้ายืนดีชดใช้ตามมูลค่าความเสียหายที่เกิดขึ้นโดยทันทีตามที่เจ้าหน้าที่ได้แจ้งให้ข้าพเจ้าได้ทราบ
                </td>
								</tr>


                <tr>
									<td></td>	<td align="center">ลงชื่อ.....................................................................ผู้ยืม</td>
								</tr>
                <tr>
                <td></td> <td align="center">('.$row['name'].')</td>
                </tr>

                <tr>
									<td></td>	<td align="center">ลงชื่อ..............................................................ผู้รับเรื่อง</td>
								</tr>
                <tr>
                <td></td> <td align="center">(..............................................................)</td>
                </tr><tr>
                <td></td> <td align="center">..................../................................../......................</td>
                </tr>


                <tr>
                  <td colspan="2" align="center" style="padding: 80px 0px 0px 0px;"><hr></td>
                </tr>
                <tr>
                  <td><h4>ความเห็นของปลัดเทศบาล</h4></td><td><h4>ความเห็นของนายยกเทศมนตรี</h4></td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;<img style="width: 20px;" src="'.$chack1.'">&nbsp;&nbsp;ควรอนุมัติ</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<img style="width: 20px;" src="'.$chack1.'">&nbsp;&nbsp;ควรอนุมัติ</td></td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;<img style="width: 20px;" src="'.$chack1.'">&nbsp;&nbsp;ไม่ควรอนุมัติ เพราะ.............................................</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<img style="width: 20px;" src="'.$chack1.'">&nbsp;&nbsp;ไม่ควรอนุมัติ เพราะ.............................................</td>
                </tr>
                <tr>
                  <td align="center">ลงชื่อ..............................................................</td>	<td align="center">ลงชื่อ..............................................................</td>
                </tr>
                <tr>
                <td align="center">('.$palad_name.')</td> <td align="center">('.$nayok_name.')</td>
                </tr>
                <tr>
                <td align="center">('.$palad_position.')</td> <td align="center">('.$nayok_position.')</td>
                </tr>



							</table>
							</div>
							</div>
							</div>';
echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";

              if ($lat!=0){

                  echo '<tr>
              								<td colspan="2" align="center">
                              <h2 style="margin-bottom:0px">แผนที่</h2>
              								<br>
              								<div id="map" style="height: 400px; width: 100%;"></div>
              								<br>
                              </td>
              								</tr>';
              }
?>

<?php
$sqls  =  "select * from files_image where table_name='tb_khruphan' and master_id='$code' ";
$rss = rsQuery($sqls);
$num = mysqli_num_rows($rss);
$count = 1;
if ($num > 0){

?>

        <tr><td align="center"><h2 style="margin-bottom:0px">รูปภาพประกอบ</h2>
                        <?php

                        while ($rows = mysqli_fetch_array($rss)){
                            echo "<img class=\"hover-shadow cursor\"
                            alt=\"image".$count."\"
                            style=\"border: 1px solid #ddd; border-radius: 4px;
                        padding: 5px; width: 70%; margin:10px; \"
                        src='../../../fileupload/khruphan/".$rows['file_name']."'>";
                            $count++;
                        }
                        ?>
        </td></tr>

<?php }?>


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDg49SZLUZdLu8KQ80fEAPJkbdBUqyN-vw&libraries=places" ></script>

<script>

    var Lat = parseFloat(<?php echo $lat; ?>);
    var Lng = parseFloat(<?php echo $lng;?>);
    //alert(Lat+" "+Lng);
    //console.log(Lat+Lng);

    myLatLng = {lat: Lat, lng: Lng};
    var map = new google.maps.Map(document.getElementById('map'), {
        center: myLatLng,
        zoom: 17,
        styles: [

            {
                featureType: 'road',
                elementType: 'geometry.fill',
                stylers: [
                    {
                        color: '#8e8f9d'
                    }
                ]
            },
            {
                featureType: 'road',
                elementType: 'labels.text.fill',
                stylers: [
                    {
                        color: '#05050a'
                    }
                ]
            }

        ]

    });

    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
    });


</script>

</body>
</html>
