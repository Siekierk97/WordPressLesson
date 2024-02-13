<?php


include('includes/database.php');
include('includes/config.php');
include('includes/functions.php');
include('includes/header.php');
// var dump is like console log
//var_dump($_POST);
// Query database only when our database has been submitted.

/* if variable $POST is set and our value email is real*/
if (isset($_POST['email'])){
  /* prepare our statement where it selects all from users where our values are = ?*/
    if ($stm = $connect->prepare('SELECT * FROM users WHERE email = ? AND password = ? AND active = 1')){
        $hashed = SHA1($_POST['password']);
        $stm->bind_param('ss', $_POST['email'], $hashed);
        $stm-> execute();

        $result = $stm->get_result();

        if ($user){
          $_SESSION['id'] = $user ['id'];
          $_SESSION['email'] = $user ['email'];
          $_SESSION['username'] = $user ['username'];

          // feedback / welcome message
          set_message("You have succesfully logged in  " . $_SESSION['username'] );
          header('location: dashboard.php');
          die(); 
        }
        $stm->close();
    } else {
      echo 'Could not Prepare Statment!';
    }
}
?>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <form method= "post">
        <!-- Email input -->
        <div class="form-outline mb-4">
          <input type="email" id="email" name="email" class="form-control" />
          <label class="form-label" for="Email">Email address</label>
        </div>

        <!-- Password input -->
        <div class="form-outline mb-4">
          <input type="password" id="password" name="password" class="form-control" />
          <label class="form-label" for="password">Password</label>
        </div>


        <!-- Submit button -->
        <button type="submit" class="btn btn-primary btn-block">Sign in</button>
      </form>
    </div>
  </div>
</div>


<?php
include('includes/footer.php');
?>