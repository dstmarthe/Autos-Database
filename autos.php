<?php
require_once "pdo.php";
if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
    die('Name parameter missing');
}
$failure = false;
if ( isset($_POST['make']) && isset($_POST['mileage']) 
     && isset($_POST['year'])) 
     {
         if (! is_numeric($_POST['mileage']) || ! is_numeric($_POST['year']))
         {
            $failure = "Mileage and year must be numeric";
         } elseif (strlen($_POST['make']) < 1 )
         {
             $failure = "Make is required";
         }
         else {
        $stmt = $pdo->prepare('INSERT INTO autos
        (make, year, mileage) VALUES ( :mk, :yr, :mi)');
      $stmt->execute(array(
        ':mk' => htmlentities($_POST['make']),
        ':yr' => htmlentities($_POST['year']),
        ':mi' => htmlentities($_POST['mileage']))
      );
      $failure = "Success";
    } 
}
// If the user requested logout go back to index.php
if ( isset($_POST['logout']) ) {
    header('Location: index.php');
    return;
}

?>
<html>
<head><title>Dale Stmarthe</title></head><body>
<h1><strong>Welcome to Autos Database</strong></h1>
<p>Add A New Car</p>
<?php

// Note triple not equals and think how badly double
// not equals would work here...
if ( $failure !== false ) {
    if ($failure == "Success"){
        echo('<p style="color: green;">Record inserted</p>');
       }else
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");

}
?>
<form method="post">
<p>Make
<input type="text" name="make" size="40"></p>
<p>Mileage
<input type="text" name="mileage"></p>
<p>Year
<input type="text" name="year"></p>
<p><input type="submit" value="Add New"/></p>
<p><button name="logout">logout</button></p>
</form>
<table border="1">
<?php
$stmt = $pdo->query("SELECT make, mileage, year FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ( $rows as $row ) {
    echo "<tr><td>";
    echo($row['make']);
    echo("</td><td>");
    echo($row['mileage']);
    echo("</td><td>");
    echo($row['year']);
    echo("</td></tr>\n");
}

?>
</table>

</body>
</html>