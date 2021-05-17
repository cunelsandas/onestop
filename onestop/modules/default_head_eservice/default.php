

<!-- Banner -->
  <section id="banner">
    <div class="inner">
      <h1 class="eng-font">E-Service</h1>
      <p></p>
    </div>
    <video  autoplay loop muted playsinline src="images/banner.mp4"></video>
  </section>

<!-- Highlights -->
  <section class="wrapper">
    <div class="inner">
      <header class="special">
        <h2 class="thai-font">ยินดีต้อนรับ</h2>
        <p></p>
      </header>
        <hr>
      <header class="special">
<!--        <h2>หัวข้อคำร้อง</h2>-->
        <p>กรุณาเลือกคำร้องที่ท่านต้องการ</p>
      </header>
      <div class="highlights">
        <?php
          $sql = "SELECT * FROM tb_mod WHERE groupid = 1 ORDER BY listno";
          $rs = rsQuery($sql);
          while ($row = mysqli_fetch_array($rs)) {
            $modtype = $row['modtype'];
            $modname = $row['modname'];
            echo '<section>
              <div class="content">
                <header>';

                if ($modtype == "calendar") {

                  if ($row['bannername'] != "") {
                    echo '<a href="calendar/calendar.php" target="_blank"><img src="fileupload/mod/'.$row['bannername'].'" style="width:110px; padding:20px" /></a>';
                  }else {
                    echo '<a href="calendar/calendar.php" target="_blank" class="icon fa-cog" target="_blank"></a>';
                  }

                }else {

                  if ($row['bannername'] != "") {
                    echo '<a href="index.php?_mod='.encode64($modtype).'"><img src="fileupload/mod/'.$row['bannername'].'" style="width:110px; padding:20px" /></a>';
                  }else {
                    echo '<a href="index.php?_mod='.encode64($modtype).'" class="icon fa-cog"></a>';
                  }

                }



          echo '<h3>'.$modname.'</h3>
                </header>
                <p></p>
              </div>
            </section>';
          }
        ?>
        <!--<section>
          <div class="content">
            <header>
              <a href="#" class="icon fa-vcard-o"><span class="label">Icon</span></a>
              <h3>Feugiat consequat</h3>
            </header>
            <p></p>
          </div>
        </section>
        <section>
          <div class="content">
            <header>
              <a href="#" class="icon fa-files-o"><span class="label">Icon</span></a>
              <h3>Ante sem integer</h3>
            </header>
            <p>Nunc lacinia ante nunc ac lobortis ipsum. Interdum adipiscing gravida odio porttitor sem non mi integer non faucibus.</p>
          </div>
        </section>
        <section>
          <div class="content">
            <header>
              <a href="#" class="icon fa-floppy-o"><span class="label">Icon</span></a>
              <h3>Ipsum consequat</h3>
            </header>
            <p>Nunc lacinia ante nunc ac lobortis ipsum. Interdum adipiscing gravida odio porttitor sem non mi integer non faucibus.</p>
          </div>
        </section>-->
      </div>

    </div>
  </section>

<!-- CTA -->
  <section id="cta" class="wrapper">
    <div class="inner">

      <h2>ขอขอบคุณที่ใช้บริการ</h2>
      <h2 class="eng-font">Thank you for using our service</h2>
    </div>
  </section>

<!-- Testimonials
  <section class="wrapper">
    <div class="inner">
      <header class="special">
        <h2>Faucibus consequat lorem</h2>
        <p>In arcu accumsan arcu adipiscing accumsan orci ac. Felis id enim aliquet. Accumsan ac integer lobortis commodo ornare aliquet accumsan erat tempus amet porttitor.</p>
      </header>
      <div class="testimonials">
        <section>
          <div class="content">
            <blockquote>
              <p>Nunc lacinia ante nunc ac lobortis ipsum. Interdum adipiscing gravida odio porttitor sem non mi integer non faucibus.</p>
            </blockquote>
            <div class="author">
              <div class="image">
                <img src="images/pic01.jpg" alt="" />
              </div>
              <p class="credit">- <strong>Jane Doe</strong> <span>CEO - ABC Inc.</span></p>
            </div>
          </div>
        </section>
        <section>
          <div class="content">
            <blockquote>
              <p>Nunc lacinia ante nunc ac lobortis ipsum. Interdum adipiscing gravida odio porttitor sem non mi integer non faucibus.</p>
            </blockquote>
            <div class="author">
              <div class="image">
                <img src="images/pic03.jpg" alt="" />
              </div>
              <p class="credit">- <strong>John Doe</strong> <span>CEO - ABC Inc.</span></p>
            </div>
          </div>
        </section>
        <section>
          <div class="content">
            <blockquote>
              <p>Nunc lacinia ante nunc ac lobortis ipsum. Interdum adipiscing gravida odio porttitor sem non mi integer non faucibus.</p>
            </blockquote>
            <div class="author">
              <div class="image">
                <img src="images/pic02.jpg" alt="" />
              </div>
              <p class="credit">- <strong>Janet Smith</strong> <span>CEO - ABC Inc.</span></p>
            </div>
          </div>
        </section>
      </div>
    </div>
  </section>-->
