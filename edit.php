<?php
require_once "pdo.php";
session_start();

if ( ! isset($_SESSION['name']) ) {
    die('Not logged in');
    header('Location: index.php');
    return;
}


if ( isset($_POST['make']) && isset($_POST['mileage'])
     && isset($_POST['year']) && isset($_POST['model'])) {

    // Data validation
    if ( strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1|| strlen($_POST['year']) < 1||  strlen($_POST['mileage']) < 1)  {
        $_SESSION['error'] = "All fields are required";
        header("Location: edit.php?autos_id=".$_REQUEST['autos_id']);
        return;
    }

    $sql = "UPDATE autos SET make = :make,
            mileage = :mileage, model = :model, year = :year
            WHERE autos_id = :autos_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':make' => $_POST['make'],
        ':mileage' => $_POST['mileage'],
        ':model' => $_POST['model'],
        ':year' => $_POST['year'],
        'autos_id' => $_GET['autos_id']));
    $_SESSION['success'] = 'Record Edited';
    header( 'Location: index.php' ) ;
    return;
}


// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

$stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for autos_id';
    header( 'Location: index.php' ) ;
    return;
}

$mk = htmlentities($row['make']);
$ml = htmlentities($row['mileage']);
$mo = htmlentities($row['model']);
$yr = htmlentities($row['year']);
?>
<p>Update Database</p>
<form method="post">
<p>Make:
<input type="text" name="make" value="<?= $mk ?>"></p>
<p>Mileage:
<input type="text" name="mileage" value="<?= $ml ?>"></p>
<p>Model:
<input type="text" name="model" value="<?= $mo ?>"></p>
<p>Year:
<input type="text" name="year" value="<?= $yr ?>"></p>
<p><input type="submit" value="Save"/>
<a href="index.php">Cancel</a></p>
</form>
