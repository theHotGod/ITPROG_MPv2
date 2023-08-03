<!doctype html>
<?php
    require("connect.php");
    session_start();
    if(!isset($_SESSION["getLogin"])){
       header("location:login.php");
    } else {
        $userName = $_SESSION["getLogin"];

?>
<html lang="en">
<?php
    include("navbar.php");
?>

<head>
  <title>Admin Home Page</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

    <link rel="stylesheet" href="admin.css">
    
</head>

<body>

  <header>
    
  </header>
  <main>
    <div class="container-lg title p-2">
        <h1 class="display-4 text-center">Restaurant Dashboard</h1>
    </div>

    <div class="container-lg mt-5 p-2 min-vh-100">
        <div class="table-responsive-lg">
            <table class="table aligned-table">
                <thead>
                    <tr class ="table_title bg-dark"><td colspan="3"><h2 class="text-light text-center fw-bold">Main Dish List</h2></td></tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Dish ID</th>
                        <th>Dish name</th>
                        <th>Price</th>
                    </tr>
                </tbody>

                    <?php
                        $mainQuery = mysqli_query($DBConnect, "SELECT dishID, dishName, dishPrice FROM dish WHERE dishCategory = 'Mains'");
                        while($fetchMains = mysqli_fetch_assoc($mainQuery)){
                            echo "<tr>";
                            echo "<td>". $fetchMains['dishID']. "</td>";
                            echo "<td>". $fetchMains['dishName']. "</td>";
                            echo "<td>". $fetchMains['dishPrice']. "</td>";
                            echo "</tr>"; 
                        }
                    

                    ?>
            </table>
        </div>   
        <div class="table-responsive-lg">
            <table class="table aligned-table">
                <thead>
                    <tr class ="table_title bg-dark"><td colspan="3"><h2 class="text-light text-center fw-bold">Side Dish List</h2></td></tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Dish ID</th>
                        <th>Dish name</th>
                        <th>Price</th>
                    </tr>
                </tbody>

                    <?php
                        $sideQuery = mysqli_query($DBConnect, "SELECT dishID, dishName, dishPrice FROM dish WHERE dishCategory = 'Sides'");
                        while($fetchSides = mysqli_fetch_assoc($sideQuery)){
                            echo "<tr>";
                            echo "<td>". $fetchSides['dishID']. "</td>";
                            echo "<td>". $fetchSides['dishName']. "</td>";
                            echo "<td>". $fetchSides['dishPrice']. "</td>";
                            echo "</tr>"; 
                        }
                    

                    ?>
            </table>
        </div>   
        
        <div class="table-responsive-lg">
            <table class="table aligned-table">
                <thead>
                    <tr class="table_title bg-dark"><td colspan="3"><h2 class=" text-light text-center fw-bold">Drinks List</h2></td></tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Dish ID</th>
                        <th>Dish name</th>
                        <th>Price</th>
                    </tr>
                    <?php
                        $drinkQuery = mysqli_query($DBConnect, "SELECT dishID, dishName, dishPrice FROM dish WHERE dishCategory = 'Drinks'");
                        while($fetchDrink = mysqli_fetch_assoc($drinkQuery)){
                            echo "<tr>";
                            echo "<td>". $fetchDrink['dishID']. "</td>";
                            echo "<td>". $fetchDrink['dishName']. "</td>";
                            echo "<td>". $fetchDrink['dishPrice']. "</td>";
                            echo "</tr>"; 
                        }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="table-responsive-lg">
            <table class="table aligned-table">
                <thead>
                    <tr class="table_title bg-dark"><td colspan="2"><h2 class=" text-light text-center fw-bold">Combo List</h2></td></tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Combo Name</th>
                        <th>Discount</th>
                    </tr>
                    <?php
                        $comboQuery = mysqli_query($DBConnect, "SELECT comboName, discount FROM food_combo ORDER BY comboID");
                        while($fetchCombo = mysqli_fetch_assoc($comboQuery)){
                            echo "<tr>";
                            echo "<td>". $fetchCombo['comboName']. "</td>";
                            echo "<td>".($fetchCombo['discount'] * 100)."%</td>";
                            echo "</tr>"; 
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>




    



  </main>

  <footer>
    <!-- place footer here -->
  </footer>

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