<?php

error_reporting(0);

$sql = "SELECT * FROM tb_citizen WHERE status != '1'  ORDER BY name asc";

$month = date("Y")."-".date("m");


if (isset($_POST['btsave']) != "") {

  $moo =  $_POST['frm_moo'];

  $Year = $_POST['frm_year'];
  $Month = $_POST['frm_month'];

	$month = $Year."-".$Month;

  if ($moo != "") {
    $sql = "SELECT * FROM tb_citizen WHERE status != '1' AND moo = '$moo'  ORDER BY name asc";
  }

}

$monthkey = MonthYaerThaiL($month);

?>



<fieldset>
	<div class="content-table">
    <h3>ประวัติการจ่ายเบี้ย</h3>
    <hr>

<br>
		<div class="content-input" style="width:90%;">
			<form name="frmData" method="POST" class="form-inline" enctype="multipart/form-data">
			<table width="100%">
				<tr>
					<td align="center">
            เดือน <select name="frm_month" class="form-control" id="frm_month">
              <option value=''></option>
              <?php
                $sqlmoo="select * from  month order by id";
              $rsmoo=rsQuery($sqlmoo);
              if($rsmoo){
                while($dmoo=mysqli_fetch_assoc($rsmoo)){
                  $mooid=$dmoo['id'];
                  $mooname=$dmoo['month'];
                  if($mooid==$Month){
                    echo "<option value='$mooid' selected>$mooname</option>";
                  }else{
                    echo "<option value='$mooid'>$mooname</option>";
                  }
                }
              }
              ?>
            </select>
                &nbsp;&nbsp;ปี
              <select name="frm_year" class="form-control" style="width:100px">
                <option value=''></option>
  						<?php
  						$year = date('Y')+543;
  						$numyear = $year-10;
  						for ($i=$numyear; $i <= $year; $i++) {
  							$valyear = $numyear-543;
                if($valyear==$Year){
                    echo "<option value='$valyear' selected>$numyear</option>";
                  }else {
                    echo "<option value='$valyear'>$numyear</option>";
                  }
  							$numyear++;
  						}

  						?>
  						</select>

            &nbsp;&nbsp;หมู่บ้าน

            <select name="frm_moo" class="form-control" id="moo">
              <option value=''></option>
              <?php
                $sqlmoo="select * from  tb_moo order by id";
              $rsmoo=rsQuery($sqlmoo);
              if($rsmoo){
                while($dmoo=mysqli_fetch_assoc($rsmoo)){
                  $mooid=$dmoo['id'];
                  $mooname=$dmoo['name'];
                  if($mooid==$moo){
                    echo "<option value='$mooid' selected>$mooname</option>";
                  }else{
                    echo "<option value='$mooid'>$mooname</option>";
                  }
                }
              }
              ?>
            </select>
            <input class="btn btn_sub" type="submit" name="btsave" value="ค้นหา">
					</td>
				</tr>

			</table>

</div>

    <br>
<div name="data_table" id="data_table">

  <?php echo "<h4>ประวัติการจ่ายเบี้ยประจำเดือน ".$monthkey."</h4>" ?>

  <table id="example" class="table table-striped table-bordered" style="width:100%">
    <tr>
      <th colspan="3"></th>
			<th colspan="3">ประเภทเบี้ย</th>
			<th colspan="2">การจ่ายเบี้ย</th>
		</tr>
		<tr>
			<th>ลำดับ</th>
			<th>ชื่อ-นามสกุล</th>
			<th>เลขที่บัตรประชาชน</th>
      <th>ผู้สูงอายุ</th>
      <th>ผู้พิการ</th>
			<th>ผู้ป่วยโรคเอดส์</th>
			<th>จำนวน</th>
			<th>วันที่จ่าย</th>
		</tr>
		<?php

    $n = 1;

    $rs = rsQuery($sql);
    while ($row = mysqli_fetch_array($rs)) {

      $datepay = "";

      $prename =  FindRS("select name from tb_prename where id = ".$row['prename'],"name");
      $name = $prename . " " . $row['name'];
      $surname = $row['surname'];
      $fullname = $name." ".$surname;
      $personid = $row['personid'];
      $address = $row['address'];

			$sqls = "SELECT a.*,b.* FROM tb_welfare_request a
			INNER JOIN tb_welfare_pay b on a.id = b.request_id
			WHERE a.personid = '$personid' AND b.month = '$month'";
      $rss = rsQuery($sqls);
			$sumpay = "";

      $type1 = "";
      $type2 = "";
      $type3 = "";



			while ($rows = mysqli_fetch_array($rss)) {
        if ($rows['type'] == 1) {
          $type1 = "x";
          $numtype1++;
        }elseif ($rows['type'] == 2) {
          $type2 = "x";
          $numtype2++;
        }elseif ($rows['type'] == 3) {
          $type3 = "x";
          $numtype3++;
        }
				$sumpay = $sumpay+$rows['amount'];
				$datepay = DateThai($rows['paydate']);
			}
      $allsum = $allsum+$sumpay;
      if ($sumpay != "") {
        echo "<tr align='center'><td>$n</td><td align='left'>$fullname</td><td>$personid</td><td>$type1</td><td>$type2</td><td>$type3</td><td>$sumpay</td><td>$datepay</td></tr>";
        $n++;
      }
    }

    echo "<tr><td colspan='8'> </td></tr>";
		echo "<tr align='center' style='font-weight: bold;'><td align='right' colspan='3'>ยอดรวมทั้งสิ้น</td><td>$numtype1</td><td>$numtype2</td><td>$numtype3</td><td>$allsum</td><td></td></tr>";



			/*if($year > 0){
				echo "<tr><td>$year</td><td>$type1</td><td>$type2</td><td>$type3</td><td>$sumtype</td><td>$sumpay</td></tr>";
				echo "<tr><td colspan='9'> </td></tr>";
				echo "<tr style='font-weight: bold;'><td align='right'>ยอดรวมทั้งสิ้น</td><td>$type1</td><td>$type2</td><td>$type3</td><td></td><td>$sumpay</td></tr>";
			}else{
				echo "<tr><td colspan='9' align='center'>ยังไม่มีข้อมูล</td></tr>";
			}*/
		?>
	</table>
</div>

				<input type="hidden" id="create_excel" name="create_excel" value="create excel">
	</div>
	<div style="text-align:center;">
		<textarea name="frm_code" id="frm_code" style="display:none;"></textarea>
			<input type="button" class="button button1" id="create_excel" name="create_excel" onClick="this.form.action='modules/configwelfare/excel.php'; submit()">
			<input name="b_print" type="button" class="button button2" onClick="printdiv('data_table');">

		</input>
	</div>
</form>
</fieldset>

<script>

	$(document).ready(function(){

			var code = $('#data_table').html();
			document.getElementById("frm_code").innerHTML = code;

			$('#create_excel').click(function(){
				var excel_data = $('#data_table').html();
				var data = encodeURI(excel_data);
				var page = "modules/configwelfare/excel.php&data="+excel_data;

				window.location = page;
				/*$.ajax({
					type: "POST",
					url: page,
					data: {data: excel_data},
					success: function(response) {

           }
				 });*/
});
});



function printdiv(printpage,fontsize)
{

if(fontsize==null){
 var fon1=12;
}else{
 var fon1=fontsize;
}
var headstr = "<html><head><title></title><style type='text/css'>[data-negative]{color: red;}@import url(../font/thsarabunnew.css);table tr:nth-child(odd) td{ background-color:#efefef;}table tr:nth-child(even) td{background-color:white;} body,th,td{font-family:THSarabunNew;font-size:"+fon1+"px;padding:3px;} th{background-color:#7f7f7f;color:white;}.title{ width:100%;background-color:#272727;color:yellow;}.th1{width:70%;height:30px; line-height:30px; background-color:#7f7f7f;color:white;display:inline-block;}.th2{width:30%;height:30px;line-height:30px;background-color:#7f7f7f;color:white;display:inline-block;}.tr1{width:70%;height:30px;line-height:30px;border-bottom:1px dashed #004080;color:blue;display:inline-block;}.tr2{width:30%;height:30px;line-height:30px;border-bottom:1px dashed #004080;color:blue;display:inline-block;}.hideul{margin-left:20px;width:100%;list-style:none;}.hideul li{height:30px;line-height:30px; background-color:#d8fcf8;border-bottom:1px dashed #868686;width:90%;}.hideul li:hover{cursor:pointer;background-color:#ffffcc;}  .bottomLine{ background-color:#b6b6b6;color:black;} .pagebreak{page-break-after: always;} @page {size: 210mm 297mm; margin: 25mm 25mm 25mm 25mm; }@media print {@page {margin:15mm 5mm 15mm 5mm} body {background: #FFF;}table,td{overflow:visible !important;} }</style></head><body>";
var footstr = "</body></html>";
var newstr = document.all.item(printpage).innerHTML;
//var oldstr = document.body.innerHTML;
//document.body.innerHTML = headstr+newstr+footstr;
//window.print();
//document.body.innerHTML = oldstr;
//return false;

myWindow=window.open('','_blank');
myWindow.document.write(headstr+newstr+footstr);
myWindow.focus();
myWindow.document.close();

}


</script>
