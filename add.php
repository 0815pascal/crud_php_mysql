<?php
    session_start();
    require_once "pdo.php";
    if ( ! isset($_SESSION['name']) ) {
        die('ACCESS DENIED');
    }
    if(isset($_POST['cancel'])){
        header('Location: index.php');
      }

    if(isset($_POST['add'])){

        if(empty($_POST['make']) || empty($_POST['model']) || 
            empty($_POST['year']) || empty($_POST['mileage'])){
            $_SESSION['error'] = "All fields are required";
            header("Location: add.php");
            return;
        } else if (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])){
            $_SESSION['error'] = "Mileage and year must be numeric";
            header("Location: add.php");
            return;
        }

        $stmt = $pdo->prepare('INSERT INTO autos
            (make, model, year, mileage) VALUES ( :mk, :md, :yr, :mi)');
        $stmt->execute(array(
            ':mk' => htmlentities($_POST['make']),
            ':md' => htmlentities($_POST['model']),
            ':yr' => htmlentities($_POST['year']),
            ':mi' => htmlentities($_POST['mileage']))
        );
        $_SESSION['success'] = "Record added";
        header("Location: index.php");
        return;
        
    }
?>
<html>
    <body>
    <?php 
        echo '<h1>Tracking Autos for ' . htmlentities($_SESSION['name']) . '</h1>';
        if (isset($_SESSION['error'])) {
            echo('<p style="color: red;">' . htmlentities($_SESSION['error']) . "</p>\n");
            unset($_SESSION['error']);
        }
    ?>
    <form method="post">
        <p>
        <label for="make">Make</label>
        <input type="text" name="make" id="make"/>
        </p>
        <p>
        <label for="model">Model</label>
        <input type="text" name="model" id="model"/>
        </p>
        <p>
        <label for="year">Year</label>
        <input type="text" name="year" id="year" />
        </p>
        <p>
        <label for="mileage">Mileage</label>
        <input type="text" name="mileage" id="mileage" />
        </p>
        <p>
        <button type="submit" name="add" id="add">Add</button>
        <button type="submit" name="cancel" id="cancel">Cancel</button>
    </form>
    </body>
</html>