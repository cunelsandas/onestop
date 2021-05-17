<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> ระบบงานสาธารณูปโภคออนไลน์ กองช่าง </title>
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
        padding: 2cm 2cm 1cm 2cm;
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
		background:url("../../../images/krut.jpg") no-repeat top center;
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
		background:url("../../../images/krut.jpg") no-repeat top center;
    }
	#thfont {
		font-family: THSarabunNew,Tahoma ,sans-serif;
		font-size:12px;
	}
	#thfont table td{
		font-size:12px;
	}
    }
/*---*/
  .page2 {
		font-family:THSarabunNew;
			font-size:12px;
        width: 21cm;
        min-height: 29.7cm;
        padding: 2cm 2cm 1cm 2cm;
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
    }
</style>
</head><body>
<?php
	include_once('../../../itgmod/connect.inc.php');
	
	
	
		
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
			//$date=thaimonth($data['date']);
			$date=thaimonth(date("Y-m-d"));
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
			$datefinish=thaidate($data['datefinish']);
			$subject=$data['subject'];
			$status=$data['status'];
			$result=$data['result'];
			$officer=$data['officer'];
			$position=FindRS("select * from tb_officer where name='$officer'",position);
			$statusname=FindRS("select * from tb_status where id=".$status,name);
			$to="เรียน      ".$nayok_position;
			if($tablename=="tb_electric"){
				$light=empty($data['light'])?"":"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หลอดไฟขนาด ".$data['light']." วัตต์&nbsp;&nbsp;";
				$lightno=empty($data['lightno'])?"":"จำนวน ".$data['lightno']." หลอด<br>";
				$starter=empty($data['starter'])?"":"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สตาร์ทเตอร์ จำนวน ".$data['starter']." อัน<br>";
				$ballard=empty($data['ballard'])?"":"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;บัลลาสต์ จำนวน ".$data['ballard']." อัน<br>";
				$lamp=empty($data['lamp'])?"":"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;โคมไฟ จำนวน ".$data['lamp']." โคม<br>";
				$wired=empty($data['wired'])?"":"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สายไฟ จำนวน ".$data['wired']." เมตร<br>";
				$other=empty($data['other'])?"":"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;อื่นๆ ".$data['other']."<br>";
				$strdo="โดยใช้อุปกรณ์ดังนี้<br>".ThaiNum($light).ThaiNum($lightno).$starter.$ballard.$lamp.$wired.$other;
			}else{
				$strdo="เห็นควร........................................................................................................................................................................................................<br>........................................................................................................................................................................................................................<br>";
			}
		
			echo '<div class="page">
							<div class="subpage">
							<div id="thfont">
							<table height="100%" width="100%" border="0">
								<tr>
								<td valign="top" width="100%" height="100%">
								<table width="100%" border="0">
								<tr><td colspan="2" height="40px"></td></tr>
								<tr>
									<td width="50%">ที่ ชม ๕๕๕๐๓/ </td><td width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สำนักงาน'.$customer_name.'</td>
								</tr>
								<tr>
									<td></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;อ.เมืองเชียงใหม่ จ.เชียงใหม่ '.ThaiNum("50100").'</td>
								</tr>
								<tr>
									<td></td><td>วันที่ '.ThaiNum($date).'</td>
								</tr>
								<tr>
									<td>เรื่อง&nbsp;&nbsp;&nbsp;&nbsp;แจ้งผลการดำเนินงาน</td><td></td>
								</tr>
								<tr>
									<td>เรียน&nbsp;&nbsp;&nbsp;&nbsp;'.$name.'</td><td></td>
								</tr>
								<tr>
									<td colspan="2">
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ตามที่กองช่าง '.$customer_name.' ได้รับแจ้งจากท่านให้ดำเนินการแก้ไขปัญหาเรื่อง  '.$work.' งาน'.$depname.' กองช่าง '.$customer_name.' ได้ดำเนินการตามคำร้องดังกล่าวแล้ว&nbsp;&nbsp; เมื่อวันที่ '.$datefinish. '
									
									</td>
								</tr>
								<tr>
									<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จึงเรียนมาเพื่อโปรดทราบ</td>
								</tr>
								<tr>
									<td></td><td>ขอแสดงความนับถือ</td>
								</tr>
								<tr>
									<td></td><td height="100px"></td>
								</tr>
								<tr>
									<td colspan="2" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;นายประหยัด  ศรีวิชัย&nbsp;)</td>
								</tr>
								<tr>
									<td colspan="2" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;รองนายกเทศมนตรี ปฏิบัติราชการแทน<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nayok_position.'</td>
								</tr>
								
								</table>
								</td>
								</tr>
								
				</table>
				</div>
				<BR><BR><BR><BR><BR><BR>
				<table>
						<tr>
								<td>กองช่าง <br>โทร (๐๕๓) ๒๗๖๔๙๑ ต่อ ๓๐๓<br>โทรสาร (๐๕๓) ๘๐๕๑๘๓<br>'.$domainname.'<br>ไปรษณีย์อีเล็กทรอนิกส์ : kongchangmuc2516@gmail.com</td>
								</tr>
					</table>
				</div>
				</div>

				<div class="page2">
							<div class="subpage2">
							<div id="thfont">
							<table height="100%" width="100%" border="0">
								<tr>
								<td valign="top" width="100%" height="100%">
								<table width="100%" border="0">
								<tr><td colspan="2" height="40px" align="center" width="100%" style="font-size:18px;">สำเนาคู่ฉบับ</td></tr>
								<tr>
									<td width="50%">ที่ ชม ๕๕๕๐๓/ </td><td width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สำนักงาน'.$customer_name.'</td>
								</tr>
								<tr>
									<td></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;อ.เมืองเชียงใหม่ จ.เชียงใหม่ '.ThaiNum("50100").'</td>
								</tr>
								<tr>
									<td></td><td>วันที่ '.ThaiNum($date).'</td>
								</tr>
								<tr>
									<td>เรื่อง&nbsp;&nbsp;&nbsp;&nbsp;แจ้งผลการดำเนินงาน</td><td></td>
								</tr>
								<tr>
									<td>เรียน&nbsp;&nbsp;&nbsp;&nbsp;'.$name.'</td><td></td>
								</tr>
								<tr>
									<td colspan="2">
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ตามที่กองช่าง '.$customer_name.' ได้รับแจ้งจากท่านให้ดำเนินการแก้ไขปัญหาเรื่อง  '.$work.' งาน'.$depname.' กองช่าง '.$customer_name.' ได้ดำเนินการตามคำร้องดังกล่าวแล้ว&nbsp;&nbsp; เมื่อวันที่ '.$datefinish. '
									
									</td>
								</tr>
								<tr>
									<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จึงเรียนมาเพื่อโปรดทราบ</td>
								</tr>
								<tr>
									<td></td><td>ขอแสดงความนับถือ</td>
								</tr>
								<tr>
									<td></td><td height="100px"></td>
								</tr>
								<tr>
									<td colspan="2" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;นายประหยัด  ศรีวิชัย&nbsp;)</td>
								</tr>
								<tr>
									<td colspan="2" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;รองนายกเทศมนตรี ปฏิบัติราชการแทน<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nayok_position.'</td>
								</tr>
								
								</table>
								</td>
								</tr>
								
				</table>
				
					
			
				</div>
				<BR><BR><BR><BR><BR><BR>
				<table>
						<tr>
								<td>กองช่าง <br>โทร (๐๕๓) ๒๗๖๔๙๑ ต่อ ๓๐๓<br>โทรสาร (๐๕๓) ๘๐๕๑๘๓<br>'.$domainname.'<br>ไปรษณีย์อีเล็กทรอนิกส์ : kongchangmuc2516@gmail.com</td>
								</tr>
					</table>
				</div>
				
				</div>


				<div class="page2">
				<div class="subpage2">
				<div id="thfont">
					<table height="100%" width="100%" border="0">
					<tr><td height="33%" width="30%"><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR></td><td width="50%"></td><td width="20%"></td></tr>
					<tr><td height="33%" align="left" valign="top" style="font-size:8px;"><img src="http://yota.maehia.go.th/images/krut.jpg" width="40px" height="40px"><br>กองช่าง<br>'.$customer_name.'<br>อ.เมือง<br>จ.เชียงใหม่<br>'.ThaiNum("50100").'</td><td align="left" valign="center">ผู้รับ<br>'.$name.'<br>'.ThaiNum($add_address).'    หมู่ที่ '.ThaiNum($add_moo).'<br>ตำบล'.$add_tambol.'<br>อำเภอ'.$add_amphur.'<br>จังหวัด'.$add_province.'</td><td align="right" valign="top"><div align="center" style="border:solid 1px #073fd1;font-size:8px;">ชำระค่าฝากส่งเป็นรายเดือน<br>ใบอนุญาตเลขที่ '.ThaiNum("30/2543").'<br>ปณ.พระสิงห์</div></td></tr>
					<tr><td height="33%"></td><td></td><td></td></tr>
				</table>
				</div>
				</div>
				</div>';
				

		}
			
			echo '</body></html>';
?>