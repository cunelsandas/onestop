
<?php


include_once("../../../itgmod/connect.php");

$modid = $_GET['_modid'];
$folder =FindRS("select foldername from tb_mod where modid=$modid","foldername");
$tablename =FindRS("select tablename from tb_mod where modid=$modid","tablename");



if ($_POST['action'] == "save") {

	$sql2 = "SELECT * FROM $tablename ORDER BY id DESC LIMIT 0,1";
	$rss = rsQuery($sql2);
	$num = mysqli_fetch_array($rss);
	$lid = $num['id'];


	$rawData = $_POST['imgBase64'];
	$filename=$_POST['filename'];
	$filetel=$_POST['filetel'];
	$id=$filename;

	$sql="INSERT INTO tb_webcam(name,tel) Values('".$filename."','".$filetel."')";
	$rs=rsQuery($sql);

	$filteredData = explode(',', $rawData);
	$unencoded = base64_decode($filteredData[1]);
	//$unencoded = $filteredData[1];
	//$randomName = rand(0, 99999);
	$datetime="-".date("Y-m-d")."-".date("H-i-s");
	$newfilename=$tablename."_".$lid.".jpg";
	$des_file=$_SERVER['DOCUMENT_ROOT']."/fileupload/webcam/".$newfilename;
	//Create the image

	$fp = fopen($des_file, 'w');
	fwrite($fp, $unencoded);
	fclose($fp);
	$filename="INSERT INTO files_image(table_name,master_id,file_name) Values('".$tablename."','".$lid."','".$newfilename."')";
	$uppicname=rsQuery($filename);

	echo "บันทึกข้อมูลแล้วค่ะ";

}elseif($_POST['action'] == "showdata") {

	$sql = "SELECT * FROM ".$tablename." INNER JOIN files_image ON ".$tablename.".id = files_image.master_id";
	$rs = rsQuery($sql);
	$data = array();
	$num = mysqli_num_fields($rs);
	$n = 0;
	while ($row = mysqli_fetch_array($rs)) {

		$arrCol = array();
			for($i=0;$i<$num;$i++){
				$field =  mysqli_fetch_field_direct($rs,$i);
				$namefield[$i] = $field->name;
				$arrCol[$namefield[$i]] = $row[$i];
			}
			array_push($data,$arrCol);
			$n++;
	}

	echo json_encode($data);

}else {
	echo "xxxxxxx";
}

?>
