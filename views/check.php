<?php
    require("connect.php");

    $login = $_POST["submit"];
    $userName = $_POST["username"];
    $password = $_POST["password"];

    if(isset($login)){
        
        $loginQuery = mysqli_query($DBConnect, "SELECT admins.username, admins.password FROM admin_accounts admins
        WHERE admins.username = '$userName' AND admins.password = '$password'");
        $fetch = mysqli_fetch_array($loginQuery);
         
        if($userName == $fetch["username"] && $password == $fetch["password"]){
            session_start();
            $_SESSION["getLogin"] = $userName;
            header("location:main.php"); 
        }
        else{
            header("location:login.php?error=1");
        }
    }


?>