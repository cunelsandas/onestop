<!DOCTYPE html>
<?php

include_once "../itgmod/connect.php";



session_start();
	if(isset($_SESSION['userid'])){
		echo "<meta http-equiv=\"Refresh\" content=\"0;url=main.php\" />";
	}


	$_SESSION = array();

	include("simple-php-captcha.php");
	$_SESSION['captcha'] = simple_php_captcha();

$msg = "";

if(isset($_POST['btlogin'])){

	$Inputname = $_POST['txtusername'];
 	$Inputpass= md5($_POST['txtpass']);
	$Inputcatc= $_POST['txtcaptcha'];
	$catcha = $_POST['captcha'];

	if ($Inputcatc == $catcha) {

		$sql = "SELECT * FROM tb_user where username='$Inputname' and pw='$Inputpass'";
		$rs = rsQuery($sql);
		$row = mysqli_fetch_array($rs);

		if ($Inputname == $row['username'] & $Inputpass == $row['pw']) {

			$sql="select * from tb_user where username='$Inputname' and pw='$Inputpass'";
			$rs=rsQuery($sql);
			$f=mysqli_fetch_array($rs);

			$_SESSION['userid']=$f['userid'];
			$_SESSION['name']=$f['nameuser']." ".$f['surname'];
			$_SESSION['username']=$f['username'];

			// update table tb_trans บันทึกการเข้าระบบ

			$updatetran=UpdateTrans('tb_user','login',$_SESSION['username'],$_SESSION['name']);
			$msg="<p style=\"color:#c6bc09;\">กำลังเข้าสู่ระบบ</p>";
			echo "<meta http-equiv=\"Refresh\" content=\"1;url=main.php\"/>";

		}else {
			//$msg = "<p style='color : red; font-size : 16px'> ".$Inputname." ".$Inputpass."</p>";

				$msg = "<p style='color : red; font-size : 16px'> กรุณาตรวจสอบ ชื่อผู้ใช้งาน และ รหัสผ่าน </p>";
		}

	}else {
		$msg = "<p style='color : red; font-size : 16px'> รหัสภาพไม่ถูกต้องค่ะ </p>";
	}
}

?>

<html lang="en">
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="font/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="font/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
				<form id="frmlogin" name="frmlogin" method="post" class="login100-form validate-form flex-sb flex-w" action="">
					<h4> WELLCOME TO</h4>
					<span class="login100-form-title p-b-32">
						WMS Login
					</span>
					<div class="p-b-20" style="text-align:center; width:100%">
					<?php echo $msg ?>
					</div>
					<span class="txt1 p-b-11">
						Username
					</span>
					<div class="wrap-input100 validate-input m-b-36" data-validate = "Username is required">
						<input class="input100" type="text" id="txtusername" name="txtusername">
						<span class="focus-input100"></span>
					</div>

					<span class="txt1 p-b-11">
						Password
					</span>
					<div class="wrap-input100 validate-input m-b-30" data-validate = "Password is required">
						<span class="btn-show-pass">
							<i class="fa fa-eye"></i>
						</span>
						<input class="input100" type="password" id="txtpass" name="txtpass">
						<span class="focus-input100"></span>
					</div>


					<div class="flex-sb-m w-full p-b-15">
						<img style="height:45px" src="<?php echo $_SESSION['captcha']['image_src'] ;?>" alt="CAPTCHA code">
					</div>

					<input type="hidden" name="captcha" id="captcha" value="<?php echo $_SESSION['captcha']['code'] ;?>"/>


					<span class="txt1 p-b-11">
						CAPTCHA
					</span>
					<div class="wrap-input100 validate-input m-b-36" data-validate = "captcha is required">
						<input class="input100" type="text" id="txtcaptcha" name="txtcaptcha">
						<span class="focus-input100"></span>
					</div>



					<div class="container-login100-form-btn">
						<button type="submit" name="btlogin" class="login100-form-btn">
							Login
						</button>
					</div>

				</form>
			</div>
		</div>
	</div>


	<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>
