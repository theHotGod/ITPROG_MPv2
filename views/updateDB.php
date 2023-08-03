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
    <head>
        <title>Update Database</title>

            <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="admin.css">
    </head>
    <?php include("navbar.php");?>
    <body>
        <main>
        <div class="container-lg d-flex justify-content-center">
            <div class="row">
                <div class="col">
                    <div style = "width:100%" class ="mx-auto ">
                        <h1 class="display-4 text-center mb-5">Update Successful!</h1>

                        <?php
                            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                                $id = $_POST['dishID'];
                                $name = $_POST['dishName'];
                                $price = $_POST['dishPrice'];
                                $category = $_POST['dishCategory'];

                                include("upload.php");
                            
                            
                                if(isset($destinationPath)){
                                    $query = "UPDATE dish SET dishName = '$name', dishPrice = '$price', dishCategory = '$category', img = '$destinationPath' WHERE dishID = '$id'";

                                }
                                else{
                                    $query = "UPDATE dish SET dishName = '$name', dishPrice = '$price', dishCategory = '$category'WHERE dishID = '$id'";
                                }
                            
                                $result = mysqli_query($conn, $query);
                            
                                // Check if the update was successful
                                if ($result) {
                                    echo "<div class = 'container'>";
                                    echo "<p class = 'fw-bold text-center mb-5'>"."Dish updated successfully with the following values: </p>";
                                    echo "<div class = 'mx-auto' style ='width:50%;'>";
                                    if(isset($destinationPath)){
                                        echo "<img style = 'max-width: 100%' class = 'mb-4' src = '$destinationPath'>";
                                    }
                                    echo "<p class = 'fw-bold'>"."Dish Name: ".$name."</p>";
                                    echo "<p class = 'fw-bold'>"."Dish Category: ".$category."</p>";
                                    echo "<p class = 'fw-bold'>"."Dish Price: ".$price."</p>";
                                    echo "</div>";
                                    echo "</div>";

                                } else {
                                    echo "Error updating data: " . mysqli_error($conn);
                                }
                                echo "<div class = 'container'>";
                                echo "<div class = 'mx-auto' style ='width:50%;'>";
                                echo "<a href='main.php'>";
                                echo "<button class = 'btn btn-primary mt-4'>". "Back to Home". "</button>";
                                echo "</a>";
                                echo "</div>";
                                echo "</div>";
                            }
                        ?>
                    </div>
                </div>
            </div>

        </div>

        </main>



    <!-- Bootstrap JavaScript Libraries -->
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

