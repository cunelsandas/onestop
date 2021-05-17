<html>
<head>
    <title> คำขออนุญาตก่อสร้างอาคาร/ดัดแปลงอาคาร หรือรื้อถอนอาคาร </title>
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

        p{
            font-size: 14px;
        }
        label{
            font-size: 14px;
        }
        .textdot{
            border-bottom: dashed 1px;
        }
        .button {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }

        .button2 {background-color: #008CBA;} /* Blue */
        .button3 {background-color: #f44336;} /* Red */
        .button4 {background-color: #e7e7e7; color: black;} /* Gray */
        .button5 {background-color: #555555;} /* Black */


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
            #DivPrint {
                display: none;
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
        .demo {
            border:1px solid black;
            border-collapse:collapse;
            padding:2px;
        }
        .demo th {
            border:1px solid black;
            padding:2px;
            background:#F0F0F0;
        }
        .demo td {
            border:1px solid black;
            padding:2px;
        }

    </style>
</head>
<body>
<button class="button button2" id="DivPrint" style="margin: 0 auto" onclick="window.print()">พิมพ์หน้านี้</button>

<?php
session_start();

include_once ("../../../itgmod/connect.php");

function DateThaimonth($strDate)
{
    $strMonth= date("n",strtotime($strDate));
    $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
    $strMonthThai=$strMonthCut[$strMonth];
    return "$strMonthThai";
}

function DateThaiyear($strDate)
{
    $strYear = date("Y",strtotime($strDate))+543;
    return "$strYear";
}


if (!isset($_GET['id'])) {
    echo "ไม่พบเลขที่คำร้อง ไม่สามารถแสดงผลได้";
    exit();
}

$code=trim($_GET['id']);
$result=rsQuery("Select * from tb_building Where id=$code");
if (!$result) {
    echo "ไม่พบคำร้องเลขที่ ". $code;
}
else {

    $row = mysqli_fetch_assoc($result);

    // ออกเอกสารเป็นไอ.ที.โกลโบล อัพเดท status_print
    $receiveno = FindRS("SELECT * FROM tb_request WHERE table_name='tb_building' AND master_id = '$code'",receiveno);
    $datein = FindRS("SELECT * FROM tb_request WHERE table_name='tb_building' AND master_id = '$code'",datein);


    $id="คำร้องออนไลน์เลขที่ ".$row['id'];
    $datepost=DateThai($datein);
    $name=$row['name'];
    $tel=$row['tel'];
    $email=$row['email'];

    $home_type1=$row['check_doc'];
    $home_type2=$row['copy_doc1'];
    $home_type3=$row['ask_doc'];
    $home_type4=$row['copy_doc2'];
    $home_type5=$row['etc_doc'];

    if ($home_type1 == "1") {
      $chack1 = "../../images/icons/checked.png";
    }else {
      $chack1 = "../../images/icons/unchecked.png";
    }

    if ($home_type2 == "1") {
      $chack2 = "../../images/icons/checked.png";
    }else {
      $chack2 = "../../images/icons/unchecked.png";
    }

    if ($home_type3 == "1") {
      $chack3 = "../../images/icons/checked.png";
    }else {
      $chack3 = "../../images/icons/unchecked.png";
    }

    if ($home_type4 == "1") {
      $chack4 = "../../images/icons/checked.png";
    }else {
      $chack4 = "../../images/icons/unchecked.png";
    }

    if ($home_type5 == "1") {
      $chack5 = "../../images/icons/checked.png";
    }else {
      $chack5 = "../../images/icons/unchecked.png";
    }

    $num_home1=$row['num_home1'];
    $num_home2=$row['num_home2'];
    $num_bin=$row['num_bin'];
//------------------------------------------------------------------
    $province=FindRS("SELECT * FROM province WHERE PROVINCE_ID=".$row['province'],PROVINCE_NAME);
    $amphur=FindRS("SELECT * FROM amphur WHERE AMPHUR_ID=".$row['amphur'],AMPHUR_NAME);
    $district=FindRS("SELECT * FROM district WHERE DISTRICT_ID=".$row['district'],DISTRICT_NAME);
    $moo = $row['moo'];
    $numhome = $row['num_home'];
    $soi = $row['soi'];
    $road = $row['road'];

    $provinceniti=FindRS("SELECT * FROM province WHERE PROVINCE_ID=".$row['provinceniti'],PROVINCE_NAME);
    $amphurniti=FindRS("SELECT * FROM amphur WHERE AMPHUR_ID=".$row['amphurniti'],AMPHUR_NAME);
    $districtniti=FindRS("SELECT * FROM district WHERE DISTRICT_ID=".$row['districtniti'],DISTRICT_NAME);
    $mooniti = $row['mooniti'];
    $soiniti = $row['soiniti'];
    $roadniti = $row['roadniti'];
    $regisnum = $row['regisnum'];
    $officenum = $row['officenum'];

    $regisday = $row['regisday'];
    $nititype = $row['nititype'];
    $byniti = $row['byniti'];
    $bynumhome = $row['bynumhome'];
    $bysoi = $row['bysoi'];
    $byroad = $row['byroad'];
    $provinceby = $row['provinceby'];
    $amphurby = $row['amphurby'];
    $districtby = $row['districtby'];
    $bymoo = $row['bymoo'];

    $buildnum = $row['buildnum'];
    $buildsoi = $row['buildsoi'];
    $buildroad = $row['buildroad'];
    $buildmoo = $row['buildmoo'];
    $buildprovince=FindRS("SELECT * FROM province WHERE PROVINCE_ID=".$row['buildprovince'],PROVINCE_NAME);
    $buildamphur=FindRS("SELECT * FROM amphur WHERE AMPHUR_ID=".$row['buildamphur'],AMPHUR_NAME);
    $builddistrict=FindRS("SELECT * FROM district WHERE DISTRICT_ID=".$row['builddistrict'],DISTRICT_NAME);
    $buildowner = $row['buildowner'];
    $buildnoso = $row['buildnoso'];
    $landowner = $row['landowner'];
    $buildtype = $row['buildtype'];
    $buildfloor = $row['buildfloor'];
    $builduse = $row['builduse'];
    $buildwh = $row['buildwh'];
    $buildcarpark = $row['buildcarpark'];

    $buildengineer = $row['buildengineer'];
    $buildcal = $row['buildcal'];
    $buildfinishday = $row['buildfinishday'];

    $blueprintset = $row['blueprintset'];
    $blueprintpaper = $row['blueprintpaper'];
    $calpaper = $row['calpaper'];
    $engineeraccept = $row['engineeraccept'];
    $deednum = $row['deednum'];
    $deedset = $row['deedset'];
    $bookaccept = $row['bookaccept'];
    $engineercopy = $row['engineercopy'];
    $otherdoc = $row['otherdoc'];


    $addrass = "บ้านเลขที่ &nbsp;".$numhome." &nbsp;&nbsp;หมู่ที่ ".$moo." &nbsp;&nbsp;ตำบล ".$district." &nbsp;&nbsp;อำเภอ ".$amphur." &nbsp;&nbsp;จังหวัด ".$province;

//------------------------------------------------------------------


    $detail= "ข้าพเจ้า ".$name." อยู่".$addrass." &nbsp;&nbsp;หมายเลขโทรศัพท์ ".$row['tel']." &nbsp;&nbsp;อีเมล ".$row['email']." <br>มีความประสงค์ขอรับบริการข้อมูลข่าวสารตามพระราชบัญญัติข้อมูลข่าวสารของราชการ พ.ศ. ๒๕๓๐";

};


echo '<div class="page">
							<table style="float: right;border: solid 1px black;">
<tbody>
<tr>
<td>
<label style="font-size:12px;">เลขที่รับ..........................................</label><br>
<label style="font-size:12px;">วันที่..............................................</label><br>
<label style="font-size:12px;">ลงชื่อ................................ผู้รับคำขอ</label><br>
<label style="font-size:12px;">&nbsp; &nbsp; &nbsp; (.......................................)</label>
</td>
</tr>
</tbody>
</table>
<label style="font-size:20px;">&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span style="text-decoration: underline;"><strong>คำขออนุญาตก่อสร้างอาคาร</strong></span></label><br>
<label style="font-size:20px;"><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span style="text-decoration: underline;">&nbsp;ดัดแปลงอาคารหรือรื้อถอนอาคาร</span>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</strong></label><br>
<br>
<label style="text-align:right;float:right;font-size:14px"> เขียนที่ การบริการเบ็ดเสร็จ ณ จุดเดียว เทศบาลตำบลบ้านธิ <br>วันที่ '.date('d').' เดือน '.DateThaimonth('m').' พ.ศ. '.DateThaiyear('y').' </label><br><br>
<br>
<br>
<label> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ข้าพเจ้า '.$name.' เจ้าของอาคารหรือตัวแทนเจ้าของอาคาร</label><br>
<label> &nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp;<img style="width: 20px;" src="'.$chack1.'"> เป็นบุคคลธรรมดา อยู่บ้านเลขที่ '  .$numhome.'  ตรอก/ซอย ' .$soi.' ถนน ' .$road. ' </label><br>
<label> หมู่ที่ ' .$moo.' ตำบล/แขวง ' .$district. ' อำเภอ/เขต ' .$amphur. 'จังหวัด' .$province. ' </label><br>
<label> &nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp;<img style="width: 20px;" src="'.$chack2.'"> เป็นนิติบุคคลประเภท ' .$nititype.' จดทะเบียนเมื่อ '  .$regisday.'</label><br>
<label> เลขทะเบียน '  .$regisnum.' มีสำนักงานตั้งอยู่เลขที่ '  .$officenum. '</label><br>
<label> ตรอก/ซอย '  .$soiniti.' ถนน '  .$roadniti.' หมู่ที่ '  .$mooniti.' </label><br>
<label> ตำบล/แขวง '  .$districtniti.' อำเภอ/เขต '  .$amphurniti.' จังหวัด '  .$provinceniti.' </label><br>
<label> โดย '  .$byniti.'  ผู้มีอำนาจลงชื่อแทนนิติบุคคลผู้ขออนุญาต</label><br>
<label> อยู่บ้านเลขที่ '  .$bynumhome.' ตรอก/ซอย '  .$bysoi.' ถนน '  .$byroad.' </label><br>
<label> หมู่ที่'  .$bymoo.'ตำบล/แขวง'  .$districtby.'อำเภอ/เขต'  .$amphurby.'จังหวัด'  .$provinceby.'</label><br>
<br>
<label> &nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; ขอยื่นคำขอใบอนุญาต ก่อสร้าง ดักแปลง รื้อถอน ต่อเจ้าพนักงานท้องถิ่นดังต่อไปนี้</label><br>
<br>
<label> &nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; ข้อ ๑ ทำการก่อสร้างอาคาร/ดัดแปลงอาคาร/รื้อถอนอาคาร  บ้านเลขที่ '  .$buildnum. ' ตรอก/ซอย '  .$buildsoi. '</label><br>
<label> ถนน '  .$buildroad. ' หมู่ที่ '  .$buildmoo. ' ตำบล/แขวง '  .$builddistrict. ' อำเภอ/เขต '  .$buildamphur. 'จังหวัด '  .$buildprovince. '</label><br>
<label> โดย '  .$buildowner. ' เป็นเจ้าของอาคารในโฉนดที่ดิน</label><br>
<label> เลขที่/น.ส.๓ เลขที่/ส.ค.๑ เลขที่ '  .$buildnoso. ' เป็นที่ดินของ '  .$landowner. '</label><br>
<br>

<label> &nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; ข้อ ๒ เป็นอาคาร</label><br>
<label> &nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; (๑) ชนิด '  .$buildtype. ' จำนวน '  .$buildfloor.' ชั้น'. ' เพื่อใช้เป็น '  .$builduse. '</label><br>
<label> โดยมีพื้นที่/ความยาว '  .$buildwh. ' โดยมีที่จอดรถ ที่กลับรถ และทางเข้า-ออกของรถ จำนวน '  .$buildcarpark. ' คัน</label><br>
<label> &nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; (๒) ชนิด.........................................จำนวน.................................เพื่อใช้เป็น..........................................</label><br>
<label> โดยมีพื้นที่/ความยาว............................โดยมีที่จอดรถ ที่กลับรถ และทางเข้า-ออกของรถ จำนวน......................คัน</label><br>
<label> &nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; (๓) ชนิด.........................................จำนวน.................................เพื่อใช้เป็น..........................................</label><br>
<label> โดยมีพื้นที่/ความยาว............................โดยมีที่จอดรถ ที่กลับรถ และทางเข้า-ออกของรถ จำนวน......................คัน</label><br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<label> &nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; ตามแผนผังบริเวณ แบบแปลน รายการประกอบแบบแปลน และรายการคำนวณที่แนบมาพร้อมนี้</label><br>
<br>
<label style="padding-top:10px;"> &nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; ข้อ ๓ มี '  .$buildengineer. '</font> เป็นผู้ควบคุมงาน</label><br>
<label> และ '  .$buildcal. ' เป็นผู้ออกแบบและคำนวณ</label><br>
<br>
<label style="padding-top:10px;"> &nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; ข้อ ๔ กำหนดแล้วเสร็จใน '  .$buildfinishday. ' วัน นับตั้งแต่วันที่ได้รับใบอนุญาต</label><br>
<br>
<label style="padding-top:10px;"> &nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; ข้อ ๕ พร้อมคำขอนี้ ข้าพเจ้าได้แนบเอกสารหลักฐานต่าง ๆ ดังต่อไปนี้ มาด้วยแล้ว คือ</label><br>
<label> (๑) แผนผังบริเวณ แบบแปลน รายการประกอบแบบแปลน จำนวน <font style="text-decoration:underline;">'  .$blueprintset. '</font> ชุด ชุดละ <font style="text-decoration:underline;">'  .$blueprintpaper. '</font> แผ่น</label><br>
<label> (๒) รายการคำนวณ ๑ ชุด จำนวน <font style="text-decoration:underline;">'  .$calpaper. '</font> แผ่น (กรณีที่เป็นอาคารสาธารณะ อาคารพิเศษหรืออาคารที่ก่อสร้างด้วยวัตถุถาวรและวัตถุทนไฟเป็นส่วนใหญ่)</label><br>
<label> (๓) หนังสือแสดงความเป็นตัวแทนของเจ้าของอาคาร (กรณีที่ตัวแทนเจ้าของอาคารเป็นผู้ขออนุญาต)</label><br>
<label> (๔) สำเนาหนังสือรับรองการจดทะเบียน วัตถุประสงค์ และผู้มีอำนาจลงชื่อแทนนิติบุคคลผู้ขออนุญาตที่ออกให้ไม่เกิน ๖ เดือน (กรณีที่นิติบุคคลเป็นผู้ขออนุญาต)</label><br>
<label> (๕) หนังสือแสดงว่าเป็นผู้จัดการหรือผู้แทนซึ่งเป็นผู้ดำเนินกิจการของนิติบุคคล (กรณีที่นิติบุคคลเป็นผู้ขออนุญาต)</label><br>
<label> (๖) หนังสือแสดงความยินยอมและรับรองของผู้ออกแบบและคำนวณอาคาร จำนวน <font style="text-decoration:underline;">'  .$engineeraccept. '</font> ฉบับ</label><br>
<label> (๗) สำเนาภาพถ่ายโฉนดที่ดิน เลขที่/น.ส.๓ เลขที่/ส.ค.๑ เลขที่ <font style="text-decoration:underline;">'  .$deednum. '</font> จำนวน <font style="text-decoration:underline;">'  .$deedset. '</font> ฉบับ</label><br>
<label> (๘) หนังสือแสดงความยินยอมของผู้ควบคุมงานตามข้อ ๓ จำนวน <font style="text-decoration:underline;">'  .$bookaccept. '</font> ฉบับ</label><br>
<label> (๙) สำเนาหรือภาพถ่ายใบอนุญาตเป็นผู้ประกอบวิชาชีพวิศวกรรมควบคุมหรือวิชาชีพสถาปัตยกรรมควบคุมของผู้ควบคุมงาน จำนวน <font style="text-decoration:underline;">'  .$engineercopy. '</font> ฉบับ (เฉพาะกรณีที่เป็นอาคารที่เป็นลักษณะ ขนาด อยู่ในประเภทเป็นวิชาชีพวิศวกรรมควบคุม หรือวิชาชีพสถาปัตยกรรมควบคุม แล้วแต่กรณี)</label><br>
<label> (๑๐) เอกสารอื่น (ถ้ามี) <font style="text-decoration:underline;">'  .$otherdoc. '</font> ฉบับ </label><br>
<br>
<br>
<br>
<label>&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;(ลายมือชื่อ)...............................................................ผู้ขออนุญาต</label><br>
<label>&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;(................. '.$name.' ..................)</label><br>

<p style="padding-top:15px"> <strong style="text-decoration:underline;">หมายเหตุ</strong>  (๑)  ข้อความข้อใดไม่ใช้ให้ขีดฆ่า <br>&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;(๒)  ใส่เครื่องหมาย / ในช่องหน้า ข้อความที่ต้องการ</p>

<hr style="height:1px;color:black;">
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<p style="text-align:center;padding-top:20px;"><strong style="text-decoration:underline;">หมายเหตุของเจ้าหน้าที่</strong></p>
<label> &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; จะต้องแจ้งให้ผู้ขออนุญาตทราบว่า จะอนุญาตหรือไม่อนุญาตหรือขยายเวลาภายในวันที่............................</label><br>
<label> &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; ผู้ขออนุญาตได้รับชำระค่าธรรมเนียมใบอนุญาต.....................................เป็นเงิน..................................บาท</label><br>
<label> และค่าธรรมเนียมการตรวจแบบแปลน................................................................เป็นเงิน..................................บาท</label><br>
<label> รวมทั้งสิ้นเป็นเงิน..............................................................บาท (....................................................................)</label><br>
<label> ตามใบเสร็จรับเงิน เลขที่...................................ลงวันที่ ......................................................................................</label><br>
<label> &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; ออกใบอนุญาตแล้ว เล่มที่.................................ฉบับที่..............................ลงวันที่..................................</label><br>
<br>
<br>
<label>&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;(ลงชื่อ)...............................................................</label><br>
<label>&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(.....................................................................)</label><br>
<label>&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;ตำแหน่ง...............................................................</label><br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

<p style="text-align:center;padding-top:20px;"><strong>บัญชีรายการเอกสารประกอบคำขออนุญาตก่อสร้าง ดัดแปลง รื้อถอนอาคาร</strong></p>
<p style="text-align:center;padding-top:0px;"><strong>ของ..................................................................................โทร. .........................................</strong></p>

<table class="demo" style="width:100%; border: 1px solid black;font-size:13px;border-collapse: collapse;">
	<thead>
	<tr style="border:solid 1px black;text-align:center;">
		<th width="10%">ลำดับที่</th>
		<th width="60%">รายการ</th>
		<th width="30%">หมายเหตุ</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td><img style="width: 20px;" src="'.$chack5.'"> 1.</td>
		<td>คําขออนุญาตก่อสร้าง ดัดแปลง รื้อถอนอาคาร (ข.1)</td>
		<td></td>
	</tr>
	<tr>
		<td><img style="width: 20px;" src="'.$chack5.'"> 2.</td>
		<td>บัตรประจําตัวและทะเบียนบ้านของผู้ขออนุญาต</td>
		<td></td>
	</tr>
	<tr>
		<td><img style="width: 20px;" src="'.$chack5.'"> 3.</td>
		<td>สำเนาภาพถ่ายโฉนดที่ดิน น.ส.3-ส.ค.1 เลขที่............</td>
		<td></td>
	</tr>
	<tr>
		<td><img style="width: 20px;" src="'.$chack5.'"> 4.</td>
		<td>หนังสือยินยอมให้ก่อสร้างอาคารในที่ดิน</td>
		<td>- กรณีก่อสร้างในที่ดินผู้อื่น</td>
	</tr>
	<tr>
		<td><img style="width: 20px;" src="'.$chack5.'"> 5.</td>
		<td>หนังสือยินยอมให้ก่อสร้างชิดแนวเขตที่ดินจากเจ้าของที่ดินข้างเคียง</td>
		<td>- กรณีก่อสร้างชิดแนวเขตที่ดินผู้อื่น</td>
	</tr>
	<tr>
		<td><img style="width: 20px;" src="'.$chack5.'"> 6.</td>
		<td>หนังสือรับรองผู้ประกอบวิชาชีพวิศวกรรมควบคุม ผู้ทำรายการคำนวณ</td>
		<td>- กรณีที่อาคารมีขนาดอยู่ในประเภทวิชาชีพวิศวกรรมหรือสถาปัตยกรรมควบคุมแล้วแต่กรณีพร้อมภาพถ่ายใบอนุญาต</td>
	</tr>
	<tr>
		<td><img style="width: 20px;" src="'.$chack5.'"> 7.</td>
		<td>หนังสือรับรองผู้ประกอบวิชาชีพสถาปัตยกรรมควบคุม ผู้ทำการออกแบบ</td>
		<td></td>
	</tr>
	<tr>
		<td><img style="width: 20px;" src="'.$chack5.'"> 8.</td>
		<td>หนังสือยินยอมวิศวกรผู้ควบคุมงาน (น.4)</td>
		<td></td>
	</tr>
	<tr>
		<td><img style="width: 20px;" src="'.$chack5.'"> 9.</td>
		<td>หนังสือยินยอมสถาปนิกผู้ควบคุมงาน (น.4)</td>
		<td></td>
	</tr>
	<tr>
		<td><img style="width: 20px;" src="'.$chack5.'"> 10.</td>
		<td>แบบแปลน แผนผังบริเวณก่อสร้าง จำนวน.........ชุด</td>
		<td></td>
	</tr>
	<tr>
		<td><img style="width: 20px;" src="'.$chack5.'"> 11.</td>
		<td>รายการประกอบแบบหรือรายการก่อสร้าง จำนวน..........ชุด</td>
		<td></td>
	</tr>
	<tr>
		<td><img style="width: 20px;" src="'.$chack5.'"> 12.</td>
		<td>รายการคำนวณความมั่นคงแข็งแรงโครงสร้าง จำนวน 1 ชุด</td>
		<td></td>
	</tr>
	<tr>
		<td><img style="width: 20px;" src="'.$chack5.'"> 13.</td>
		<td>หนังสือรับรองการจดทะเบียนและผู้มีอำนาจลงนาม</td>
		<td>- กรณีนิติบุคคล</td>
	</tr>
	<tr>
		<td><img style="width: 20px;" src="'.$chack5.'"> 14.</td>
		<td>หนังสือมอบอำนาจให้ผู้อื่นทำการแทน</td>
		<td>- ปิดอากรแสตมป์ 30  บาท</td>
	</tr>
	<tr>
		<td><img style="width: 20px;" src="'.$chack5.'"> 15.</td>
		<td>หนังสือหรือเอกสารที่เกี่ยวข้อง</td>
		<td></td>
	</tr>
	</tbody>
</table>
<br>
<br>
<label>(ลงชื่อ)..................................................ผู้ยื่นคำขออนุญาต &nbsp;&nbsp;&nbsp; (ลงชื่อ)............................................ผู้ยื่นคำขออนุญาต </label>
<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(.....................................................................)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(.....................................................................)</label>
<br>
<br>
<br>
<br>
<br>
<br>
<p style="padding-top:100px;padding-left:50px;"> <strong style="text-decoration:underline;">คำเตือน</strong> </p>
<label style="padding-left:50px;"> 1. ผู้ใดก่อสร้าง ดัดแปลง รื้อถอน หรือเคลื่อนย้ายอาคารก่อนได้รับอนุญาตจากเจ้าพนักงานท้องถิ่นต้องระวางโทษจำคุกไม่เกินสามเดือน ปรับไม่เกินหกหมื่นบาทหรือทั้งจำทั้งปรับ </label> <br>
<label style="padding-left:50px;"> 2. ถ้าเป็นการกระทำของผู้ดำเนินการต้องระวางโทษเป็นสองเท่าของโทษที่บัญญัติไว้สำหรับความผิดนั้น ๆ </label> <br>
<label style="padding-left:50px;"> 3. ถ้าเป็นการกระทำอันเกี่ยวกับอาคารเพื่อพาณิชยกรรม อุตสาหกรรม การศึกษา หรือสาธารณสุข หรือเป็นการกระทำในทางการค้า เพื่อให้เช่า ให้เช่าซื้อ ขายหรือจำหน่วย โดยมีค่าตอบแทนซึ่งอาคารใดผู้กระทำต้องระวางโทษจำคุกไม่เกินสองปี หรือปรับเป็นสิบเท่าของโทษที่บัญญัติไว้ สำหรับความผิดนั้น ๆ หรือทั้งจำทั้งปรับ</label> <br>
<label style="padding-left:50px;"> 4. ใบอนุญาตให้ทำการก่อสร้าง ดัดแปลง รื้อถอน หรือเคลื่อนย้ายอาคารมีระยะกำหนดเวลาจำกัดให้ใช้ได้ตามระยะเวลาที่กำหนดในใบอนุญาต ถ้าผู้ได้รับใบอนุญาตประสงค์จะขอต่อใบอนุญาต จะต้องยื่นคำขอต่อใบอนุญาต </label> <br>
								


							</table>
							</div>
							</div>
							</div>';
echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";

?>

<?php
$sqls  =  "select * from files_image where table_name='tb_waste' and master_id='$code' ";
$rss = rsQuery($sqls);
$num = mysqli_num_rows($rss);
$count = 1;
if ($num > 0){

?>

        <tr><td align="center"><h2 style="margin-bottom:0px">รูปภาพตำแหน่งที่ต้องการนำถังขยะไปตั่ง</h2>
                        <?php

                        while ($rows = mysqli_fetch_array($rss)){
                            echo "<img class=\"hover-shadow cursor\"
                            alt=\"image".$count."\"
                            style=\"border: 1px solid #ddd; border-radius: 4px;
                        padding: 5px; width: 70%; margin:10px; \"
                        src='../../../fileupload/waste/".$rows['file_name']."'>";
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
