<?php

$path_image_header = "../fileupload/header/";

?>


<style>
    .table th {
        text-align: center;
        font-weight: 900;
    }
    .table td {
        text-align: center;
    }
</style>

<div class="panel panel-default col-12">
    <div style="background-color: #222222" class="panel-heading">
        <h5 style="color: #fffbfd">Header Slide</h5>
    </div>

    <!-- -------------------------- Start panel body ---------------------------------- -->
    <div class="panel-body">
        <!-- -------------------------- Start form ---------------------------------- -->
        <div class="panel panel-default">
            <div class="panel-body">

                <div class="row col-md-12">
                    <form method="post" id="uploadForm" action="#">
                        <div class="col-md-12" style="text-align: center">
                            <button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#myModal">เพิ่ม Slide</button>                            <div class="separator col-md-12"></div>
                        </div>
                    </form>
                </div>

                <div id="show_data" class="row col-md-12">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th></th>
                        <th>รูปภาพ</th>
                        <th>หัวเรื่อง</th>
                        <th>ลำดับ</th>
                        <th>จัดการ</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                        $path_image_header = "../fileupload/slide_header/";
                        $sql = 'SELECT * FROM tb_slide_head ORDER BY no';
                        $rs = rsQuery($sql);
                        $n=1;

                        while ($row = mysqli_fetch_array($rs)){
                            echo '<tr> 
                                    <td>'.$n.'</td>
                                    <td> <img id="img" style="width: 100px; height: auto;"  src="'.$path_image_header.$row["image"].'"></td>
                                    <td>'.$row["title"].'</td>
                                    <td>'.$row["no"].'</td>
                                    <td>
                                        <a class="btn btn-warning btn_edit" data-toggle="modal" data-target="#myEditModal"
                                        data-id="'.$row["id"].'" data-image="'.$row["image"].'"
                                         data-bg_color="'.$row["bg_color"].'" data-title="'.$row["title"].'"
                                         data-content="'.$row["content"].'" data-name_url="'.$row["name_url"].'"
                                         data-url="'.$row["url"].'" data-no="'.$row["no"].'">แก้ไข</a>
                                        <a class="btn btn-danger" onclick="btn_delete('.$row["id"].')">ลบ</a>
                                    </td>                                   
                                  </tr>';
                            $n++;
                        }

                    ?>

                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>



<!---------------------------------------------------- MODAL-ADD ---------------------------------------------------->

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">เพิ่ม Slide</h4>
            </div>
            <div class="modal-body">

                <form action="" id="Add_form" method="post" enctype="multipart/form-data">
                    <div class="form-group col-md-12">
                        <label>เพิ่มรูปภาพ</label>
                            <div class="input-group">
                                <label class="input-group-btn">
                    <span class="btn btn-default">
                        Browse&hellip; <input type="file" name="f_img" id="f_img" style="display: none;">
                    </span>
                                </label>
                                <input type="text" class="form-control" readonly>
                            </div>
                            <span class="help-block">กรุณาเลือกรูปภาพ</span>
                    </div>

                    <div class="form-group">
                        <label for="f_bg">สีพื้นหลัง:</label>
                        <input type="text" data-wheelcolorpicker data-wcp-format="rgba" name="f_bgcolor" class="form-control" id="f_bgcolor">
                    </div>
                    <div class="form-group">
                        <label for="f_title">หัวเรื่อง:</label>
                        <input type="text" class="form-control" name="f_title" id="f_title">
                    </div>
                    <div class="form-group">
                        <label for="f_content">เนื้อหา:</label>
                        <textarea class="form-control" rows="5"  name="f_content" id="f_content"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="f_link">ชื่อ link:</label>
                        <input type="text" class="form-control" name="f_link" id="f_link">
                    </div>
                    <div class="form-group">
                        <label for="f_url">Url :</label>
                        <input type="text" class="form-control" name="f_url" id="f_url">
                    </div>
                    <div class="form-group">
                        <label for="f_no">ลำดับ :</label>
                        <input type="text" class="form-control" name="f_no" id="f_no">
                    </div>

                    <input type="hidden" name="action" id="action" value="Add_data">

                </form>

            </div>

            <div class="modal-footer">
                <button type="button" id="btn_upload" class="btn btn-default">Submit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<!---------------------------------------------------- MODAL-Edit ---------------------------------------------------->

<div id="myEditModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">แก้ไข Slide</h4>
            </div>
            <div class="modal-body">

                <form action="" id="Edit_form" method="post" enctype="multipart/form-data">
                    <div class="form-group col-md-12">
                        <label>เพิ่มรูปภาพ</label>
                        <div class="input-group">
                            <label class="input-group-btn">
                    <span class="btn btn-default">
                        Browse&hellip; <input type="file" name="f_img" id="f_img" style="display: none;">
                    </span>
                            </label>
                            <input type="text" class="form-control" readonly>
                        </div>
                        <span class="help-block">กรุณาเลือกรูปภาพ</span>
                    </div>

                    <div class="form-group">
                        <label for="f_bg">สีพื้นหลัง:</label>
                        <input type="text" data-wheelcolorpicker data-wcp-format="rgba" name="f_bgcolor" class="form-control f_bgcolor" id="f_bgcolor">
                    </div>
                    <div class="form-group">
                        <label for="f_title">หัวเรื่อง:</label>
                        <input type="text" class="form-control f_title" name="f_title" id="f_title">
                    </div>
                    <div class="form-group">
                        <label for="f_content">เนื้อหา:</label>
                        <textarea class="form-control f_content" rows="5"  name="f_content" id="f_content"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="f_link">ชื่อ link:</label>
                        <input type="text" class="form-control f_link" name="f_link" id="f_link">
                    </div>
                    <div class="form-group">
                        <label for="f_url">Url :</label>
                        <input type="text" class="form-control f_url" name="f_url" id="f_url">
                    </div>
                    <div class="form-group">
                        <label for="f_no">ลำดับ :</label>
                        <input type="text" class="form-control f_no" name="f_no" id="f_no">
                    </div>

                    <input type="hidden" name="action" id="action" value="Edit_data">
                    <input type="hidden" class="f_id" name="f_id" id="f_id">
                    <input type="hidden" class="f_imgs" name="f_imgs" id="f_imgs">

                </form>

            </div>

            <div class="modal-footer">
                <button type="button" id="btn_edit" class="btn btn-default">Submit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


<script>


    $(function() {
        // We can attach the `fileselect` event to all file inputs on the page
        $(document).on('change', ':file', function() {
            var input = $(this),
                numFiles = input.get(0).files ? input.get(0).files.length : 1,
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [numFiles, label]);
        });

        // We can watch for our custom `fileselect` event like this
        $(document).ready( function() {
            $(':file').on('fileselect', function(event, numFiles, label) {

                var input = $(this).parents('.input-group').find(':text'),
                    log = numFiles > 1 ? numFiles + ' files selected' : label;

                if( input.length ) {
                    input.val(log);
                } else {
                    if( log ) alert(log);
                }
            });

        });
    });

    $(document).ready(function() {

        $('#btn_upload').click(function () {
            var data = new FormData($("#Add_form")[0]);
            $.ajax({
                url: "modules/configstyle_slideheader/action.php",
                type: 'POST',
                data: data,
                contentType: false,
                processData: false,
                success: function(data){
                    alert(data);
                    $("#myModal").modal("hide");
                    document.getElementById("Add_form").reset();
                    $("#show_data").load(location.href + " #show_data");
                },
                error: function () {
                    alert("Function Error.");
                }
            });
        });


        $(document).on("click",'.btn_edit',function (e){

            var id = $(this).data('id');
            var image = $(this).data('image');
            var bg_color = $(this).data('bg_color');
            var title = $(this).data('title');
            var content = $(this).data('content');
            var name_url = $(this).data('name_url');
            var url = $(this).data('url');
            var no = $(this).data('no');

            $(".f_id").val(id);
            $(".f_imgs").val(image);
            $(".f_bgcolor").val(bg_color);
            $(".f_title").val(title);
            $(".f_content").val(content);
            $(".f_link").val(name_url);
            $(".f_url").val(url);
            $(".f_no").val(no);

        });


        $('#btn_edit').click(function () {

            var data = new FormData($("#Edit_form")[0]);
            $.ajax({
                url: "modules/configstyle_slideheader/action.php",
                type: 'POST',
                data: data,
                contentType: false,
                processData: false,
                success: function(data){
                    alert(data);

                    $("#myEditModal").modal("hide");
                    document.getElementById("Edit_form").reset();
                    $("#show_data").load(location.href + " #show_data");
                },
                error: function () {
                    alert("Function Error.");
                }
            });
        });

        $('#btn_delete').click(function () {



        });


    });


    function btn_delete(id) {
        var action = "remove_file";
        if(confirm("ต้องการลบรูปภาพหรือไม่")){
            $.ajax({
                url : "modules/configstyle_slideheader/action.php",
                method : "POST",
                data : {
                    action : action,
                    id : id
                },
                success: function (data) {
                    alert(data);
                    $("#show_data").load(location.href + " #show_data");
                }
            });
        }else {
            return false;
        }
    }

    /* ---------------------- Add Image ------------------------*/
/*
    $(document).ready(function(){
        $('#uploadForm').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url: "modules/configstyle_slideheader/action.php",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                processData:false,
                success: function(data)
                {
                    $("#image_preview").html("");
                    $("#divimage").load(location.href + " #divimage");
                    alert(data);
                }
            });
        });
    });

*/

</script>
