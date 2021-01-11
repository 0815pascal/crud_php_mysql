<?php
  session_start();
  require_once "pdo.php";
?>
<html>
  <head>
    <title>Pascal Witzig - Autos Database</title>
  </head>
  <body>
  <h1>Welcome to Autos Database</h1>
  <?php
    if(isset($_SESSION['success'])){
      echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
      unset($_SESSION['success']);
    }
  ?>
    <?php
      $stmt = $pdo->query("SELECT auto_id, make, model, year, mileage FROM autos");
      $numberOfEntries = $stmt->rowCount();
      if(isset($_SESSION['name'])){
        if($numberOfEntries > 0) {
          echo "<h2>Automobiles</h2>";

          if(isset($_SESSION['error'])){
            echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
            unset($_SESSION['error']);
          }

          echo "<table border='1'>";
          echo "<tr><th>Make</th><th>Model</th><th>Year</th><th>Mileage</th><th>Action</th>";
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
        echo '<p><a href="add.php">Add New Entry</a></p>';
        echo '<p><a href="logout.php">Logout</a></p>';
      }      
    ?>

    <?php
      if(!isset($_SESSION['name'])) {
        echo '<p><a href="login.php">Please log in</a></p>';
        echo '<p>Attempt to <a href="add.php">add data</a> without logging in</p>';
      } 
    ?>
  </body>
</html>
