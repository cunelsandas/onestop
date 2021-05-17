<script>
	function ChkEmpty(txtName){
		if(document.getElementById(txtName).value==""){
			alert('ป้อนข้อมูลก่อนดำเนินการต่อไป');
			document.getElementById(txtName).focus();
			return false;
		}
}

</script>

<?php
$part = "../fileupload/mod/";

$modid=$_GET['_modid'];
$uploadfoldername="/images/";
$btvalue="addnew";

$sql="Select * From tb_mod Where modid='".$_GET['edit']."'";
$rs=rsQuery($sql);
$row = mysqli_fetch_array($rs);

$id = $row['modid'];
$check = getimagesize($_FILES["frm_image"]["tmp_name"]);


	if(isset($_POST['btedit'])){  // เมื่อมีการคลิกปุ่มแก้ไขโมดูล


		switch($_POST['btedit']){
			case "addnew":

if ($check !== false){

			$filename = $_FILES["frm_image"]["name"];
			$ext = end(explode(".",$filename));
			$newname = 'mod_'.$id.'.'.$ext;
			$filetmp = $_FILES["frm_image"]["tmp_name"];
			$filetype = $_FILES["frm_image"]["type"];
			$filepath = $part.$newname;

			if (move_uploaded_file($filetmp,$filepath)) {

				$sql = "INSERT INTO tb_mod(modname,modtype,moddetail,modpath,typeid,tablename,foldername,groupid,listno,bannername) Values('".$_POST['txtname']."','".$_POST['txttype']."','".$_POST['txtdetail']."','".$_POST['txtpath']."','".$_POST['cbomodtype']."','".$_POST['txttablename']."','".$_POST['txtfoldername']."','".$_POST['cbogroupid']."','".$_POST['txtlistno']."','".$newname."')";
				$alert = "<script>alert('เพิ่มข้อมูลสำเร็จ')</script>";

			} else {
					$alert = "<script>alert('Image not upload.'); </script>";
			}

		}else {
			$sql = "INSERT INTO tb_mod(modname,modtype,moddetail,modpath,typeid,tablename,foldername,groupid,listno) Values('".$_POST['txtname']."','".$_POST['txttype']."','".$_POST['txtdetail']."','".$_POST['txtpath']."','".$_POST['cbomodtype']."','".$_POST['txttablename']."','".$_POST['txtfoldername']."','".$_POST['cbogroupid']."','".$_POST['txtlistno']."')";
			$alert = "<script>alert('เพิ่มข้อมูลสำเร็จ')</script>";
		}

				break;

			case "edit":


if ($check !== false){

				$filename = $_FILES["frm_image"]["name"];
				$ext = end(explode(".",$filename));
				$newname = 'mod_'.$id.'.'.$ext;
				$filetmp = $_FILES["frm_image"]["tmp_name"];
				$filetype = $_FILES["frm_image"]["type"];
				$filepath = $part.$newname;

				if (move_uploaded_file($filetmp,$filepath)) {


					if(!empty($filebanner)){
							$banner=$filebanner;
						}else{
							$banner=$newname;
					}

				$sql="UPDATE tb_mod SET modname='".EscapeValue($_POST['txtname'])."',modtype='".EscapeValue($_POST['txttype'])."',moddetail='".EscapeValue($_POST['txtdetail'])."',modpath='".EscapeValue($_POST['txtpath'])."',typeid='".$_POST['cbomodtype']."',tablename='".$_POST['txttablename']."',foldername='".$_POST['txtfoldername']."',groupid='".$_POST['cbogroupid']."',listno='".$_POST['txtlistno']."',bannername='$banner' Where modid='".EscapeValue($_GET['edit'])."'";
					$alert="<script>alert('แก้ไขข้อมูลสำเร็จ')</script>";

				} else {
						$alert = "<script>alert('Image not upload.'); </script>";
				}
}else {
	$sql="UPDATE tb_mod SET modname='".EscapeValue($_POST['txtname'])."',modtype='".EscapeValue($_POST['txttype'])."',moddetail='".EscapeValue($_POST['txtdetail'])."',modpath='".EscapeValue($_POST['txtpath'])."',typeid='".$_POST['cbomodtype']."',tablename='".$_POST['txttablename']."',foldername='".$_POST['txtfoldername']."',groupid='".$_POST['cbogroupid']."',listno='".$_POST['txtlistno']."' Where modid='".EscapeValue($_GET['edit'])."'";
	$alert="<script>alert('แก้ไขข้อมูลสำเร็จ')</script>";

}


				break;

		}
		//echo $v_bannername;
		$saveedit=rsQuery($sql);
		if($saveedit){

			echo $alert;
			echo"<script>window.location.href='main.php?_modid=".$modid.";</script>";

		}

	}



if(isset($_GET['del'])){  // ถ้าหากมีการกดปุ่มลบ
	$sql="Delete From tb_mod Where modid='".$_GET['del']."'";
		$saveedit=rsQuery($sql);
		if($saveedit){
			echo"<script>window.location.href='main.php?_modid=".$modid.";</script>";;

		}
}
	if(isset($_GET['edit'])){
		$btvalue="edit";
	$sql="Select * From tb_mod Where modid='".$_GET['edit']."'";
	$rs=rsQuery($sql);
	$row=mysqli_fetch_assoc($rs);

		$modname=$row['modname'];
		$modtype=$row['modtype'];
		$moddetail=$row['moddetail'];
		$modpath=$row['modpath'];
		$tablename=$row['tablename'];
		$foldername=$row['foldername'];
		$groupid=$row['groupid'];
		$listno=$row['listno'];
		$bannername=$row['bannername'];
	}
	if(isset($_GET['addnew'])){
		$modname="";
		$modtype="";
		$moddetail="";
		$modpath="";
		$tablename="";
		$foldername="";
		$bannername="";
		$listno="0";
	}

	if(isset($_POST['btFolder'])){
		$dir=$_SERVER['DOCUMENT_ROOT']."/".$gloUploadPath."/";
		if (!file_exists($dir.$_POST['txtCreatefoldername'])) {
		   mkdir($dir."/".$_POST['txtCreatefoldername'], 0777, true);
			echo "<script>alert('สร้างโฟลเดอร์  ".$_POST['txtCreatefoldername']." สำเร็จ')</script>";
		}else{
			echo "<script>alert('".$_POST['txtCreatefoldername']." มีในระบบแล้ว ไม่สามารถสร้างโฟลเดอร์ซ้ำได้')</script>";
		}
	}

	if(isset($_POST['btTable'])){
		$tablename=$_POST['txtcreate_tablename'];
		$tabletype=$_POST['cbocreate_tabletype'];
		$create_code=FindRS("select * from tb_modpath where id=".$tabletype,"create_table");
		$sql="CREATE TABLE IF NOT EXISTS $tablename ".$create_code;
		$chk="Show TABLES LIKE '".$tablename."'";
		$rsChk=rsQuery($chk);
		if(mysqli_num_rows($rsChk)>0){
			$data=mysqli_fetch_array($rsChk);
			echo "<script>alert('".$data['0']." มีอยู่ก่อนแล้วไม่สามารถสร้างตารางซ้ำได้')</script>";

		}else{
		$rsNew=rsQuery($sql);
		if($rsNew){
			echo "<script>alert('".$tablename."  สร้างสำเร็จ')</script>";
		}else{
			echo $sql;
		}
		}

	}
	?>

<div class="panel panel-default col-12">
    <div style="background-color: #222222" class="panel-heading">
        <h5 style="color: #fffbfd">สร้างโมดูล</h5>
    </div>


<div class="content-box">

    <br><p style="right:15%;position:absolute;"><?php echo"
    <a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&addnew=addnew\"  class='btn btn-success'>เพิ่มรายการใหม่</a>
    ";?></p>
    <br>
    <br>

    <!-- -------------------------- Start panel body ---------------------------------- -->
    <div class="panel-body">
        <!-- -------------------------- Start form ---------------------------------- -->

        <div class="row col-md-12">
            <div class="col-md-1"></div>

            <div style="background-color: rgba(157,157,157,0.8)" class="well col-md-10">
                <div class="row col-md-12">

    <form name="frmedit" method="POST" action="" enctype="multipart/form-data">


        <div class="form-group row">
            <label class="col-sm-2" style="text-align: right; padding-top: 6px">ชื่อแสดงในเว็บ: </label>
            <div class="col-sm-10">
                <input class="form-control" type="text" name="txtname" style="width: 40%" value="<?php echo $modname;?>" />
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2" style="text-align: right; padding-top: 6px">ชื่อโมดูล: </label>
            <div class="col-sm-10">
                <input class="form-control" type="text" name="txttype"  style="width: 40%" value="<?php echo $modtype;?>" />
                *สำหรับค้นหาในหน้าเว็บ ต้องเป็นภาษาอังกฤษและตรงกับระบบ
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2" style="text-align: right; padding-top: 6px">คำอธิบายโมดูล: </label>
            <div class="col-sm-10">
                <textarea class="form-control" name="txtdetail" rows="5" style="width: 60%"><?php echo $moddetail;?></textarea>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2" style="text-align: right; padding-top: 6px">ประเภทโมดูล (Wms Path): </label>
            <div class="col-sm-10">
                <select name="txtpath" class="form-control" style="width: 30%">
                    <option value="">ยังไม่ได้กำหนด</option>
                    <?php
                    $sql="select * from tb_modpath order by name";
                    $rs=rsQuery($sql);
                    if($rs){
                        while($dpath=mysqli_fetch_assoc($rs)){
                            $id=$dpath["id"];
                            $name=$dpath['name'];
                            if($id==$modpath){
                                echo "<option value='$id' selected>$name</option>";
                            }else{
                                echo "<option value='$id'>$name</option>";
                            }
                        }
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2" style="text-align: right; padding-top: 6px">ตารางเก็บข้อมูล (Table name): </label>
            <div class="col-sm-10">
                <select name="txttablename" class="form-control" style="width: 30%">
                    <option value="">ไม่กำหนด</option>


                    <?php
                    if($tablename<>""){
                        echo "<option value='$tablename' selected>$tablename</option>";
                    }
                    $sql="show tables";
                    $tb=rsQuery($sql);
                    if($tb){
                        while($data=mysqli_fetch_array($tb)){
                            $checkdup=FindRS("select * from tb_mod where tb_mod.tablename='".$data['0']."'",tablename);
                            //echo "<option>".$data['0']." - ".$checkdup."</option>";
                            if($checkdup==""){
                                $chktb=substr($data['0'],0,3);
                                if($chktb=="tb_"){

                                    echo "<option value=\"".$data['0']."\">".$data['0']."</option>";

                                }
                            }
                        }
                    }
                    ?>
                </select>
                * ถ้าไม่พบตารางที่ต้องการให้ไปสร้างตารางใหม่ก่อน
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2" style="text-align: right; padding-top: 6px">โฟลเดอร์เก็บรูป (Foldername): </label>
            <div class="col-sm-10">
                <select name="txtfoldername" class="form-control" style="width: 30%">
                    <option value="">ไม่กำหนด</option>
                    <?php
                    if($foldername<>""){
                        echo "<option value='$foldername' selected>$foldername</option>";
                    }
                    $dir=$_SERVER['DOCUMENT_ROOT']."/".$gloUploadPath."/";

                    if (is_dir($dir)){
                        if ($dh = opendir($dir)){
                            while (($file = readdir($dh)) !== false){
                                $chkfile=substr($file,0,1);
                                if($chkfile<>"."){
                                    $checkdup=FindRS("select * from tb_mod where tb_mod.foldername='".$file."'",foldername);
                                    //echo "<option>".$file."-".$checkdup."</option>";
                                    if($checkdup==""){

                                        echo "<option value=\"".$file."\">" . $file . "</option>";

                                    }
                                }
                            }
                            closedir($dh);
                        }
                    }
                    ?>
                </select>* ถ้าไม่พบโฟลเดอร์ที่ต้องการให้ไปสร้างโฟลเดอร์ใหม่ก่อน
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2" style="text-align: right; padding-top: 6px">เมนูระบบจัดการ: </label>
            <div class="col-sm-10">
                <select name="cbomodtype" class="form-control" style="width: 30%">
                    <?php
                    $sql="select * from tb_modtype order by listno";
                    $rec=rsQuery($sql);
                    if($rec){
                        while($modtype=mysqli_fetch_assoc($rec)){
                            if($row['typeid']==$modtype['id']){
                                echo"<option value=\"".$modtype['id']."\" selected>".$modtype['name']."</option>";
                            }else{
                                echo"<option value=\"".$modtype['id']."\">".$modtype['name']."</option>";
                            }

                        }
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2" style="text-align: right; padding-top: 6px">เมนูหน้าเว็บ: </label>
            <div class="col-sm-10">
                <select name="cbogroupid" class="form-control" style="width: 30%">
                    <option value="0">ไม่แสดง</option>
                    <?php
                    $sql="select * from tb_menugroup order by listno";
                    $rec=rsQuery($sql);
                    if($rec){
                        while($menugroup=mysqli_fetch_assoc($rec)){
                            if($row['groupid']==$menugroup['id']){
                                echo"<option value=\"".$menugroup['id']."\" selected>".$menugroup['name']."</option>";
                            }else{
                                echo"<option value=\"".$menugroup['id']."\">".$menugroup['name']."</option>";
                            }

                        }
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2" style="text-align: right; padding-top: 6px">ลำดับการแสดงเมนูในเว็บ: </label>
            <div class="col-sm-10">
                <input class="form-control" type="text" name="txtlistno" style="width: 10%" value="<?php echo $listno;?>">
            </div>
        </div>


        <div class="form-group row ">
            <label class="col-sm-2" style="text-align: right; padding-top: 6px">รูปแบนเนอร์: </label>
            <div class="input-group col-sm-10">
                <label class="input-group-btn">
                    <span class="btn btn-default">
                        Browse&hellip; <input type="file" name="frm_image" id="frm_image" style="display: none;">
                    </span>
                </label>
                <input type="text" class="form-control" style="width: 50%" readonly>

            </div>
                    </div>


        <div class="form-group row">
            <div class="col-sm-12" style="text-align: center">
                <input class="btn btn-lg btn-default" type="submit" name="btedit" value="<?php echo $btvalue;?>"/>
            </div>
        </div>

	<br>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>




        <div class="row col-md-12">
            <div class="col-md-1"></div>

            <div style="background-color: rgba(157,157,157,0.8)" class="well col-md-10">
                <div class="row col-md-12">

	<table class="content-detail">
		<tr>
			<td>สร้างตารางเก็บข้อมูลและโฟลเดอร์</td>
		</tr>
		<tr>
			<td>ชื่อตารางเก็บข้อมูลใหม่ (Table name) ต้องขึ้นต้นด้วย tb_&nbsp;<input type="text"  name="txtcreate_tablename" id="txtcreate_tablename">&nbsp;&nbsp;ประเภทตาราง
                <select name="cbocreate_tabletype">
				<?php
							$sql="select * from tb_modpath where name like 'Page_%' order by name";
							$rs=rsQuery($sql);
							if($rs){
								while($dpath=mysqli_fetch_assoc($rs)){
									$id=$dpath["id"];
									$name=$dpath['name'];

										echo "<option value='$id'>$name</option>";

								}
							}
					?>


				</select>
				<input type="submit" name="btTable" value="สร้างฐานข้อมูลใหม่" onclick="return ChkEmpty('txtcreate_tablename')">
			</td>
		</tr>
		<tr>
			<td>ชื่อโฟลเดอร์เก็บข้อมูล&nbsp;<input type="text" name="txtCreatefoldername" id="txtCreatefoldername">&nbsp;
                <input type="submit" name="btFolder" value="สร้างโฟลเดอร์ใหม่" onclick="return ChkEmpty('txtCreatefoldername')">
            </td>
		</tr>
	</table>


	</form>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>


		<div id="show_data" class="row col-md-12">
			<table id="example" class="table table-striped table-bordered" style="width:100%">
			<thead>
<tr>
	<th align="center">เมนูระบบจัดการ</th>
	<th align="center">เมนูหน้าเว็บ</th>
	<th align="center">ลำดับการแสดง</th>
	<th align="center">ชื่อโมดูล</th>
	<th align="center">ชื่อเรียกใช้</th>
	<th align="center">ตาราง(Table)</th>
	<th align="center">ปรับปรุง</th>
</tr>
</thead>
<tbody>
<?php
	$sql="Select * From tb_mod Order by typeid,modname";
	$rs=rsQuery($sql);
	if(mysqli_num_rows($rs)==0){
		echo"<tr height=\"25\" bgcolor=\"#FFFFFF\"><td align=\"center\">- - - - ยังไม่มีการตั้งค่าใด ๆ  - - - -</td></tr>";
	}else{
		while($row=mysqli_fetch_assoc($rs)){
			echo"<tr>";
			$typename=FindRS("select * from tb_modtype where id=".$row['typeid'],"name");
			$menugroup=FindRS("select * from tb_menugroup where id=".$row['groupid'],"name");
			echo "<td>$typename</td>";
			echo "<td>$menugroup</td>";
			echo "<td align='center'>".$row['listno']."</td>";
			echo "<td>&nbsp;".$row['modname']."</td>";
			echo "<td>&nbsp;".$row['modtype']."</td>";
			echo "<td>&nbsp;".$row['tablename']."</td>";
			echo "<td align=\"center\"><a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&edit=".$row['modid']."\">แก้ไข<img src=\"\" width=\"18\" border=\"0\" /></a>&nbsp;&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&del=".$row['modid']."\" onclick=\"return confirm('คุณต้องการลบโมดูล : ".$row['modname']." นี้หรือไม่ค่ะ ?');\">ลบ</a></td>";
			echo"</tr>";
		}
	}
?>
</tbody>
</table>
</div>



<!--
<br>
	<form name="frm01" method="POST" action="" enctype="multipart/form-data">
	<table width='100%' class='content-input'>
		<tr>
			<td>ค้นหาวันที่ <input type='date' name='datestart' id='datestart' value='<?php echo ChangeYear(date('Y-m-d'),"th");?>'> ถึงวันที่ <input type='date' name='dateend' id='dateend' value=''></td>
		</tr>
		<tr>
			<td><input type='submit' name='btfind' value='ค้นหา'>&nbsp;&nbsp;<input name="b_print" type="button" class="ipt"   onClick="printdiv('printDetail');" value=" Print "></td>
		</tr>
	</table>
	</form>

	<?php

			/*if(isset($_POST['datestart'])){
				$datestart=ChangeYear($_POST['datestart'],"en");
				$dateend=ChangeYear($_POST['dateend'],"en");
			}else {
				$datestart=firstOfMonth(getdate());
				$dateend=lastOfMonth(getdate());
			}

			$title="รายงานสรุปการบันทึกข้อมูลเว็บไซต์ $customer_name ระหว่างวันที่ ".DateThai($datestart)." ถึงวันที่ ".DateThai($dateend);
			$sqlMod="select * from tb_mod where typeid in (1) AND tablename<>''";
			$rsMod=rsQuery($sqlMod);
			if($rsMod){
				while($dataMod=mysqli_fetch_assoc($rsMod)){
					$modName=$dataMod['modname'];
					$tableName=$dataMod['tablename'];
					$sqlRec = "select '$modName' as mName , sum(if(month(datepost)=1,1,0))as 'มค', sum(if(month(datepost)=2,1,0))as 'กพ', sum(if(month(datepost)=3,1,0))as 'มีค', sum(if(month(datepost)=4,1,0))as 'เมย', sum(if(month(datepost)=5,1,0))as 'พค', sum(if(month(datepost)=6,1,0))as 'มิย', sum(if(month(datepost)=7,1,0))as 'กค', sum(if(month(datepost)=8,1,0))as 'สค', sum(if(month(datepost)=9,1,0))as 'กย', sum(if(month(datepost)=10,1,0))as 'ตค', sum(if(month(datepost)=11,1,0))as 'พย', sum(if(month(datepost)=12,1,0))as 'ธค',count(*) as total From $tableName Where datepost between '$datestart' and '$dateend'";


					$rs=rsQuery($sqlRec);
					$num_field=mysqli_num_fields($rs);
					if($rs){
						while($data=mysqli_fetch_array($rs)){
							$strTable .="<tr>";
							for($i=0;$i<$num_field;$i++){
								$count=($data[$i]==null?0:$data[$i]);
								if($i>0){$align='center';}else{$align='left';}
								$strTable .="<td align='$align'>".$count."</td>";

								$sum[$i] +=$count;
							}
							$strTable .="</tr>";

						}
						$strSumTable ="<tr><th align='right'>รวม</th><th>".$sum['1']."</th><th>".$sum['2']."</th><th>".$sum['3']."</th><th>".$sum['4']."</th><th>".$sum['5']."</th><th>".$sum['6']."</th><th>".$sum['7']."</th><th>".$sum['8']."</th><th>".$sum['9']."</th><th>".$sum['10']."</th><th>".$sum['11']."</th><th>".$sum['12']."</th><th>".$sum['13']."</th></tr>";
					}
				}
			}*/
	?>

	<div id='printDetail'>
			<table width='100%' class='content-table'>
				<tr><th colspan='14' align='center'><?php //echo $title;?></th></tr>
				<tr>
					<th>ชื่อโมดูล</th>
					<th>ม.ค.</th>
					<th>ก.พ.</th>
					<th>มี.ค.</th>
					<th>เม.ย.</th>
					<th>พ.ค.</th>
					<th>มิ.ย.</th>
					<th>ก.ค.</th>
					<th>ส.ค.</th>
					<th>ก.ย.</th>
					<th>ต.ค.</th>
					<th>พ.ย.</th>
					<th>ธ.ค.</th>
					<th>รวม</th>
				</tr>
				<?php //echo $strTable.$strSumTable;?>
			</table>

	</div>
        -->
</div>
</div>
</div>

<script>


    $(function() {
        // We can attach the `fileselect` event to all file inputs on the page
        $(document).on('change', ':file', function() {
            var input = $(this),
                numFiles = input.get(0).files ? input.get(0).files.length : 1,
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [numFiles, label]);
        });

        // We can watch for our custom `fileselect` event like this
        $(document).ready( function() {
            $(':file').on('fileselect', function(event, numFiles, label) {

                var input = $(this).parents('.input-group').find(':text'),
                    log = numFiles > 1 ? numFiles + ' files selected' : label;

                if( input.length ) {
                    input.val(log);
                } else {
                    if( log ) alert(log);
                }
            });

        });
    });


	/*$(function () {
		    var d = new Date();
		     var toDay =(d.getFullYear() + 543)  + '-' + (d.getMonth() + 1) + '-' + d.getDate();

	  $("#datestart").datepicker({ showOn: 'button', changeMonth: true, changeYear: true,dateFormat: 'yy-mm-dd', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});


	 $("#dateend").datepicker({ showOn: 'button', changeMonth: true, changeYear: true,dateFormat: 'yy-mm-dd', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});

	  $("#datesend").datepicker({ showOn: 'button', changeMonth: true, changeYear: true,dateFormat: 'yy-mm-dd', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
	});
*/
	/*function printdiv(printpage)
{
var headstr = "<html><head><title></title><style type='text/css'>@import url(../font/thsarabunnew.css);table tr:nth-child(odd) td{ background-color:#efefef;}table tr:nth-child(even) td{background-color:white;} th,td{font-family:THSarabunNew;font-size:13px;padding:3px;} th{background-color:#7f7f7f;color:white;}.title{	width:100%;background-color:#272727;color:yellow;}.th1{width:70%;height:30px;	line-height:30px;	background-color:#7f7f7f;color:white;display:inline-block;}.th2{width:30%;height:30px;line-height:30px;background-color:#7f7f7f;color:white;display:inline-block;}.tr1{width:70%;height:30px;line-height:30px;border-bottom:1px dashed #004080;color:blue;display:inline-block;}.tr2{width:30%;height:30px;line-height:30px;border-bottom:1px dashed #004080;color:blue;display:inline-block;}.hideul{margin-left:20px;width:100%;list-style:none;}.hideul li{height:30px;line-height:30px;	background-color:#d8fcf8;border-bottom:1px dashed #868686;width:90%;}.hideul li:hover{cursor:pointer;background-color:#ffffcc;}</style></head><body>";
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

}*/
</script>
