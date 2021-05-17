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
		
		include_once("../../../itgmod/connect.inc.php");
		
		
		if(isset($_GET['no'])){
			
			$no=decode64($_GET['no']);
			$tablename=decode64($_GET['tb']);
			switch($tablename){
				case "tb_electric":
					$picfolder="../../../fileupload/electric/";
					$depname="ไฟฟ้าสาธารณะ";
					$work="บำรุงรักษา  ซ่อมแซมไฟฟ้าสาธารณะนั้น";
					break;
				case "tb_infrastructure":
					$picfolder="../../../fileupload/infrastructure/";
					$depname="สาธารณูปโภค";
					$work="บำรุงรักษา  ซ่อมแซมสาธารณูปโภคนั้น";
					break;
			}
			$sql="select * from $tablename where no=$no";
			$rs=rsQuery($sql);
			$data=mysqli_fetch_array($rs);
			$date=thaidate($data['date']);
			$name=$data['name'];
			$add_address=$data['add_address'];
			$add_moo=$data['add_moo'];
			$add_tambol1=$data['add_tambol'];
			$add_amphur1=$data['add_amphur'];
			$add_province1=$data['province'];
			$add_tambol=FindRS("select * from district Where DISTRICT_ID='$add_tambol1'",DISTRICT_NAME);
			$add_amphur=FindRS("select * from amphur Where AMPHUR_ID='$add_amphur1'",AMPHUR_NAME);
			$add_province=FindRS("select * from province Where PROVINCE_ID='$add_province1'",PROVINCE_NAME);
			$telephone=$data['telephone'];
			$email=$data['email'];
			$moo=$data['moo'];
			$post_ip=$data['post_ip'];
			$remark=$data['remark'];
			$datefinish=thaidate($data['datefinish']);
			$subject=$data['subject'];
			$status=$data['status'];
			$result=$data['result'];
			$officer=$data['officer'];
			$position=FindRS("select * from tb_officer where name='$officer'",position);
			$statusname=FindRS("select * from tb_status where id=".$status,name);
			$to="เรียน      ".$nayok_sub_position;
			if($tablename=="tb_electric"){
				$light=empty($data['light'])?"":"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หลอดไฟขนาด ".$data['light']." วัตต์&nbsp;&nbsp;";
				$lightno=empty($data['lightno'])?"":"จำนวน ".$data['lightno']." หลอด<br>";
				$starter=empty($data['starter'])?"":"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สตาร์ทเตอร์ จำนวน ".$data['starter']." อัน<br>";
				$ballard=empty($data['ballard'])?"":"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;บัลลาสต์ จำนวน ".$data['ballard']." อัน<br>";
				$lamp=empty($data['lamp'])?"":"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;โคมไฟ จำนวน ".$data['lamp']." โคม<br>";
				$wired=empty($data['wired'])?"":"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สายไฟ จำนวน ".$data['wired']." เมตร<br>";
				$other=empty($data['other'])?"":"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;อื่นๆ ".$data['other']."<br>";
				$strdo="โดยใช้อุปกรณ์ดังนี้<br>".$light.$lightno.$starter.$ballard.$lamp.$wired.$other;
			}else{
				$strdo="เห็นควร........................................................................................................................................................................................................<br>........................................................................................................................................................................................................................<br>";
			}
			
			$html='
				<style>
			span.box1 { 
				font-size:15pt;
				font-family:Tahoma;
				padding-left:15pt;
				border:1px solid red;
				overflow:hidden;
				}	
			span.box2 { 
				font-size:10pt;
				font-family:Tahoma;
				padding-left:15;

				border:1px solid green;
				overflow:hidden;
				}
			span.box3 { 
				font-size:5px;
				font-family:Tahoma;
				padding-left:5px;
				border:1px solid blue;
				overflow:hidden;
				}
				</style>
				<body>
			<div align="center" style="font-size:12px;">รายงานผลการดำเนินการแก้ไข'.$depname.'</div><br>
			'.$to.'<br>
			อ้างถึงคำร้อง ลงวันที่ '.$date.'<br>
			<span style="width:100%;word-wrap: break-word;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ตามที่'.$name.'ได้ยื่นคำร้องให้งาน'.$depname .'  ดำเนินการแก้ไขปัญหาเรื่อง  '.$work.'</span><br>
			<span style="text-align:justify;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; งาน'.$depname.' กองช่าง ได้ดำเนินการตามคำร้องดังกล่าวแล้ว&nbsp;&nbsp; เมื่อวันที่ '.$datefinish. '  ผลปรากฏว่า</span><br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$statusname.'<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$result.'<br>
			'.$strdo.'<br>	ทั้งนี้ได้แจ้งผลการดำเนินงานให้แก่ผู้ขอ หรือผู้แทนได้ทราบ<br><br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จึงเรียนมาเพื่อโปรดทราบ<br><br>
			<table width="100%"><tr>
			
			
			<div align="center" style="font-size:12px;"></div>
			<table width="100%" border="1">
			<tr><td width=90% style="border-right-style:solid;border-width:1px;font-size:10px;">เรียน '.$nayok_sub_position.'<br>- เพื่อโปรดพิจารณา<br><br>
			<div align="center">
			
			ลงชื่อ.......................................................นายช่างโยธาเขต<br>
			(...................................................................)<br><br>
			
			ลงชื่อ.......................................................หัวหน้าฝ่ายการโยธา<br>
			(&nbsp;ว่าที่ร้อยโทประภาส  อินทวงศ์&nbsp;)<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><BR>
			ลงชื่อ.......................................................ผอ.กองช่าง<br>
			(&nbsp;'.$headofficer.'&nbsp;)<br>
			
			</div>
			
			</td></tr></table><p></p>';
	
	$strSql="select * from filename where tablename='$tablename' AND masterid='".$no."' Order by id DESC Limit 0,3";	
					$rs2=rsQuery($strSql);
					$rs2_row=mysqli_num_rows($rs2);
					//ถ้า rs2 มีข้อมูลให้แสดงภาพแบบใหม่ ถ้าเป็น0ให้แสดงภาพตาม code เก่า
					$html_pic='<body><br><br><span>ภาพถ่ายผลการดำเนินการ ตามคำร้อง</span><br>';
					if($rs2_row>0){ 
						//$i=0;
						$html_pic.='<br><table>';
						while($rs_filename=mysqli_fetch_array($rs2)){
		
							$cpic=file_exists($picfolder.$rs_filename['filename']);
							$type=strtolower(substr($rs_filename['filename'],-3));
							$strfilename=strtolower($rs_filename['filename']);
							$needle="bf";
						if($cpic){
								if($type<>"pdf"){
									if (strpos($strfilename,$needle) !== false) {
										//ถ้ามีคำว่า bf ให้แสดงรูป
										
										$html_pic.='<tr><td>ก่อนดำเนินการ<a href="'.$picfolder.$rs_filename['filename'].'" target="_blank"><img src="'.$picfolder.$rs_filename['filename'].'" width="360" height="220"></a></td></tr>';
									
									}else{
										//ถ้าไม่มีคำว่าbf ให้แสดงรูป
										$html_pic.='<tr><td>หลังดำเนินการ<a href="'.$picfolder.$rs_filename['filename'].'" target="_blank"><img src="'.$picfolder.$rs_filename['filename'].'" width="360" height="220"></a></td></tr>';
										
									}
								}
							}
						}
						$html_pic.='</tr></table>';
					}
					echo "<div class='page'><div class='subpage'><div id='thfont'>";
					echo $html;
					echo "</div></div><p></p>";
					echo "<div class='subpage'><div id='thfont'>";
					echo $html_pic;
					echo "</div></div></div>";
		}

		/**<td width="100%" border="0">
			<div align="center">
			ลงชื่อ .......................................................................เจ้าหน้าที่ผู้ควบคุมงาน<br>
			(&nbsp;&nbsp;'.$officer.'&nbsp;&nbsp;)<br>'.$position.'</div>
			</td>
			</tr></table>**/ //เอาไว้ล่างจึงเรียนมาเพื่อโปรดทราบ **
	?>
 <body>
  
 </body>
</html>
