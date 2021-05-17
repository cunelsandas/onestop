

<?php


$mod = $_GET["_mod"] ;
$modid = $_GET['_modid'];
$modname=FindRS("select modname from tb_mod where modid=$modid","modname");
$tablename=FindRS("select tablename from tb_mod where modid=$modid","tablename");
$folder =FindRS("select foldername from tb_mod where modid=$modid","foldername");

$modpath =FindRS("select modpath from tb_mod where modid=$modid","modpath");
$pathmod =FindRS("select wms_path from tb_modpath where id=$modpath","wms_path");
$fdmod = explode("/", $pathmod);
$foldermod = $fdmod[0]."/".$fdmod[1]."/";

empty($_GET['type'])?$type="":$type=$_GET['type'];


$part = "../fileupload/".$folder."/";

 ?>

 <style>

 thead{
   font-weight: bold;
   text-align: center;
 }

 tbody{
   text-align: center;;
 }

 </style>

 <head>

 <script>

   showAllData();

   function showAllData(){
     var action = "showdata";
     $.ajax({
       type: 'POST',
       url: 'modules/configwebcam/camsave.php?_modid=<?php echo $modid;?>',
       dataType: 'json',
       data: {
         action: action
       },
       success: function(data){

         var html = '';
         var i;
         var n = 1;
         for(i=0; i<data.length; i++){

           html += '<tr>'+
           '<td>'+ n +'</td>'+
           '<td>'+ data[i].name +'</td>'+
           '<td>'+ data[i].tel +'</td>'+
           '<td><img style="width: 150px" src="../fileupload/webcam/'+ data[i].file_name +'"></td>'+
           '</tr>';
           n++;
         }
         $('#showdata').html(html);
         //console.log(data);
       },error: function() {
          alert("ERROR")
       }
     })
   }


	var video = document.querySelector("#videoElement");

	// Put event listeners into place
	window.addEventListener("DOMContentLoaded", function() {
	// Grab elements, create settings, etc.
	var canvas = document.getElementById("canvas"),
	context = canvas.getContext("2d"),
	video = document.getElementById("video"),
	videoObj = { "video": true },
	errBack = function(error) {
		console.log("Video capture error: ", error.code);
	};
	// Put video listeners into place
	if (navigator.mediaDevices.getUserMedia) {
    navigator.mediaDevices.getUserMedia({video: true})
  .then(function(stream) {
    video.srcObject = stream;
  })
  .catch(function(err0r) {
    console.log("Something went wrong!");
  });
} else if(navigator.webkitGetUserMedia) { // WebKit-prefixed
		navigator.webkitGetUserMedia(videoObj, function(stream){
			video.src = window.webkitURL.createObjectURL(stream);
			video.play();
		}, errBack);
		} else if(navigator.mozGetUserMedia) { // WebKit-prefixed
		navigator.mozGetUserMedia(videoObj, function(stream){
			video.src = window.URL.createObjectURL(stream);
			video.play();
		}, errBack);
	}
	// Trigger photo take
	document.getElementById("snap").addEventListener("click", function() {
		//context.drawImage(video, 0, 0, 640, 480);

		context.drawImage(video, 0, 0, 400, 320);
		// Littel effects
		$('#video').hide();
		$('#canvas').show();
		$('#snap').hide();
		$('#new').show();
		// Allso show upload button
		//$('#upload').show();
	});
	// Capture New Photo
	document.getElementById("new").addEventListener("click", function() {
		//$('#video').fadeIn('slow');
		//$('#canvas').fadeOut('slow');
    $('#video').show();
    $('#canvas').hide();
		$('#snap').show();
		$('#new').hide();
		$('#upload').show();
	});
	// Upload image to sever
	document.getElementById("upload").addEventListener("click", function(){

		if(document.getElementById("frm_name").value!=""){
		var dataUrl = canvas.toDataURL("image/jpeg");
		var fileName = document.getElementById("frm_name").value;
    var fileTel = document.getElementById("frm_tel").value;
    var action = "save"

		$.ajax({
			type: "POST",
			url: "modules/configwebcam/camsave.php?_modid=<?php echo $modid; ?>",
			data: {
				imgBase64: dataUrl,
				filename: fileName,
        filetel: fileTel,
        action: action
			}
			})
		.done(function( msg ) {

			// Do Any thing you want
			  alert( msg );
        showAllData();
        document.getElementById("frm_name").value = "";
        document.getElementById("frm_tel").value = "";
		});

	}else{
		alert("กรุณาใส่ชื่อ");
	};

	});

}, false);


</script>

</head>




 <div class="content" name="content">
     <div class="col-md-12">
       <h1><?php echo $modname;?></h1>
       <div class="panel panel-default">
         <div class="panel-body">
         <div  class="col-md-12">

           <div class="col-md-6">


             <div class="col-md-12">
                 <label for="frm_name">ชื่อ - นามสกุล</label>
                 <input class="form-control"  type="text" name="frm_name" id="frm_name">
                 <br>
             </div>
             <div class="col-md-12">
                 <label for="frm_tel">เบอร์โทรศัพท์</label>
                 <input class="form-control"  type="text" name="frm_tel" id="frm_tel">
                 <br>
             </div>
              <div style="text-align: center;">
             <button class="btn btn-success" style="width:300px; margin:10px" id="upload">ตกลง</button>
           </div>

           </div>

           <div class="col-md-6" style="text-align: center;">
             <button class="btn btn-info" style="width:300px; margin:10px" id="snap">Capture</button>
             <button class="btn btn-info" style="width:300px; margin:10px; display: none;" id="new" >New</button>

             <video id="video" width="400" height="320" autoplay="true"></video>
             <div id="msg"></div>

             <canvas id="canvas" width="400" height="320" style="display: none;"></canvas>

           </div>
         </div>
</div>
</div>

<div class="panel panel-default">
<div class="panel-body">
  <div class="col-md-12">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <td>#</td>
              <td>ชื่อ</td>
              <td>เบอร์โทรศัพท์</td>
              <td>รูปภาพ</td>
            </tr>
          </thead>
          <tbody id="showdata">

          </tbody>
        </table>
      </div>
  </div>
</div>
</div>
</div>
</div>

<script>

</script>
