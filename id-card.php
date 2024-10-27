<?php 
include 'config.php';

$html = '';

if (isset($_POST['search'])) {
    $identification = $_POST['identification'];

    if (!empty($identification)) {
        $sql = "SELECT * FROM users_dusi WHERE identification='$identification'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            $html = "<div class='card' style='width:200px; padding:0;'>";

            while ($row = mysqli_fetch_assoc($result)) {
                $name_title = $row["name_title"];
                $name = $row["name"];
                $surname = $row["surname"];
                $birthday = $row["birthday"];
                $identification = $row['identification'];
                $sex = $row['sex'];
                $id_card = $row['id_card'];
                $date = $row['date'];
                
                $html .= "
                    <div class='container' style='text-align:left; border:2px dotted black;'>
                        <div class='header'></div>
                        <div class='box-3'>
                            <h2>ชื่อ-นามสกุล $name_title $name $surname</h2>
                        </div>
                        <div class='container-3'>
                            <div class='info-1'>
                                <div>
                                    <h4>หมายเลขบัตรประจำตัวประชาชน $identification</h4>
                                </div>
                            </div>
                            <div class='info-2'>
                                <div>
                                    <h4>วันเกิด $birthday</h4>
                                </div>
                                <div>
                                    <h4>เพศ</h4>
                                    <p></p>
                                </div>
                            </div>
                            <div class='info-3'>
                                <div>
                                    <h4>วันที่สร้าง</h4>
                                    <p>$date</p> <!-- แสดงวันที่ที่สร้าง -->
                                </div>
                            </div>
                        </div>
                        <div class=barcode>
                        <svg id='barcode$id_card'></svg>
                        </div>
                    </div>
                ";
            }
            $html .= "</div>";

            // แทรกบาร์โค้ดที่นี่
            echo "<script>
                JsBarcode('#barcode$id_card', '$id_card', {
                    format: 'CODE128',
                    lineColor: '#000',
                    width: 2,
                    height: 50,
                    displayValue: true
                });
            </script>";

        } else {
            // Handle case when no result is found
            $html = "<div class='alert alert-warning'>No ID card found for the entered ID number.</div>";
        }
    } else {
        // Handle case when ID number is not provided
        $html = "<div class='alert alert-danger'>Please enter a valid ID number.</div>";
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="cardid.css">
    <title>สร้างการ์ด</title>
    
    <!-- JsBarcode -->
    <script src="https://cdn.jsdelivr.net/npm/dom-to-image@2.6.0/src/dom-to-image.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>

  </head>
  <body>

    <nav class="navbar navbar-expand-lg navbar-dark" style="background-image: linear-gradient(to right, rgb(0,300,255), rgb(93,4,217));">
      <a class="navbar-brand" href="#"><img src="assets/images/codingcush-logo.png" alt=""></a>
    </nav>

    <br>

    <div class="row" style="margin: 0px 20px 5px 20px">
      <div class="col-sm-6">
        <div class="card jumbotron">
          <div class="card-body">
            <form class="form" method="POST" action="id-card.php">
              <label for="id_no">หมายเลขบัตรประจำตัวประชาชน</label>
              <input class="form-control mr-sm-2" type="search" placeholder="ป้อนข้อมูลหมายเลขประจำตัวประชาชน" name="identification">
              <br>
              <button class="btn btn-outline-primary" type="submit" name="search">สร้าง</button>
            </form>
          </div>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="card">
          <div class="card-header">บัตรประจำตัวผู้ป่วย</div>
          <div class="card-body" id="mycard">
            <?php echo $html?>
          </div>
          <br>
        </div>
      </div>
    </div>

    <hr>

    <button id="demo" class="btn btn-primary" onclick="downloadtable()">Download Id Card</button>

    <script>
      <?php if (isset($id_card)) { ?>
        JsBarcode("#barcode<?php echo $id_card; ?>", "<?php echo $id_card; ?>", {
            format: "CODE128",  // Use Code 128 format
            lineColor: "#000",
            width: 2,
            height: 50,
            displayValue: true
        });
    <?php } ?>

      function downloadtable() {
        var node = document.getElementById('mycard');
        domtoimage.toPng(node)
            .then(function(dataUrl) {
                downloadURI(dataUrl, "id-card.png");
            })
            .catch(function(error) {
                console.error('Oops, something went wrong!', error);
            });
    }

      function downloadURI(uri, name) {
        var link = document.createElement("a");
        link.download = name;
        link.href = uri;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    </script>

  </body>
</html>