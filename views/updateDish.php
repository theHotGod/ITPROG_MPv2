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

    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <main>
    <div class="container-lg mb-5 ">
    <div class="row">
        <div class="col-12 text-center mt-4 mb-5">
            <h1 class ="display-5">Select a Dish to Update/Modify</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div style="width: 30%;" class="mx-auto">
                <table class="table table-responsive-md aligned-table bg-light text-center" id="update_table">
                    <th>Number</th>
                    <th>Dish Name</th>
                        <?php
                            $dishQuery = mysqli_query($conn, "SELECT * FROM dish ");
                            $i = 1;

                            while ($dish = mysqli_fetch_assoc($dishQuery)) {
                                $id = $dish['dishID'];
                                $name = $dish['dishName'];
                                $img = $dish['img'];
                                echo "<tr>";
                                echo "<td>". $i . "</td>";
                                echo "<td>". "<a style = 'border-radius:10px;' class = 'btn btn-secondary p-2' href='modify.php?dish=$id'>"."<img style = 'max-width:100%; max-height:auto;' class = 'mb-2' src = '$img'>"."<br>". "$name</a>". "</td>";
                                echo "</tr>";
                                $i++;
                            }
                        ?>                      
                </table>
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
</html>
<?php
    }
?>