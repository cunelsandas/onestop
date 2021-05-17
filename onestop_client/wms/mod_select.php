<?php
if (!isset($_GET['_mod'])) {
    echo "<p style=\"text-align:center;\">กรุณาเลือกส่วนที่คุณต้องการตั้งค่า</p>";


} else {
    empty($_GET['_modid']) ? $mod = "" : $mod = $_GET['_modid'];

    ############# เป็นการเลือก โมดูลที่ต้องการ สำหรับในกรณีที่เราอยากจะได้แบบ เพิ่ม โมดูลเอง ###################
    if ($mod == "logout") {
        include "modules/logout.php";
    } else {
        $sql = "Select * From tb_mod Where modid='$mod'";
        $rs = rsQuery($sql);
        if ($rs) {
            $arrm = mysqli_fetch_assoc($rs);
            $wms_path = FindRS("select * from tb_modpath where id=" . $arrm['modpath'], wms_path);
            $server_path = '';
			         $server_path="/var/www/share/onestop/wms/";  // remark on localhost

            $path = $server_path . $wms_path;
            if (file_exists($path)) {            //ตรวจสอบตำแหน่งของโฟลเดอร์โมดูลก่อนว่ามีอยู่จริง อ๊ะ เปล่า
                include "$path";
            } else {                                        // ถ้าไม่มี
                echo "<p style=\"text-align:center;font-size:14px;font-weight:bold;color:red;\">กรุณาตรวจสอบตำแหน่งของโฟลเดอร์ที่เก็บโมดูลด้วยค่ะ</p>";
                echo "<p style=\"text-align:center;font-size:14px;font-weight:bold;color:red;\">ตำแหน่ง&nbsp;:&nbsp;\"$path\"</p>";
            }
        }
    }
}
?>
