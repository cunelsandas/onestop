<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// Load Composer's autoloader
require 'vendor/autoload.php';

$fm = "sasikan@itglobal.co.th"; // *** ต้องใช้อีเมล์ @yourdomain.com เท่านั้น  ***
$to = "migarlza00@gmail.com"; // อีเมล์ที่ใช้รับข้อมูลจากแบบฟอร์ม
$custemail = "migarlza00@gmail.com"; // อีเมล์ของผู้ติดต่อที่กรอกผ่านแบบฟอร์ม

$subj = "TEST_E-MAIL";

/* ------------------------------------------------------------------------------------------------------------- */
$message.= "ชื่อ-นามสกุล.............................";

/* ------------------------------------------------------------------------------------------------------------- */

/* หากต้องการรับข้อมูลจาก Form แบบไม่ระบุชื่อตัวแปร สามารถรับข้อมูลได้ไม่จำกัด ให้ลบบรรทัด 11-14 แล้วใช้ 19-22 แทน

foreach ($_POST as $key => $value) {
 //echo "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";
 $message.= "Field ".htmlspecialchars($key)." = ".htmlspecialchars($value)."\n";
}

*/

$mesg = $message;

$mail = new PHPMailer();
$mail->CharSet = "utf-8";

/* ------------------------------------------------------------------------------------------------------------- */
/* ตั้งค่าการส่งอีเมล์ โดยใช้ SMTP ของ โฮสต์ */
$mail->SMTPDebug = 2;
$mail->IsSMTP();

/*$mail->SMTPOptions = array(
     'ssl' => array(
         'verify_peer' => false,
         'verify_peer_name' => false,
         'allow_self_signed' => true
     )
);*/

$mail->Mailer = "smtp";
$mail->SMTPAutoTLS = false; //false//true
//$mail->SMTPSecure = 'ssl'; // บรรทัดนี้ ให้ Uncomment ไว้ เพราะ Mail Server ของโฮสต์ ไม่รองรับ SSL.
$mail->Port = "25"; // หมายเลข Port สำหรับส่งอีเมล์ 25 // 465

$mail->Host = "mail.itglobal.co.th"; //ใส่ SMTP Mail Server ของท่าน
$mail->Username = "sasikan@itglobal.co.th"; //ใส่ Email Username ของท่าน (ที่ Add ไว้แล้วใน Plesk Control Panel)
$mail->Password = "13245678a"; //ใส่ Password ของอีเมล์ (รหัสผ่านของอีเมล์ที่ท่านตั้งไว้)
/* ------------------------------------------------------------------------------------------------------------- */

//$mail->From = $fm;
$mail->SetFrom($fm, 'TEST NANE');
$mail->AddAddress($to);
$mail->AddReplyTo($custemail);
$mail->Subject = $subj;
$mail->Body     = $mesg;
$mail->WordWrap = 50;
//

echo date("Y-m-d H:i:s")."</br>";

if(!$mail->Send()) {
echo "<script>alert('Send Mail ERROR')</script>";
echo "<script>console.log('".$mail->ErrorInfo."')</script>";
exit;
} else {
echo 'ส่งเมลล์สำเร็จ';
}

?>
