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
    <title>Delete Dish</title>
    <?php include 'connect.php'; ?>

    <!--bootstrap cdn-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="admin.css">

    <script>
    function cancelFormSubmission() {
        event.preventDefault();
        window.location.href = "main.php";
    }
</script>

</head>
<body>
    <?php include 'navbar.php'; ?>

    <main>
        <div class = "container-lg text-center">

                
                <?php
                    if ($_SERVER["REQUEST_METHOD"] === "POST") {
                        $id = $_POST['dishID'];
                        $name = $_POST['dishName'];
                        echo "<p class = 'fw-bold'>". "Delete dish ".$name." ? </p>";

                        echo '
                            <form action="deleteDB.php" method="POST">
                                <input type="hidden" name="dishID" value="'.$id.'">
                                <input type="hidden" name="dishName" value="'.$name.'">
                                <input style = "width: 5%;" class = "btn btn-primary m-2 p-2" type="submit" value="Yes">
                                <button type="button" style = "width: 5%;" class="btn btn-primary m-2 p-2" onclick="cancelFormSubmission()">No</button>
                                <br>
                            </form>
                        ';
                    }
                    else{
                ?>
                    
                    <h1 class = "display-4 mb-5">Select a Dish to Delete</h1>


                <div class = "col">
                    <div style="width:50%" class = "mx-auto">
                        <table class="table table-responsive-lg aligned-table delete-table">
                            <th>Main Dishes</th>
                                <?php
                                    $dishQuery = mysqli_query($conn, "SELECT * FROM dish WHERE dishCategory = 'Mains'");


                                    while ($dish = mysqli_fetch_assoc($dishQuery)) {
                                        $id = $dish['dishID'];
                                        $name = $dish['dishName'];
                                        $dishCategory = $dish['dishCategory'];
                                        $price = $dish['dishPrice'];
                                        echo '
                                            <form action="deleteDish.php" method="POST">
                                                <input type="hidden" name="dishID" value="'.$id.'">
                                                <input type="hidden" name="dishName" value="'.$name.'">
                                                <tr>
                                                    <td><input type="submit" value="' . $name . '" style="font-size: 16px; background-color: transparent; border: none;"></td>
                                                </tr>
                                            </form>
                                        ';
                                    }
                                    
                                ?>
                        </table>
                    </div>
                </div>

                <div class = "col">
                    <div style="width:50%" class = "mx-auto">
                        <table class="table table-responsive-lg aligned-table delete-table">
                            <th>Side Dishes</th>
                                <?php
                                    $dishQuery = mysqli_query($conn, "SELECT * FROM dish WHERE dishCategory = 'Sides'");


                                    while ($dish = mysqli_fetch_assoc($dishQuery)) {
                                        $id = $dish['dishID'];
                                        $name = $dish['dishName'];
                                        $dishCategory = $dish['dishCategory'];
                                        $price = $dish['dishPrice'];
                                        echo '
                                            <form action="deleteDish.php" method="POST">
                                                <input type="hidden" name="dishID" value="'.$id.'">
                                                <input type="hidden" name="dishName" value="'.$name.'">
                                                <tr>
                                                    <td><input type="submit" value="' . $name . '" style="font-size: 16px; background-color: transparent; border: none;"></td>
                                                </tr>
                                            </form>
                                        ';
                                    }
                                
                                ?>
                        </table>
                    </div>
                </div>

                <div class = "col">
                    <div style="width:50%" class = "mx-auto">
                        <table class="table table-responsive-lg aligned-table delete-table">
                            <th>Side Dishes</th>
                                <?php
                                    $dishQuery = mysqli_query($conn, "SELECT * FROM dish WHERE dishCategory = 'Sides'");


                                    while ($dish = mysqli_fetch_assoc($dishQuery)) {
                                        $id = $dish['dishID'];
                                        $name = $dish['dishName'];
                                        $dishCategory = $dish['dishCategory'];
                                        $price = $dish['dishPrice'];
                                        echo '
                                            <form action="deleteDish.php" method="POST">
                                                <input type="hidden" name="dishID" value="'.$id.'">
                                                <input type="hidden" name="dishName" value="'.$name.'">
                                                <tr>
                                                    <td><input type="submit" value="' . $name . '" style="font-size: 16px; background-color: transparent; border: none;"></td>
                                                </tr>
                                            </form>
                                        ';
                                    }
                                }
                                ?>
                        </table>
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