<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['delete'])) {
    $sql = "DELETE FROM autos WHERE autos_id = :autos_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':autos_id' => $_GET['autos_id']));
    $_SESSION['success'] = 'Record deleted';
    header( 'Location: index.php' ) ;
    return;
}
   

// Guardian: Make sure that user_id is present
if ( ! isset($_GET['autos_id']) ) {
  $_SESSION['error'] = "Missing autos_id";
  header('Location: index.php');
  return;
}
?>
<?
if (isset($_GET['autos_id']))
{
    echo('<div class= "container"');
    echo("<h2> Confirm: Deleting car id: {$_GET['autos_id']} ?</h2>");
    echo('<form method="POST">
    <p><button name="Delete"/></p>
    </form><p><a href="index.php">Cancel</a></p>');
    echo('</div>');
}
?>
<a href="index.php">Cancel</a>
</form>
