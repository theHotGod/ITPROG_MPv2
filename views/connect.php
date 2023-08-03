<?php
    $conn = mysqli_connect("localhost", "root", "p@ssword") or die ("Unable to connect!". mysqli_error($conn));
    mysqli_select_db($conn, "dbclient_side");
?>

<?php
    $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn));
    mysqli_select_db($conn, "dbclient_side");
?>

<?php
      $DBConnect = mysqli_connect("localhost", "root", "") or die ("Unable to Connect". mysqli_error($DBConnect));

      $db = mysqli_select_db($DBConnect, 'dbclient_side');   
?>

<?php
      $DBConnect = mysqli_connect("localhost", "root", "p@ssword") or die ("Unable to Connect". mysqli_error($DBConnect));

      $db = mysqli_select_db($DBConnect, 'dbclient_side');   
?>