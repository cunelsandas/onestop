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
        padding-top: 2px;
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
            padding: 0px;
            margin: 0px;
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
require '../itgmod/connect.inc.php';
include_once('DB/myfnc2.php');
function SumofYear($year, $type)
{
    $sql = 'SELECT SUM(amount) AS Sum FROM tb_welfare_pay WHERE year = ' . $year . ' AND type = ' . $type;
    $Sum = result_row($sql);
    return $Sum['Sum'];
}

$sql = 'SELECT * FROM tb_welfare_pay WHERE year BETWEEN ' . $_GET['sy'] . ' AND ' . $_GET['ly'] . ' ORDER BY year';
$list = result_array($sql);
$sqlType = 'SELECT * FROM tb_welfare_type ORDER BY id';
$Type = result_array($sqlType);
$data = [];
$sum = [];
$ss = [];
$year = '';
$NumYear = [];
$i = 0;
$ArrayTest = [];

foreach ($list as $key => $item) {
    if ($item['year'] != $year) {
        $year = $item['year'];
        $NumYear[$i] = $item['year'];
        $data['year'][$i] = $item['year'];
        foreach ($Type as $_key => $_Type) {
            $sum[$i][$_key] = SumofYear($year, $_Type['id']);
        }
        $i++;
    }
}
for ($i = 0; $i < count($Type); $i++) {
    for ($x = 0; $x < count($NumYear); $x++) {
        $ArrayTest[$i][$x] = $sum[$x][$i];
    }
    $ss[$i]['name'] = $Type[$i]['name'];
    $ss[$i]['data'] = $ArrayTest;
}
$data['ss'] = $ss;
?>
<head>
    <title>รายงาน <?= 5 ?></title>
</head>
<body>
<div class="a4">
    <h1>
        รายงานเปรียบเทียบค่าเบี้ยประจำปี
        <?php if ($_GET['sy'] == $_GET['ly']): echo $_GET['sy']; ?>
        <?php else:echo $_GET['sy'] . ' ถึง ' . $_GET['ly']; endif; ?>
    </h1>
    <?php foreach ($data['year'] as $Ykey => $Yval): ?>
        <h2>ยอดรวมเบี้ยปี <?php echo $Yval ?></h2>
        <table width="100%">
            <thead>
            <tr>
                <th style="text-align: center">ลำดับที่</th>
                <th style="text-align: center">ประเภทเบี้ย</th>
                <th style="text-align: center">ค่าเบี้ยรวม</th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 0; ?>
            <?php foreach ($data['ss'] as $Skey => $Sval): ?>
                <tr>
                    <td class="Detail"><?php echo $Skey + 1 ?></td>
                    <td class="Detail"><?php echo $Sval['name'] ?></td>
                    <td class="Detail" style="text-align: right;">
                        <?php echo number_format($Sval['data'][$i][$Ykey], '2') ?>
                    </td>
                </tr>
                <?php $i++ ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endforeach; ?>

</div>
<footer></footer>
</body>
