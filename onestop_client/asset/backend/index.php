<?php
/**
 * Created by PhpStorm.
 * User: Programmer-ITG
 * Date: 12/9/2017
 * Time: 9:41 AM
 */
?>
<style>
    .content-wrapper, a.btn, span.badge {
        font-size: 14px;
    }

    .table td {
        padding: 3px;
        margin: 3px;
    }

    #Image, .Imagetd {
        width: 100px;
    }
</style>
<div class="card">
    <div class="card-body">
        <div class="row" style="padding-bottom: 10px;">
            <div class="col-12">
                <select id="year" class="form-control">
                    <?php $Year = date('Y') + 543 ?>
                    <?php $welfare_sql = result_array('SELECT * FROM tb_welfare ORDER BY year ASC '); ?>
                    <?php foreach ($welfare_sql as $key => $item): ?>
                        <?php
                        $select = '';
                        if ($item['year'] == $Year) {
                            $select = 'selected';
                        }
                        ?>
                        <option value="<?php echo $item['year'] ?>" <?php echo $select; ?>><?php echo $item['year'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4 mb-4">
                <div class="card text-white bg-primary o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fa fa-fw fa-list"></i>
                        </div>
                        <div class="mr-5">ขอรับเบี้ยยังชีพผู้สูงอายุ
                            <span class="badge badge-light" id="OrderPoint">0</span> คน
                        </div>
                    </div>
                    <a href="#" class="card-footer text-white clearfix small z-1" id="bt-order">
                        <span class="float-left">รายละเอียด</span>
                        <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
                    </a>
                </div>
            </div>
            <div class="col-xl-4 mb-4">
                <div class="card text-white bg-warning o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fa fa-fw fa-list"></i>
                        </div>
                        <div class="mr-5">ขอรับเบี้ยยังชีพผู้พิการ
                            <span class="badge badge-light" id="handicap">0</span> คน
                        </div>
                    </div>
                    <a href="#" class="card-footer text-white clearfix small z-1" id="bt-handicap">
                        <span class="float-left">รายละเอียด</span>
                        <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
                    </a>
                </div>
            </div>
            <div class="col-xl-4 mb-4">
                <div class="card text-white bg-success  o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fa fa-fw fa-list"></i>
                        </div>
                        <div class="mr-5">ขอรับเบี้ยยังชีพผู้ป่วยเอดส์
                            <span class="badge badge-light" id="AIDS">0</span> คน
                        </div>
                    </div>
                    <a href="#" class="card-footer text-white clearfix small z-1" id="bt-AIDS">
                        <span class="float-left">รายละเอียด</span>
                        <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row" id="Detail" hidden>
            <div class="col-12">
                <div class="table-responsive" style="height: 400px">
                    <table class="table table-bordered" id="TableDetail">
                        <thead>
                        <tr>
                            <th style="white-space: nowrap;">ชื่อผู้ขอ</th>
                            <th style="white-space: nowrap;">วันที่ขอ</th>
                            <th style="white-space: nowrap;">จำนวนเงิน</th>
                            <th style="white-space: nowrap;">วิธีการรับเงิน</th>
                            <th style="white-space: nowrap;">จัดการ</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="CancelBox" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">เหตุผลที่ไม่อนุมัติ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <input type="text" id="CancelID" hidden>
                            <label for="exampleFormControlTextarea1">เหตุผล</label>
                            <textarea class="form-control" id="detail" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="Btn-Cancel">ตกลง</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     style="padding-right: 17px;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">เอกสาร <b id="UserName"></b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="panel panel-body table-responsive">
                    <table class="table table-bordered table-striped" id="showImage">
                        <tbody>
                        <tr class="File">

                        </tr>
                        <tr class="FileName">

                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" value="" id="CheckImg">
                        เอกสารไม่ผ่าน (เช็คเพื่อระบุว่าเอกสารใดไม่ผ่าน)
                    </label>
                </div>
                <div class="form-group" id="form-check" hidden>
                    <label for="text-check">ระบุ (เอกสารที่ไม่ผ่าน):</label>
                    <textarea class="form-control" id="text-check" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <input type="text" id="id-check" hidden>
                <button type="button" class="btn btn-danger" id="btn-check-img" hidden>แจ้งเอกสารไม่ผ่าน</button>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">
    function DateThai(date) {
        thai = new Date(date);
        strMonthCut = ["", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];
        thai = thai.getDate() + '/' + strMonthCut[thai.getMonth() + 1] + '/' + (thai.getFullYear() + 543);
        return thai;
    }

    function NumString(num) {
        return num == null || num == undefined ? 0 : parseFloat(num).toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")
    }

    function NumMoney(num) {
        return num == null || num == undefined ? 0 : parseFloat(num).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")
    }

    var dataAIDS = [];
    var dataOrder = [];
    var datahandi = [];
    var This = '';
    var year = $('#year');
    year.change(function () {
        OrderPoint();
        handicapPoint();
        AIDSPoint();
    });
    OrderPoint();
    handicapPoint();
    AIDSPoint();

    function OrderPoint() {
        $.ajax({
            url: 'ajax/ajax_data.php',
            type: 'POST',
            data: {action: 'Point', Name: 'Order', Year: year.val()},
            dataType: 'JSON',
            success: function (result) {
                dataOrder = result['data'];
                $('#OrderPoint').text(NumString(result['data'].length));
                console.log(result);
            },
            error: function (result) {
                console.log(result);
            }
        });
    }

    function handicapPoint() {
        $.ajax({
            url: 'ajax/ajax_data.php',
            type: 'POST',
            data: {action: 'Point', Name: 'handicap', Year: year.val()},
            dataType: 'JSON',
            success: function (result) {
                datahandi = result['data'];
                $('#handicap').text(NumString(result['data'].length));
                console.log(result);
            },
            error: function (result) {
                console.log(result);
            }
        });
    }

    function AIDSPoint() {
        $.ajax({
            url: 'ajax/ajax_data.php',
            type: 'POST',
            data: {action: 'Point', Name: 'AIDS', Year: year.val()},
            dataType: 'JSON',
            success: function (result) {
                dataAIDS = result['data'];
                $('#AIDS').text(NumString(result['data'].length));
                console.log(result);
            },
            error: function (result) {
                console.log(result);
            }
        });
    }

    $('#bt-AIDS').click(function () {
        AddTable(dataAIDS);
    });
    $('#bt-order').click(function () {
        AddTable(dataOrder);
    });
    $('#bt-handicap').click(function () {
        AddTable(datahandi);
    });

    function AddTable(data) {
        $('#Detail').removeAttr('hidden');
        $('#TableDetail tbody').empty();
        $.each(data, function (key, val) {
            $('#TableDetail tbody').append('<tr class="detail">' +
                '<td class="personid" hidden>' + val['personid'] + '</td>' +
                '<td class="id" hidden>' + val['PID'] + '</td>' +
                '<td class="Uid" hidden>' + val['Uid'] + '</td>' +
                '<td style="white-space: nowrap;" width="20%"><a class="File" href="#">' + val['userid'] + '</a></td>' +
                '<td style="white-space: nowrap;" width="20%">' + DateThai(val['requestdate']) + '</td>' +
                '<td style="white-space: nowrap;" width="20%">' + NumMoney(val['amount']) + '</td>' +
                '<td style="white-space: nowrap;" width="20%">' + val['name'] + '</td>' +
                '<td style="white-space: nowrap;" width="2%">' +
                '<a class="btn btn-success btn-ok" style="color:white">อนุมัติ</a> ' +
                '<a class="btn btn-danger btn-no" style="color:white">ยกเลิก</a>' +
                '</td>' +
                '</tr>')
        });
    }

    function Accept(PersonId, Id, This) {
        $.ajax({
            url: 'ajax/ajax_data.php',
            type: 'POST',
            data: {action: 'accept', ID: Id, PersonId: PersonId},
            dataType: 'JSON',
            success: function (result) {
                This.remove();
                OrderPoint();
                handicapPoint();
                AIDSPoint();
            },
            error: function (result) {
                console.log(result);
            }
        });

    }

    function Cancel(Id, This, detail) {
        $.ajax({
            url: 'ajax/ajax_data.php',
            type: 'POST',
            data: {action: 'cancel', Id: Id, detail: detail},
            dataType: 'JSON',
            success: function (result) {
                This.remove();
                OrderPoint();
                handicapPoint();
                AIDSPoint();
                $('#CancelBox').modal('hide');
            },
            error: function (result) {
                console.log(result);
            }
        });
    }

    $('#TableDetail tbody').on('click', '.btn-ok', function () {
        PersonId = '';
        Id = '';
        var This = $(this).closest('tr');
        var PersonId = $(this).closest('tr').find('.personid').text();
        var Id = $(this).closest('tr').find('.id').text();
        Accept(PersonId, Id, This);
    });
    $('#TableDetail tbody').on('click', '.btn-no', function () {
        PersonId = '';
        Id = '';
        This = $(this).closest('tr');
        var PersonId = $(this).closest('tr').find('.personid').text();
        var Id = $(this).closest('tr').find('.id').text();
        $('#CancelBox').modal({backdrop: 'static', keyboard: false}, 'show');
        $('#CancelID').val(Id);
    });
    $('#Btn-Cancel').click(function () {
        var Id = $('#CancelID').val();
        var detail = $('#detail').val();
        Cancel(Id, This, detail);
    });
    var ThisRemove = '';
    $('#TableDetail tbody').on('click', '.File', function () {
        Uid = $(this).closest('tr').find('.Uid').text();
        Pid = $(this).closest('tr').find('.id').text();
        ThisRemove = $(this).closest('tr');
        UserName = $(this).text();
        $('.bd-example-modal-lg').modal('show');
        $('#UserName').text(UserName);
        $('#id-check').val(Pid)
        FindFile(Uid);
    });

    function FileName(filename) {
        var ii = filename.split('_');
        var jj = ii[3].split('.');
        var $file = '';
        if (jj[0] == 'personidfile') {
            $file = 'สำเนาบัตรประชาชน';
        } else if (jj[0] == 'addressid') {
            $file = 'สำเนาทะเบียนบ้าน';
        } else if (jj[0] == 'bank') {
            $file = 'สำเนาสมุดเงินฝาก';
        } else if (jj[0] == 'authority') {
            $file = 'หนังสือมอบอำนาจ';
        } else if (jj[0] == 'authority-personid') {
            $file = 'สำเนาบัตรประชาชน ผู้รับมอบอำนาจ';
        } else if (jj[0] == 'authority-address') {
            $file = 'สำเนาบัตรทะเบียนบ้านผู้รับมอบอำนาจ';
        } else if (jj[0] == 'handicapid') {
            $file = 'สำเนาบัตรคนพิการ';
        } else if (jj[0] == 'aids') {
            $file = 'ใบรับรองแพทย์ยืนยันว่าป่วยเป็นโรคเอดส์จริง';
        }
        return $file;
    }

    function FindFile(id) {
        $.ajax({
            url: 'ajax/ajax_data.php',
            type: 'POST',
            data: {action: 'FindFile', Id: id},
            dataType: 'JSON',
            success: function (result) {
                $('#showImage tbody tr').empty();
                $('#showImage tbody tr.FileName').empty();
                $.each(result, function (key, val) {
                    var filename = val['filename'].split('.')[3];
                    if (filename == 'pdf') {
                        $('#showImage tbody tr.File').append('' +
                            '<td class="Imagetd">' +
                            '<a target="_blank" href="' + val['filename'] + '">' +
                            '<img src="../asset/pdf.png" alt="Trolltunga Norway" width="100" height="100"> ' +
                            '</a>' +
                            '</td>');
                        $('#showImage tbody tr.FileName').append('' +
                            '<td class="Imagetda" style="text-align: center">' +
                            '<b>' + FileName(val['F']) + '</b>' +
                            '</td>');
                    } else {
                        $('#showImage tbody tr.File').append('' +
                            '<td class="Imagetd">' +
                            '<a target="_blank" href="' + val['filename'] + '">' +
                            '<img src="' + val['filename'] + '" alt="Trolltunga Norway" width="100" height="100"> ' +
                            '</a>' +
                            '</td>');
                        $('#showImage tbody tr.FileName').append('' +
                            '<td class="Imagetda" style="text-align: center">' +
                            '<b>' + FileName(val['F']) + '</b>' +
                            '</td>');
                    }
                });
            },
            error: function (result) {
                console.log(result);
            }
        });
    }

    var check = $('#CheckImg');
    var BtCheck = $('#btn-check-img');
    var TextCheck = $('#text-check');
    BtCheck.click(function () {
        var id = $('#id-check').val();
        $.ajax({
            url: 'ajax/ajax_data.php',
            type: 'POST',
            data: {action: 'NoImg', text: TextCheck.val(), ID: id},
            dataType: 'JSON',
            success: function (result) {
                console.log(result);
                ThisRemove.remove();
                OrderPoint();
                handicapPoint();
                AIDSPoint();
                $('.bd-example-modal-lg').modal('hide');
            },
            error: function (result) {
                console.log(result);
            }
        });
    });
    check.change(function () {
        if (check.prop('checked')) {
            $('#btn-check-img').removeAttr('hidden');
            $('#form-check').removeAttr('hidden');
        }
        else {
            $('#btn-check-img').attr('hidden', 'hidden');
            $('#form-check').attr('hidden', 'hidden');
        }
    });
    $("#navbarResponsive li.nav-item:nth-child(1)").addClass("active");
</script>

