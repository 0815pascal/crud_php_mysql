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
<!doctype html>
<html lang="en">
  <head>
    <?php require_once "head.php"; ?>
    <title>Pascal Witzig - Autos Database</title>
  </head>
  <body class="d-flex align-items-center">
    <div class="w-25 container shadow p-3 mb-5 bg-white rounded ">

      <h3>Please Log In</h3>
      <?php 
        if ( isset($_SESSION['error']) ) {
          alert(htmlentities($_SESSION['error']), "alert-danger");
          unset($_SESSION['error']);
        }
      ?>
      <form method="post">
        <p>
          <label for ="email" class="form-label">User name</label>
          <input name="email" id="email" type="text" class="form-control"/>
        </p>
        <p> 
          <label for ="pass" class="form-label">Password</label>
          <input name="pass" id="pass" type="text" class="form-control"/>
        </p>
        <button type="submit" name="submit" class="btn btn-primary">Log In</button>
        <button type="reset" class="btn btn-secondary">Cancel</button>
      </form>
      <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
      <strong>Hint:</strong> Enter a random email-address for user name and use password <code>php123</code>.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
  </body>
</html>
