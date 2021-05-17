<?php
/**
 * Created by PhpStorm.
 * User: Programmer-ITG
 * Date: 11/29/2017
 * Time: 1:38 PM
 */
function IsChecked($check)
{
    $Check = '';
    if ($check == 1) {
        $Check = 'checked';
    } else {
        $Check = '';
    }
    return $Check;
}

$TabelName = 'tb_citizen';
$dis = '';
if (isset($_GET['id'])) {
    $UserID = $_GET['id'];
    $sql = 'select * from tb_citizen where id = \'' . $UserID . '\'';
    $data = result_array($sql);
    $sqlFile = 'SELECT DISTINCT filename FROM filename WHERE tablename = \'' . $TabelName . '\' AND masterid = \'' . $UserID . '\'';
    $dataFile = result_array($sqlFile);
    $dis = 'disabled';
} else {
    $UserID = '';
    $data[0] = [
        'name' => '',
        'surname' => '',
        'prename' => '1',
        'moo' => '1',
        'maritalstatus' => '1',
        'bankname' => '1',
        'relationship' => '1',
        'birthdate' => '',
        'personid' => '',
        'otherprename' => '',
        'nationality' => '',
        'address' => '',
        'soi' => '',
        'road' => '',
        'telephone' => '',
        'occupation' => '',
        'income' => '',
        'bankbranch' => '',
        'bankaccount' => '',
        'bankaccountname' => '',
        'name2' => '',
        'telephone2' => '',
        'personid2' => '',
        'address2' => '',
        'welfare_older' => '',
        'welfare_handicap' => '',
        'welfare_aids' => '',
        'newcitizendate' => '',
        'handicap_eye' => '',
        'handicap_ear' => '',
        'handicap_body' => '',
        'handicap_mind' => '',
        'handicap_brain' => '',
        'handicap_learn' => '',
        'handicap_ortistic' => '',
    ];
    $dataFile = [];
}

$dir = 'welfare';
$parth = '../' . $gloUploadPath . '/' . $dir . '/';
$parthRemove = $gloUploadPath . '/' . $dir . '/';
?>
<style>
    a, #aa, .form-control, .form-check, .form-group, label, .file, .row {
        font-size: 14px;
    }

    .form-control {
        padding: 0.375rem 0.75rem;
    }

    #Image, .Imagetd {
        width: 100px;
    }
</style>

<link rel="stylesheet" href="DatePick/datepicker.css">
<script src="DatePick/bootstrap-datepicker.js"></script>
<script src="DatePick/bootstrap-datepicker.th.js"></script>
<script src="DatePick/bootstrap-datepicker-thai.js"></script>
<div class="container">
    <div class="card" id="content">
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <input type="text" id="USER_ID" name="id" value="<?php echo $UserID ?>" hidden/>
                <div id="accordion" role="tablist">
                    <div class="card">
                        <div class="card-header" role="tab" id="headingOne">
                            <h5 class="mb-0">
                                <a data-toggle="collapse" href="#collapseOne" aria-expanded="true"
                                   aria-controls="collapseOne">
                                    ข้อมูลส่วนบุคคล
                                </a>
                            </h5>
                        </div>
                        <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne"
                             data-parent="#accordion">
                            <div class="card-body">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table" id="aa">
                                            <tbody>
                                            <tr>
                                                <td width="20%" style="text-align: right">
                                                    <label>เลขบัตรประชาชน</label></td>
                                                <td width="60%">
                                                    <input type="text" class="form-control" id="personid"
                                                           placeholder="เลขบัตรประชาชน" maxlength="13"
                                                           value="<?php echo $data[0]['personid'] ?>" name="personid"
                                                           required <?php echo $dis ?>>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right"><label>คำนำหน้าชื่อ</label>
                                                </td>
                                                <td width="60%">
                                                    <div class="row">
                                                        <div class="col-sm-4" style="padding-right: 0px">
                                                            <select name="prename"
                                                                    class="form-control"
                                                                    id="prename">
                                                                <?php
                                                                $sqlSelect = 'SELECT DISTINCT a.id,a.name FROM tb_prename a INNER JOIN tb_citizen b ON a.id = b.prename WHERE b.prename = \'' . $data[0]['prename'] . '\'';
                                                                $sql = 'SELECT * FROM tb_prename';
                                                                $prename = result_array($sqlSelect);
                                                                $prename2 = result_array($sql);
                                                                foreach ($prename as $item => $value) {
                                                                    echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                                                                }
                                                                foreach ($prename2 as $item => $value) {
                                                                    if ($value['id'] != $prename[0]['id']) {
                                                                        echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control"
                                                                   id="otherprename" placeholder="ระบุ"
                                                                   name="otherprename"
                                                                   value="<?php echo $data[0]['otherprename'] ?>"
                                                                   hidden>
                                                        </div>
                                                    </div>

                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right"><label>ชื่อ</label></td>
                                                <td width="60%">
                                                    <input type="text" class="form-control" id="name"
                                                           placeholder="ชื่อ" value="<?php echo $data[0]['name'] ?>"
                                                           name="name" required>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right"><label>นามสกุล</label></td>
                                                <td width="60%">
                                                    <input type="text" class="form-control" id="surname"
                                                           placeholder="นามสกุล"
                                                           value="<?php echo $data[0]['surname'] ?>" name="surname"
                                                           required>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right"><label>วันเกิด</label></td>
                                                <td width="60%">
                                                    <input type="text" class="form-control datepick"
                                                           id="birthdate" placeholder="วันเกิด" name="birthdate"
                                                           value="<?php echo DateB($data[0]['birthdate']) ?>"
                                                           onkeyup="autoTab(this)">
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right"><label>สัญชาติ</label></td>
                                                <td width="60%">
                                                    <input type="text" class="form-control"
                                                           id="nationality" name="nationality"
                                                           placeholder="สัญชาติ"
                                                           value="<?php echo $data[0]['nationality'] ?>" required>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right"><label>ที่อยู่</label></td>
                                                <td width="60%">
                                                    <input type="text" class="form-control" id="address"
                                                           placeholder="ที่อยู่" name="address"
                                                           value="<?php echo $data[0]['address'] ?>" required>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right"><label>หมู่</label></td>
                                                <td width="60%">
                                                    <select name="moo" class="form-control"
                                                            id="moo">
                                                        <?php
                                                        $sqlSelect = 'SELECT DISTINCT a.id,a.name FROM tb_moo a RIGHT JOIN tb_citizen b ON a.id = b.moo WHERE b.moo = \'' . $data[0]['moo'] . '\'';
                                                        $sql = 'SELECT * FROM tb_moo';
                                                        $moo = result_array($sqlSelect);
                                                        $moo2 = result_array($sql);
                                                        foreach ($moo as $item => $value) {
                                                            echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                                                        }
                                                        foreach ($moo2 as $item => $value) {
                                                            if ($value['id'] != $moo[0]['id']) {
                                                                echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right"><label>ซอย</label></td>
                                                <td width="60%">
                                                    <input type="text" class="form-control" id="soi" name="soi"
                                                           placeholder="ซอย" value="<?php echo $data[0]['soi'] ?>"
                                                           required>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right"><label>ถนน</label></td>
                                                <td width="60%">
                                                    <input type="text" class="form-control" id="road" name="road"
                                                           placeholder="ถนน" value="<?php echo $data[0]['road'] ?>"
                                                           required>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <label>ตำบล<?php echo $customer_tambon . "&nbsp;อำเภอ" . $customer_amphur . "&nbsp;จังหวัด" . $customer_province; ?></label>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right"><label>หมายเลขโทรศัพท์</label>
                                                </td>
                                                <td width="60%">
                                                    <input type="text" class="form-control" id="telephone"
                                                           name="telephone"
                                                           placeholder="หมายเลขโทรศัพท์"
                                                           value="<?php echo $data[0]['telephone'] ?>" required>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right"><label>สถานภาพการสมรส</label>
                                                </td>
                                                <td width="60%">
                                                    <select name="maritalstatus" class="form-control"
                                                            id="maritalstatus">
                                                        <?php
                                                        $sqlSelect = 'SELECT DISTINCT a.id,a.name FROM tb_maritalstatus a INNER JOIN tb_citizen b ON a.id = b.maritalstatus WHERE b.maritalstatus = \'' . $data[0]['maritalstatus'] . '\'';
                                                        $sql = 'SELECT * FROM tb_maritalstatus';
                                                        $maritalstatus = result_array($sqlSelect);
                                                        $maritalstatus2 = result_array($sql);
                                                        foreach ($maritalstatus as $item => $value) {
                                                            echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                                                        }
                                                        foreach ($maritalstatus2 as $item => $value) {
                                                            if ($value['id'] != $maritalstatus[0]['id']) {
                                                                echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right"><label>อาชีพ</label></td>
                                                <td width="80%">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control"
                                                                   id="occupation" name="occupation"
                                                                   placeholder="อาชีพ"
                                                                   value="<?php echo $data[0]['occupation'] ?>"
                                                                   required>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group row">
                                                                <label for="income" class="col-sm-2 col-form-label">รายได้</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="income" placeholder="รายได้"
                                                                           name="income"
                                                                           value="<?php echo $data[0]['income'] ?>"
                                                                           required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <label>กรณีต้องการให้โอนเงิน กรุณาระบุชื่อธนาคาร สาขาเลขบัญชี
                                                        และชื่อเจ้าของบัญชี</label>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right"><label>ชื่อธนาคาร</label></td>
                                                <td width="60%">
                                                    <select name="bankname" class="form-control"
                                                            id="bankname">
                                                        <?php
                                                        $sqlSelect = 'SELECT DISTINCT a.id,a.name FROM tb_bankname a INNER JOIN tb_citizen b ON a.id = b.bankname WHERE b.bankname = \'' . $data[0]['bankname'] . '\'';
                                                        $sql = 'SELECT * FROM tb_bankname';
                                                        $bankname = result_array($sqlSelect);
                                                        $bankname2 = result_array($sql);
                                                        foreach ($bankname as $item => $value) {
                                                            echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                                                        }
                                                        foreach ($bankname2 as $item => $value) {
                                                            if ($value['id'] != $bankname[0]['id']) {
                                                                echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right"><label>ชื่อสาขา</label></td>
                                                <td width="60%"><input type="text" class="form-control"
                                                                       id="bankbranch"
                                                                       placeholder="ชื่อสาขา" name="bankbranch"
                                                                       value="<?php echo $data[0]['bankbranch'] ?>"
                                                                       required>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right"><label>เลขบัญชี</label></td>
                                                <td width="60%"><input type="text" class="form-control"
                                                                       id="bankaccount" name="bankaccount"
                                                                       placeholder="เลขบัญชี"
                                                                       value="<?php echo $data[0]['bankaccount'] ?>"
                                                                       required>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right"><label>ชื่อบัญชี</label></td>
                                                <td width="60%"><input type="text" class="form-control"
                                                                       id="bankaccountname"
                                                                       placeholder="ชื่อบัญชี" name="bankaccountname"
                                                                       value="<?php echo $data[0]['bankaccountname'] ?>"
                                                                       required>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" role="tab" id="headingTwo">
                            <h5 class="mb-0">
                                <a class="collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false"
                                   aria-controls="collapseTwo">
                                    บุคคลอ้างอิงที่สามารถติดต่อได้
                                </a>
                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse show" role="tabpanel" aria-labelledby="headingTwo"
                             data-parent="#accordion">
                            <div class="card-body">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table" id="aa">
                                            <tbody>
                                            <tr>
                                                <td width="20%" style="text-align: right">
                                                    <label>ชื่อ-นามสกุล</label></td>
                                                <td width="60%"><input type="text" class="form-control"
                                                                       id="name2" placeholder="ชื่อ-นามสกุล"
                                                                       name="name2"
                                                                       value="<?php echo $data[0]['name2'] ?>" required>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                            <tr>
                                                <td width="20%" style="text-align: right">
                                                    <label>หมายเลขโทรศัพท์</label></td>
                                                <td width="60%"><input type="text" class="form-control"
                                                                       id="telephone2" placeholder="หมายเลขโทรศัพท์"
                                                                       name="telephone2"
                                                                       value="<?php echo $data[0]['telephone2'] ?>"
                                                                       required>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                            <tr>
                                                <td width="20%" style="text-align: right">
                                                    <label>เลขบัตรประชาชน</label></td>
                                                <td width="60%"><input type="text" class="form-control"
                                                                       id="personid2" placeholder="เลขบัตรประชาชน"
                                                                       maxlength="13" name="personid2"
                                                                       value="<?php echo $data[0]['personid2'] ?>"
                                                                       required>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right">
                                                    <label>ที่อยู่</label></td>
                                                <td width="60%"><input type="text" class="form-control"
                                                                       id="address2" placeholder="ที่อยู่"
                                                                       name="address2"
                                                                       value="<?php echo $data[0]['address2'] ?>"
                                                                       required>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right"><label>ความเกี่ยวข้อง</label>
                                                </td>
                                                <td width="60%">
                                                    <select name="relationship" class="form-control"
                                                            id="relationship">
                                                        <?php
                                                        $sqlSelect = 'SELECT DISTINCT a.id,a.name FROM tb_relationship a INNER JOIN tb_citizen b ON a.id = b.relationship WHERE b.relationship = \'' . $data[0]['relationship'] . '\'';
                                                        $sql = 'SELECT * FROM tb_relationship';
                                                        $relationship = result_array($sqlSelect);
                                                        $relationship2 = result_array($sql);
                                                        foreach ($relationship as $item => $value) {
                                                            echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                                                        }
                                                        foreach ($relationship2 as $item => $value) {
                                                            if ($value['id'] != $relationship[0]['id']) {
                                                                echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" role="tab" id="headingThree">
                            <h5 class="mb-0">
                                <a class="collapsed" data-toggle="collapse" href="#collapseThree"
                                   aria-expanded="false"
                                   aria-controls="collapseThree">
                                    สถานภาพการรับสวัสดิการภาครัฐ
                                </a>
                            </h5>
                        </div>
                        <div id="collapseThree" class="collapse show" role="tabpanel" aria-labelledby="headingThree"
                             data-parent="#accordion">
                            <div class="card-body">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" value="1"
                                               name="welfare_older" <?php echo IsChecked($data[0]['welfare_older']) ?>>
                                        เคยได้รับเบี้ยผู้สูงอายุ
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" value="1"
                                               name="welfare_handicap" <?php echo IsChecked($data[0]['welfare_handicap']) ?>>
                                        เคยได้รับเบี้ยผู้พิการ
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" value="1"
                                               name="welfare_aids" <?php echo IsChecked($data[0]['welfare_aids']) ?>>
                                        เคยได้รับเบี้ยยังชีพผู้ป่วยเอดส์
                                    </label>
                                </div>
                                <div class="form-group row">
                                    <label for="InDate" class="col-sm-4 col-form-label">เคยได้รับ
                                        ย้ายภูมิลำเนาเข้ามาอยู่ใหม่ เมื่อวันที่</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control datepick" id="registerdate"
                                               name="newcitizendate" placeholder="วัน"
                                               value="<?php echo DateB($data[0]['newcitizendate']) ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" role="tab" id="heading4">
                            <h5 class="mb-0">
                                <a class="collapsed" data-toggle="collapse" href="#collapse4"
                                   aria-expanded="false"
                                   aria-controls="collapseThree">
                                    สำหรับผู้พิการ
                                </a>
                            </h5>
                        </div>
                        <div id="collapse4" class="collapse show" role="tabpanel" aria-labelledby="heading4"
                             data-parent="#accordion">
                            <div class="card-body">
                                <div>
                                    <label>ประเภทความพิการ (เลือกได้มากกว่า 1 ข้อ) </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox"
                                               value="1" <?php echo IsChecked($data[0]['handicap_eye']) ?>
                                               name="handicap_eye">
                                        ความพิการทางการเห็น
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox"
                                               value="1" <?php echo IsChecked($data[0]['handicap_ear']) ?>
                                               name="handicap_ear">
                                        ความพิการทางการได้ยินหรือสื่อความหมาย
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox"
                                               value="1" <?php echo IsChecked($data[0]['handicap_body']) ?>
                                               name="handicap_body">
                                        ความพิการทางการเคลื่อนไหวหรือทางร่างกาย
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox"
                                               value="1" <?php echo IsChecked($data[0]['handicap_mind']) ?>
                                               name="handicap_mind">
                                        ความพิการทางการจิตใจหรือพฤติกรรม
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox"
                                               value="1" <?php echo IsChecked($data[0]['handicap_brain']) ?>
                                               name="handicap_brain">
                                        ความพิการทางสติปัญญา
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox"
                                               value="1" <?php echo IsChecked($data[0]['handicap_learn']) ?>
                                               name="handicap_learn">
                                        ความพิการทางการเรียนรู้
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox"
                                               value="1" <?php echo IsChecked($data[0]['handicap_ortistic']) ?>
                                               name="handicap_ortistic">
                                        ความพิการทางออทิสติก
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if (isset($_GET['id'])): ?>
                    <div class="card">
                        <div class="card-header" role="tab" id="heading5">
                            <h5 class="mb-0">
                                <a class="collapsed" data-toggle="collapse" href="#collapse5"
                                   aria-expanded="false"
                                   aria-controls="collapseThree">
                                    ส่งเอกสาร (ไฟล์ jpg หรือ pdf )
                                </a>
                            </h5>
                        </div>
                        <div id="collapse5" class="collapse show" role="tabpanel" aria-labelledby="heading5"
                             data-parent="#accordion">
                            <div class="card-body">
                                <div class="row" style="padding-bottom: 10px;">
                                    <input type="file" name="personidfile" accept="application/pdf,image/*"
                                           class="file">สำเนาบัตรประชาชน
                                </div>
                                <div class="row" style="padding-bottom: 10px;">
                                    <input type="file" name="addressid" accept="application/pdf,image/*" class="file">สำเนาทะเบียนบ้าน
                                </div>
                                <div class="row" style="padding-bottom: 10px;">
                                    <input type="file" name="bank" accept="application/pdf,image/*" class="file">สำเนาสมุดเงินฝาก
                                    บัญชีที่ต้องการให้โอนเงินเข้า
                                </div>
                                <div class="row" style="padding-bottom: 10px;">
                                    <input type="file" name="authority" accept="application/pdf,image/*" class="file">หนังสือมอบอำนาจ
                                    กรณีให้ผู้อื่นรับเงินแทน
                                </div>
                                <div class="row" style="padding-bottom: 10px;">
                                    <input type="file" name="authority-personid" accept="application/pdf,image/*"
                                           class="file">สำเนาบัตรประชาชน
                                    ผู้รับมอบอำนาจ
                                </div>
                                <div class="row" style="padding-bottom: 10px;">
                                    <input type="file" name="authority-address" accept="application/pdf,image/*"
                                           class="file">สำเนาบัตรทะเบียนบ้านผู้รับมอบอำนาจ
                                </div>
                                <div class="row" style="padding-bottom: 10px;">
                                    <input type="file" name="handicapid" accept="application/pdf,image/*" class="file">(สำหรับผู้พิการ)
                                    สำเนาบัตรคนพิการ
                                </div>
                                <div class="row" style="padding-bottom: 10px;">
                                    <input type="file" name="aids" accept="application/pdf,image/*" class="file">(สำหรับผู้ป่วยเอดส์)
                                    ใบรับรองแพทย์ ออกโดยสถานพยาบาลของรัฐ
                                    ยืนยันว่าป่วยเป็นโรคเอดส์จริง
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php /////////////////////////////ขอขึ้นทะเบียนรับเงินเบี้ยยังชีพ/////////////////////////////////////?>
                <div class="card">
                    <?php
                    $Y = date('Y') + 543;
                    $sqlYear = 'SELECT * FROM tb_welfare WHERE year = ' . $Y;
                    $year = result_row($sqlYear);
                    $sqlID = 'SELECT * FROM tb_citizen WHERE id = \'' . $_GET['id'] . '\'';
                    $Master = result_row($sqlID);
                    $sqlReceivet = 'SELECT * FROM tb_welfare_receivetype';
                    $Receivet = result_array($sqlReceivet);
                    $yearA = $year['year'];
                    $personID = $Master['personid'];
                    $calage = getAge2($Master['birthdate']);
                    if ($calage >= 90) {
                        $olderpay = $year['older90'];
                    } elseif ($calage >= 80 && $calage < 90) {
                        $olderpay = $year['older80'];
                    } elseif ($calage >= 70 && $calage < 80) {
                        $olderpay = $year['older70'];
                    } elseif ($calage >= 60 && $calage < 70) {
                        $olderpay = $year['older60'];
                    } else {
                        $olderpay = 0;
                    }
                    $showolder = result_row('SELECT * FROM tb_welfare_request WHERE type = \'1\' AND year = \'' . $yearA . '\' AND personid = \'' . $personID . '\'');
                    if (strtotime($Master['birthdate']) >= strtotime($year['birthdate']) || $olderpay == 0 || $showolder) {
                        $showolder = "disabled";
                    } else {
                        $showolder = "";
                    }
                    $showhandicap = result_row('SELECT * FROM tb_welfare_request WHERE type = \'2\' AND year = \'' . $yearA . '\' AND personid = \'' . $personID . '\'');
                    $showaids = result_row('SELECT * FROM tb_welfare_request WHERE type = \'3\' AND year = \'' . $yearA . '\' AND personid = \'' . $personID . '\'');
                    $showhandicap = ($showhandicap == '' ? '' : "disabled");
                    $showaids = ($showaids == '' ? '' : "disabled");
                    if ($showolder == 'disabled' && $showhandicap == 'disabled' && $showaids == 'disabled') {
                        $showBt = 'disabled';
                        $showTxt = 'ท่านไม่สามารถขอรับเบี้ยได้';
                    } else {
                        $showBt = '';
                        $showTxt = '';
                    }
                    ?>
                    <div class="card-header" role="tab" id="heading7">
                        <h5 class="mb-0">
                            <a class="collapsed" data-toggle="collapse" href="#collapse7"
                               aria-expanded="false"
                               aria-controls="collapseThree">
                                ขอขึ้นทะเบียนรับเงินเบี้ยยังชีพ
                            </a>
                        </h5>
                    </div>
                    <div id="collapse7" class="collapse show" role="tabpanel" aria-labelledby="heading7"
                         data-parent="#accordion">
                        <div class="card-body">
                            <h5 class="card-title">ปีงบประมาณ <?php echo $year['year'] ?></h5>
                            <input type="text" value="<?php echo $year['year'] ?>" name="year" hidden>
                            <input type="text" value="<?php echo $data[0]['personid'] ?>" name="personid" hidden>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="<?= $olderpay ?>"
                                           name="olderpay" <?= $showolder ?>>
                                    ขอรับเบี้ยยังชีพผู้สูงอายุ (
                                    ท่านต้องเกิดก่อนวันที่ <?php echo DateThaiNa($year['birthdate']) ?>
                                    ) อายุ <?php echo $calage ?> จำนวนเงิน <?= $olderpay ?> บาท
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="<?= $year['handicap'] ?>"
                                           name="handicap" <?= $showhandicap ?>>
                                    ขอรับเบี้ยยังชีพผู้พิการ จำนวน <?= $year['handicap'] ?> บาท
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="<?= $year['aids'] ?>"
                                           name="aids" <?= $showaids ?>>
                                    ขอรับเบี้ยยังชีพผู้ป่วยเอดส์ จำนวนเงิน <?= $year['aids'] ?> บาท
                                </label>
                            </div>
                            <div>
                                <label>* หากท่านเคยลงทะเบียนในปีงบประมาณ <?php echo $year['year']; ?>
                                    ไว้แล้วจะไม่สามารถลงซ้ำได้ </label>
                            </div>
                            <div class="row" style="padding-bottom: 10px;">
                                <div class="col-sm-6">
                                    เลือกวิธีการรับเงิน
                                    <select name="receivetype" class="form-control" <?= $showBt ?>>
                                        <?php
                                        foreach ($Receivet as $key => $value):
                                            ?>
                                            <option value="<?= $value['id']; ?>"><?= $value['name'] ?></option>
                                        <?php endforeach; ?>

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php //////////////////////////// ขอขึ้นทะเบียนรับเงินเบี้ยยังชีพ /////////////////////////////////?>
                <div class="row" style="padding: 10px;">
                    <?php if ($dataFile != []): ?>
                        <h5>ไฟล์เอกสาร</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped" id="Image">
                                <tbody>
                                <tr>
                                    <?php foreach ($dataFile as $key => $item) : ?>
                                        <?php $type = explode('.', $item['filename'])[1] ?>
                                        <?php if ($type == 'pdf'): ?>
                                            <td class="Imagetd" style="text-align: center;">
                                                <a target="_blank" href="<?php echo $parth . $item['filename'] ?>"
                                                   class="img">
                                                    <img src="../asset/pdf.png" alt="Trolltunga Norway" width="100"
                                                         height="100">
                                                </a>
                                            </td>
                                        <?php else: ?>
                                            <td class="Imagetd" style="text-align: center;">
                                                <a target="_blank" href="<?php echo $parth . $item['filename'] ?>"
                                                   class="img">
                                                    <img src="<?php echo $parth . $item['filename'] ?>"
                                                         alt="Trolltunga Norway"
                                                         width="100"
                                                         height="100">
                                                </a>
                                            </td>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tr>
                                <tr>
                                    <?php foreach ($dataFile as $key => $item) : ?>
                                        <?php $type = explode('.', $item['filename'])[1] ?>
                                        <?php if ($type == 'pdf'): ?>
                                            <td class="Imagetd" style="text-align: center;">
                                                <b style="white-space: nowrap"><?php
                                                    fileName($item['filename']);
                                                    ?>
                                                </b>
                                                <a class="urlFile"
                                                   hidden><?php echo $parthRemove . $item['filename'] ?></a>
                                                <a style="color: white;" class="btn btn-danger btn-del">ลบ</a>
                                            </td>
                                        <?php else: ?>
                                            <td class="Imagetd" style="text-align: center;">
                                                <b style="white-space: nowrap"><?php
                                                    fileName($item['filename']);
                                                    ?>
                                                </b>
                                                <a class="urlFile"
                                                   hidden><?php echo $parthRemove . $item['filename'] ?></a>
                                                <a style="color: white;" class="btn btn-danger btn-del">ลบ</a>
                                            </td>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <div>
                    <button class="btn btn-outline-success" name="btnSave" id="btnSave">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $('#personid').focusout(function () {
        serachID();
    });

    function serachID() {
        $.ajax({
            url: 'ajax/ajax_data.php',
            type: 'POST',
            data: {action: 'SearchID', id: $('#personid').val()},
            dataType: 'JSON',
            success: function (result) {
                if (result != '') {
                    if (result['data'].length == 0 && $('#personid').val() != '' && $('#personid').val().length == 13 && result['chk'] != 'false') {
                        $('#personid').css('border-color', 'rgb(52, 179, 52)');
                    } else {
                        alert('เลขบัตรประชาชนไม่ถูกต้อง!');
                        $('#personid').val('');
                        $('#personid').css('border-color', 'red');
                    }
                } else {
                    alert('มีเลขบัตรประชาชนนี้อยู่แล้ว!');
                    $('#personid').val('');
                    $('#personid').css('border-color', 'red');
                }

            },
            error: function (result) {
                console.log(result);
            }
        });
    }

    $('#prename').change(function () {
        if ($(this).val() == 6) {
            $('#otherprename').removeAttr('hidden');
        } else {
            $('#otherprename').attr('hidden', 'true');
        }
    });
    if ($('#prename').val() == 6) {
        $('#otherprename').removeAttr('hidden');
    }

    $('.datepick').datepicker({
        todayBtn: "linked",
        autoclose: true,
        todayHighlight: true,
        language: "th-th"
    });

    // TODO เช็คไฟล์ก่อนอัพโหลด
    $(".file").change(function () {
        var Type = $(this).val().split('.').pop().toLowerCase();
        var filePic = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
        var fileDoc = ['pdf'];
        var Maxsize = 0;
        if ($.inArray(Type, filePic) != -1) {
            Maxsize = parseFloat(<?php echo $gloPicture_filesize?>);
        }
        if ($.inArray(Type, fileDoc) != -1) {
            Maxsize = parseFloat(<?php echo $gloData_filesize?>);
        }
        var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'pdf'];
        if ($.inArray(Type, fileExtension) == -1) {
            alert("รูปแบบไฟล์ไม่ถูกต้อง กรุณาเลือกไฟล์ที่มีนามสกุล : " + fileExtension.join(', '));
            $(this).val('');
        }
        if ($(this).val() != '') {
            var size = $(this)[0].files[0].size;
            if (size >= Maxsize) {
                alert('ขนาดไฟล์ใหญ่กว่ากำหนด');
                $(this).val('');
            }
        }
    });
    $("#navbarResponsive li.nav-item:nth-child(2)").addClass("active");

    function autoTab(obj) {
        var pattern = new String("__/__/____");
        var pattern_ex = new String("/");
        var returnText = new String("");
        var obj_l = obj.value.length;
        var obj_l2 = obj_l - 1;
        for (i = 0; i < pattern.length; i++) {
            if (obj_l2 == i && pattern.charAt(i + 1) == pattern_ex) {
                returnText += obj.value + pattern_ex;
                obj.value = returnText;
            }
        }
        if (obj_l >= pattern.length) {
            obj.value = obj.value.substr(0, pattern.length);
        }
    }

    $('table#Image tbody').on('click', '.btn-del', function () {
        var Url = $(this).closest('.Imagetd').find('.urlFile').text();
        $.ajax({
            url: 'ajax/ajax_data.php',
            type: 'POST',
            data: {action: 'un', p: Url},
            dataType: 'JSON',
            success: function (result) {
                window.location.reload();
            },
            error: function (result) {
            }
        });
    });
</script>
