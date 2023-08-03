<?php
    require("connect.php");
    session_start();
    if(!isset($_SESSION["getLogin"])){
       header("location:login.php");
    } else {
        $userName = $_SESSION["getLogin"];

?>
<?php include 'connect.php'; 
      include("navbar.php");?>


<html>

    <head><title>Dish to XML File</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="admin.css">
    </head>
    <body>
        <div class="container-lg d-flex justify-content-center mt-5">
            <?php
                $maxIDQuery = "SELECT MAX(dishID) AS max_value FROM dish";
                $result = mysqli_query($conn, $maxIDQuery);    
                $row = mysqli_fetch_assoc($result);
                $id = $row['max_value'] + 1;

            ?>

            <?php
                $dishName = $_POST['dishName'];
                $dishCategory = $_POST['dishCategory'];
                $dishPrice = $_POST['dishPrice'];

                $query = "SELECT * FROM dish WHERE LOWER(dishName) = LOWER('$dishName')";
                $result = mysqli_query($conn, $query);    
            
                if (mysqli_num_rows($result) == 0) {

                    include 'upload.php';
                    
                    if(file_exists("dishes_xmldata.xml")){
                        $dishes = simplexml_load_file('dishes_xmldata.xml');
                        $dish = $dishes->addChild("dish");
                        $dish->addChild('id', $id);
                        $dish->addChild('name', $dishName);
                        $dish->addChild('category', $dishCategory);
                        $dish->addChild('price', $dishPrice);
                        $dish->addChild('img', $filePathInDatabase);
                        file_put_contents('dishes_xmldata.xml', $dishes->asXML());
                
                        header("Location: XMLtoDB.php");
                        exit();
                    }
                    else{
                        $dishes = new SimpleXMLElement('<dishes></dishes>');
                
                        $dishes->addAttribute("xmlns:xsi", "http://www.w3.org/2001/XMLSchema-instance");
                        $dishes->addAttribute("xsi:noNamespaceSchemaLocation", "dishes.xsd");
                
                        $dish = $dishes->addChild("dish");
                        $dish->addChild('id', $id);
                        $dish->addChild('name', $dishName);
                        $dish->addChild('category', $dishCategory);
                        $dish->addChild('price', $dishPrice);
                        $dish->addChild('img', $filePathInDatabase);
                        $dishes->asXML("dishes_xmldata.xml");
                
                        header("Location: XMLtoDB.php");
                        exit();
                    }   
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
            ?>
        </div>
        
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
    
    </body>
</html>



<?php
    }
?>