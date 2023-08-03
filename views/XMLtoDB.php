<?php include 'connect.php'; ?>

<?php

$xml = simplexml_load_file("dishes_xmldata.xml") or die("Error: Cannot create object");


foreach ($xml->children() as $row) {
    $id = $row->id;
    $name = $row->name;
    $category = $row->category;
    $price = $row->price; 
    $img = $row->img; 

    $query = "SELECT * FROM dish WHERE dishID=$id ";
    $result = mysqli_query($conn, $query);    
 
    if (mysqli_num_rows($result) == 0) {
      $sql = "INSERT INTO dish(dishID, dishName, dishCategory, dishPrice, img) VALUES ('" . $id . "','" . $name . "','" . $category . "','" . $price . "','" . $img . "')";
      $result = mysqli_query($conn, $sql);
    }
      

  }

?>
<!DOCTYPE html>
<?php
    require("connect.php");
    session_start();
    if(!isset($_SESSION["getLogin"])){
       header("location:login.php");
    } else {
        $userName = $_SESSION["getLogin"];

?>
<html>
    <?php include("navbar.php");?>
<head>
    <title>Add New Dish</title>
        <!--bootstrap cdn-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="admin.css">
</head>
<body>
    <main>

    <div class="container-lg title p-2 d-flex justify-content-center">
      <div class="row">
        <div class="col-12">
          <h1 class="display-4 text-center">Item Added Successfully!</h1>
        </div>
      </div>
    </div>
    <div class="container-lg title p-2 d-flex justify-content-center">
      <div class="row">
        <div class="col-12">
          <a href="addDish.php">
            <button class="btn btn-primary">Add Another Dish</button>
          </a>
          <a href="main.php">
            <button class="btn btn-primary">Back to Home Page</button>
          </a>
        </div>
      </div>
    </div>

    
</main>
    
    <!--bootstrap cdn-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>
<?php
    }
?>
</html>