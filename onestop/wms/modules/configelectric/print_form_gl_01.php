<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> New Document </title>
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


    .page {
		font-family:THSarabunNew;
			font-size:12px;
        width: 21cm;
        min-height: 29.7cm;
        padding: 1cm;
        margin: 1cm auto;
       /* border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);*/

    }
    .subpage {

        padding: 0.5cm;

        height: 245mm;
        outline: 2cm;
		background:url("../../../images/watermark_logo.jpg") no-repeat center center;
    }
	#thfont {
		font-family: THSarabunNew,Tahoma ,sans-serif;
		font-size:12px;
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
			font-family:THSarabunNew;
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

        height: 245mm;
        outline: 2cm;
		background:url("../../../images/watermark_logo.jpg") no-repeat center center;
    }
	#thfont {
		font-family: THSarabunNew,Tahoma ,sans-serif;
		font-size:12px;
	}
	#thfont table td{
		font-size:12px;
	}
	p{
		 page-break-after: always;
	}
    }
/*---*/
  .page2 {
		font-family:THSarabunNew;
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
    .subpage2 {

        padding: 0.5cm;

        height: 245mm;
        outline: 2cm;
		/*background:url("../../../images/krut.jpg") no-repeat top center; */
    }
	#thfont2 {
		font-family: THSarabunNew,Tahoma ,sans-serif;
		font-size:12px;
	}
	#thfont2 table td{
		font-size:12px;
	}

    @page {

        size: A4;
        margin: 0;
    }
    @media print {


		.page2 {
			font-family:THSarabunNew;
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
		 .subpage2 {

        padding: 0.5cm;

        height: 245mm;
        outline: 2cm;
		/*background:url("../../../images/krut.jpg") no-repeat top center; */
    }
	#thfont2 {
		font-family: THSarabunNew,Tahoma ,sans-serif;
		font-size:12px;
	}
	#thfont2 table td{
		font-size:12px;
	}
	p{
		 page-break-after: always;
	}
    }
</style>
 </head>
<?php


session_start();
if(!isset($_SESSION['userid'])){
	echo"<meta http-equiv=\"Refresh\" content=\"0;url=main.php\" />";
	exit();
}
include_once ("../../../itgmod/connect.php");


if(!isset($_GET['tb']) and !isset($_GET['id'])){
	echo "?????????????????????????????????????????????????????? ??????????????????????????????????????????????????????????????????????????????";
}else{
	$tablename=decode64($_GET['tb']);

	$no=decode64($_GET['no']);
	$latsql="Select * from $tablename where no=$no";

	$sql="select * from $tablename where no=$no";
	$rs=rsQuery($sql);
	$data=mysqli_fetch_array($rs);
	$date="??????????????????  ".thaidate($data['date']);
	$subjectdetail=$data['subject'];
	$name=$data['name'];
	$add_address=$data['add_address'];
	$add_moo=$data['add_moo'];
	$add_tambol1=$data['add_tambol'];
	$add_amphur1=$data['add_amphur'];
	$add_province1=$data['add_province'];
	$add_tambol=FindRS("select * from district Where DISTRICT_ID='$add_tambol1'",DISTRICT_NAME);
	$add_amphur=FindRS("select * from amphur Where AMPHUR_ID='$add_amphur1'",AMPHUR_NAME);
	$add_province=FindRS("select * from province Where PROVINCE_ID='$add_province1'",PROVINCE_NAME);
	$telephone=$data['telephone'];
	$email=$data['email'];
	$moo=$data['moo'];
	$post_ip=$data['post_ip'];
	$remark=$data['remark'];
	$to="???????????????      ".$nayok_position;
	$writeform="????????????????????????     ".$customer_name;
	$text1="???????????????????????? ".$name."    ?????????????????????????????????????????? ".$add_address." ????????????????????? ".$add_moo."  ???????????? ".$add_tambol."  ???????????????  ".$add_amphur."  ?????????????????????  ".$add_province."  ???????????????????????? ".$telephone."  ????????????????????????????????? ".$post_ip;

	$end="??????????????????????????????????????????????????????????????????????????????";

		switch($tablename){
			case "tb_electric":
				$picfolder="../../../fileupload/electric/";
				$folder="fileupload/electric/";
				$title="???????????????????????????????????????????????????????????????????????????  (?????????????????????)";
				$detail=explode(';',$data['fix_with_code']);
				$subject="??????????????????      ".$subjectdetail;
				$text2="???????????????????????????????????????????????? ".$customer_name."  ????????????????????????????????????????????????????????? ????????????????????? ".$moo."  ".$customer_tambon."  ".$customer_amphur."  ".$customer_province."  ???????????????????????????????????????????????????????????????";
				$map="???????????????????????????????????????????????????????????????????????????????????????????????? (??????????????????????????????????????????????????????????????????????????????)";
				break;
			case "tb_infrastructure":
				$picfolder="../../../fileupload/infrastructure/";

				$folder="fileupload/infrastructure/";
				$title="???????????????????????????????????? (?????????????????????)";
				$subject="??????????????????     ".$data['subject'];
				$detail=$data['detail'];
				$text2="??????????????????????????????????????? ".$detail;
				$map="???????????????????????????????????????????????????????????????????????????????????????";
				break;
		}
		$html='<div class="page">
							<div class="subpage">
							<div id="thfont"><div align="center">'.$title.'</div><br><table width="100%"><tr><td width="70%">&nbsp;</td><td width="30%">'.$writeform.'</td></tr><tr><td>&nbsp;</td><td>'.$date.'</td></tr></table><br><div align="left">'.$subject.'<br><br>'.$to.'<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$text1.'<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$text2.'<br>';

			switch($tablename){
			case "tb_electric":

				foreach($detail as $fixwithcode){
						$i+="1";
						$html_detail .='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$i.'  '.$fixwithcode.'<br>';
				}
						$html_detail.="<u>?????????????????????</u> ".$data['remark']."<br>";
					//	$html_detail.=$map.' <div style="width:550px; border:0px #000 solid;"> <div id="map_canvas" style="width:550px;height:400px;border:solid black 1px;"></div></div>';
				break;
			case "tb_infrastructure":
				    $html_detail="<u>?????????????????????</u> ".$data['remark']."<br>";
				break;
	}
					$strSql="select * from filename where tablename='$tablename' AND masterid='".$no."' Order by id DESC Limit 0,3";
					$rs2=mysqli_query($strSql);
					$rs2_row=mysqli_num_rows($rs2);
					//????????? rs2 ??????????????????????????????????????????????????????????????????????????? ?????????????????????0??????????????????????????????????????? code ????????????
					if($rs2_row>0){
						//$i=0;
						$html_pic='<br><table><tr>';
						while($rs_filename=mysqli_fetch_array($rs2)){

							$cpic=file_exists($picfolder.$rs_filename['filename']);
							$type=strtolower(substr($rs_filename['filename'],-3));
							$strfilename=strtolower($rs_filename['filename']);
							$needle="bf";
						if($cpic){
								if($type<>"pdf"){
									if (strpos($strfilename,$needle) !== false) {
										//?????????????????????????????? bf ??????????????????????????????

										$html_pic.='<td><a href="http://yota.maehia.go.th/'.$folder.$rs_filename['filename'].'" target="_blank"><img src="'.$picfolder.$rs_filename['filename'].'" width="180" height="140"></a></td>';

									}else{
										//???????????????????????????????????????bf ??????????????????????????????
										//$html_pic.='';

									}
								}
							}
						}
						$html_pic.='</tr></table>';
					}

			$result1 = rsQuery($latsql);
			$result = rsQuery($latsql);
			$data=mysqli_fetch_array($result1);
			$lat_d = $data['latitude'];
			$long_d = $data['longitude'];
      require ('../../lib/gPoint.php');
			$myHome = new gPoint();	// Create an empty point
			$myHome->setLongLat($long_d, $lat_d);	// I live in sunny California :-)
			$myHome->convertLLtoTM();
			$latlng="Latitude : $lat_d &nbsp;&nbsp;Longitude : $long_d";

			$html_end='<br><div align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$end.'</div><br><br><br><table width="100%"><tr><td width="60%">&nbsp;</td><td width="40%" align="center">??????????????????&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$name.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;?????????????????????</td></tr></table></div></div><p></p>';
			$newpage='<div class="subpage2"><br><BR>';

			$googlemap='<div id="thfont">'.$map.' <div style="width:550px; border:0px #000 solid;"> <div id="map_canvas" style="width:620px;height:500px;border:solid black 1px;"></div></div></div></div></div>';



}


		?>
		<!-- map -->
	  <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
        <script type="text/javascript">
        var map;

		 var flagIcon_front ;
		//flagIcon_front.size = new google.maps.Size(35, 35);
		flagIcon_front.anchor = new google.maps.Point(0, 35);

 function initialize() {
            // Set static latitude, longitude value
            var latlng = new google.maps.LatLng(<?php echo $lat_d; ?>, <?php echo $long_d; ?>);
            // Set map options
            var myOptions = {
                zoom: 16,
                center: latlng,
                panControl: true,
                zoomControl: true,
                scaleControl: true,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
				var contentString;
            // Create map object with options
            map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
        <?php
            // uncomment the 2 lines below to get real data from the db
            // $result = mysqli_query("SELECT * FROM parkings");
             while ($row = mysqli_fetch_array($result)){
            //foreach($result as $row) // <- remove this line

				$titlebox="<div>".$row['subject']."</div>????????????????????????????????? : ".$row['name']."<br>???????????????????????? : ".$row['telephone']."<br>????????????????????? : ".$row['fix_with_code']."<br>?????????????????????????????????????????? : ".$row['resule'];
                echo "addMarker(new google.maps.LatLng(".$row['latitude'].", ".$row['longitude']."), map, '".$titlebox."',new google.maps.MarkerImage('../../../images/electric_".$row['status'].".png'));";
			 }
        ?>


        }
        function addMarker(latLng, map, title, icon) {
            var marker = new google.maps.Marker({
                position: latLng,
                map: map,
                draggable: false, // enables drag & drop
                animation: google.maps.Animation.DROP,
				 //icon: flagIcon_front,
				icon: icon,
				title:'???????????????????????????????????????????????????????????????'
            });
			var infowindow = new google.maps.InfoWindow({
		      content: title
  });
		 google.maps.event.addListener(marker, 'click', function() {
    infowindow.open(map,marker);
  });
            return marker;
        }

        </script>
<!-- end map -->
 <body onload="initialize()">
	<?php
		echo $html.$html_detail.$html_pic.$html_end.$newpage;
		//echo "???????????? UTM : "; $myHome->printUTM(); echo "<br>";
		echo $latlng."<br>";
		echo $googlemap;
	?>
 </body>
</html>
