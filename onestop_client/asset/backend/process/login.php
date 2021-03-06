<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="exampleModalLabel">กรุณาเข้าสู่ระบบ</h2>
            </div>
            <div class="modal-body">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="user">ชื่อผู้ใช้งาน</label>
                        <input name="user" type="text" class="form-control" id="user"
                               placeholder="ชื่อผู้ใช้งาน"
                               autocomplete="off" value="asd">
                        <small id="userHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="password">รหัสผ่าน</label>
                        <input name="password" type="password" class="form-control" id="password"
                               placeholder="รหัสผ่าน"
                               autocomplete="off" value="123456">
                    </div>
                    <div style="float: right">
                        <button type="submit" name="login" value="login" class="btn btn-primary" id="login"
                                /*disabled="disabled"*/>เข้าสู่ระบบ
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.location.href ='../../backend.php'">
                    ปิด
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#exampleModal').modal({backdrop: 'static', keyboard: false}, 'show');
    });
    $('#exampleModal').on('shown.bs.modal',function () {
        $('#user').focus();
    });
    $('#login').on('click', function () {
        $('#exampleModal').modal('hide');
    });
    $('#user').focusout(function () {
        if ($('#user').val() == '') {
            $('#userHelp').append('<b style="color: red">กรุณากรอกชื่อผู้ใช้</b>');
            $('#login').attr('disabled', 'true');
            $('#user').css('border-color', 'red');
        } else {
            $('#login').removeAttr('disabled');
            $('#user').css('border-color', '#34b334');
        }
    });
</script>
