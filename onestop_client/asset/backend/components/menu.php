<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top d-print-none" id="mainNav">
    <a class="navbar-brand" href="#">admin WMS</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
            data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                <a class="nav-link" href="backend.php?r=index">
                    <i class="fa fa-fw fa-dashboard"></i>
                    <span class="nav-link-text">หน้าแรก</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
                <a class="nav-link" href="backend.php?r=view">
                    <i class="fa fa-fw fa-user-circle"></i>
                    <span class="nav-link-text">ข้อมูลประชากร</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
                <a class="nav-link" href="backend.php?r=welfare">
                    <i class="fa fa-fw fa fa-money"></i>
                    <span class="nav-link-text">จัดการข้อมูลเบี้ย</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
                <a class="nav-link" href="backend.php?r=pay">
                    <i class="fa fa-fw fa-money"></i>
                    <span class="nav-link-text">จ่ายเงิน</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents"
                   data-parent="#exampleAccordion">
                    <i class="fa fa-fw fa-wrench"></i>
                    <span class="nav-link-text">รายงาน</span>
                </a>
                <ul class="sidenav-second-level collapse" id="collapseComponents">
                    <li>
                        <a href="backend.php?r=print&p=type">รายงานผู้ได้รับเบี้ย</a>
                    </li>
                    <li>
                        <a href="backend.php?r=print&p=receivetype">รายงานวิธีรับเงิน</a>
                    </li>
                    <li>
                        <a href="backend.php?r=print&p=money">รายงานสรุปยอดเงิน</a>
                    </li>
                    <li>
                        <a href="backend.php?r=print&p=balance">รายงานเปรียบเทียบยอดเงิน</a>
                    </li>
                </ul>
            </li>
        </ul>
        <ul class="navbar-nav sidenav-toggler">
            <li class="nav-item">
                <a class="nav-link text-center" id="sidenavToggler">
                    <i class="fa fa-fw fa-angle-left"></i>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a href="#" class="btn btn-sm" id="plus">ก+</a>
                <a href="#" class="btn btn-sm" id="neg">ก-</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="backend.php?r=logout">
                    <i class="fa fa-fw fa-sign-out"></i>Logout</a>
            </li>
        </ul>
    </div>
</nav>
<script>
    function getSize() {
        size = $("body *").css("font-size");
        size = parseInt(size, 10);
    }

    getSize();
    $("#plus").on("click", function () {
        if ((size + 1) <= 36) {
            $(".content-wrapper *,a.btn").css("font-size", "+=1");
        }
    });
    $("#neg").on("click", function () {
        if ((size - 1) >= 12) {
            $(".content-wrapper *,a.btn").css("font-size", "-=1");
        }
    });
</script>
<?php
//if (is_dir('../fileupload/aa')) {
//    echo 555;
//} else {
//    mkdir('../fileupload/aa');
//} ?>