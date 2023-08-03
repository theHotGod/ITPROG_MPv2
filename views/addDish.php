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
<?php
    include("navbar.php");
?>
<head>
    <title>Add New Dish</title>
        <!--bootstrap cdn-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="admin.css">
</head>
<body>
    <main>


    <div class="container-lg title mt-5 ">
        <h1 class="display-4 text-center">Add a New Dish Item</h1>
    </div>

        <div class = "container-lg mt-5 d-flex justify-content-center">
            <form action="addDishToDB.php" method="POST" enctype="multipart/form-data">

            <label for="dishName" class="form-label fw-bold">Dish Name:</label>
            <input type='text' name='dishName' class ="form-control" autocomplete="off"><br><br>

            <label for="dishCategory" class="form-label fw-bold">Dish Category:</label>
            <select name="dishCategory" class="dishCategory form-select">
            <option value="" disabled selected hidden></option>

            <?php
                 $categQuery = mysqli_query($conn, "SELECT * FROM dish_category ");

                    while ($category = mysqli_fetch_assoc($categQuery)) {
                        echo '<option value="' . $category['categoryName'] . '">' . $category['categoryName'] . '</option>';
                    }
                 
            ?>
            </select>

                <br><br>
                <label for="dishPrice" class="form-label fw-bold">Dish Price:</label>
                <input type='number' class="form-control" name='dishPrice' step="0.01" size='5' min="1" autocomplete="off">
                <br><br>
                <label class="form-label fw-bold" for="image">Select an image:</label>
                <input class="form-control" type="file" name="image"/>
                <br>
                <label  class = "form-label fw-bold" for="xmlfile">or Upload an XML File:</label>
                <input class="form-control" type="file" name="xmlfile"/>
                <br>

                <div class="col d-flex justify-content-center">
                <input type="Submit" value="Add Dish to Menu" class="btn btn-primary mt-3">
                </div>
        
                
                <br>
            </form>
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