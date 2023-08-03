<?php
    require("connect.php");
    session_start();
    if(!isset($_SESSION["getLogin"])){
       header("location:login.php");
    } else {
        $userName = $_SESSION["getLogin"];

?>


<!DOCTYPE html>
<html>
<head>
    <title>Add Combo Meal</title>
    <?php include 'connect.php'; ?>
    <!--bootstrap cdn-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="admin.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <main>


        <div class="container-lg mt-5 d-flex justify-content-center">
            <div class="row mt-5">

                <form action="comboMealDB.php" method="POST">
                <h1 class="display-5 mt-2 mb-5">Add a New Combo Meal</h1>

                <label class="col-form-label fw-bold"for="comboName">Combo Meal Name:</label>
                <input  class = "form-control" type='text' name='comboName' required>
                <br>

                <label class="col-form-label fw-bold" for="dishCategory">Select a Main Dish:</label>
                <select class = "form-control" name="mainDish" required>
                <option value="" disabled selected hidden></option>

                <?php
                    $mainQuery = mysqli_query($conn, "SELECT * FROM dish WHERE dishCategory='Mains'");

                        while ($dish = mysqli_fetch_assoc($mainQuery)) {
                            echo '<option value="' . $dish['dishID'] . '">' . $dish['dishName'] . '</option>';
                        }
                    
                ?>
                </select>

                <br><br>
                
                <label class="form-label fw-bold""dishCategory">Select a Side Dish:</label>
                <select class="form-control" name="sideDish" required>
                <option value="" disabled selected hidden></option>

                <?php
                    $sideQuery = mysqli_query($conn, "SELECT * FROM dish WHERE dishCategory='Sides'");

                        while ($dish = mysqli_fetch_assoc($sideQuery)) {
                            echo '<option value="' . $dish['dishID'] . '">' . $dish['dishName'] . '</option>';
                        }
                    
                ?>
                </select>

                <br><br>
                
                <label class="form-label fw-bold" for="dishCategory">Select a Drink:</label>
                <select class="form-control" name="drink" required>
                <option value="" disabled selected hidden></option>

                <?php
                    $drinkQuery = mysqli_query($conn, "SELECT * FROM dish WHERE dishCategory='Drinks'");

                        while ($dish = mysqli_fetch_assoc($drinkQuery)) {
                            echo '<option value="' . $dish['dishID'] . '">' . $dish['dishName'] . '</option>';
                        }
                    
                ?>
                </select>

                <br><br>

                <label class="form-label fw-bold" for="discount">Combo Meal Discount (input in decimal):</label>
                <input class="form-control" type='text' name='discount' pattern="^\d+(\.\d{1,2})?$" title="Enter a valid decimal number (e.g., 0.50)" required>


                    <br><br>
                <div class="col d-flex justify-content-center">
                    <input type="Submit" value="Add Combo Meal" class="btn btn-primary p-2">
                </div>
                
                </form>
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
