<?php
  session_start();

  $status = '';
  $salt = 'asl28xJw';
  $pw = $salt.'php123';
  $storedHash = hash('md5', $pw);

  if(isset($_POST['submit'])){
    if(empty($_POST['email']) || empty($_POST['pass'])){
      $_SESSION['error'] = 'User name and password are required';
      header("Location: login.php");
      return;
    }
    else if(strpos($_POST['email'], '@') === false){
      $_SESSION['error'] = 'Email must have an at-sign (@)';
      header("Location: login.php");
      return;
    }
    
    if(!isset($_SESSION['error'])){
      
      $check = hash('md5', $salt . htmlentities($_POST['pass']));
      if ($check === $storedHash) {
        error_log("Login success ".htmlentities($_POST['email']));
        $_SESSION['name'] = $_POST['email'];
        header('Location: index.php');
      } else {
        error_log("Login fail ".htmlentities($_POST['email'])." $check");
        $_SESSION['error'] = 'Incorrect password';
        header("Location: login.php");
        return;
      } 
    }
  }
  
?>

<html>
  <head>
    <title>Pascal Witzig - Autos Database</title>
  </head>
  <body>
  <h1>Please Log In</h1>
  <?php 
    if ( isset($_SESSION['error']) ) {
      echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
      unset($_SESSION['error']);
    }
  ?>
  <form method="post">
    <p>
      <label for ="email">User name</label>
      <input name="email" id="email" type="text"/>
    </p>
     <p> 
      <label for ="pass">Password</label>
      <input name="pass" id="pass" type="text" />
    </p>
    <button type="submit" name="submit">Log In</button>
    <button type="reset">Cancel</button>
  </form>
  </body>
</html>
