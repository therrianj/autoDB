<?php
session_start();
require_once 'pdo.php';

$stmt = $pdo->query("SELECT make, model, year, mileage, autos_id FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<title>Jonathan Therrian - Auto Database</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<h1>Welcome to the Autos Database</h1>
<?php
if ( isset($_SESSION['success']) ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
}
if ( isset($_SESSION['error']) ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}
if ( ! isset($_SESSION['email'])) { ?>
<p>
<a href="login.php">Please Log In</a>
</p>

<p>
Attempt to 
<a href="add.php">add data</a> without logging in
</div>
</body> 

<?php } 
elseif (empty($rows) == false) {
	
	echo('<table border="2">'."\n");
	echo('<th>Make</th><th>Model</th><th>Year</th><th>Mileage</th>');
	foreach ( $rows as $row ) {
    
    echo "<tr><td> ";
    echo htmlentities($row['make']);
    echo("</td><td>");
    echo htmlentities($row['model']);
    echo("</td><td>");
    echo htmlentities($row['year']);
    echo("</td><td>");
    echo htmlentities($row['mileage']);
    echo('<a href="edit.php?autos_id='.$row['autos_id'].'"> Edit /</a>');
    echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
    echo(" </td></tr>\n");

} ?>
</table>
</br>
<a href="add.php">Add New Entry</a>
</br>
</br>
<a href="logout.php">Logout</a>
<?php }
else{
	echo('No Record Found');
 ?>
</br>
</br>
<a href="add.php">Add New Entry</a>
</br>
</br>
<a href="logout.php">Logout</a>
<?php }?>


