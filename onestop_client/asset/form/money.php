<link rel="stylesheet" href="../font/thsarabunnew.css">
<style>
    table, h1, h2 {
        font-family: THSarabunNew;
        font-size: 12px;
    }
    * {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box
    }

    .a4 {
        height: auto;
        width: 210mm;
        min-height: 190mm;
        margin: 0px auto 0px auto;
        border: 1px solid #f1f1e3;
        padding: 0px 20px;
        line-height: 10px;
        overflow: hidden;
    }

    h1 {
        text-align: center;
        font-size: 18px;
        font-weight: bold;
        padding-top: 10px;
        padding-bottom: 0px;
    }

    h2 {
        font-size: 16px;
        text-align: center;
        font-weight: bold;
        margin: 30px 0 10px 0;
    }

    span {
        padding: 0 50px 0 15px;
        border-bottom: 1px dashed #000;
    }

    .sen {
        width: 300px;
        height: 75px;
        font-size: 12px;
        text-align: center;
        line-height: 18px;
        padding-top: 20px;
        clear: both;
    }

    table, th, td {
        border-collapse: collapse;
        border: 1px solid black;
        line-height: 20px;
    }

    .Detail {
        padding-left: 10px;
    }

    th {
        line-height: 30px;
        padding: 3px;
        margin: 3px;
    }

    @media print {
        body,.a4 {
            border: none;
            height: auto;
            margin: 0;
            padding:0;
        }

        .print {
            display: none;
        }

        br {
            display: none;
        }

        footer {
            page-break-after: always;
        }
    }
</style>
<script>
    window.print();
    setTimeout('window.close()', 300);
</script>
<?php
include_once '../itgmod/connect.inc.php';
include_once('DB/myfnc2.php');
$Mouth = $_GET['m'];
$Year = $_GET['y'];
function SumType($Mouth, $Year, $Type)
{
    $sql = 'SELECT SUM(amount) AS Amount FROM tb_welfare_pay WHERE status = 2 AND type = ' . $Type . ' AND paymonth = ' . $Mouth . ' AND year = ' . $Year;
    $data = result_array($sql);
    return $data;
}

function Data($Type, $Year, $Mouth)
{
    $sql = 'SELECT * FROM tb_welfare_pay a INNER JOIN tb_citizen b ON a.personid = b.personid WHERE a.status = 2 AND a.type = ' . $Type . ' AND paymonth = ' . $Mouth . ' AND a.year = ' . $Year;
    $data = result_array($sql);
    return $data;
}

$sqlType = 'SELECT * FROM tb_welfare_type';
$qType = result_array($sqlType);

?>
<head>
    <title>รายงานเบี้ยประจำเดือน <?= getMouth($Mouth) ?></title>
</head>
<body>
<div class="a4">
    <h1>รายงานเบี้ยประจำเดือน <?= getMouth($Mouth) ?> ปี <?= $Year ?></h1>
    <?php for ($i = 0; $i < count($qType); $i++): ?>
        <?php $Data = Data($i + 1, $Year, $Mouth) ?>
        <?php $Sum = SumType($Mouth, $Year, $i + 1); ?>
        <?php if ($Data != []): ?>
            <h2><?= $qType[$i]['name'] ?></h2>
            <table width="100%">
                <thead>
                <tr>
                    <th style="text-align: center">ลำดับที่</th>
                    <th style="text-align: center">เลขบัตรประชาชน</th>
                    <th style="text-align: center">ชื่อ - สกุล</th>
                    <th style="text-align: center">ที่อยู่</th>
                    <th style="text-align: center">จำนวนเบี้ย</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($Data as $key => $val): ?>

                    <tr>
                        <td class="Detail" style="text-align: center"><?= $key + 1 ?></td>
                        <td class="Detail"><?= $val['personid'] ?></td>
                        <td class="Detail"><?= $val['name'] . ' ' . $val['surname'] ?></td>
                        <td class="Detail"><?= 'บ้านเลขที่ ' . $val['address'] . ' หมู่ที่ ' . $val['moo'] ?></td>
                        <td class="Detail" style="text-align: right;"><?= number_format($val['amount'], '2') ?></td>
                    </tr>

                <?php endforeach; ?>
                <tr>
                    <td colspan="4" style="text-align: right;"><b style="padding-right: 10px;">รวม</b></td>
                    <td style="text-align: right;"><?= number_format($Sum[0]['Amount'], '2') ?></td>
                </tr>
                </tbody>
            </table>
        <?php endif; ?>
    <?php endfor; ?>
</div>
</body>
