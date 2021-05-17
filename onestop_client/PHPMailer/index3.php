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

$subj = "แจ้งเตือนคำร้อง ONE STOP SERVICE";

/* ------------------------------------------------------------------------------------------------------------- */
$message.= "<html>
              <head>
              <title> ONE STOP SERVICE </title>
              </head>
              <body>

              <center>

              <h2>ONE STOP SERVICE</h2>
              <BR>
              <p>ทางเราได้รับคำร้องจากคุณ <b>".$_POST['frm_name']."</b></p>
              <p>เรื่อง <b>".$modname."</b> เลขที่คำร้อง <b>'" .$receiveno. "'</b></p>
              <p>สามารถตรวจสอบได้ที่ <a href=\"http://www.".$domainname."/index.php?_mod=Zm9sbG93ZGF0YQ\">www.".$domainname."</a></p>
              <p><b>ขอขอบคุณที่ใช้บริการค่ะ</b></p>

              </center>
              </body>
              </html>";

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
$mail->SMTPDebug = 0;
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
$mail->Username = "noreply@itglobal.co.th"; //ใส่ Email Username ของท่าน (ที่ Add ไว้แล้วใน Plesk Control Panel)
$mail->Password = "456852aB"; //ใส่ Password ของอีเมล์ (รหัสผ่านของอีเมล์ที่ท่านตั้งไว้)
/* ------------------------------------------------------------------------------------------------------------- */

//$mail->From = $fm;
$mail->SetFrom($fm);
$mail->AddAddress($to);
$mail->AddReplyTo($custemail);

$mail->Subject = $subj;
$mail->MsgHTML($mesg);
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
