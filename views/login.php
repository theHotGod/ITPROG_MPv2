<!doctype html>
<html lang="en">

<head>
  <title>Login</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

    <link rel="stylesheet" href="/views/public/css/login.css">
</head>

<body>
  <header>
  </header>
  <main>

    <div class="container min-vh-100 d-flex justify-content-center align-items-center ">

        <form method = "post" action="http://localhost:3000/check.php">
            <h1>Administrator Login</h1>
            <div class="mb-3">
              <label for="username" class="form-label">Username: </label>
              <input type="text" class="form-control" id="username" name="username">
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password:</label>
              <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
                <?php
                  if(isset($_GET["error"])) {
                      $error=$_GET["error"];
              
                    
                    if ($error==1) {
                        echo "<p align='center'>Username and/or password invalid<br/></p>"; 
                  }
                  }
                ?>                    
            </div>
            <div class="mb-3">
                Not an admin?
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
          </form>
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

</html>