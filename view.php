<?php
session_start();

if ( ! isset($_SESSION['email'] ) ) {
    // Redirect the browser to game.php
    die ("Not Logged In");
    return;
}

require_once "pdo.php";
$stmt = $pdo->query("SELECT make, model, year, mileage FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<html>
<head>
<title>aa955ab6 Jonathan Therrian Auto Database</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<h1>Tracking Autos for <?php echo htmlentities($_SESSION['email']);?></h1>
<?php 
	if (isset($_SESSION['success'])){
	echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
}
?>
<h2>Automobiles</h2>
<?php 

foreach ( $rows as $row ) {
    echo "<ul><li>";
    echo "<tr><td> ";
    echo htmlentities($row['year']);
    echo(" </td><td>");
    echo htmlentities($row['make']);
    echo(" / </td><td>");
    echo htmlentities($row['mileage']);
    echo(" </td></tr></li></ul>\n");
}
?>

<p>
<a href="add.php">Add New</a>
|
<a href= "logout.php">Logout</a>
</p>
</body>
</html>
