<?php
session_start();
require_once "pdo.php";

if ( ! isset($_SESSION['name']) ) {
    die('Not logged in');
}

if ( isset($_SESSION['success']) ) {
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
}

// If the user requested logout go to logout.php
if ( isset($_POST['logout']) ) {
    header('Location: logout.php');
    return;
}

?>
<html>
<head><title>Dale Stmarthe</title></head><body>
<h1> Tracking Car Database</h1>

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
<p><a href="add.php">Add A New Entry</a></p>
<form method="POST">
<p><button name="logout">logout</button></p>
</form>
</table>

</body>
</html>