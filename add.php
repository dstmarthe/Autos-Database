<?php
session_start();
require_once "pdo.php";
if ( ! isset($_SESSION['name']) ) {
    die('ACCESS DENIED');
    header('Location: logout.php');
    return;
}
if ( isset($_POST['logout']) ) {
    header('Location: logout.php');
    return;
}

if ( isset($_POST['make']) && isset($_POST['mileage']) 
     && isset($_POST['year'])) 
     {
         if (! is_numeric($_POST['mileage']) || ! is_numeric($_POST['year']))
         {
            $_SESSION['error'] = "Mileage and year must be numeric";
            header("Location: add.php");
        return;
         } elseif (strlen($_POST['make']) < 1 )
         {
            $_SESSION['error'] = "Make is required";
            header("Location: add.php");
        return;
         }
         else {
        $stmt = $pdo->prepare('INSERT INTO autos
        (make, year, mileage) VALUES ( :mk, :yr, :mi)');
      $stmt->execute(array(
        ':mk' => htmlentities($_POST['make']),
        ':yr' => htmlentities($_POST['year']),
        ':mi' => htmlentities($_POST['mileage']))

      );
      $_SESSION['success'] = "Record inserted";
header("Location: view.php");
return;
    } 
}




?>
<html>
<head><title>Dale Stmarthe</title></head><body>
<h1><strong>Welcome to Autos Database</strong></h1>
<p>Add A New Car</p>
<form method="post">
<p>Make
<input type="text" name="make" size="40"></p>
<p>Mileage
<input type="text" name="mileage"></p>
<p>Model
<input type="text" name="mileage"></p>
<p>Year
<input type="text" name="year"></p>
<p><input type="submit" value="Add New"/></p>
<form method="POST">
<p><button name="logout">logout</button></p>
</form>
</form>
<?php

if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}
?>
</html>