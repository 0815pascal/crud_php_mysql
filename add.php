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
        $_SESSION['success'] = $_POST['make']." ".$_POST['model']." (".$_POST['year'].") has been added to your database";
        header("Location: index.php");
        return;
        
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <?php require_once "head.php"; ?>
        <title></title>
    </head>
    <body class="d-flex align-items-center">
        <div class="w-25 container shadow p-3 mb-5 bg-white rounded ">
            <?php 
                echo '<h1>Add New Item</h1>';
                if (isset($_SESSION['error'])) {
                    alert(htmlentities($_SESSION['error']), "alert-danger");
                    unset($_SESSION['error']);
                }
            ?>
            <form method="post">
                <p>
                <label for="make" class="form-label">Make</label>
                <input type="text" name="make" id="make" class="form-control"/>
                </p>
                <p>
                <label for="model" class="form-label">Model</label>
                <input type="text" name="model" id="model" class="form-control"/>
                </p>
                <p>
                <label for="year" class="form-label">Year</label>
                <input type="text" name="year" id="year" class="form-control"/>
                </p>
                <p>
                <label for="mileage" class="form-label">Mileage</label>
                <input type="text" name="mileage" id="mileage" class="form-control"/>
                </p>
                <p>
                <button type="submit" name="add" id="add" class="btn btn-primary">Add</button>
                <button type="submit" name="cancel" id="cancel" class="btn btn-secondary">Cancel</button>
            </form>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    </body>
</html>