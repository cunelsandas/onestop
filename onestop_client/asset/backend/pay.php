<?php
/**
 * Created by PhpStorm.
 * User: Programmer-ITG
 * Date: 12-Dec-17
 * Time: 4:26 PM
 */
$sqlmoo = 'SELECT * FROM tb_moo';
$moo = result_array($sqlmoo);
$sqltype = 'SELECT * FROM tb_welfare_type';
$type = result_array($sqltype);
$sqlyear = 'SELECT * FROM tb_welfare ORDER BY year';
$year = result_array($sqlyear);
?>
<style>
    .content-wrapper, a.btn, span.badge {
        font-size: 14px;
    }

    .input-group-sm > .input-group-btn > select.btn:not([size]):not([multiple]), .input-group-sm > select.form-control:not([size]):not([multiple]), .input-group-sm > select.input-group-addon:not([size]):not([multiple]), select.form-control-sm:not([size]):not([multiple]) {
        height: auto;
    }

    .form-check {
        margin-bottom: 0px;
    }
</style>
<div class="card">
    <div class="card-body">
        <div class="row" style="padding-bottom: 10px;">
            <div class="col-sm-4 offset-sm-8">
                <select class="form-control form-control-sm" id="Type">
                    <?php foreach ($type as $key => $item): ?>
                        <option value="<?php echo $item['id'] ?>"><?php echo $item['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="row" style="padding-bottom: 10px;">
            <div class="col-sm-4 offset-sm-8">
                <select class="form-control form-control-sm" id="Year">
                    <?php $Y = date('Y') + 543; ?>
                    <?php foreach ($year as $key => $item): ?>
                        <?php
                        $select = '';
                        if ($item['year'] == $Y) {
                            $select = 'selected';
                        }
                        ?>
                        <option value="<?php echo $item['year'] ?>" <?php echo $select; ?>><?php echo $item['year'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="row" style="padding-bottom: 10px;">
            <div class="col-sm-4 offset-sm-8">
                <select class="form-control form-control-sm" id="Month">
                    <?php
                    $m = date('m');
                    ?>
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <?php $select = '';
                        if ($m == $i) {
                            $select = 'selected';
                        }
                        ?>
                        <option value="<?php echo $i ?>" <?php echo $select; ?>><?php echo getMouth($i) ?></option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>
        <div class="row" id="Detail">
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
                <div class="table-responsive" style="height: 400px">
                    <table class="table table-bordered table-sm" id="TableDetail">
                        <thead>
                        <tr>
                            <th style="white-space: nowrap;" width="2%">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" id="parent" type="checkbox" value="">
                                        เลือกทั้งหมด
                                    </label>
                                </div>
                            </th>
                            <th style="white-space: nowrap;">ชื่อผู้ขอ</th>
                            <th style="white-space: nowrap;">วันที่ขอ</th>
                            <th style="white-space: nowrap;">จำนวนเงิน</th>
                            <th style="white-space: nowrap;">วิธีการรับเงิน</th
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div style="padding-top: 10px;float: right;">
                    <button class="btn btn-success" id="PayCheck" type="submit" disabled>
                        <i class=""></i>จ่ายที่เลือก
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
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

    var Type = $('#Type');
    var Moo = $('#Moo');
    var Sperson = $('#SearchPerson');
    var YearS = $('#Year');
    var Month = $('#Month');
    FindData();
    Sperson.keyup(function () {
        FindData();
    });
    YearS.change(function () {
        FindData();
    });
    Month.change(function () {
        FindData();
    });
    Type.change(function () {
        FindData();
    });
    Moo.change(function () {
        FindData();
    });

    function FindData() {
        $.ajax({
            url: 'ajax/ajax_data.php',
            type: 'POST',
            data: {
                action: 'PointPay',
                data: Sperson.val(),
                Type: Type.val(),
                Moo: Moo.val(),
                Year: YearS.val(),
                Month: Month.val()
            },
            dataType: 'JSON',
            success: function (result) {
                $("#parent").prop('checked', false);
                $('#TableDetail tbody').empty();
                $('#PayCheck').attr('disabled', 'true');
                $.each(result, function (key, val) {
                    $('#TableDetail tbody').append('<tr class="detail">' +
                        '<td class="personid" hidden>' + val['personid'] + '</td>' +
                        '<td class="id" hidden>' + val['PID'] + '</td>' +
                        '<td class="type" hidden>' + val['type'] + '</td>' +
                        '<td class="checkID" style="text-align: center;">' +
                        '<div class="form-check">' +
                        '<label class="form-check-label">' +
                        '<input class="form-check-input child" type="checkbox" value="">เลือก' +
                        '</label>' +
                        '</div>' +
                        '</td>' +
                        '<td style="white-space: nowrap;" width="25%">' + val['userid'] + '</td>' +
                        '<td style="white-space: nowrap;" width="25%">' + DateThai(val['requestdate']) + '</td>' +
                        '<td style="white-space: nowrap;" width="25%">' + NumMoney(val['amount']) + '</td>' +
                        '<td style="white-space: nowrap;" width="25%">' + val['name'] + '</td>' +
                        '<td class="year" hidden>' + val['year'] + '</td>' +
                        '<td class="amount" hidden>' + val['amount'] + '</td>' +
                        '<td class="paymonth" hidden>' + val['paymonth'] + '</td>' +
                        '</tr>')
                });

                console.log(result);
            },
            error: function (result) {
                console.log(result);
            }
        });
    }

    var Data = [];
    $('#PayCheck').click(function () {
        $(this).find('i').addClass('fa fa-circle-o-notch fa-spin');
        $(this).attr('disabled', 'disabled');
        Data = [];
        $.each($('#TableDetail tbody').find('.table-primary'), function () {
            PersonID = $(this).find('.personid').text();
            ID = $(this).find('.id').text();
            WelfareType = $(this).find('.type').text();
            Year = $(this).find('.year').text();
            Amount = $(this).find('.amount').text();
            Paymonth = $(this).find('.paymonth').text();
            Data.push({
                personid: PersonID,
                ID: ID,
                type: WelfareType,
                year: Year,
                amount: Amount,
                paymonth: Paymonth,
            });
        });
        if (Data.length != 0) {
            Pay(Data, $(this));
        } else {
            alert('ท่านไม่ได้เลือกรายชื่อใด');
            $(this).find('i').removeClass('fa fa-circle-o-notch fa-spin');
            $(this).attr('disabled', 'disabled');
        }
    });

    function Pay(data, i) {
        $.ajax({
            url: 'ajax/ajax_data.php',
            type: 'POST',
            data: {action: 'Pay', data: data},
            dataType: 'JSON',
            success: function (result) {
                console.log(result);
                FindData();
                i.find('i').removeClass('fa fa-circle-o-notch fa-spin');
                i.removeAttr('disabled');
            },
            error: function (result) {
                console.log(result);
            }
        });
    }

    $("#parent").click(function () {
        $(".child").prop("checked", this.checked);
        if (this.checked) {
            $(".child").closest('tr').addClass('table-primary');
            $('#PayCheck').removeAttr('disabled');
        } else {
            $(".child").closest('tr').removeClass('table-primary');
            $('#PayCheck').attr('disabled', 'true');
        }

    });
    $('table tbody').on('click', '.child', function (event) {
        $(event.target).closest('tr').toggleClass('table-primary');
        if ($('.child:checked').length == $('.child').length) {
            $('#parent').prop('checked', true);
        } else {
            $('#parent').prop('checked', false);
        }

        if ($('.child:checked').length > 0) {
            $('#PayCheck').removeAttr('disabled');
        } else {
            $('#PayCheck').attr('disabled', 'true');
        }
    });
    $("#navbarResponsive li.nav-item:nth-child(4)").addClass("active");
</script>