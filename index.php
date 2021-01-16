<?php
  session_start();
  require_once "pdo.php";
?>
<!doctype html>
<html lang="en">
  <head>
    <?php require_once "head.php"; ?>
    <title>Pascal Witzig - Autos Database</title>
  </head>
  <body class="h-100 pt-3 pb-3">
  <div class="container shadow p-3 mb-5 bg-white rounded w-50 h-100">
  <h1 class="mt-4">Welcome to Autos Database</h1>
  <?php

    if(isset($_SESSION['success'])){
      alert(htmlentities($_SESSION['success']), "alert-success");
      unset($_SESSION['success']);
    }
      $stmt = $pdo->query("SELECT auto_id, make, model, year, mileage FROM autos");
      $numberOfEntries = $stmt->rowCount();

      if(isset($_SESSION['name'])){
        if($numberOfEntries > 0) {
          echo ('<p class="mt-4">Hi '.htmlentities($_SESSION['name']).'</p>');
          echo "<p>Currently the following items are registered in your database:</p>";
          echo "<h3 class='mt-4'>Automobiles</h3>";

          if(isset($_SESSION['error'])){
            alert(htmlentities($_SESSION['error']), "alert-danger");
            unset($_SESSION['error']);
          }

          echo "<table class='table table-striped'>";
          echo "<thead></thead><tr><th>Make</th><th>Model</th><th>Year</th><th>Mileage</th><th>Action</th></thead>";
          while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            echo "<tr><td>";
            echo $row['make'];
            echo("</td><td>");
            echo $row['model'];
            echo("</td><td>");
            echo $row['year'];
            echo "</td><td>";
            echo $row['mileage'];
            echo "</td><td>";
            echo "<a href=\"edit.php?autos_id=".$row['auto_id']."\">Edit</a> / 
            <a href=\"delete.php?autos_id=".$row['auto_id']."\">Delete</a>";
            echo "</td></tr>\n";
          }
          echo "</table>";
        } else {
          echo '<p>No rows found</p>';
        }
        echo '<p><a href="add.php">Add New Entry</a> | ';
        echo '<a href="logout.php">Logout</a></p>';
      }      
    ?>

    <?php
      if(!isset($_SESSION['name'])) {
        echo '<p><a href="login.php">Please log in</a></p>';
        echo '<p>Attempt to <a href="add.php">add data</a> without logging in</p>';
      } 
    ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
  </body>
</html>
