
<html>

<head>

<?php include_once("../itgmod/connect.php"); ?>

<link rel="stylesheet" href="../js/fullcalendar/fullcalendar.min.css" />
<link rel="stylesheet" href="../font/th_k2d_july8.css" />
<script src="../js/fullcalendar/lib/jquery.min.js"></script>
<script src="../js/fullcalendar/lib/moment.min.js"></script>
<script src="../js/fullcalendar/fullcalendar.min.js"></script>


<script>


$(document).ready(function () {
    var calendar = $('#calendar').fullCalendar({

      monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
      monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'],
      dayNames: ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัส','ศุกร์','เสาร์'],
      dayNamesShort: ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัส','ศุกร์','เสาร์'],

        editable: true,
        events: "fetch-event.php",
        displayEventTime: false,
        eventRender: function (event, element, view) {
            if (event.allDay === 'true') {
                event.allDay = true;
            } else {
                event.allDay = false;
            }
        },
        selectable: true,
        selectHelper: true,
        editable: true,
        eventClick: function (event) {

          $.ajax({
              type: "POST",
              url: "show-data.php",
              data: "id=" + event.id,
              success: function (data) {

                var responsedata = $.parseJSON(data);

                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");

                //console.log(responsedata);

                alert("\nรายละเอียด : "+ responsedata[3].detail + "\n\nเริ่มวันที่ : " + responsedata[1] + " เวลา : " + responsedata[0].start_time +
                "\nถึง : " + responsedata[2]);

              }
          });



        }

    });
});

</script>

<style>


  html {
    font-family: THK2DJuly8;
    text-align: center;
  }


table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  padding: 15px;
}

#calendar {
    width: 900px;
    margin: 0 auto;
}

.response {
    height: 60px;
}

.success {
    background: #cdf3cd;
    padding: 10px 60px;
    border: #c3e6c3 1px solid;
    display: inline-block;
}
</style>

</head>
<body>
    <h2>ปฎิทินกิจกรรม</h2>

    <div class="response"></div>
    <div id='calendar'></div>

  </body>


</html>
