<?php
    session_start();
    require_once "pdo.php";
    if ( ! isset($_SESSION['name']) ) {
        die('ACCESS DENIED');
    }
    if(isset($_POST['cancel'])){
        header('Location: index.php');
    }

    if(isset($_POST['delete']) && isset($_POST['auto_id'])) {
        $sql = "DELETE FROM autos WHERE auto_id = :zip";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':zip' => $_POST['auto_id']));
        $_SESSION['success'] = 'Record deleted';
        header('Location: index.php');
        return;
    }

    // Guardian: Make sure that user_id is present
    if(!isset($_GET['autos_id'])) {
        $_SESSION['error'] = 'Missing autos_id';
        header('Location: index.php');
        return;
    }

    $stmt = $pdo->prepare('SELECT make, auto_id FROM autos where auto_id = :autos_id');
    $stmt->execute(array(':autos_id' => $_GET['autos_id']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row === false) {
        $_SESSION['error'] = 'Bad value for autos_id';
        header('Location: index.php');
        return;
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <?php require_once "head.php"; ?>
        <title>Delete <?= htmlentities($row['make']) ?>?</title>
    </head>
    <body class="d-flex align-items-center">
        <div class="w-25 container shadow p-3 mb-5 bg-white rounded ">
            <p>Please Confirm: <b>Deleting <?= htmlentities($row['make']) ?></b></p>

            <form method="post">
                <input type="hidden" name="auto_id" value="<?= $row['auto_id'] ?>">
                <input type="submit" value="Delete" name="delete" class="btn btn-primary">
                <input type="submit" value="Cancel" name="cancel" class="btn btn-secondary">
            </form>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    </body>
</html>