<style type="text/css">
    .content-wrapper, a.btn, span.badge {
        font-size: 14px;
    }

    .table td {
        padding: 3px;
        margin: 3px;
    }

    select.form-control:not([size]):not([multiple]) {
        font-size: 14px;
        height: auto;
    }
</style>
<?php if ($_GET['p'] == 'type'): ?>
    <div class="col-12">
        <?php
        $sql = 'SELECT * FROM tb_welfare_type';
        $Type = result_array($sql);
        $sqlyear = 'SELECT * FROM tb_welfare ORDER BY year';
        $Year = result_array($sqlyear);
        ?>
        <div class="row">
            <div class="col-lg-8 offset-lg-2" style="text-align: center">
                <div class="form-group">
                    <select class="form-control" id="SL_Welfare">
                        <?php foreach ($Type as $item) : ?>
                            <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <select class="form-control" id="SL_Year">
                        <?php foreach ($Year as $item) : ?>
                            <option value="<?= $item['year'] ?>"><?= $item['year'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12" style="text-align: center">
                <div class="panel panel-body table-responsive" style="overflow-x: auto;height: 400px">
                    <table class="table table-bordered table-sm" id="ShowWelfare">
                        <thead>
                        <tr>
                            <th style="text-align: center; white-space: nowrap;">ลำดับที่</th>
                            <th style="text-align: center; white-space: nowrap;">เลขบัตรประชาชน</th>
                            <th style="text-align: center; white-space: nowrap;">ชื่อ - สกุล</th>
                            <th style="text-align: center; white-space: nowrap;">ที่อยู่</th>
                            <th style="text-align: center; white-space: nowrap;">จำนวนเบี้ย</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <a id="btn-print" href="#" class="btn btn-primary" target="_blank">
                    <i class="fa fa-print"></i>สั่งพิมพ์
                </a>
            </div>
        </div>

        <script>
            function NumMoney(num) {
                return num == null || num == undefined ? 0 : parseFloat(num).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")
            }

            var Year = $('#SL_Year');
            var Type = '1';
            var year = Year.val();
            $('#SL_Welfare').change(function () {
                if ($(this).val() == 1) {
                    Type = '1';
                } else if ($(this).val() == 2) {
                    Type = '2';
                } else {
                    Type = '3';
                }
                FindData();
                $('#btn-print').attr('href', 'print.php?p=paytype&type=' + Type + '&y=' + year);
                $('#btn-print').attr('hidden', false);
            });
            Year.change(function () {
                year = $(this).val()
                FindData();
                $('#btn-print').attr('href', 'print.php?p=paytype&type=' + Type + '&y=' + year);
                $('#btn-print').attr('hidden', false);
            });
            $('#btn-print').attr('href', 'print.php?p=paytype&type=' + Type + '&y=' + year);

            function FindData() {
                var Yeara = Year.val();
                $.ajax({
                    url: 'ajax/ajax_data.php',
                    type: 'POST',
                    data: {action: 'FindType', Type: Type, Year: Yeara},
                    dataType: 'JSON',
                    success: function (result) {
                        $('#ShowWelfare tbody').empty();
                        $.each(result, function (key, val) {
                            $('#ShowWelfare tbody').append('<tr>' +
                                '<td style="white-space: nowrap;">' + (key + 1) + '</td>' +
                                '<td style="white-space: nowrap;">' + val['personid'] + '</td>' +
                                '<td style="white-space: nowrap;">' + val['name'] + ' ' + val['surname'] + '</td>' +
                                '<td style="white-space: nowrap;"> บ้านเลขที่ ' + val['address'] + ' หมู่ที่ ' + val['moo'] + '</td>' +
                                '<td style="white-space: nowrap;">' + NumMoney(val['amount']) + '</td>' +
                                '</tr>')
                        });
                    },
                    error: function (result) {
                        console.log(result);
                    }
                });
            }

            FindData();
        </script>
    </div>


<?php elseif ($_GET['p'] == 'money'): ?>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <?php
                $year = '';
                $sql = 'SELECT * FROM tb_welfare_pay ORDER BY year';
                $data = result_array($sql);
                $Sum = 0;
                foreach ($data as $key => $val):
                    if ($val['year'] != $year):
                        $year = $val['year'];
                        $Sum = 0;
                        ?>
                        <div style="text-align: center"><h1>ประจำปี <?php echo $year ?></h1></div>
                        <table class="table table-sm table-bordered" id="">
                            <thead>
                            <tr>
                                <th style="text-align: center">เดือน</th>
                                <th style="text-align: right">ยอดเงินรวม</th>
                                <th style="text-align: center">รายละเอียด</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php for ($i = 1; $i <= 12; $i++) : ?>
                                <tr>
                                    <td style="text-align: center"><?= getMouth($i) ?></td>
                                    <td style="text-align: right"><?= number_format(getSumMouth($i, $year), '2') ?></td>
                                    <td width="2%">
                                        <a class="btn btn-primary btn-sm" style="color: white"
                                           href="print.php?p=mouth&m=<?= $i; ?>&y=<?= $year ?>" target="_blank">รายละเอียด</a>
                                    </td>
                                </tr>
                                <?php $Sum += getSumMouth($i, $year) ?>
                            <?php endfor; ?>
                            <tr>
                                <td colspan="2" style="text-align: right;padding-right: 10px;"><b>รวม</b></td>
                                <td style="text-align: right"><b><?php echo number_format($Sum, '2') ?></b></td>
                            </tr>
                            </tbody>
                        </table>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

<?php elseif ($_GET['p'] == 'receivetype'): ?>
    <div class="row">
        <div class="col-lg-8 offset-lg-2" style="text-align: center">
            <div class="form-group">
                <label for="SL_ReceiveType">เลือกวิธีการชำระเงิน</label>
                <select class="form-control" id="SL_ReceiveType">
                    <option value="" selected disabled>โปรดเลือกวิธีการชำระเงิน</option>
                    <?php $sql = 'SELECT * FROM tb_welfare_receivetype';
                    $data = result_array($sql);
                    foreach ($data as $key => $val):?>
                        <option value="<?= $val['id'] ?>"><?= $val['name'] ?></option>
                    <?php endforeach; ?>
                </select>

                <select class="form-control" id="SL_Year" style="margin-top: 5px">
                    <?php $sql = 'SELECT * FROM tb_welfare ORDER BY year';
                    $data = result_array($sql);
                    foreach ($data as $key => $val):?>
                        <option value="<?= $val['year'] ?>"><?= $val['year'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="panel panel-body table-responsive" style="overflow-x: auto;height: 400px">
                <table class="table table-bordered table-sm" id="ShowReceivetype">
                    <thead>
                    <tr>
                        <th style="text-align: center; white-space: nowrap;">เลขบัตรประชาชน</th>
                        <th style="text-align: center; white-space: nowrap;">ชื่อ - สกุล</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <a class="btn btn-success" id="btn-print" style="color: white;" target="_blank" hidden>
                <i class="fa fa-print"></i> สั่งพิมพ์
            </a>
        </div>
        <script>
            var SL_Year = $('#SL_Year');
            var year = SL_Year.val();
            var Type = $('#SL_ReceiveType').val();
            SL_Year.change(function () {
                year = $(this).val();
                FindData(Type, year);
                $('#btn-print').attr('href', 'print.php?p=receive&type=' + Type + '&y=' + year);
                $('#btn-print').attr('hidden', false);
            });
            $('#SL_ReceiveType').change(function () {
                Type = $(this).val();
                FindData(Type, year);
                $('#btn-print').attr('href', 'print.php?p=receive&type=' + Type + '&y=' + year);
                $('#btn-print').attr('hidden', false);

            });

            function FindData(Type, year) {
                $.ajax({
                    url: 'ajax/ajax_data.php',
                    type: 'POST',
                    data: {action: 'Receivetype', Type: Type, Year: year},
                    dataType: 'JSON',
                    success: function (result) {
                        $('#ShowReceivetype tbody').empty();
                        if (result.length > 0) {
                            $.each(result, function (key, val) {
                                $('#ShowReceivetype tbody').append('<tr>' +
                                    '<td style="white-space: nowrap;">' + val['personid'] + '</td>' +
                                    '<td style="text-align: left; white-space: nowrap">' + val['name'] + ' ' + val['surname'] + '</td>' +
                                    '</tr>');
                            });
                        } else {
                            $('#ShowReceivetype tbody').append('<tr>' +
                                '<td colspan="2" style="text-align: center"><b style="color: red;font-size: 20px;">ไม่พบข้อมูล</b></td>' +
                                '</tr>');
                        }
                    },
                    error: function (result) {
                        console.log(result);
                    }
                });
            }
        </script>
    </div>
<?php elseif ($_GET['p'] == 'balance'): ?>
    <div class="row">
        <?php $sql = 'SELECT DISTINCT year FROM tb_welfare_pay ORDER BY year';
        $data = result_array($sql);
        ?>
        <script type="application/javascript" src="backend/components/vendor/chart.js/highcharts.js"></script>
        <script type="application/javascript" src="backend/components/vendor/chart.js/exporting.js"></script>
        <div class="col-12">
            <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
            <div class="row" style="padding-bottom: 10px;">
                <div class="col-6 offset-3" style="text-align: center">
                    <div class="form-row">
                        <div class="col">
                            <select class="form-control" id="SYear">
                                <?php foreach ($data as $val): ?>
                                    <option value="<?= $val['year'] ?>"><?= $val['year'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col">
                            <select class="form-control" id="LYear">
                                <?php foreach ($data as $val): ?>
                                    <option value="<?= $val['year'] ?>"><?= $val['year'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="padding-bottom: 10px;">
                <div class="col-12" style="text-align: center">
                    <a id="ComparePrint" href="#" class="btn btn-success" target="_blank"><i class="fa fa-print"></i>
                        สั่งพิมพ์</a>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            var data = [];
            var SYear = $('#LYear').val();
            var LYear = $('#LYear').val();
            FindData();
            $('a#ComparePrint').attr('href', 'print.php?p=compare&sy=' + SYear + '&ly=' + LYear);
            $('#SYear,#LYear').change(function () {
                SYear = $('#SYear').val();
                LYear = $('#LYear').val();
                if (LYear < SYear) {
                    alert('กรุณาเลือกปีให้ถูกต้อง');
                } else {
                    FindData();
                    $('a#ComparePrint').attr('href', 'print.php?p=compare&sy=' + SYear + '&ly=' + LYear);
                }
            });

            function FindData() {
                $.ajax({
                    url: 'ajax/ajax_data.php',
                    type: 'POST',
                    data: {action: 'Chart', SYear: SYear, LYear: LYear},
                    dataType: 'JSON',
                    success: function (result) {
                        var year = [];
                        var name = [];
                        $.each(result['year'], function (key, val) {
                            year[key] = val;
                        });
                        $.each(result['name'], function (key, val) {
                            name.push({
                                name: val['name'],
                                data: result['ss'][key],
                            });
                        });

                        x = 0;
                        data['year'] = year;
                        data['data'] = name;
                        aa(data);
                    },
                    error: function (result) {
                        console.log(result);
                    }
                });
            }

            function aa(data) {
                Highcharts.chart('container', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'ค่าเบี้ย'
                    },
                    subtitle: {
                        text: 'เปรียบเทียบเบี้ย'
                    },
                    xAxis: {
                        categories: data['year'],
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'บาท'
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.2f} บาท</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: data['data']
                });
            }

        </script>
    </div>

<?php elseif ($_GET['p'] == 'mouth'): ?>
    <?php include('form/money.php'); ?>

<?php elseif ($_GET['p'] == 'receive'): ?>
    <?php include('form/receive.php'); ?>

<?php elseif ($_GET['p'] == 'compare'): ?>
    <?php include('form/compare.php'); ?>

<?php elseif ($_GET['p'] == 'paytype'): ?>
    <?php include('form/paytype.php'); ?>
<?php endif; ?>

