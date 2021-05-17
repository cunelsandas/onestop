
<?php
$tablename="tb_menutop";
$foldername="/images/";
$btname="addnew";
if(isset($_GET['del'])){
    $strdel="delete from $tablename Where id=".$_GET['del'];
    $bannername=FindRS("select * from $tablename where id=".$_GET['del'],"bannername");
    $rsdel=rsQuery($strdel);
}

if(isset($_GET['addnew'])){
    $btname="addnew";
}

if(isset($_POST['btsave'])){
    $id=$_POST['id'];
    $name=$_POST['txtname'];
    $modid=$_POST['cbomodules'];
    $listno=$_POST['txtlistno'];

    switch($_POST['btsave']){
        case "addnew":
            $sql="insert into $tablename (modid,name,listno) values('$modid','$name','$listno')";
            $stralert="บันทึกข้อมูลใหม่แล้ว";
            break;
        case "edit":
            $sql="Update $tablename SET modid='$modid',name='$name',listno='$listno' Where id='$id'";
            $stralert="แก้ไขข้อมูลแล้ว";
            break;
    }
    $rs=rsQuery($sql);
    if($rs){
        echo $stralert;
    }
}

if(isset($_GET['edit'])){
    $btname="edit";
    $sql="select * from $tablename Where id=".$_GET['edit'];
    $rs=rsQuery($sql);
    if($rs){
        $data=mysqli_fetch_assoc($rs);
        $v_id=$data['id'];
        $v_modid=$data['modid'];
        $v_name=$data['name'];
        $v_listno=$data['listno'];
        $v_bannername=$data['bannername'];
    }
}
?>



<div class="panel panel-default col-12">
    <div style="background-color: #222222" class="panel-heading">
        <h5 style="color: #fffbfd">สร้างเมนูด้านบน ( menutop )</h5>
    </div>
    <!-- -------------------------- Start panel body ---------------------------------- -->
    <div class="panel-body">
        <!-- -------------------------- Start form ---------------------------------- -->
        <form name="frmstylemap" id="frmstylemap" method="post" action="#" enctype="multipart/form-data">

            <p style="right:12%;position:absolute;"><?php echo"<a href=\"main.php?_modid=".$_GET['_modid']."&_mod=".$_GET['_mod']."&addnew=addnew\"  class='link'>เพิ่มรายการใหม่</a>";?></p><Br><br>


            <div class="row col-md-12">
                <div class="col-md-1"></div>

                <div style="background-color: rgba(157,157,157,0.8)" class="well col-md-10">



                    <form name="frmdata" method="POST" action="" enctype="multipart/form-data">
                        <table width="85%" class="content-input">
                            <tr>
                                <td>id</td><td><?php echo $v_id;?><input type="hidden" name="id" value="<?php echo $v_id;?>"></td>
                            </tr>
                            <tr>
                                <td>modules</td><td>
                                    <select name="cbomodules">
                                        <option value="0">หน้าหลัก/home</option>
                                        <?php
                                        $sql="select * from tb_mod where typeid<=3 order by modtype "; // เอาเฉพาะ เนื้อหา ส่วนประกอบและบริการออนไลน์
                                        $rs=rsQuery($sql);
                                        if($rs){
                                            while($data=mysqli_fetch_assoc($rs)){
                                                if($v_modid==$data['modid']){
                                                    echo "<option value='".$data['modid']."' selected>".$data['modtype']."  ".$data['modname']."</option>";
                                                }else{
                                                    echo "<option value='".$data['modid']."'>".$data['modtype']."  ".$data['modname']."</option>";
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>ชื่อเมนู</td><td><input type="text" name="txtname" value="<?php echo $v_name;?>" placeholder="ชื่อที่ต้องการให้แสดงในเมนูด้านบน menutop" style="width:80%"></td>
                            </tr>
                            <tr>
                                <td>ลำดับการแสดงผล จากซ้ายไปขวา</td><td><input type="text" name="txtlistno" value="<?php echo $v_listno;?>"> *ตัวเลขเท่านั้น 0 ไม่แสดง</td>
                            </tr>
                            <tr>
                                <td></td><td><input type="submit" name="btsave" value="<?php echo $btname;?>"></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="col-md-1"></div>
            </div>

            <table class="table" width="85%">
                <tr>
                    <th width="15%">ลำดับการแสดงผล</th>
                    <th width='60%'>ชื่อเมนู</th>
                    <th width='15%'>จัดการ</th>
                </tr>
                <?php
                $sql="select * from tb_menutop order by listno";
                $rs=rsQuery($sql);
                if($rs){
                    while($data=mysqli_fetch_assoc($rs)){
                        echo "<tr>";
                        echo "<td align='center'>".$data['listno']."</td>";
                        echo "<td align='left'>".$data['name']."</td>";
                        echo "<td><a href=\"main.php?_modid=".$_GET['_modid']."&_mod=".$_GET['_mod']."&edit=".$data['id']."\">แก้ไข</a>&nbsp;&nbsp;<a href=\"main.php?_modid=".$_GET['_modid']."&_mod=".$_GET['_mod']."&del=".$data['id']."\" onclick=\"return confirm('คุณต้องการลบใช่หรือไม่?');\">ลบ</a></td>";
                        echo "</tr>";
                    }
                }
                ?>
            </table>


            <!-- End form body -->
        </form>
        <!-- End div panel body -->
    </div>
</div>


</div>
