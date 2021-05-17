<!DOCTYPE HTML>
<!--
	Industrious by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->

<?php
		include_once("itgmod/connect.php");

		!empty($_GET['_mod'])?$mod1=$_GET['_mod']:null;

		$mod=EscapeValue(decode64($mod1));
		$pathid=FindRS("select * from tb_mod where modtype='".$mod."'",modpath);
		$web_path=FindRS("select * from tb_modpath where id=".$pathid,web_path);
		$server_path=FindRS("select * from tb_modpath where id=".$pathid,server_path);  //remark on localhost
		$full_path=$server_path.$web_path;

		if ($mod == 'welfare') {
			echo "<script>window.location.href='welfare_index.php';</script>";
		}

?>

<html>
	<head>
		<title>ONE STOP SERVICE</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" href="font/th_k2d_july8.css" />
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
		<script src="assets/js/jquery.min.js"></script>

		<style>
		.thai-font {
		  font-family: THK2DJuly8;
		}

		.eng-font{
			font-family: "Raleway", Arial, Helvetica, sans-serif;
		}
		</style>
	</head>
	<body class="is-preload">

		<!-- Header -->
		  <header id="header">
		    <a class="logo" href="index.php">ONE STOP SERVICE</a>
		    <nav>
		      <a href="#menu">Menu</a>
		    </nav>
		  </header>

		<!-- Nav -->
		  <nav id="menu" class="thai-font">
		    <ul class="links">
		      <li><a href="index.php">หน้าหลัก</a></li>
					<li><a href="index.php?_mod=Zm9sbG93ZGF0YQ">ติดตามผลการดำเนินงาน</a></li>
					<li><a href="calendar/calendar.php" target="_blank">ปฏิทินกิจกรรม</a></li>
                    <li><a href="wms" target="_blank">ผู้ดูแลระบบ</a></li>
		    </ul>
		  </nav>

		<div class="content thai-font" name="content">
		<?php

			include("itgmod/mod_select.php");


			?>
		</div>

		<!-- Footer -->
			<footer id="footer">
				<div class="inner">
					<div class="content">
						<section>
							<h3 class="thai-font"><?php echo $customer_name; ?></h3>
							<p class="thai-font"><?php echo $address; ?></p>
							<p><a href="<?php echo $maindomainname; ?>"> www.<?php echo $maindomainname; ?> </a></p>
							<a href="https://goo.gl/maps/AFyC8PjXZdM2"><img style="width: 80px; margin-left: 100px" src="images/icon-marker.png" /></a>
						</section>
						<section>
							<h4>Contact Us</h4>
							<ul class="alt">
								<li><a><i class="fas fa-phone">&nbsp;&nbsp;&nbsp;</i><?php echo $customer_tel; ?></a></li>
								<li><a><i class="fas fa-fax">&nbsp;&nbsp;&nbsp;</i><?php echo $customer_fax; ?></a></li>
								<li><a href="mailto:<?php echo $customer_email; ?>"><i class="fas fa-envelope">&nbsp;&nbsp;&nbsp;</i><?php echo $customer_email; ?></a></li>

							</ul>
						</section>
						<section>
							<h4>Follow Me</h4>
							<ul class="alt">
								<li><a href="<?php echo $facebook; ?>"><i class="icon fa-facebook">&nbsp;&nbsp;&nbsp;</i>Facebook</a></li>
								<li><a href="#"><i class="fab fa-line">&nbsp;&nbsp;&nbsp;</i>LINE</a></li>

							</ul>
						</section>
					</div>
					<div class="copyright">
						Copyright © 2018 I.T. GLOBAL Co., Ltd. All Rights Reserved.
					</div>
				</div>
			</footer>

		<!-- Scripts -->

			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>
