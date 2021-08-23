<?php 
require('./DBMethods/Validation.php');

# INCLUDE TO PREVENT NOTICE WARNINGS FROM SHOWING 
$Email = isset($_POST['Email']) ? $_POST['Email'] : '';
$Password = isset($_POST['Password']) ? $_POST['Password'] : '';
$submit = isset($_POST['submit']) ? $_POST['submit'] : '';

if($submit)
{
    if($Email != null || '' && $Password != null || '')
    {
            # SAVE VALUES TO SESSION IN ORDER TO VALIDATE IN DB
            $_SESSION['Email'] = $_POST['Email'];
            $_SESSION['Password'] = $_POST['Password'];

            # CALL NEW INSTANCE OF DB CLASS AND VALIDATE 
            $DatabaseMethods = new DBMethods();
            $DatabaseMethods->ValidateUser($conn, $_POST['Email'], $_POST['Password']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico" />

    <title>The Gallery</title>

    <link
      rel="canonical"
      href="https://getbootstrap.com/docs/4.0/examples/floating-labels/"
    />

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="floating-labels.css" rel="stylesheet" />
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous"
    />
  </head>

  <body>
    <form class="form-signin" method="POST">
      <div class="text-center mb-4">
        <img
          class="mb-4"
          src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg"
          alt=""
          width="72"
          height="72"
        />
        <h1 class="h3 mb-3 font-weight-normal">The Gallery</h1>
        <p>
          Access the Gallery Provided your Account Exists
          <code>:placeholder-shown</code> pseudo-element.
          <a href="https://caniuse.com/#feat=css-placeholder-shown"
            >Works in latest Chrome, Safari, and Firefox.</a
          >
        </p>
      </div>

      <div class="form-label-group">
        <input
            name="Email"
            type="email"
            id="inputEmail"
            class="form-control"
            placeholder="Email address"
            required
            autofocus
        />
        <label for="inputEmail">Email address</label>
      </div>

      <div class="form-label-group">
        <input
            name="Password"
            type="password"
            id="inputPassword"
            class="form-control"
            placeholder="Password"
            required
        />
        <label for="inputPassword">Password</label>
      </div>

      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me" /> Remember me
        </label>
      </div>
        <input class="Grey Quarter Boxshadow" name="submit" type="submit" value="SIGN IN"/>
    

        <div class="form-label-group">
            <a href="./RegisterAccount/index.php">Register an Account</a>
        </div>
        
        <p class="mt-5 mb-3 text-muted text-center">&copy; 2020-2025</p>
    </form>

    <script
      src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
      integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
      integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
      integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
