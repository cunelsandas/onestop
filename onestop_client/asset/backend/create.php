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
                                    ?????????????????????????????????????????????
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
                                                    <label>??????????????????????????????????????????</label></td>
                                                <td width="60%">
                                                    <input type="text" class="form-control" id="personid"
                                                           placeholder="??????????????????????????????????????????" maxlength="13"
                                                           value="<?php echo $data[0]['personid'] ?>" name="personid"
                                                           required <?php echo $dis ?>>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right"><label>????????????????????????????????????</label>
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
                                                                   id="otherprename" placeholder="????????????"
                                                                   name="otherprename"
                                                                   value="<?php echo $data[0]['otherprename'] ?>"
                                                                   hidden>
                                                        </div>
                                                    </div>

                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right"><label>????????????</label></td>
                                                <td width="60%">
                                                    <input type="text" class="form-control" id="name"
                                                           placeholder="????????????" value="<?php echo $data[0]['name'] ?>"
                                                           name="name" required>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right"><label>?????????????????????</label></td>
                                                <td width="60%">
                                                    <input type="text" class="form-control" id="surname"
                                                           placeholder="?????????????????????"
                                                           value="<?php echo $data[0]['surname'] ?>" name="surname"
                                                           required>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right"><label>?????????????????????</label></td>
                                                <td width="60%">
                                                    <input type="text" class="form-control datepick"
                                                           id="birthdate" placeholder="?????????????????????" name="birthdate"
                                                           value="<?php echo DateB($data[0]['birthdate']) ?>"
                                                           onkeyup="autoTab(this)">
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right"><label>?????????????????????</label></td>
                                                <td width="60%">
                                                    <input type="text" class="form-control"
                                                           id="nationality" name="nationality"
                                                           placeholder="?????????????????????"
                                                           value="<?php echo $data[0]['nationality'] ?>" required>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right"><label>?????????????????????</label></td>
                                                <td width="60%">
                                                    <input type="text" class="form-control" id="address"
                                                           placeholder="?????????????????????" name="address"
                                                           value="<?php echo $data[0]['address'] ?>" required>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right"><label>????????????</label></td>
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
                                                <td width="20%" style="text-align: right"><label>?????????</label></td>
                                                <td width="60%">
                                                    <input type="text" class="form-control" id="soi" name="soi"
                                                           placeholder="?????????" value="<?php echo $data[0]['soi'] ?>"
                                                           required>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right"><label>?????????</label></td>
                                                <td width="60%">
                                                    <input type="text" class="form-control" id="road" name="road"
                                                           placeholder="?????????" value="<?php echo $data[0]['road'] ?>"
                                                           required>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <label>????????????<?php echo $customer_tambon . "&nbsp;???????????????" . $customer_amphur . "&nbsp;?????????????????????" . $customer_province; ?></label>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right"><label>?????????????????????????????????????????????</label>
                                                </td>
                                                <td width="60%">
                                                    <input type="text" class="form-control" id="telephone"
                                                           name="telephone"
                                                           placeholder="?????????????????????????????????????????????"
                                                           value="<?php echo $data[0]['telephone'] ?>" required>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right"><label>??????????????????????????????????????????</label>
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
                                                <td width="20%" style="text-align: right"><label>???????????????</label></td>
                                                <td width="80%">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control"
                                                                   id="occupation" name="occupation"
                                                                   placeholder="???????????????"
                                                                   value="<?php echo $data[0]['occupation'] ?>"
                                                                   required>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group row">
                                                                <label for="income" class="col-sm-2 col-form-label">??????????????????</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="income" placeholder="??????????????????"
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
                                                    <label>??????????????????????????????????????????????????????????????? ????????????????????????????????????????????????????????? ????????????????????????????????????
                                                        ?????????????????????????????????????????????????????????</label>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right"><label>??????????????????????????????</label></td>
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
                                                <td width="20%" style="text-align: right"><label>????????????????????????</label></td>
                                                <td width="60%"><input type="text" class="form-control"
                                                                       id="bankbranch"
                                                                       placeholder="????????????????????????" name="bankbranch"
                                                                       value="<?php echo $data[0]['bankbranch'] ?>"
                                                                       required>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right"><label>????????????????????????</label></td>
                                                <td width="60%"><input type="text" class="form-control"
                                                                       id="bankaccount" name="bankaccount"
                                                                       placeholder="????????????????????????"
                                                                       value="<?php echo $data[0]['bankaccount'] ?>"
                                                                       required>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right"><label>???????????????????????????</label></td>
                                                <td width="60%"><input type="text" class="form-control"
                                                                       id="bankaccountname"
                                                                       placeholder="???????????????????????????" name="bankaccountname"
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
                                    ??????????????????????????????????????????????????????????????????????????????????????????
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
                                                    <label>????????????-?????????????????????</label></td>
                                                <td width="60%"><input type="text" class="form-control"
                                                                       id="name2" placeholder="????????????-?????????????????????"
                                                                       name="name2"
                                                                       value="<?php echo $data[0]['name2'] ?>" required>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                            <tr>
                                                <td width="20%" style="text-align: right">
                                                    <label>?????????????????????????????????????????????</label></td>
                                                <td width="60%"><input type="text" class="form-control"
                                                                       id="telephone2" placeholder="?????????????????????????????????????????????"
                                                                       name="telephone2"
                                                                       value="<?php echo $data[0]['telephone2'] ?>"
                                                                       required>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                            <tr>
                                                <td width="20%" style="text-align: right">
                                                    <label>??????????????????????????????????????????</label></td>
                                                <td width="60%"><input type="text" class="form-control"
                                                                       id="personid2" placeholder="??????????????????????????????????????????"
                                                                       maxlength="13" name="personid2"
                                                                       value="<?php echo $data[0]['personid2'] ?>"
                                                                       required>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right">
                                                    <label>?????????????????????</label></td>
                                                <td width="60%"><input type="text" class="form-control"
                                                                       id="address2" placeholder="?????????????????????"
                                                                       name="address2"
                                                                       value="<?php echo $data[0]['address2'] ?>"
                                                                       required>
                                                </td>
                                                <td width="20%" style="text-align: right"></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="text-align: right"><label>??????????????????????????????????????????</label>
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
                                    ????????????????????????????????????????????????????????????????????????????????????
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
                                        ????????????????????????????????????????????????????????????????????????
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" value="1"
                                               name="welfare_handicap" <?php echo IsChecked($data[0]['welfare_handicap']) ?>>
                                        ??????????????????????????????????????????????????????????????????
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" value="1"
                                               name="welfare_aids" <?php echo IsChecked($data[0]['welfare_aids']) ?>>
                                        ????????????????????????????????????????????????????????????????????????????????????????????????
                                    </label>
                                </div>
                                <div class="form-group row">
                                    <label for="InDate" class="col-sm-4 col-form-label">???????????????????????????
                                        ????????????????????????????????????????????????????????????????????????????????? ?????????????????????????????????</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control datepick" id="registerdate"
                                               name="newcitizendate" placeholder="?????????"
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
                                    ??????????????????????????????????????????
                                </a>
                            </h5>
                        </div>
                        <div id="collapse4" class="collapse show" role="tabpanel" aria-labelledby="heading4"
                             data-parent="#accordion">
                            <div class="card-body">
                                <div>
                                    <label>????????????????????????????????????????????? (????????????????????????????????????????????? 1 ?????????) </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox"
                                               value="1" <?php echo IsChecked($data[0]['handicap_eye']) ?>
                                               name="handicap_eye">
                                        ?????????????????????????????????????????????????????????
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox"
                                               value="1" <?php echo IsChecked($data[0]['handicap_ear']) ?>
                                               name="handicap_ear">
                                        ???????????????????????????????????????????????????????????????????????????????????????????????????????????????
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox"
                                               value="1" <?php echo IsChecked($data[0]['handicap_body']) ?>
                                               name="handicap_body">
                                        ?????????????????????????????????????????????????????????????????????????????????????????????????????????????????????
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox"
                                               value="1" <?php echo IsChecked($data[0]['handicap_mind']) ?>
                                               name="handicap_mind">
                                        ????????????????????????????????????????????????????????????????????????????????????????????????
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox"
                                               value="1" <?php echo IsChecked($data[0]['handicap_brain']) ?>
                                               name="handicap_brain">
                                        ????????????????????????????????????????????????????????????
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox"
                                               value="1" <?php echo IsChecked($data[0]['handicap_learn']) ?>
                                               name="handicap_learn">
                                        ?????????????????????????????????????????????????????????????????????
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox"
                                               value="1" <?php echo IsChecked($data[0]['handicap_ortistic']) ?>
                                               name="handicap_ortistic">
                                        ????????????????????????????????????????????????????????????
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
                                    ??????????????????????????? (???????????? jpg ???????????? pdf )
                                </a>
                            </h5>
                        </div>
                        <div id="collapse5" class="collapse show" role="tabpanel" aria-labelledby="heading5"
                             data-parent="#accordion">
                            <div class="card-body">
                                <div class="row" style="padding-bottom: 10px;">
                                    <input type="file" name="personidfile" accept="application/pdf,image/*"
                                           class="file">????????????????????????????????????????????????
                                </div>
                                <div class="row" style="padding-bottom: 10px;">
                                    <input type="file" name="addressid" accept="application/pdf,image/*" class="file">????????????????????????????????????????????????
                                </div>
                                <div class="row" style="padding-bottom: 10px;">
                                    <input type="file" name="bank" accept="application/pdf,image/*" class="file">????????????????????????????????????????????????
                                    ???????????????????????????????????????????????????????????????????????????????????????
                                </div>
                                <div class="row" style="padding-bottom: 10px;">
                                    <input type="file" name="authority" accept="application/pdf,image/*" class="file">?????????????????????????????????????????????
                                    ????????????????????????????????????????????????????????????????????????
                                </div>
                                <div class="row" style="padding-bottom: 10px;">
                                    <input type="file" name="authority-personid" accept="application/pdf,image/*"
                                           class="file">????????????????????????????????????????????????
                                    ??????????????????????????????????????????
                                </div>
                                <div class="row" style="padding-bottom: 10px;">
                                    <input type="file" name="authority-address" accept="application/pdf,image/*"
                                           class="file">??????????????????????????????????????????????????????????????????????????????????????????????????????
                                </div>
                                <div class="row" style="padding-bottom: 10px;">
                                    <input type="file" name="handicapid" accept="application/pdf,image/*" class="file">(??????????????????????????????????????????)
                                    ????????????????????????????????????????????????
                                </div>
                                <div class="row" style="padding-bottom: 10px;">
                                    <input type="file" name="aids" accept="application/pdf,image/*" class="file">(??????????????????????????????????????????????????????)
                                    ??????????????????????????????????????? ??????????????????????????????????????????????????????????????????
                                    ???????????????????????????????????????????????????????????????????????????????????????
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php /////////////////////////////?????????????????????????????????????????????????????????????????????????????????????????????/////////////////////////////////////?>
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
                        $showTxt = '??????????????????????????????????????????????????????????????????????????????';
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
                                ?????????????????????????????????????????????????????????????????????????????????????????????
                            </a>
                        </h5>
                    </div>
                    <div id="collapse7" class="collapse show" role="tabpanel" aria-labelledby="heading7"
                         data-parent="#accordion">
                        <div class="card-body">
                            <h5 class="card-title">?????????????????????????????? <?php echo $year['year'] ?></h5>
                            <input type="text" value="<?php echo $year['year'] ?>" name="year" hidden>
                            <input type="text" value="<?php echo $data[0]['personid'] ?>" name="personid" hidden>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="<?= $olderpay ?>"
                                           name="olderpay" <?= $showolder ?>>
                                    ?????????????????????????????????????????????????????????????????????????????? (
                                    ?????????????????????????????????????????????????????????????????? <?php echo DateThaiNa($year['birthdate']) ?>
                                    ) ???????????? <?php echo $calage ?> ??????????????????????????? <?= $olderpay ?> ?????????
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="<?= $year['handicap'] ?>"
                                           name="handicap" <?= $showhandicap ?>>
                                    ???????????????????????????????????????????????????????????????????????? ??????????????? <?= $year['handicap'] ?> ?????????
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="<?= $year['aids'] ?>"
                                           name="aids" <?= $showaids ?>>
                                    ???????????????????????????????????????????????????????????????????????????????????? ??????????????????????????? <?= $year['aids'] ?> ?????????
                                </label>
                            </div>
                            <div>
                                <label>* ????????????????????????????????????????????????????????????????????????????????????????????? <?php echo $year['year']; ?>
                                    ?????????????????????????????????????????????????????????????????????????????? </label>
                            </div>
                            <div class="row" style="padding-bottom: 10px;">
                                <div class="col-sm-6">
                                    ?????????????????????????????????????????????????????????
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
                <?php //////////////////////////// ????????????????????????????????????????????????????????????????????????????????????????????? /////////////////////////////////?>
                <div class="row" style="padding: 10px;">
                    <?php if ($dataFile != []): ?>
                        <h5>??????????????????????????????</h5>
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
                                                <a style="color: white;" class="btn btn-danger btn-del">??????</a>
                                            </td>
                                        <?php else: ?>
                                            <td class="Imagetd" style="text-align: center;">
                                                <b style="white-space: nowrap"><?php
                                                    fileName($item['filename']);
                                                    ?>
                                                </b>
                                                <a class="urlFile"
                                                   hidden><?php echo $parthRemove . $item['filename'] ?></a>
                                                <a style="color: white;" class="btn btn-danger btn-del">??????</a>
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
                    <button class="btn btn-outline-success" name="btnSave" id="btnSave">??????????????????</button>
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
                        alert('????????????????????????????????????????????????????????????????????????!');
                        $('#personid').val('');
                        $('#personid').css('border-color', 'red');
                    }
                } else {
                    alert('?????????????????????????????????????????????????????????????????????????????????!');
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

    // TODO ?????????????????????????????????????????????????????????
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
            alert("???????????????????????????????????????????????????????????? ?????????????????????????????????????????????????????????????????????????????? : " + fileExtension.join(', '));
            $(this).val('');
        }
        if ($(this).val() != '') {
            var size = $(this)[0].files[0].size;
            if (size >= Maxsize) {
                alert('???????????????????????????????????????????????????????????????');
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
