<?php


session_start();
include_once "../itgmod/connect.php";
$gloUploadPath = "onestop/fileupload";

if(!isset($_SESSION['userid'])) {
    echo "<meta http-equiv=\"Refresh\" content=\"0;url=index.php\" />";
    exit();
}
    $str="select * from tb_trans where username='".$_SESSION['username']."' And action='login' Order by edittime DESC limit 1,2";
    $rs=rsQuery($str);
    if($rs){
        $lastlogin=DateTimeThai(mysqli_result($rs,0,"edittime"));
    }
    else{
        $lastlogin=$_SESSION['username'];
    }

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <link type="text/css" rel="stylesheet" href="css/add_style.css">
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">



    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery.wheelcolorpicker-3.0.5.min.js"></script>
    <script type="text/javascript" src="js/bootstrap1.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>


    <title>WMSi</title>

    <style>
        @font-face {
            font-family: 'THK2DJuly8';
            src: url('font/th_k2d_july8_bold-webfont.eot');
            src: url('font/th_k2d_july8_bold-webfont.eot?#iefix') format('embedded-opentype'),
            url('font/th_k2d_july8_bold-webfont.woff') format('woff'),
            url('font/th_k2d_july8_bold-webfont.ttf') format('truetype');
            font-weight: bold;
            font-style: normal;
        }
        body {
            font-family: "THK2DJuly8";
        }
        input[type="file"] {
            display: none;
        }
        .custom-file-upload {
            border: 1px solid #ccc;
            display: inline-block;
            width: 100px;
            padding: 6px 12px;
            cursor: pointer;
        }
    </style>

</head>

<body>
<div class="text-center">
    <h1>WMS</h1>
    <p>Website Management System</p>
    <?php echo $lastlogin; ?>
    <?php echo $_SESSION['username']; ?>
</div>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="main.php">I.T.GLOBAL</a>
        </div>

        <?php
        $sql1 = "Select * from tb_modtype Order by listno";
        $rs1 = rsQuery($sql1);
        while ($data = mysqli_fetch_array($rs1)) {
            $modtypeid = $data['id'];
            echo "<ul class=\"nav navbar-nav\">";
            echo "<li class=\"dropdown\"><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">" . $data['name'] . "</a>";
            echo "<ul class=\"dropdown-menu\">";

            $sql="Select tb_select_mod.*,tb_mod.* From tb_select_mod INNER JOIN tb_mod ON tb_select_mod.modid=tb_mod.modid INNER JOIN tb_user ON tb_select_mod.userid=tb_user.userid Where tb_select_mod.userid='".$_SESSION['userid']."' AND tb_mod.typeid=$modtypeid Order by tb_mod.modname";
						$rs=rsQuery($sql);

            if(!$rs){
							echo "คุณยังไม่ได้รับการกำหนดสิทธิ์เพื่อใช้งาน กรุณาติดต่อผู้ดูแลระบบ ";
						}else{
            while ($row = mysqli_fetch_array($rs)) {
                echo "<li><a class='clear".$row['modtype']."' href=\"main.php?_mod=".$row['modtype']."&_modid=".$row['modid']."\">".$row['modname']."
                <span class=\"label label-pill label-danger ".$row['modtype']."\" style=\"border-radius:10px;\"></span> </a>  </li>";
            }
          }
            echo "</ul>";
            echo "</li>";
            echo "</ul>";
        }
        ?>

        <ul class="nav navbar-nav navbar-right">
              <li>
                <a href="#" class="dropdown-toggle clear" data-toggle="dropdown"><span class="label label-pill label-danger count" style="border-radius:10px;"></span> <span class="glyphicon glyphicon-bell" style="font-size:18px;"></span></a>
                <ul class="dropdown-menu data"></ul>
              </li>
              <li><a href="#" id="logout"> Logout <img style="" src="../fileupload/icon/logout.png"/></a></li>
        </ul>

    </div>

</nav>

<br>

<div class="container wrapper">
    <div class="row">
        <div id="content">
            <?php
            include("mod_select.php");
            ?>
        </div>
    </div>
</div>



<!-- Footer -->
<div class="footer col-md-12">
    <div class="text-center" style="color:white;">
      Copyright © 2018 I.T. GLOBAL Co., Ltd. All Rights Reserved.
    </div>
</div>
  <!-- Footer -->

</body>
</html>


<script src='../js/tinymce/tinymce.min.js'></script>


<script>

$(document).ready(function() {

  $('#logout').click(function () {

    if(confirm('คุณต้องการออกจากระบบหรือไม่ค่ะ ?')){
      <?php //session_destroy(); ?>
      location.href = "index.php";
    }else {
      return false;
    }
  });

});



$(document).ready(function() {
    var table = $('#example').DataTable( {
        responsive: true
    } );

   // new $.fn.dataTable.FixedHeader( table );
} );


tinymce.init({


    selector: '#mytextarea',
    theme: 'modern',
    width: "100%",
    height: 200,
    plugins: [
        'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
        'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
        'save table contextmenu directionality emoticons template paste textcolor'
    ],

    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons',
    save_onsavecallback : "ajaxSave",

    image_title: true,
    // enable automatic uploads of images represented by blob or data URIs
    automatic_uploads: true,
    // add custom filepicker only to Image dialog
    file_picker_types: 'image',
    file_picker_callback: function(cb, value, meta) {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');

        input.onchange = function() {
            var file = this.files[0];
            var reader = new FileReader();

            reader.onload = function () {
                var id = 'blobid' + (new Date()).getTime();
                var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                var base64 = reader.result.split(',')[1];
                var blobInfo = blobCache.create(id, file, base64);
                blobCache.add(blobInfo);

                // call the callback and populate the Title field with the file name
                cb(blobInfo.blobUri(), { title: file.name });
            };
            reader.readAsDataURL(file);
        };

        input.click();
    }


});
</script>


<script>
$(document).ready(function(){

var result = [];
var num;
//notification Sub
 function load_unseen_sub_notification(view = ''){
  $.ajax({
   url:"notification.php",
   method:"POST",
   data:{view:view},
   dataType:"json",
   success:function(data)
   {
for (var i = 0; i < data.length; i++) {
  if(data[i].count > 0)
      {
       $('.'+data[i].modtype).html(data[i].count);
     }
     result[i] = data[i];
    }
    sub_notification();
}
  });

 }

 function sub_notification() {

     for (var i = 0; i < result.length; i++) {
       modtype = result[i].modtype;
       modid = result[i].modid;
       $('.clear'+result[i].modtype).on( "click", { modtype:modtype , modid:modid } , myHandler);

   }

 }

 function myHandler(event){

   $('.'+event.data.modtype).html('');
   load_unseen_sub_notification(event.data.modid);

 }

 load_unseen_sub_notification();
//END notification sub


//notification main
 function load_unseen_notification(view = ''){
  $.ajax({
   url:"action.php",
   method:"POST",
   data:{view:view},
   dataType:"json",
   success:function(data)
   {
     $('.data').html(data.notification);
     if(data.unseen_notification > 0)
     {
      $('.count').html(data.unseen_notification);
    }
   }
  });
 }

 load_unseen_notification();
$(document).on('click', '.clear', function(){
  $('.count').html('');
  load_unseen_notification('yes');
});
//END notification main

// Refresh AOTO notification
 setInterval(function(){
  load_unseen_sub_notification();
  load_unseen_notification();;
 }, 5000);

});
</script>
