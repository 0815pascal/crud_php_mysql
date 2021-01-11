<?php
    session_start();
    require_once "pdo.php";
    
    if ( ! isset($_SESSION['name']) ) {
        die('ACCESS DENIED');
    }

    if(isset($_POST['cancel'])){
        header('Location:index.php');
        return;
    }

    // Load values
    $stmt = $pdo->prepare('SELECT make, model, year, mileage, auto_id FROM autos where auto_id = :autos_id');
    $stmt->execute(array(':autos_id' => $_GET['autos_id']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row === false) {
        $_SESSION['error'] = 'Bad value for id';
        header('Location: index.php');
        return;
    }

    // Data validation
    if(!empty($_POST)){
        if(!empty($_POST['make']) && !empty($_POST['model']) && !empty($_POST['year'])
        && !empty($_POST['mileage'])) {

        // Update values
        $sql = "UPDATE autos SET make = :make, model = :model, year = :year, mileage = :mileage
        WHERE auto_id = :auto_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':make' => $_POST['make'],
            ':year' => $_POST['year'],
            ':mileage' => $_POST['mileage'],
            ':model' => $_POST['model'],
            'auto_id' => $_POST['autos_id']));
        $_SESSION['success'] = 'Record edited';
        header('Location: index.php');
        return;
        } else {
            $_SESSION['error'] = "All fields are required";
            header("Location: edit.php?autos_id=".$_POST['autos_id']);
            return;
        }
    }
?>

<!-- View -->
<?php
    $make = htmlentities($row['make']);
    $model = htmlentities($row['model']);
    $year = htmlentities($row['year']);
    $mileage = htmlentities($row['mileage']);
    $auto_id = $row['auto_id'];
?>
<html>
    <body>
        <h1>Editing Automobile</h1>
        <?php 
        if ( isset($_SESSION['error']) ) {
            echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
            unset($_SESSION['error']);
        }
        ?>
        <form method="post">
            <p>Make <input type="text" name="make" value="<?= $make ?>" /></p>
            <p>Model <input type="text" name="model" value="<?= $model ?>" /></p>
            <p>Year <input type="text" name="year" value="<?= $year ?>" /></p>
            <p>Mileage <input type="text" name="mileage" value="<?= $mileage ?>" /></p>
            <input type="hidden" name="autos_id" value="<?= $auto_id ?>" />
            <input type="submit" value="Save" name="save"/>
            <input type="submit" value="cancel" name="cancel"/>
        </form>
    </body>
</html>