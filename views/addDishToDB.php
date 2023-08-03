<?php include 'connect.php'; ?>

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

    <?php
        if(isset($_FILES['xmlfile']) && $_FILES['xmlfile']['name'] !== ''){

            if ($_FILES["xmlfile"]["error"] === UPLOAD_ERR_OK) {

                $fileType = $_FILES["xmlfile"]["type"];
                if ($fileType === "text/xml" || $fileType === "application/xml") {

                    $fileName = $_FILES['xmlfile']['name'];
                    $xml = simplexml_load_file($fileName) or die("Error: Cannot create object");

                    foreach ($xml->children() as $row) {
                        $name = $row->name;
                        $category = $row->category;
                        $price = $row->price; 
                        $img = $row->img; 
                    
                        $query = "SELECT * FROM dish WHERE LOWER(dishName) = LOWER('$name')";
                        $result = mysqli_query($conn, $query);    

                        $maxIDQuery = "SELECT MAX(dishID) AS max_value FROM dish";
                        $res = mysqli_query($conn, $maxIDQuery);    
                        $row = mysqli_fetch_assoc($res);
                        $id = $row['max_value'] + 1;
                     
                        if (mysqli_num_rows($result) == 0) {
                          $sql = "INSERT INTO dish(dishID, dishName, dishCategory, dishPrice, img) VALUES ('" . $id . "','" . $name . "','" . $category . "','" . $price . "','" . $img . "')";
                          $result = mysqli_query($conn, $sql);

                          echo '
                          <div class="container-lg title p-2 d-flex justify-content-center">
                          <div class="row">
                            <div class="col-12">
                              <h1 class="display-4 text-center">Item Added Successfully!</h1>
                            </div>
                          </div>
                        </div>
                          ';

                          echo "<div class = 'col-12 d-flex justify-content-center'>";
                                    echo "<a href = 'addDish.php'";
                                        echo "<button class ='btn btn-primary'>". "Add Another Dish". "</button>";
                                    echo "</a>";
                                    echo "&nbsp";
                                    echo "<a href = 'main.php'";
                                        echo "<button class ='btn btn-primary'>". "Back to Home". "</button>";
                                    echo "</a>";
                                echo "</div>";
                            echo "</div>";
                        }
                        else{
                            echo "<div class = 'row'>";
                                echo "<div class = 'col-12 d-flex justify-content-center mb-5'>";
                                    echo "<h1 class = 'display-1 text-center mt-5'>". "Dish already exists!". "</h1>";
                                echo "</div>";
                                echo "<div class = 'col-12 d-flex justify-content-center'>";
                                    echo "<a href = 'addDish.php'";
                                        echo "<button class ='btn btn-primary'>". "Add Another Dish". "</button>";
                                    echo "</a>";
                                    echo "&nbsp";
                                    echo "<a href = 'main.php'";
                                        echo "<button class ='btn btn-primary'>". "Back to Home". "</button>";
                                    echo "</a>";
                                echo "</div>";
                            echo "</div>";
            
        
                        } 
                    
                      }
                    
                } 
                else {
                    echo'
                    <div class="container-lg title p-2 d-flex justify-content-center">
                    <div class="row">
                      <div class="col-12">
                        <h1 class="display-4 text-center">File is not an XML.</h1>
                      </div>
                    </div>
                  </div>
                    ';
                    
                }
            } 
            else {
                echo'
                <div class="container-lg title p-2 d-flex justify-content-center">
                <div class="row">
                  <div class="col-12">
                    <h1 class="display-4 text-center">Error uploading file.</h1>
                  </div>
                </div>
              </div>
                ';
            }
        }
        else{

            if(isset($_POST['dishName']) && isset($_POST['dishCategory']) && isset($_POST['dishPrice']) && isset($_FILES['image'])  && $_FILES['image']['name'] !== ''){
                
                include 'upload.php';

                $dishName = $_POST['dishName'];
                $dishCategory = $_POST['dishCategory'];
                $dishPrice = $_POST['dishPrice'];

                $query = "SELECT * FROM dish WHERE LOWER(dishName) = LOWER('$dishName')";
                $result = mysqli_query($conn, $query);

                $maxIDQuery = "SELECT MAX(dishID) AS max_value FROM dish";
                $res = mysqli_query($conn, $maxIDQuery);    
                $row = mysqli_fetch_assoc($res);
                $id = $row['max_value'] + 1;

                if (mysqli_num_rows($result) == 0) {
                    $sql = "INSERT INTO dish(dishID, dishName, dishCategory, dishPrice, img) VALUES ('" . $id . "','" . $dishName . "','" . $dishCategory . "','" . $dishPrice . "','" . $filePathInDatabase . "')";
                    $result = mysqli_query($conn, $sql);

                    echo '
                    <div class="container-lg title p-2 d-flex justify-content-center">
                    <div class="row">
                      <div class="col-12">
                        <h1 class="display-4 text-center">Item Added Successfully!</h1>
                      </div>
                    </div>
                  </div>
                    ';

                    echo "<div class = 'col-12 d-flex justify-content-center'>";
                              echo "<a href = 'addDish.php'";
                                  echo "<button class ='btn btn-primary'>". "Add Another Dish". "</button>";
                              echo "</a>";
                              echo "&nbsp";
                              echo "<a href = 'main.php'";
                                  echo "<button class ='btn btn-primary'>". "Back to Home". "</button>";
                              echo "</a>";
                          echo "</div>";
                      echo "</div>";
                  }
                  else{
                      echo "<div class = 'row'>";
                          echo "<div class = 'col-12 d-flex justify-content-center mb-5'>";
                              echo "<h1 class = 'display-1 text-center mt-5'>". "Dish already exists!". "</h1>";
                          echo "</div>";
                          echo "<div class = 'col-12 d-flex justify-content-center'>";
                              echo "<a href = 'addDish.php'";
                                  echo "<button class ='btn btn-primary'>". "Add Another Dish". "</button>";
                              echo "</a>";
                              echo "&nbsp";
                              echo "<a href = 'main.php'";
                                  echo "<button class ='btn btn-primary'>". "Back to Home". "</button>";
                              echo "</a>";
                          echo "</div>";
                      echo "</div>";
      
  
                  } 
            }
            else{
                echo'
                <div class="container-lg title p-2 d-flex justify-content-center">
                <div class="row">
                  <div class="col-12">
                    <h1 class="display-4 text-center">Fields for  Dish Name, Dish Category, and Dish Price may be empty, or no image was uploaded.</h1>
                  </div>
                </div>
              </div>
                ';

                echo "<div class = 'col-12 d-flex justify-content-center'>";
                    echo "<a href = 'addDish.php'";
                        echo "<button class ='btn btn-primary'>". "Go Back to Add Dish". "</button>";
                    echo "</a>";
                    echo "&nbsp";
                    echo "<a href = 'main.php'";
                        echo "<button class ='btn btn-primary'>". "Back to Home". "</button>";
                    echo "</a>";
                echo "</div>";

            }
            
        }

    ?>

    
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