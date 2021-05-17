<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// Load Composer's autoloader
require 'PHPMailer/vendor/autoload.php';


$MailDetail = "<html>
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

    $to      = "smile_garl@hotmail.com";
    $form    = "noreply@itglobal.co.th";

    $subject = "แจ้งเตือนคำร้อง ONE STOP SERVICE.";
    $message = $MailDetail;



/* ------------------------------------------------------------------------------------------------------------- */

$mesg = $MailDetail;
$mail = new PHPMailer();
$mail->CharSet = "utf-8";

$mail->SMTPDebug = 2;
$mail->IsSMTP();

$mail->Mailer = "smtp";
$mail->SMTPAutoTLS = false; //false//true

$mail->Port = "25"; // หมายเลข Port สำหรับส่งอีเมล์ 25 // 465

$mail->Host = "mail.itglobal.co.th"; //ใส่ SMTP Mail Server ของท่าน
$mail->Username = "noreply@itglobal.co.th"; //ใส่ Email Username ของท่าน (ที่ Add ไว้แล้วใน Plesk Control Panel)
$mail->Password = "456852aB"; //ใส่ Password ของอีเมล์ (รหัสผ่านของอีเมล์ที่ท่านตั้งไว้)

$mail->SetFrom($form, 'TEST NANE');
$mail->AddAddress($to, 'E-Mail1');
$mail->AddReplyTo($form);
$mail->Subject = $subject;
$mail->Body     = $mesg;
$mail->MsgHTML($MailDetail);
$mail->WordWrap = 50;
//

if(!$mail->Send()) {
echo "<script>alert('Send Mail ERROR')</script>";
echo "<script>console.log('".$mail->ErrorInfo."')</script>";
exit;
} else {
echo 'ส่งเมลล์สำเร็จ';
}


?>
