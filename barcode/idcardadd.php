<?php  
include('config.php');

$insert = false;
$update = false;
$empty = false;
$delete = false;
$already_card = false;

if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `users_dusi` WHERE `sno` = $sno";
  $result = mysqli_query($conn, $sql);
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_POST['snoEdit'])){
        // Update the record
        $sno = mysqli_real_escape_string($conn, $_POST['snoEdit']);
        $name_title = mysqli_real_escape_string($conn, $_POST["name_titleEdit"]);
        $name = mysqli_real_escape_string($conn, $_POST["nameEdit"]);
        $surname = mysqli_real_escape_string($conn, $_POST["surnameEdit"]);
        $identification = mysqli_real_escape_string($conn, $_POST["identificationEdit"]);

            $sql = "UPDATE `users_dusi` SET 
                    `name_title` = '$name_title',
                    `name` = '$name',
                    `surname` = '$surname',
                    `identification` = '$identification' 
                    WHERE `users_dusi`.`sno` = '$sno'";

            echo $sql; 

            $result = mysqli_query($conn, $sql);
            if ($result) {
                $update = true;
            } else {
                echo "We could not update the record successfully: " . mysqli_error($conn);
            }
        } else {
            echo "No record found for sno: $sno"; // ไม่มีข้อมูลที่ตรงกับ sno
        }
    } else {
        
        $name_title = isset($_POST['name_title']) ? $_POST['name_title'] : '';
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $surname = isset($_POST['surname']) ? $_POST['surname'] : '';
        $birthday = isset($_POST['birthday']) ? $_POST['birthday'] : '';
        $identification = isset($_POST['identification']) ? $_POST['identification'] : '';
        $sex = isset($_POST['sex']) ? $_POST['sex'] : '';
        $date = date('Y-m-d');
        $id_card_base = rand(100000, 999999); 
        $id_card = generateCode128($date, $id_card_base); 

        if ($name_title == '' || $surname == '' || $name == '' || $sex == '' || $birthday == '' || $identification == '') {
            $empty = true;
        } else {
            // Check for existing card number
            $query = mysqli_query($conn, "SELECT * FROM users_dusi WHERE identification = '$identification'");
            if (mysqli_num_rows($query) > 0) {
                $already_card = true;
            } else {
                $sql = "INSERT INTO `users_dusi` 
                        (`name_title`, `name`, `surname`, `birthday`, `date`, `identification`, `sex`, `id_card`) 
                        VALUES ('$name_title', '$name', '$surname', '$birthday', '$date', '$identification', '$sex', '$id_card')";
                $result = mysqli_query($conn, $sql);
                
                if ($result) { 
                    $insert = true;
                    exit();
                } else {
                    echo "The record was not inserted successfully because of this error: " . mysqli_error($conn); // แสดงข้อผิดพลาดที่เกิดขึ้น
                } 
            }
        }
    }

function generateCode128($date, $id_card_base) {
    $day = date('d', strtotime($date));
    return $day . $id_card_base;
}
?>



<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

  <link rel="icon" type="image/png" href="images/favicon.png"/>
  <title>เพิ่มผู้ใช้</title>
</head>

<body>

  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">แก้ไข</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form method="POST">
          <div class="modal-body">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="form-group">
            <label>ข้อมูลผู้ใช้</label>
    
              <div>
                  <label for="name_titleEdit">คำนำหน้า:</label>
                  <select name="name_titleEdit" id="name_titleEdit" class="form-control" >
                  <option selected>เลือก...</option>
                  <option>นาย</option>
                  <option>นาง</option>
                  <option>นางสาว</option>
                  <option>เด็กหญิง</option>
                  <option>เด็กชาย</option>
                </select>
              </div>

              <div>
                  <label for="nameEdit">ชื่อ:</label>
                  <input type="text" id="nameEdit" name="nameEdit" class="form-control">
              </div>

              <div>
                  <label for="surnameEdit">นามสกุล:</label>
                  <input type="text" id="surnameEdit" name="surnameEdit" class="form-control">
              </div>

              <div>
                  <label for="identificationEdit">หมายเลขบัตรประจำตัวประชาชน:</label>
                  <input type="text" class="form-control" id="identificationEdit" name="identificationEdit">
              </div>

            </div>
          </div>
          <div class="modal-footer d-block mr-auto">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">บันทึก</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Navigation bar -->
  <nav class="navbar navbar-expand-lg navbar-dark" style="background-image: linear-gradient(to right, rgb(0,300,255), rgb(93,4,217));">
    <a class="navbar-brand" href="#"><img src="assets/images/codingcush-logo.png" alt=""></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </nav>

  <div class="container my-4">
    <?php
    if($insert){
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
              <strong>Success!</strong> Your Card has been inserted successfully
              <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>×</span>
              </button>
            </div>";
    }
    if($delete){
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
              <strong>Success!</strong> Your Card has been deleted successfully
              <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>×</span>
              </button>
            </div>";
    }
    if($update){
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
              <strong>Success!</strong> Your Card has been updated successfully
              <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>×</span>
              </button>
            </div>";
    }
    if($empty){
      echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
              <strong>Error!</strong> The Fields Cannot Be Empty! Please Give Some Values.
              <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>×</span>
              </button>
            </div>";
    }
    if($already_card){
      echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
              <strong>Error!</strong> This Card is Already Added.
              <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>×</span>
              </button>
            </div>";
    }
    ?>
    
    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
      <i class="fa fa-plus"></i>เพิ่มผู้ใช้
    </button>
    <a href="id-card.php" class="btn btn-primary">
      <i class="fa fa-address-card"></i>สร้างการ์ด
    </a>
    
    <div class="collapse" id="collapseExample">
      <div class="card card-body">
        <form method="POST" enctype="multipart/form-data">
          <div class="form-row">

            <div class="form-group col-md-2.5">
              <label for="name_title">คำนำหน้า</label>
              <select name="name_title" class="form-control" id="name_title">
                <option selected>เลือก...</option>
                <option>นาย</option>
                <option>นาง</option>
                <option>นางสาว</option>
                <option>เด็กหญิง</option>
                <option>เด็กชาย</option>
              </select>
            </div>

            <div class="form-group col-md-4">
              <label for="name">ชื่อ</label>
              <input type="text" name="name" class="form-control" id="name">
            </div>

            <div class="form-group col-md-4">
              <label for="surname">นามสกุล</label>
              <input type="text" name="surname" class="form-control" id="surname">
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-2">
              <label for="sex">เพศ</label>
              <select name="sex" class="form-control" id="sex">
                <option selected>เลือก...</option>
                <option>ชาย</option>
                <option>หญิง</option>
              </select>
            </div>

            <div class="form-group col-md-6.5">
              <label for="birthday">วันเกิด</label>
              <input type="date" name="birthday" class="form-control" id="birthday">
            </div>

            <div class="form-group col-md-5">
              <label for="identification">หมายเลขบัตรประจำตัวประชาชน</label>
              <input type="identification" name="identification" class="form-control" id="identification">
            </div>
            
          </div>

          <button type="submit" class="btn btn-primary">ยืนยัน</button>
        </form>
      </div>
    </div>
  </div>

        <div class="container my-4">

        <table class="table" id="myTable">
          <thead>
            <tr>
            <th scope="col">ลำดับที่</th>
            <th scope="col">ชื่อ-นามสกุล</th>
            <th scope="col">หมายเลขบัตรประจำตัวประชาชน</th>
            <th scope="col">แก้ไข</th>
            </tr>
        </thead>
        <tbody>
  <?php 
        $sql = "SELECT sno, CONCAT(name_title, ' ', name, ' ', surname) AS full_name, identification FROM `users_dusi` ORDER BY sno DESC";
        $result = mysqli_query($conn, $sql);
        $sno = 0;
        while($row = mysqli_fetch_assoc($result)){
        $sno++;
        echo "<tr>
            <th scope='row'>". $sno . "</th>
            <td>". $row['full_name'] . "</td>
            <td>". $row['identification'] . "</td>
            <td>
                <button class='edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button>
                <button class='delete btn btn-sm btn-primary' id=d".$row['sno'].">Delete</button>
            </td>
          </tr>";
        }
  ?>

  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="script.js"></script>
</body>
</html>
