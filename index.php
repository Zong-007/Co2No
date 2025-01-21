<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <!-- เพิ่ม jQuery CDN ก่อนโค้ด JavaScript ที่ใช้งาน jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  <link rel="stylesheet" href="styles1.css">
</head>

<body>

<script>
    // ฟังก์ชันที่จะดึงข้อมูลจากฐานข้อมูลทุกๆ 5 วินาที
    function fetchData() {
        $.ajax({
            url: 'sent_data/connect.php', // ไฟล์ PHP ที่ดึงข้อมูลจากฐานข้อมูล
            method: 'GET',
            dataType: 'json', // กำหนดให้รับข้อมูลในรูปแบบ JSON
            success: function(response) {
                // ตรวจสอบว่ามีข้อมูลหรือไม่
                if (response.error) {
                    // ถ้ามีข้อผิดพลาดในข้อมูล
                    $('#Co2').html(0); // แสดง 0 หากไม่มี Co2
                    $('#Tvoc').html(0); // แสดง 0 หากไม่มี Tvoc
                    $('#Date').html(0); // แสดง 0 หากไม่มี Date
                } else {
                    // ถ้ามีข้อมูล, อัปเดตข้อมูลทีละตัว
                    $('#Co2').html(response.Co2 || 0); // ถ้าไม่มี Co2 ให้แสดงเป็น 0
                    $('#Tvoc').html(response.Tvoc || 0); // ถ้าไม่มี Tvoc ให้แสดงเป็น 0
                    $('#Date').html(response.Date || 0); // ถ้าไม่มี Date ให้แสดงเป็น 0

                    // เรียกฟังก์ชันการเปลี่ยนสีหลังจากอัปเดตข้อมูล
                    changeTextColor(response.Co2, response.Tvoc);
                }
            },
            error: function() {
                // หากเกิดข้อผิดพลาดในการเชื่อมต่อ
                $('#Co2').html("เกิดข้อผิดพลาดในการดึงข้อมูล");
                $('#Tvoc').html("");
                $('#Date').html("");
            }
        });
    }

    // ฟังก์ชันในการเปลี่ยนสีข้อความตามค่า Co2 และ Tvoc
    function changeTextColor(Co2, Tvoc) {
        // แปลงค่าจาก Co2 เป็นตัวเลข
        var co2ValueNum = parseInt(Co2); // แปลงค่าเป็นตัวเลข
        if (isNaN(co2ValueNum)) return; // ตรวจสอบว่าเป็นตัวเลขไหม

        // เปลี่ยนสีข้อความตามค่า Co2
        if (co2ValueNum < 400) {
            $('#Co2').css("color", "#00bf62"); // ST77XX_CYAN
        } else if (co2ValueNum < 1000) {
            $('#Co2').css("color", "#7fd959"); // ST77XX_BLUE
        } else if (co2ValueNum < 2000) {
            $('#Co2').css("color", "#ffdf58"); // ST77XX_MAGENTA
        } else if (co2ValueNum < 5000) {
            $('#Co2').css("color", "#febd57"); // ST77XX_YELLOW
        } else {
            $('#Co2').css("color", "#fe5759"); // ST77XX_RED
        }

        // แปลงค่าจาก Tvoc เป็นตัวเลข
        var tvocValueNum = parseInt(Tvoc); // แปลงค่าเป็นตัวเลข
        if (isNaN(tvocValueNum)) return; // ตรวจสอบว่าเป็นตัวเลขไหม

        // เปลี่ยนสีข้อความตามค่า Tvoc
        if (tvocValueNum < 220) {
            $('#Tvoc').css("color", "#51a46c"); // ST77XX_CYAN
        } else if (tvocValueNum < 660) {
            $('#Tvoc').css("color", "#f3cd51"); // ST77XX_BLUE
        } else if (tvocValueNum < 1430) {
            $('#Tvoc').css("color", "#ec9f67"); // ST77XX_MAGENTA
        } else if (tvocValueNum < 2200) {
            $('#Tvoc').css("color", "#ff544d"); // ST77XX_YELLOW
        } else if (tvocValueNum < 3300) {
            $('#Tvoc').css("color", "#7f47f2"); // ST77XX_ORANGE
        } else {
            $('#Tvoc').css("color", "#753885"); // ST77XX_RED
        }
    }

    // เรียกใช้ฟังก์ชันทุกๆ 5 วินาที
    setInterval(fetchData, 5000); // 5000 มิลลิวินาที = 5 วินาที

    // เรียกใช้ครั้งแรกเมื่อโหลดหน้า
    fetchData();
</script>
  
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between ">
      <a href="index.php" class="logo d-flex a-itlignems-center">
        <img src="assets/img/1.png" alt="OXY_logo" >
      </a>
    </div><!-- End Logo -->
    
    <nav class="header-nav ms-auto">

      <img class="logo_position" src="assets/img/logo_RBM.png" alt="RBM Logo" style="width: 100px; height: auto;">
        
    </nav><!-- End Icons Navigation -->
      
      

  </header><!-- End Header -->

  

  <main id="main" class="main">

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-12 col-md-6">
                <div class="card info-card sales-card">
  
                    <div class="card-body ">
                        <div class="card-title-wrapper">
                            <h5 class="card-title"> 
                                <img src="assets/img/3.png" alt="SPO2 Logo" style="width: 50px; height: auto;">
                                Co2
                            </h5>
                        </div>
  
                        
                        <div class="ps-3 card-title-wrapper end">
                            <div class="ps-3 card-title-wrapper span text-V">
                            <div id="Co2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Sales Card -->

            
            <!-- Sales Card -->
            <div class="col-xxl-12 col-md-6">
                <div class="card info-card sales-card">
  
                    <div class="card-body ">
                        <div class="card-title-wrapper">
                            <h5 class="card-title"> 
                                <img src="assets/img/2.png" alt="SPO2 Logo" style="width: 40px; height: auto;">
                                Tvoc
                            </h5>
                        </div>
  
                        
                        <div class="ps-3 card-title-wrapper end">
                            <div class="ps-3 card-title-wrapper span text-V">
                              <div id="Tvoc"></div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div><!-- End Sales Card -->

            

            <!-- Reports -->
            <div class="col-12">
              <div class="card">

                

                <div class="card-body">
                  <h5 class="card-title">Reports </h5>
                  
                  <!-- Export Data -->
                  <form action="export.php" method="post" class="form-right" >
                    <button class="button" type="submit">
                      <img src="assets/img/download.png" alt="Export Data" style="width: 40px; height: 40px;">
                    </button>
                  </form>

                  <!-- Line Chart -->
                  <div id="reportsChart"></div>

                  <script>
                    var chart;  // ตัวแปรสำหรับเก็บกราฟ

                    // ฟังก์ชันที่จะดึงข้อมูลจากฐานข้อมูลทุกๆ 5 วินาที
                    function fetchData() {
                        $.ajax({
                            url: 'sent_data/line_chart.php', // ไฟล์ PHP ที่ดึงข้อมูลจากฐานข้อมูล
                            method: 'GET',
                            dataType: 'json', // กำหนดให้รับข้อมูลในรูปแบบ JSON
                            success: function(response) {
                                // ตรวจสอบว่ามีข้อมูลหรือไม่
                                if (response.error) {
                                    // ถ้ามีข้อผิดพลาด
                                    $('#Co2_G').html(0); // แสดง 0 หากไม่มี Co2
                                    $('#Hour').html(0); // แสดง 0 หากไม่มี Hour
                                } else {
                                    // ถ้ามีข้อมูล, อัปเดตข้อมูลทีละตัว
                                    $('#Co2_G').html(response.last_6_hours[0].Co2_G || 0); // แสดงค่า Co2 ของชั่วโมงล่าสุด
                                    $('#Hour').html(response.last_6_hours[0].hour || 0); // แสดงชั่วโมงของข้อมูลล่าสุด

                                    if (chart) {  // ตรวจสอบว่า chart ถูกสร้างหรือยัง
                                        // เรียกฟังก์ชันการอัปเดตกราฟ
                                        updateChart(response.last_6_hours);
                                    } else {
                                        // สร้างกราฟใหม่
                                        createChart(response.last_6_hours);
                                    }
                                }
                            },
                            error: function() {
                                // หากเกิดข้อผิดพลาดในการเชื่อมต่อ
                                $('#Co2_G').html("เกิดข้อผิดพลาดในการดึงข้อมูล");
                                $('#Hour').html("");
                            }
                        });
                    }

                    // ฟังก์ชันสร้างกราฟครั้งแรก
                    function createChart(last_24_hours_data) {
                        var labels = [];  // ชั่วโมง
                        var co2Data = [];  // ค่า Co2

                        // เตรียมข้อมูลจาก response
                        last_24_hours_data.forEach(function(hourData) {
                            labels.push(hourData.hour);  // ชั่วโมง
                            co2Data.push(hourData.Co2_G);  // ค่า Co2
                        });

                        // กำหนดค่า options สำหรับกราฟ
                        var options = {
                            series: [{
                                name: 'Co2',
                                data: co2Data,  // ใช้ค่า Co2 จากข้อมูล
                            }],
                            chart: {
                                height: 350,
                                type: 'area',
                                toolbar: {
                                    show: false
                                },
                            },
                            markers: {
                                size: 4
                            },
                            colors: ['#3eff6e'],
                            fill: {
                                type: "gradient",
                                gradient: {
                                    shadeIntensity: 1,
                                    opacityFrom: 0.3,
                                    opacityTo: 0.4,
                                    stops: [0, 90, 100]
                                }
                            },
                            dataLabels: {
                                enabled: false
                            },
                            stroke: {
                                curve: 'smooth',
                                width: 2
                            },
                            xaxis: {
                                type: 'category',
                                categories: labels,  // ชั่วโมงที่ได้รับจากข้อมูล
                            },
                            tooltip: {
                                x: {
                                    format: 'HH:mm'
                                },
                            }
                        };

                        // สร้างกราฟใหม่และเก็บไว้ในตัวแปร chart
                        chart = new ApexCharts(document.querySelector("#reportsChart"), options);
                        chart.render();
                    }

                    // ฟังก์ชันอัปเดตกราฟ
                    function updateChart(last_24_hours_data) {
                        if (chart) {  // ตรวจสอบว่า chart ถูกสร้างหรือยัง
                            var labels = [];  // ชั่วโมง
                            var co2Data = [];  // ค่า Co2

                            // เตรียมข้อมูลจาก response
                            last_24_hours_data.forEach(function(hourData) {
                                labels.push(hourData.hour);  // ชั่วโมง
                                co2Data.push(hourData.Co2_G);  // ค่า Co2
                            });

                            // อัปเดตข้อมูลในกราฟที่มีอยู่
                            chart.updateOptions({
                                series: [{
                                    name: 'Co2',
                                    data: co2Data,  // ใช้ค่า Co2 จากข้อมูลใหม่
                                }],
                                xaxis: {
                                    categories: labels,  // อัปเดตชั่วโมง
                                }
                            });
                        }
                    }

                    // เรียกฟังก์ชัน fetchData ทุก 5 วินาที
                    setInterval(fetchData, 5000);  // ทุก 5 วินาที

                    // สร้างกราฟครั้งแรกเมื่อโหลดหน้า
                    $(document).ready(function() {
                        fetchData();  // ดึงข้อมูลทันทีเมื่อโหลดหน้า
                    });
                </script>
                  <!-- End Line Chart -->

                </div>

              </div>
            </div><!-- End Reports -->
          </div>
        

      </div>
    </section>

  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>