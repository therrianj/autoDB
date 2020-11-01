
<?php
session_start();

if ( ! isset($_SESSION['email'] ) ) {
    
    die ("ACCESS DENIED");
    return;
}
if ( isset($_POST['cancel']) ) {
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
            $_SESSION['error'] = "Mileage and year must be numeric";
        	header('location: add.php');
        	return;

        } elseif (strlen($_POST['make'])<1 || strlen($_POST['model'])<1) {
           $_SESSION['error'] = "Make and Model is required";
           header('location: add.php');
        	return;
        } 
        else{

            $sql = "INSERT INTO autos (make, model, year, mileage) 
                      VALUES (:make, :model, :year, :mileage)";

            // echo("<pre>\n".$sql."\n</pre>\n");

            $stmt = $pdo->prepare($sql);

            $make = ($_POST['make']);
            $model = ($_POST['model']);
            $year = ($_POST['year']);
            $mileage = ($_POST['mileage']);

            $stmt->execute(array(       
                ':make' => $make,
                ':model' => $model,
                ':year' => $year,
                ':mileage' => $mileage)
            );
   //          $stmt = $pdo->query("SELECT make, year, mileage FROM autos");
			// $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION['success'] = "Record inserted";
            header('location: index.php');
        	return;

        }
    //          $_SESSION['stmt'] = $pdo->query("SELECT make, year, mileage FROM autos");
			// $_SESSION['rows'] = $stmt->fetchAll(PDO::FETCH_ASSOC);     
}

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
// Note triple not equals and think how badly double
// not equals would work here...
if ( isset($_SESSION['error']) ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}
?>
<form method="post">
    <p>Make:
    <input type="text" name="make" size="60">
    </p>
    <p>Model:
    <input type="text" name="model" size="60">
    </p>
    <p>Year:
    <input type="text" name="year">
    </p>
    <p>Mileage:
    <input type="text" name="mileage">
    </p>
    <input type="submit" name="add" value="Add">
    <input type="submit" name="cancel" value="Cancel">
</form>