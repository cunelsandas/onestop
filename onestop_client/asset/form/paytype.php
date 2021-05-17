<link rel="stylesheet" href="../font/thsarabunnew.css">
<style>
    table, h1 {
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
        padding-top: 5px;
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
            margin: 0;
            padding: 0;
            border: none;
            height: auto;
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
    setTimeout('window.close()', 1500);
</script>
<?php
require '../itgmod/connect.inc.php';
include_once('DB/myfnc2.php');
$sql = 'SELECT a.personid AS PersonID,b.name AS Name, b.surname AS SurName,a.amount AS Amount ,CONCAT(\'บ้านเลขที่ \',address,\' หมู่ที่ \' ,moo) AS Address FROM tb_welfare_request a INNER JOIN tb_citizen b on a.personid = b.personid INNER JOIN tb_welfare_type c ON a.type = c.id WHERE a.status != 3 AND a.type = ' . $_GET['type'].' AND year = \''.$_GET['y'].'\'';
$data = result_array($sql);
$sqlType = 'SELECT * FROM tb_welfare_type WHERE id = \'' . $_GET['type'] . '\'';
$Type = result_row($sqlType);
?>
<head>
    <title>รายงาน <?= $Type['name'] ?></title>
</head>
<body>
<div class="a4">
    <h1><?php echo $Type['name'] ?></h1>
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
        <?php foreach ($data as $key => $val): ?>
            <tr>
                <td style="word-break: break-all;text-align: center"><?= $key + 1 ?></td>
                <td class="Detail" style="word-break: break-all"><?= $val['PersonID'] ?></td>
                <td class="Detail" style="word-break: break-all"><?= $val['Name'] . ' ' . $val['SurName'] ?></td>
                <td class="Detail" style="word-break: break-all"><?= $val['Address'] ?></td>
                <td class="Detail" style="word-break: break-all"><?= number_format($val['Amount'], '2') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<footer></footer>
</body>
