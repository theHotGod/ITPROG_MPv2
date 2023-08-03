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
        <title>Combo to Database</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="admin.css">
        <?php include("navbar.php");?>    
    </head>
    <body>
        <main>
        <div class="container-lg d-flex justify-content-center mt-5">
            <div class="row d-flex justify-content-center mt-5">
            <?php
                if ($_SERVER["REQUEST_METHOD"] === "POST") {
            
                    //for contentID in table combo_content
                    $maxIDQuery = "SELECT MAX(contentid) AS max_value FROM combo_content";
                    $result = mysqli_query($conn, $maxIDQuery);    
                    $row = mysqli_fetch_assoc($result);
                    $contentid = $row['max_value'] + 1;

                    //for comboID in table combo_content
                    $maxIDQuery = "SELECT MAX(comboID) AS max_value FROM combo_content";
                    $result = mysqli_query($conn, $maxIDQuery);    
                    $row = mysqli_fetch_assoc($result);
                    $holder = $row['max_value'];
                    $comboID = $row['max_value'] + 1;


                    $mainID = $_POST['mainDish'];
                    $sideID = $_POST['sideDish'];
                    $drinkID = $_POST['drink'];
                    $discount = $_POST['discount'];
                    $comboName = $_POST['comboName'];



                    $combo = [];

                    $mainQuery = mysqli_query($conn, "SELECT * FROM dish WHERE dishID=$mainID");
                        while ($dish = mysqli_fetch_assoc($mainQuery)) {
                            $combo[] = $dish['dishName'];
                        }

                    $sideQuery = mysqli_query($conn, "SELECT * FROM dish WHERE dishID=$sideID");
                        while ($dish = mysqli_fetch_assoc($sideQuery)) {
                            $combo[] = $dish['dishName'];
                        }

                    $drinkQuery = mysqli_query($conn, "SELECT * FROM dish WHERE dishID=$drinkID");
                        while ($dish = mysqli_fetch_assoc($drinkQuery)) {
                            $combo[] = $dish['dishName'];
                        }

                    /*
                    for loop max value of combo ID then nested loop to check each dish and counter. if count == 3 then combo already exists 
                    */    

                    $comboLength = count($combo);

                    // check if combo already exists
                    for ($i = 1; $i <= $holder; $i++) {
                        $counter = 0;
                        $sql = "SELECT * FROM combo_content WHERE comboID=$i";
                        $result = mysqli_query($conn, $sql); 
                    
                        while ($res = mysqli_fetch_assoc($result)) {
                            for ($j = 0; $j < $comboLength; $j++) {
                                if ($combo[$j] == $res['foodName']) {
                                    $counter++;
                                }
                            }
                        }
                    }
                    

                    if($counter == 3){
                        echo "<div class = 'col-12 mt-5 p-2 d-flex justify-content-center'>";
                        echo "<h1 class = 'display-1 mt-5'>". "Combo already exists". "</h1>";
                        echo "</div>";
                    }
                    else{
                        $query = "INSERT INTO food_combo (comboID, comboName, discount) VALUES($comboID, '$comboName', $discount);";
                        $result = mysqli_query($conn, $query);
                        echo "<div class = 'col-12 mb-3 p-2 d-flex justify-content-center'>";
                        echo "<h1 class = 'display-4'>". "Combo Successfully Added!". "</h1>";
                        echo "</div>";
                        


                        echo "<div class = 'col-12 col-md-3  p-2 d-flex justify-content-center'>";
                        
                        echo "<table class = 'table table-respnosive-xl table-sm aligned-table table-light'>";
                        echo "<th>". "Combo Details". "</th>";
                        echo "<tr>";
                        echo "<td class = 'fw-bold'>". "Combo Name: ".$comboName. "</td>";
                        echo "</tr>"; 
                        for($i = 0; $i < $comboLength; $i++){
                            echo "<tr>";
                            echo "<td class ='fw-bold'>". "Dish: ". $combo[$i]. "</td>";
                            echo "</tr>";
                        
                            $contentQuery = "INSERT INTO combo_content (contentID, comboID, foodName) VALUES($contentid, $comboID, '$combo[$i]');";
                            $result = mysqli_query($conn, $contentQuery);
                            $contentid++;
                        }   
                        echo "</table>";
                        echo "</div>";
                    }
                    echo "<div class = 'row d-flex justify-content-center'>";
                        echo "<div class = 'col-12 d-flex justify-content-center mt-1'>";
                            echo "<a href='main.php'>";
                            echo "<button class = 'btn btn-primary p-2'>". "Back to Home". "</button>";
                            echo "</a>";
                        echo "</div>";
                    echo "</div>";

                    /*
                    $query = "INSERT INTO food_combo (comboID, comboName, discount) VALUES($comboID, '$comboName', $discount);";
                    $result = mysqli_query($conn, $query);
                    echo "combo name: ".$comboName."<br>";
                    for($i = 0; $i < $comboLength; $i++){
                        echo "combo id: ".$comboID."<br>";
                        echo "content id: ".$contentid."<br>";
                        echo "dish: ".$combo[$i]."<br>";
                        
                        $contentQuery = "INSERT INTO combo_content (contentID, comboID, foodName) VALUES($contentid, $comboID, '$combo[$i]');";
                        $result = mysqli_query($conn, $contentQuery);
                        $contentid++;
                    }
                    */
                    
                
                    /*
                    $query = "UPDATE dish SET dishName = '$name', dishPrice = '$price', dishCategory = '$category' WHERE dishID = '$id'";
                
                    $result = mysqli_query($conn, $query);
                
                    // Check if the update was successful
                    if ($result) {
                        echo "Dish updated successfully with the following values: <br>.";
                        echo "Dish Name: ".$name."<br>";
                        echo "Dish Category: ".$category."<br>";
                        echo "Dish Price: ".$price."<br>";

                        echo '<a href="homePage.php">Home</a>';
                    } else {
                        echo "Error updating data: " . mysqli_error($conn);
                    }
                    

                    */
                }
                ?>

            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
            integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
            integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
        </script>
        </main>
    </body>
    <?php
        } 
    ?>
</html>