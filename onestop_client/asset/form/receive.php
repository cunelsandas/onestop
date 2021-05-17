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
        body, .a4 {
            border: none;
            height: auto;
            margin: 0;
            padding: 0;
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
    setTimeout('window.close()', 250);
</script>
<?php
include_once '../itgmod/connect.inc.php';
include_once('DB/myfnc2.php');
$type = $_GET['type'];
$year = $_GET['y'];
$sql = 'SELECT DISTINCT a.personid,b.name,b.surname,a.amount FROM tb_welfare_request a INNER JOIN tb_citizen b ON a.personid = b.personid WHERE a.receivetype = ' . $type . ' AND a.year = \'' . $year . '\'';
$data = result_array($sql);
$sqlType = 'SELECT * FROM tb_welfare_receivetype WHERE id = ' . $type;
$NameType = result_row($sqlType);
$Sum = 0;
?>
<head>
    <title>รายงานวิธีรับเงิน</title>
</head>
<body>
<div class="a4">
    <h1>รายงานวิธีรับเงิน</h1>
    <h2> <?= $NameType['name'] ?></h2>
    <table class="table" width="100%">
        <thead>
        <tr>
            <th style="text-align: center;width: 10%">ลำดับที่</th>
            <th style="text-align: center;width: 30%">เลขบัตรประชาชน</th>
            <th style="text-align: center">ชื่อ - สกุล</th>
            <th style="text-align: center;width: 15%">จำนวนเบี้ย</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data as $key => $val): ?>
            <tr>
                <td style="text-align: center;"><?php echo $key + 1 ?></td>
                <td style="text-align: center;"><?php echo $val['personid'] ?></td>
                <td style="padding-left: 20px"><?php echo $val['name'] . '   ' . $val['surname'] ?></td>
                <td style="text-align: right"><?php echo number_format($val['amount'], '2') ?></td>
            </tr>
            <?php $Sum += $val['amount']; ?>
        <?php endforeach; ?>
        <tr>
            <td colspan="3" style="text-align: right;"><b style="padding-right: 10px">รวม</b></td>
            <td style="text-align: right;"><?php echo number_format($Sum, '2') ?></td>
        </tr>
        </tbody>
    </table>

</div>
</body>
