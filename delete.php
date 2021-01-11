<?php
    session_start();
    require_once "pdo.php";

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
<html>
    <body>
        <p>Confirm: Deleting <?= htmlentities($row['make']) ?></p>

        <form method="post">
            <input type="hidden" name="auto_id" value="<?= $row['auto_id'] ?>">
            <input type="submit" value="Delete" name="delete">
            <a href="index.php">Cancel</a>
        </form>
    </body>
</html>