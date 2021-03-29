<html>
<head>
<title>Dale Stmarthe</title>
<?php require_once "bootstrap.php";
    require_once "pdo.php"; 
   session_start(); 
   
   if ( isset($_POST['delete']) && isset($_GET['autos_id']) ) {
    $sql = "DELETE FROM autos WHERE autos_id = :autos_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':autos_id' => $_GET['autos_id']));
    $_SESSION['success'] = 'Record deleted';
    header( 'Location: index.php' ) ;
    return;
}
    if (isset($_POST['logout']))
    {
        header( 'Location: logout.php' ) ;
    return;
    }
   
   ?>
</head>
<body>
<div class="container">
<p>
<h1>Welcome to this Automobile Database</h1>
<a href="login.php">Please log in</a>
</p>
</div>
<div class="container">
<table border="2">
<?php
$stmt = $pdo->query("SELECT autos_id, make, mileage, model, year FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ( $rows === false || ! isset($_SESSION['name'])) {
echo " No rows found";
} else
{
    foreach ( $rows as $row ) {
    echo "<tr><td>";
    echo(htmlentities($row['autos_id']));
    echo("</td><td>");
    echo(htmlentities($row['make']));
    echo("</td><td>");
    echo(htmlentities($row['mileage']));
    echo("</td><td>");
    echo(htmlentities($row['model']));
    echo("</td><td>");
    echo(htmlentities($row['year']));
    echo("</td><td>");
    echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
    echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
    echo("</td></tr>\n");
}
}
?>
</table>
<?php


if ( isset($_SESSION['success']) ) {
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
}
?>


<p><a href="add.php">Add New Entry</a></p>
<form method="POST">
<p><button name="logout">logout</button></p>
</form>
</table>

</div>
</body>
</html>

