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
    <title>Update/Modify Dish</title>
    <?php include 'connect.php'; ?>

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="admin.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <main>
        <div class="container-lg mt-5">
        <?php
            $id = $_GET['dish'];
            $name;
            $price;
            $category;
            $dishQuery = mysqli_query($conn, "SELECT * FROM dish WHERE dishID=$id");

            while ($dish = mysqli_fetch_assoc($dishQuery)) {
                $id = $dish['dishID'];
                $name = $dish['dishName'];
                $price =  $dish['dishPrice'];
                $dcategory = $dish['dishCategory'];
                $img = $dish['img'];
                

            }
        ?>
        
            
            <div class="container-lg title p-2 ">
                <h1 class="display-4 text-center">Modify <?php echo $name?></h1>
            </div>

            <div class = "container-lg mt-5 d-flex justify-content-center">
                <form action="updateDB.php" method="POST" enctype="multipart/form-data">

                    <input type="hidden" name="dishID" value="<?php echo $id; ?>">

                    <label class="form-label fw-bold" for="dishName">Dish Name:</label>
                    <input class ="form-control" type='text' name='dishName' value='<?php echo $name; ?>'required><br><br>

                    <label class="form-label fw-bold" for="dishCategory">Dish Category:</label>
                    <select class="form-control" name="dishCategory" class="dishCategory" required>
                    <?php
                        $categQuery = mysqli_query($conn, "SELECT * FROM dish_category ");

                        while ($category = mysqli_fetch_assoc($categQuery)) {
                            $categoryName = $category['categoryName'];
                            if ($categoryName === $dcategory) {
                                echo '<option value="' . $categoryName . '" selected>' . $categoryName . '</option>';
                            } else {
                                echo '<option value="' . $categoryName . '">' . $categoryName . '</option>';
                            }
                        }
                    ?>
                    </select>


                    <br><br>

                    <label class="form-label fw-bold" for="dishPrice">Dish Price:</label>
                    <input class="form-control" type='number' name='dishPrice' step="0.01" size='5' min="1" value='<?php echo $price; ?>' required>
                    <br><br>
                    <label class="form-label fw-bold" for="image">Upload an image:</label>
                    <input class="form-control" type="file" name="image"/>
                    <br><br>
                    
                    <div class="container d-flex justify-content-center">
                        <input class="btn btn-primary" type="Submit" value="Update Dish">
                    </div>


                    <br>
                </form>
                
                    <br>
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