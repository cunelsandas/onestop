<?php
?>
<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">เบี้ยยังชีพ</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse " id="navbarNav">
        <ul class="navbar-nav  mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="welfare_index.php?r=index">หน้าแรก</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="welfare_index.php?r=request">ขอขึ้นทะเบียนรับเงินเบี้ยยังชีพ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="welfare_index.php?r=result">ตรวจสอบผลการขอขึ้นทะเบียน</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="welfare_index.php?r=history">ประวัติการรับเงิน</a>
            </li>
        </ul>
        <form method="post" class="form-inline">
            <a href="#" class="btn btn-sm" id="plus">ก+</a>
            <a href="#" class="btn btn-sm" id="neg">ก-</a>
            <button class="btn btn-outline-danger my-2 my-sm-0" name="logout" type="submit">LogOut</button>
        </form>
    </div>
</nav>
<script>
    function getSize() {
        size = $( "body *" ).css( "font-size" );
        size = parseInt(size, 10);
    }
    getSize();
    $( "#plus" ).on( "click", function() {
        if ((size + 1) <= 36) {
            $( ".container * , .navbar-nav" ).css( "font-size", "+=1" );
        }
    });
    $( "#neg" ).on( "click", function() {
        if ((size - 1) >= 12) {
            $( ".container *, .navbar-nav" ).css( "font-size", "-=1" );
        }
    });
</script>