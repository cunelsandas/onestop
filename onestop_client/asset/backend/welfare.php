<?php
/**
 * Created by PhpStorm.
 * User: Programmer-ITG
 * Date: 28/12/2560
 * Time: 10:58
 */
?>
<link rel="stylesheet" href="DatePick/datepicker.css">
<script src="DatePick/bootstrap-datepicker.js"></script>
<script src="DatePick/bootstrap-datepicker.th.js"></script>
<script src="DatePick/bootstrap-datepicker-thai.js"></script>
<style>
    .card {
        font-size: 12px;
    }

    .form-control {
        border-radius: 0;
    }

    th {
        white-space: nowrap;
    }
</style>
<div class="card">
    <div class="card-body">
        <div class="row" style="padding-bottom: 10px;">
            <div class="col-lg-2 pl-0 pr-0">
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
            <div class="col-lg-2 pl-0 pr-0">
                <select class="form-control" id="Moo">
                    <?php $moo = result_array('SELECT * FROM tb_moo'); ?>
                    <?php foreach ($moo as $key => $item): ?>
                        <option value="<?php echo $item['id'] ?>"><?php echo $item['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-lg-5 pl-0 pr-0">
                <select class="form-control" id="SL_Type">
                    <?php $sql = 'SELECT * FROM tb_welfare_type';
                    $data = result_array($sql);
                    foreach ($data as $key => $val):?>
                        <option value="<?= $val['id'] ?>"><?= $val['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-lg-3 pl-0 pr-0 text-right">
                <button class="btn btn-primary" id="process"><i class=""></i> กดประมวลยอดขอขึ้นทะเบียน</button>
            </div>
        </div>

        <div class="row" style="padding-top: 10px;">
            <div class="table-responsive" style="height: 400px;">
                <table class="table table-bordered table-sm" id="welfare-table">
                    <thead>
                    <tr>
                        <th>ปี</th>
                        <th>กำหนดวัน</th>
                        <th style="text-align: right;">เบี็ยผู้สูงอายุ 60</th>
                        <th style="text-align: right;">เบี็ยผู้สูงอายุ 70</th>
                        <th style="text-align: right;">เบี็ยผู้สูงอายุ 80</th>
                        <th style="text-align: right;">เบี็ยผู้สูงอายุ 90</th>
                        <th style="text-align: right;">เบี้ยผู้พิการ</th>
                        <th style="text-align: right;">เบี้ยผู้ป่วยโรคเอดส์</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <a href="#" class="btn btn-success" id="btplus">
                    เพิ่มเบี้ย
                </a>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">เพิ่มเบี้ย</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="Wf-Form">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="ip-wf-year"><b>ปี</b></label>
                                        <input type="text" class="form-control" id="ip-wf-year"
                                               required placeholder="ปี">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="ip-wf-date"><b>วัน</b></label>
                                        <input type="text" class="form-control" id="ip-wf-date"
                                               required placeholder="กำหนดวัน">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="ip-wf-old60"><b>เบี้ยผู้สูงอายุ 60 ปี</b></label>
                                        <input type="text" class="form-control" id="ip-wf-old60"
                                               required placeholder="เบี้ยผู้สูงอายุ 60">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="ip-wf-old70"><b>เบี้ยผู้สูงอายุ 70 ปี</b></label>
                                        <input type="text" class="form-control" id="ip-wf-old70"
                                               required placeholder="เบี้ยผู้สูงอายุ 70">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="ip-wf-old80"><b>เบี้ยผู้สูงอายุ 80 ปี</b></label>
                                        <input type="text" class="form-control" id="ip-wf-old80"
                                               required placeholder="เบี้ยผู้สูงอายุ 80">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="ip-wf-old90"><b>เบี้ยผู้สูงอายุ 90 ปี</b></label>
                                        <input type="text" class="form-control" id="ip-wf-old90"
                                               required placeholder="เบี้ยผู้สูงอายุ 90">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="ip-wf-handicap"><b>เบี้ยผู้พิการ</b></label>
                                        <input type="text" class="form-control" id="ip-wf-handicap"
                                               required placeholder="เบี้ยผู้พิการ">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="ip-wf-aids"><b>เบี้ยผู้ป่วยโรคเอดส์</b></label>
                                        <input type="text" class="form-control" id="ip-wf-aids"
                                               required placeholder="เบี้ยผู้ป่วยโรคเอดส์">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="bt-wf-add">เพิ่ม</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var Btwfadd = $('#bt-wf-add');
    $('.datepick').datepicker({
        todayBtn: "linked",
        autoclose: true,
        todayHighlight: true,
        language: "th-th"
    });
    var btnPlus = $('#btplus');
    btnPlus.click(function () {
        $('#exampleModal').modal('show');
    });
    $('#exampleModal').on('show.bs.modal', function () {
        var nextYear = 0;
        var nextDate = '';
        var dateNow = $('.birthdate:last').text();
        nextYear = parseInt($('.year:last').text()) + 1;
        nextDate = dateNow.split('/');
        nextDate = nextDate[0] + '/' + nextDate[1] + '/' + (parseInt(nextDate[2]) + 1)
        $('#ip-wf-year').val(nextYear);

        $('#ip-wf-date').val(nextDate);
        $('#ip-wf-old60').val(parseInt($('.older60:last').text().replace(/,/g, "")));
        $('#ip-wf-old70').val(parseInt($('.older70:last').text().replace(/,/g, "")));
        $('#ip-wf-old80').val(parseInt($('.older80:last').text().replace(/,/g, "")));
        $('#ip-wf-old90').val(parseInt($('.older90:last').text().replace(/,/g, "")));
        $('#ip-wf-handicap').val(parseInt($('.handicap:last').text().replace(/,/g, "")));
        $('#ip-wf-aids').val(parseInt($('.aids:last').text().replace(/,/g, "")));

    });
    Btwfadd.click(function () {
        var data = [];
        data.push({
            WfYear: $('#ip-wf-year').val(),
            WfDate: Splitdate($('#ip-wf-date').val()),
            WfOld60: $('#ip-wf-old60').val(),
            WfOld70: $('#ip-wf-old70').val(),
            WfOld80: $('#ip-wf-old80').val(),
            WfOld90: $('#ip-wf-old90').val(),
            WfHandicap: $('#ip-wf-handicap').val(),
            WfAids: $('#ip-wf-aids').val(),
        });
        $.ajax({
            url: 'ajax/ajax_data.php',
            type: 'POST',
            data: {action: 'WelfareAdd', Data: data},
            dataType: 'JSON',
            success: function (result) {
                $('#exampleModal').modal('hide');
                findWelfare();
            },
            error: function (result) {
                console.log(result);
            }
        });
    });

    function Splitdate(date) {
        if (date != '') {
            date = date.split('/');
            date[2] = date[2] - 543;
            date = date[2] + '-' + date[1] + '-' + date[0];
        }
        return date;
    }

    var year = $('#year');
    var sl_type = $('#SL_Type');
    var moo = $('#Moo');
    $('#process').click(function () {
        $(this).attr('disabled', 'true');
        $(this).find('i').addClass('fa fa-circle-o-notch fa-spin');
        Process($(this));
    });

    function Process(itis) {
        $.ajax({
            url: 'ajax/ajax_data.php',
            type: 'POST',
            data: {action: 'Process', Year: year.val(), Type: sl_type.val(), Moo: moo.val()},
            dataType: 'JSON',
            success: function (result) {
                console.log(result);
                itis.removeAttr('disabled');
                itis.find('i').removeClass('fa fa-circle-o-notch fa-spin')
                if (result.length == 0) {
                    alert('ไม่มีรายการที่ต้องประมวลผล');
                } else {
                    alert('ประมวลผลเรียบร้อยแล้ว');
                }
            },
            error: function (result) {
                alert('ไม่สามาประมวลยอดได้');
            }
        });
    }

    findWelfare();

    function NumberString(num) {
        return num != null && num != undefined && num != 0 ? parseFloat(num).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") : '';
    };

    function DateT(n) {
        if (n != null && n != '') {
            var SHdate = new Date(n)

            function ga(date) {
                return date < 10 ? "0" + date : date;
            }

            return ga(SHdate.getDate()) + '/' + ga((SHdate.getMonth() + 1)) + '/' + (SHdate.getFullYear() + 543);
        } else {
            return '';
        }

    };

    function findWelfare() {
        $.ajax({
            url: 'ajax/ajax_data.php',
            type: 'POST',
            data: {action: 'findWelfare'},
            dataType: 'JSON',
            success: function (result) {
                console.log(result);
                $('#welfare-table tbody').empty();
                $.each(result, function (key, val) {
                    $('#welfare-table tbody').append('<tr>' +
                        '<td class="year">' + val['year'] + '</td>' +
                        '<td class="birthdate">' + DateT(val['birthdate']) + '</td>' +
                        '<td class="older60" style="text-align: right;">' + NumberString(val['older60']) + '</td>' +
                        '<td class="older70" style="text-align: right;">' + NumberString(val['older70']) + '</td>' +
                        '<td class="older80" style="text-align: right;">' + NumberString(val['older80']) + '</td>' +
                        '<td class="older90" style="text-align: right;">' + NumberString(val['older90']) + '</td>' +
                        '<td class="handicap" style="text-align: right;">' + NumberString(val['handicap']) + '</td>' +
                        '<td class="aids" style="text-align: right;">' + NumberString(val['aids']) + '</td>' +
                        '</tr>')
                });
            },
            error: function (result) {
                console.log(result);
            }
        });
    }

    $("#navbarResponsive li.nav-item:nth-child(3)").addClass("active");
</script>