<?php
include_once "../../../itgmod/connect.php";
$path_image_header = "../../../fileupload/slide_header/";


if(isset($_POST['action'])) {

    //----------------- -Delete- ---------------

    if ($_POST['action'] == "remove_file") {

        $sqls = "select * from tb_slide_head where id = " . $_POST['id'];
        $rss = rsQuery($sqls);
        $row = mysqli_fetch_array($rss);
        $path = $path_image_header.$row['image'];
        if (unlink($path)) {
            $sql = "delete from tb_slide_head where id =" . $_POST['id'];
            $rs = rsQuery($sql);
            echo "ลบรูปภาพเรียบร้อยค่ะ <3";
        } else {
            echo "Err";
        }

        //----------------- -Add_data- ---------------

    } elseif ($_POST['action'] == "Add_data") {


        if ($_FILES["f_img"]["tmp_name"] !== null) {

            $sqlsl = 'SELECT * FROM tb_slide_head ORDER BY id DESC LIMIT 0,1';
            $rssl = rsQuery($sqlsl);
            $num = mysqli_fetch_array($rssl);
            $count = $num['id'] + 1;

                $filename = $_FILES["f_img"]["name"];
                $string = explode(".", $filename);
                $ext = end($string);
                $newname = "Slide_Im_Head_" . $count . '.' . $ext;
                $filetmp = $_FILES["f_img"]["tmp_name"];
                $filetype = $_FILES["f_img"]["type"];
                $filepath = $path_image_header . $newname;

                if (move_uploaded_file($filetmp, $filepath)) {
                    $sql = "INSERT INTO tb_slide_head(image,bg_color,title,content,name_url,url,no) 
                            VALUES ('" . $newname . "','" . $_POST['f_bgcolor'] . "','" . $_POST['f_title'] . "','" . $_POST['f_content'] . "'
                            ,'" . $_POST['f_link'] . "','" . $_POST['f_url'] . "','" . $_POST['f_no'] . "')";
                    if (rsQuery($sql)){
                        echo "บรรทึกข้อมูลเรียบร้อยค่ะ";
                    }else {
                        echo "Error Add";
                    }
                } else {
                    echo "Image not upload.";
                }
        }else{
            echo "กรุณาเลือกรูปภาพค่ะ";
        }

        //----------------- -Edit_data- ---------------
    }elseif ($_POST['action'] == "Edit_data") {


        if ($_FILES["f_img"]["tmp_name"] !== "") { //----------------- -Edit Image- ---------------

            $path = $path_image_header.$_POST['f_imgs'];

            unlink($path);

                $filename = $_FILES["f_img"]["name"];
                $string = explode(".", $filename);
                $ext = end($string);
                $newname = "Slide_Im_Head_" . $_POST['f_id'] . '.' . $ext;
                $filetmp = $_FILES["f_img"]["tmp_name"];
                $filetype = $_FILES["f_img"]["type"];
                $filepath = $path_image_header . $newname;

                if(move_uploaded_file($filetmp,$filepath)){
                    $sql = 'update tb_slide_head set image="'.$newname.'",bg_color="'.$_POST['f_bgcolor'].'",title="'.$_POST['f_title'].'",
            content="'.$_POST['f_content'].'",name_url="'.$_POST['f_link'].'",url="'.$_POST['f_url'].'",no="'.$_POST['f_no'].'"
                    where id="'.$_POST['f_id'].'"';
                    $rs = rsQuery($sql);
                    echo "แก้ไขข้อมูลแล้วค่ะ <3";
                }else{
                    echo "image not upload.";
                }


        }else{ //----------------- -Not Edit Image- ---------------
            $sql = 'update tb_slide_head set bg_color="'.$_POST['f_bgcolor'].'",title="'.$_POST['f_title'].'",
            content="'.$_POST['f_content'].'",name_url="'.$_POST['f_link'].'",url="'.$_POST['f_url'].'",no="'.$_POST['f_no'].'"
                    where id="'.$_POST['f_id'].'"';
            $rs = rsQuery($sql);
            echo "แก้ไขข้อมูลแล้วค่ะ <3";
        }




    }else{
        echo "action is null.";
    }

}else{
    echo "Not action.";

}
?>