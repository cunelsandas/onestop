<div class="content-box">
<?php

################## เพิ่มฝ่าย #######################
$modid=$_GET['_modid'];
//if(isset($_POST['btadddep'])){ // เมื่อมีการคลิกปุ่มเพิ่มฝ่าย
//	if($_POST['depname']<>""){
//		$sql="Select * From tb_department Where depname='".$_POST['depname']."'";
//		$rs=rsQuery($sql);
//		if(mysqli_num_rows($rs)==0){
//			$sql="INSERT INTO tb_department(depname) Values('".$_POST['depname']."')";
//			$rssave=rsQuery($sql);
//		}else{
//			echo"<p style=\"margin-left:10px;\">ชื่อ ".$_POST['depname']." นี้มีอยู่แล้วในระบบ</p>";
//		}
//	}
//}
?>

<form name="adddep" method="POST" action="">
<!--<p style="margin-left:10px;">เพิ่มฝ่าย : <input type="text" class="txt" name="depname" autocomplete="off" style="width:250px;" />&nbsp;<input class="bt" type="submit" name="btadddep" value="เพิ่มฝ่าย"/></p> -->
</form>

<!-- ################# จบเพิ่มฝ่าย ######################## -->

<?php

if(isset($_POST['btn_add_dep'])){
	$dep = $_POST['frm_dep'];
	$sql = "INSERT INTO department(department) VALUES ('$dep')";
	$rs = rsQuery($sql);
	echo "<script>alert('เพิ่มข้อมูลเทศบาลแล้วค่ะ')</script>";
}

if(isset($_GET['del'])){
	$del=EscapeValue($_GET['del']);
	$sql="Delete From tb_user Where userid='".$del."'";
	$rsdel=rsQuery($sql);
	$sql="Delete From tb_select_mod Where userid='".$del."'";
	$rsdel=rsQuery($sql);
}
if(isset($_GET['edit'])){ // เมื่อมีการแก้ไขข้อมูลของผู้ใช้งาน
		$edit=EscapeValue($_GET['edit']);
		if(isset($_POST['btedituser'])){

			$sql="UPDATE tb_user SET 			nameuser='".EscapeValue($_POST['txtnameuser'])."',surname='".EscapeValue($_POST['txtsurname'])."',username='".EscapeValue($_POST['txtusername'])."',pw='".EscapeValue(md5($_POST['txtpassword']))."',pwfix='".EscapeValue($_POST['txtpassword'])."',department_id='".EscapeValue($_POST['dep'])."' Where userid='".$edit."'";
			$rssave=rsQuery($sql);
			$sql="Delete From tb_select_mod Where userid='".$edit."'";
			$rsdel=rsQuery($sql);
				for($i=0;$i<count($_POST['mod']);$i++){
					$sql="INSERT INTO tb_select_mod(userid,modid) Values('".$edit."','".$_POST['mod'][$i]."')";
					$rsmod=rsQuery($sql);
				}
				//echo"<script>window.location.href='main.php?_mod=".$_GET['_mod']."';</script>";
		}

		$sql="Select * From tb_user Where userid='".$edit."'";
		$rs=rsQuery($sql);
		$ruser=mysqli_fetch_assoc($rs);
		$name=$ruser['nameuser'];
		$surname=$ruser['surname'];
		$username=$ruser['username'];
		$password=$ruser['pwfix'];
		$department=$ruser['department_id'];
		$btname="btedituser";
		$btvalue="แก้ไขข้อมูลผู้ใช้";
}else{
			if(isset($_POST['btadduser'])){
				$sql="Select username From tb_user Where username='".$_POST['txtusername']."'";
				$rs=rsQuery($sql);
				if(mysqli_num_rows($rs)==0){
					$sql="INSERT INTO tb_user(nameuser,surname,username,pw,pwfix,department_id) Values('".$_POST['txtnameuser']."','".$_POST['txtsurname']."','".$_POST['txtusername']."','".md5($_POST['txtpassword'])."','".$_POST['txtpassword']."','".$_POST['dep']."')";
					$username=$_POST['txtusername'];
					$rssave=rsQuery($sql);
					if($rssave){
						$strSQL="select * from tb_user where username='".$username."'";
						$re=rsQuery($strSQL);
						$uid=mysqli_result($re,0,"userid");
						for($i=0;$i<count($_POST['mod']);$i++){
							$sqlADD="INSERT INTO tb_select_mod(userid,modid) Values('".$uid."','".$_POST['mod'][$i]."')";
							$rsmod=rsQuery($sqlADD);
						}
					}
								//echo"<script>window.location.href='main.php?_mod=".$_GET['_mod']."';</script>";
				}else{
					echo"<p> User name ซ้ำ</p>";
				}
			}
		$name="";
		$surname="";
		$username="";
		$password="";
		$department="";
		$btname="btadduser";
		$btvalue="เพิ่มผู้ใช้งาน";

}
	?>

<div class="panel panel-default col-12">
    <div style="background-color: #222222" class="panel-heading">
        <h5 style="color: #fffbfd">กำหนดผู้ใช้งาน</h5>
    </div>
    <!-- -------------------------- Start panel body ---------------------------------- -->
    <div class="panel-body">
        <!-- -------------------------- Start form ---------------------------------- -->

          <div class="row col-md-12">
              <div class="col-md-1"></div>

              <div style="background-color: rgba(157,157,157,0.8)" class="well col-md-10">
                  <div class="row col-md-12">
										<form name="frmuser" method="POST" action="">
										<table width="70%" class="content-input">
										<tr>
											<td align="right">ชื่อผู้ใช้:&nbsp; </td>
											<td><input class="form-control" type="text" name="txtnameuser" value="<?php echo $name;?>" required/></td>
										</tr>
										<tr >
											<td align="right">นามสกุล:&nbsp; </td>
											<td><input class="form-control" type="text" name="txtsurname" value="<?php echo $surname;?>" /></td>
										</tr>
										<tr >
											<td align="right">User name:&nbsp; </td>
											<td><input class="form-control" type="text" name="txtusername" value="<?php echo $username;?>" required/></td>
										</tr>
										<tr >
											<td align="right">Password:&nbsp; </td>
											<td><input class="form-control" type="text" name="txtpassword" value="<?php echo $password;?>" required/></td>
										</tr>
										<!-- <tr >
											<td align="right">เทศบาล(เขต):&nbsp; </td>
											<td>
												<select class="form-control" name="dep" required>
												<option value="">- - - - กรุณาเลือกฝ่าย - - - -</option>
											<?php


											$department;

											$sql="Select * From department Order by id";
											$rs=rsQuery($sql);
											$num=mysqli_num_rows($rs);

											while($row=mysqli_fetch_assoc($rs)){
												if($department == $row['id']){
													echo"<option value=\"".$row['id']."\" selected>".$row['department']."</option>";
												}else {
													echo"<option value=\"".$row['id']."\" >".$row['department']."</option>";
												}
											}
											?>
											</select>
										</td>
										<td><button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">เพิ่ม</button></td>
									</tr> -->
										<tr>
											<td align="right" valign="top"> <br>กำหนดสิทธิ์การเข้าใช้งาน:&nbsp; </td>
											<td valign="top">
                      <br>
											<?php
											$sql="Select * from tb_mod Order by modid";
											$rs=rsQuery($sql);
											while($row=mysqli_fetch_assoc($rs)){
												$sql="Select * From tb_select_mod Where userid='".$_GET['edit']."' And modid='".$row['modid']."'";
												$rsmod=rsQuery($sql);
												if(mysqli_num_rows($rsmod)>0){
													echo"<input type=\"checkbox\" name=\"mod[]\" value=\"".$row['modid']."\" checked/>&nbsp;".$row['modname']."<br />";
												}else{
													echo"<input type=\"checkbox\" name=\"mod[]\" value=\"".$row['modid']."\"/>&nbsp;".$row['modname']."<br />";
												}
											}
											?>
											</td>
										</tr>
										</table>

                                            <div class="row" style="text-align: center; padding-top: 15px">
                                                <input class="btn btn-default" type="submit" name="<?php echo $btname;?>" value="<?php echo $btvalue;?>"/>
                                            </div>
										</form>
                    </div>
              </div>
              <div class="col-md-1"></div>
            </div>



						<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">เพิ่มข้อมูลเทศบาล(เขต)</h4>
        </div>
        <div class="modal-body">
					<form name="frm_add_dep" method="post" action="#" >
						<label for="frm_dep">เทศบาล</label>
						<input class="form-control" name="frm_dep"></input>


        </div>
        <div class="modal-footer">
					<button type="submit" name="btn_add_dep" class="btn btn-info">ตกลง</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
        </div>
      </div>
</form>
    </div>
  </div>



						<div id="show_data" class="row col-md-12">
								<table id="example" class="table table-striped table-bordered" style="width:100%">
										<thead>
										<tr>
												<th>*</th>
												<th>ชื่อผู้ใช้งาน</th>
												<th>เทศบาล(เขต)</th>
												<th>จัดการ</th>
										</tr>
										</thead>
										<tbody>
											<?php
											$sql="Select * from tb_user Order by userid";
											$rs=rsQuery($sql);
											$n = 1;
												empty($_GET['_mod'])?$mod="":$mod=$_GET['_mod'];
												while($row=mysqli_fetch_assoc($rs)){

													echo "<tr><td align=\"center\">".$n."</td>";
													echo "<td>&nbsp;".$row['nameuser']."</td>";
													echo "<td>xxx</td>";
													echo "<td align=\"center\"><a href=\"main.php?_modid=".$modid."&_mod=$mod&edit=".$row['userid']."\">แก้ไข</a>&nbsp;&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=$mod&del=".$row['userid']."\" onclick=\"return confirm('คุณต้องการลบผู้ใช้งานนี้หรือไม่ค่ะ ?');\">ลบ</a></td></tr>";

													$n++;
											}
											?>
										</tbody>
									</table>

</div>

        <!-- End div panel body -->
    </div>
	</div>
</div>
