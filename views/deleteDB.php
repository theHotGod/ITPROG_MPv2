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
        <title>Delete Success</title>
            <!--bootstrap cdn-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="admin.css">
    </head>
    <body>
        <main>
        <div class="container">
            <div class="row">
                <div class="col">
                        <?php
                            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                                $id = $_POST['dishID'];
                                $name = $_POST['dishName'];

                                $query = "DELETE FROM dish WHERE dishID = '$id'";
                                $result = mysqli_query($conn, $query);
                            
                                if ($result) {
                                    echo "<h1 class = 'display-6 text-center '>". "Dish ". $name ." Successfully Deleted. </h1> <br>";

                                } else {
                                    echo "Error updating data: " . mysqli_error($conn);
                                }
                            }
                        ?>   
                </div>
            </div>
        </div>
        <div class="container d-flex justify-content-center">
            <div class="row">
                <div class="col">
                    <a href="main.php"><button class = "btn btn-primary p-2">Back to Home</button></a>

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
</html>



<?php }?>