<?php
/**
 * Created by PhpStorm.
 * User: Programmer-ITG
 * Date: 12-Dec-17
 * Time: 11:08 AM
 */
$sqlmoo = 'SELECT * FROM tb_moo';
$moo = result_array($sqlmoo);
?>
<style>
    .content-wrapper, a.btn, span.badge {
        font-size: 14px;
    }

    .table td {
        padding: 3px;
        margin: 3px;
    }

    .input-group-sm > .input-group-btn > select.btn:not([size]):not([multiple]), .input-group-sm > select.form-control:not([size]):not([multiple]), .input-group-sm > select.input-group-addon:not([size]):not([multiple]), select.form-control-sm:not([size]):not([multiple]) {
        height: auto;
    }
</style>
<div class="card">
    <div class="card-body">
        <div class="row text-right" style="padding-bottom: 10px;">
            <div class="col-12">
                <a class="AddNew btn btn-success" style="color: white;" href="backend.php?r=add">
                    <i class="fa fa-plus"></i> เพิ่มข้อมูลใหม่</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="input-group" style="padding-bottom: 10px;">
                    <input type="text" class="form-control" placeholder="ค้นหาตามเลขบัตร/ชื่อ" id="SearchPerson">
                    <span class="input-group-btn">
                       <select class="form-control form-control-sm" id="Moo">
                           <?php foreach ($moo as $key => $item): ?>
                               <option value="<?php echo $item['id'] ?>"><?php echo $item['name'] ?></option>
                           <?php endforeach; ?>
                    </select>
                </span>
                </div>
                <table class="table table-bordered table-hover table-responsive-md" id="viewPerson"
                       style="overflow-x: auto; overflow-y: auto;">
                    <thead>
                    <tr>
                        <th style="text-align: center;white-space: nowrap;">เลขบัตรปรชาชน</th>
                        <th style="text-align: center;white-space: nowrap;">ชื่อ-นามสกุล</th>
                        <th style="text-align: center;white-space: nowrap;">จัดการ</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
<script>
    var Table = $('#viewPerson tbody');
    var Moo = $('#Moo')

    function SPersonData(data = '') {
        $.ajax({
            url: 'ajax/ajax_data.php',
            type: 'POST',
            data: {action: 'SPerson', data: data, moo: Moo.val()},
            dataType: 'JSON',
            success: function (result) {
                Table.empty();
                if (result['data'].length > 0) {
                    $.each(result['data'], function (key, val) {
                        Table.append('<tr class="person' + key + '">' +
                            '<td class="Pid" hidden>' + val['id'] + '</td>' +
                            '<td style="white-space: nowrap;">' + val['personid'] + '</td>' +
                            '<td style="white-space: nowrap;">' + val['name'] + ' ' + val['surname'] + '</td>' +
                            '<td style="white-space: nowrap;" width="2%">' +
                            '<a class="view btn btn-primary btn-block" style="color: white;"><i class="fa fa-user"></i> ดู</a>' + ' ' +
                            '</td>' +
                            '</tr>');
                    });
                } else {
                    Table.append('<tr>' +
                        '<td colspan="3" style="text-align: center;"><b style="color: red; font-size: 18px;">ไม่พบข้อมูล</b></td>' +
                        '</tr>');
                }
            },
            error: function (result) {
                console.log(result);
            }
        });
    }

    var SPerson = $('#SearchPerson');
    SPerson.keyup(function () {
        SPersonData(SPerson.val());
    });
    Moo.change(function () {
        SPersonData(SPerson.val());
    });
    SPersonData();
    Table.on('click', '.view', function () {
        var Pid = $(this).closest('tr').find('.Pid').text();
        window.location.href = 'backend.php?r=add&id=' + Pid;
    });
    $("#navbarResponsive li.nav-item:nth-child(2)").addClass("active");
</script>
