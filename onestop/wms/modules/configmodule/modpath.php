<?php
	$btname="addnew";
	if(isset($_GET['id'])){
		$sql="select * from tb_modpath where id=".$_GET['id'];
		$rs=rsQuery($sql);
		$data=mysqli_fetch_assoc($rs);
		$v_id=$data['id'];
		$v_name=$data['name'];
		$v_wms_path=$data['wms_path'];
		$v_web_path=$data['web_path'];
		$v_server_path=$data['server_path'];
		$v_create_table=$data['create_table'];
		$btname="edit";
}
	if(isset($_POST['btsave'])){

		$btname="addnew";
		$id=$_POST['txtid'];
		$name=$_POST['txtname'];
		$wms_path=$_POST['txtwms_path'];
		$web_path=$_POST['txtweb_path'];
		$server_path=$_POST['txtserver_path'];
		$create_table=$_POST['txtcreate_table'];
		switch($_POST['btsave']){
			case "addnew":
				$strSql="insert into tb_modpath(name,wms_path,web_path,server_path,create_table) values('$name','$wms_path','$web_path','$server_path','$create_table')";
				break;

			case "edit":
				$strSql="Update tb_modpath SET name='$name',wms_path='$wms_path',web_path='$web_path',server_path='$server_path',create_table='$create_table' Where id=".$id;
				break;
		}
		$rs=rsQuery($strSql);
		if($rs){

			echo "<script>alert('บันทึกข้อมูลสำเร็จ');window.location.href='main.php?_modid=".$_GET['_modid']."&_mod=".$_GET['_mod']."';</script>";
		}
	}

	?>





<div class="panel panel-default col-12">
    <div style="background-color: #222222" class="panel-heading">
        <h5 style="color: #fffbfd">Modpath</h5>
    </div>
    <!-- -------------------------- Start panel body ---------------------------------- -->
    <div class="panel-body">
        <!-- -------------------------- Start form ---------------------------------- -->

          <div class="row col-md-12">
              <div class="col-md-1"></div>

              <div style="background-color: rgba(157,157,157,0.8)" class="well col-md-10">




                  <div class="row col-md-12">
										<form class="form-inline" name="frmModpath" action="" method="post" enctype="multipath/form-data">

											<div class="form-group col-md-12">
												<div class="col-md-3">
											    <label>id:</label>
												</div>
												<?php echo $v_id;?>
											    <input type="hidden" name="txtid" value="<?php echo $v_id;?>">
											  </div>

												<br>

												<div class="form-group col-md-12">
													<div class="col-md-3">
													<label>name:</label>
												</div>
													<input type="text" name="txtname" class="form-control"  value="<?php echo $v_name;?>" required>
												</div>

												<br>

												<div class="form-group col-md-12">
													<div class="col-md-3">
													<label>wms_path:</label>
												</div>
													<input type="text" class="form-control" name="txtwms_path" size="80" value="<?php echo $v_wms_path;?>" />
												</div>

												<br>

												<div class="form-group col-md-12">
													<div class="col-md-3">
													<label>web_path:</label>
												</div>
													<input type="text" class="form-control" name="txtweb_path" value="<?php echo $v_web_path;?>" size="80">
												</div>

												<br>

												<div class="form-group col-md-12">
													<div class="col-md-3">
													<label>server_path:</label>
												</div>
													<input type="text" class="form-control" name="txtserver_path" value="<?php echo $v_server_path;?>" size="80">
												</div>

												<div class="form-group col-md-12">
													<div class="col-md-3">
													<label>script create table:</label>
												</div>
													<textarea name="txtcreate_table" class="form-control" cols="80" rows="6"><?php echo $v_create_table;?></textarea>
												</div>

												<div class="col-md-12 " style="text-align: center; margin-top: 15px;">
													<input class="btn" type="submit" name="btsave" value="<?php echo $btname;?>">
												</div>
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
										<th>*</th>
										<th>name</th>
										<th>wms_path</th>
										<th>web_path</th>
										<th>server_path</th>
										<th>create_table</th>
										<th>จัดการ</th>
									</tr>
									</thead>
									<tbody>
									<?php
										$sql="select * from tb_modpath";
										$rs=rsQuery($sql);
										$n = 1;
										if(mysqli_num_rows($rs)>0){
											while($data=mysqli_fetch_assoc($rs)){
												echo "<tr><td>".$n."</td><td>".$data['name']."</td><td>".$data['wms_path']."</td><td>".$data['web_path']."</td><td>".$data['server_path']."</td>
												<td>".$data['create_table']."</td>
												<td  align='center'><a href=\"main.php?_modid=".$_GET['_modid']."&_mod=".$_GET['_mod']."&type=view&id=".$data['id']."\" title='แก้ไขข้อมูล'><img src='../fileupload/icon/contract.png' height='18' width='18'></a></td></tr>";
												$n++;
												}
										}
									?>
								</tbody>
								</table>
							</div>

        <!-- End div panel body -->
    </div>
</div>


