<?php 
session_start();
require('../DBMethods/Validation.php');

# INCLUDE TO PREVENT NOTICE WARNINGS FROM SHOWING 
$Email = isset($_POST['Email']) ? $_POST['Email'] : '';
$Password = isset($_POST['Password']) ? $_POST['Password'] : '';
$ConfirmPassword = isset($_POST['ConfirmPassword']) ? $_POST['ConfirmPassword'] : '';
$UserName = isset($_POST['UserName']) ? $_POST['UserName'] : '';
$FirstName = isset($_POST['FirstName']) ? $_POST['FirstName'] : '';
$LastName = isset($_POST['LastName']) ? $_POST['LastName'] : '';
$Occupation = isset($_POST['Occupation']) ? $_POST['Occupation'] : '';


$submit = isset($_POST['submit']) ? $_POST['submit'] : '';
$Inputs = '';

if($submit)
{
    if($Email != null || '' && $Password != null || '' && $ConfirmPassword != null || '' && $UserName != null || '' && $FirstName != null || '' && $LastName != null || '' && $Occupation != null || '')
    {
        if($Password !== $ConfirmPassword)
        {
            $PasswordError = 1;
            var_Dump('error');
        }
        else
        {

        }
            # SAVE VALUES TO SESSION IN ORDER TO VALIDATE IN DB
            // $_SESSION['Email'] = $Email;
            // $_SESSION['Password'] = $Password;
            // $_SESSION['UserName'] = $UserName;
            // $_SESSION['ConfirmPassword'] = $ConfirmPassword;
            // $_SESSION['UserName'] = $UserName;
            // $_SESSION['FirstName'] = $FirstName;
            // $_SESSION['Occupation'] = $Occupation;
            // $_SESSION['LastName'] = $LastName;

            $sql = "INSERT INTO userdetails (username,passwordChr,firstname,lastname,occupation,email)
            VALUES ('$UserName','$Password', '$FirstName', '$LastName', '$Occupation', '$Email')";
            # CALL NEW INSTANCE OF DB CLASS AND VALIDATE 
            $DatabaseMethods = new DBMethods();
            $result = $DatabaseMethods->InsertNewUser($conn, $sql,$Email, $Password);
    }
}

$ARR_InputTypes = ['text','text','text','email','text','password','password'];
$ARR_InputIDName = ['UserName','FirstName', 'LastName', 'Email', 'Occupation', 'Password','ConfirmPassword'];


if(isset($ARR_InputTypes))
{
    for($i=0;$i < count($ARR_InputTypes); $i++)
    {
        
        $Inputs .= '
            <div class="form-label-group">
                <input
                name="'. $ARR_InputIDName[$i] .'"
                type="'. $ARR_InputTypes[$i] .'"
                id="'. $ARR_InputIDName[$i] .'"
                class="form-control"
                placeholder="'. $ARR_InputIDName[$i] .'"
                required
                autofocus
                />
                <label for="inputEmail">'. $ARR_InputIDName[$i] .'</label>
            </div>
        
        
        ';
        
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" rel="stylesheet">

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
         <div id="ValidationError"></div>
        <?php echo $Inputs;?>
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me" /> Remember me
        </label>
      </div>
        <input class="Grey Quarter Boxshadow" name="submit" type="submit" value="SIGN UP"/>
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
    <script>
        let ValidationError = "<?php echo $result;?>";
        console.log(ValidationError);

        if(ValidationError == 2)
        {
            let ValidationErrBox = document.getElementById('ValidationError');

            ValidationErrBox.classList.add("alert-danger");
        
            ValidationErrBox.classList.add("row");
            var Ielement = document.createElement("I");
            Ielement.classList.add("bi-bag-x");
          
            //<i class="bi bi-bag-x"></i>
            ValidationErrBox.innerText = "This Email Address is Already Taken";
            //btn.href = "http://localhost/SESSION/templates/AddNewVehicle.php";
            //Span.appendChild(Ielement);
           
            
            ValidationErrBox.appendChild(Ielement);
        }
    </script>
  </body>
</html>
