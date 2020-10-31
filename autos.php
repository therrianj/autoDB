<?php

// Demand a GET parameter
if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
    die('Name parameter missing');
}

// If the user requested logout go back to index.php
if ( isset($_POST['logout']) ) {
    header('Location: index.php');
    return;
}

require_once "pdo.php";
$failure = false;
$success = false;
if ( isset($_POST['make']) && isset($_POST['year']) 
     && isset($_POST['mileage'])) {
        if (! is_numeric($_POST['year']) 
             || ! is_numeric($_POST['mileage'])){
            $failure = "Mileage and year must be numeric";

        } elseif (strlen($_POST['make'])<1) {
           $failure = "Make is required";
        } 
        else{

            $sql = "INSERT INTO autos (make, year, mileage) 
                      VALUES (:make, :year, :mileage)";

            // echo("<pre>\n".$sql."\n</pre>\n");

            $stmt = $pdo->prepare($sql);

            $make = ($_POST['make']);
            $year = ($_POST['year']);
            $mileage = ($_POST['mileage']);

            $stmt->execute(array(       
                ':make' => $make,
                ':year' => $year,
                ':mileage' => $mileage)
            );

            $success = "Record inserted";
        }
}
$stmt = $pdo->query("SELECT make, year, mileage FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<title>aa955ab6 Jonathan Therrian's Auto Database</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<h1>Tracking Autos for <?php echo htmlentities($_REQUEST['name']);?></h1>
<?php
// Note triple not equals and think how badly double
// not equals would work here...
if ( $failure !== false ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
}
if ( $success !== false ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: green;">'.htmlentities($success)."</p>\n");
}
?>
<form method="post">
    <p>Make:
    <input type="text" name="make" size="60">
    </p>
    <p>Year:
    <input type="text" name="year">
    </p>
    <p>Mileage:
    <input type="text" name="mileage">
    </p>
    <input type="submit" name="add" value="Add">
    <input type="submit" name="logout" value="Logout">
</form>
<?php
    echo "<h2> Automobiles </h2>";
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

</div>
</body>
</html>
