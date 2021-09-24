<?php
require('../DBMethods/Validation.php');
require('../ClassMethods/ClassSwitch.php');
require('./InputComponents.php');
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Checkout example for Bootstrap</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/checkout/">

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="form-validation.css" rel="stylesheet">
    <link href="../Homepage/index.css" rel="stylesheet">
  </head>

  <body class="bg-light">

    <div class="container">
      <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h2>Checkout</h2>
        <p class="lead">Enter in Personal Information, Be mindful of submitting the correct information we will not be liable for lost purchases.</p>
      </div>

      <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Your cart</span>
            <span class="badge badge-secondary badge-pill">3</span>
          </h4>
          <ul class="list-group mb-3">
            <?php echo $ARR_Data['DisplayCheckoutItems']; ?>

            <li class="list-group-item d-flex justify-content-between">
              <span>Total (USD)</span>
              <strong>£<?php echo $ARR_Data['Total'];?></strong>
            </li>
          </ul>

          <form class="card p-2">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Promo code">
              <div class="input-group-append">
                <button type="submit" class="btn btn-secondary">Redeem</button>
              </div>
            </div>
          </form>
        </div>
        <div class="col-md-8 order-md-1">
          <h4 class="mb-3">Billing address</h4>
          <form class="needs-validation" novalidate>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="firstName">First name</label>
                <input type="text" class="form-control" id="firstName" placeholder="" value="" required>
                <div class="invalid-feedback">
                  Valid first name is required.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="lastName">Last name</label>
                <input type="text" class="form-control" id="lastName" placeholder="" value="" required>
                <div class="invalid-feedback">
                  Valid last name is required.
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="username">Username</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">@</span>
                </div>
                <input type="text" class="form-control" id="username" placeholder="Username" required>
                <div class="invalid-feedback" style="width: 100%;">
                  Your username is required.
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="email">Email <span class="text-muted">(Optional)</span></label>
              <input type="email" class="form-control" id="email" placeholder="you@example.com">
              <div class="invalid-feedback">
                Please enter a valid email address for shipping updates.
              </div>
            </div>

            <div class="row">
              <div class="col-md-5 mb-3">
                <label for="country">Country</label>
                <select id="CountrySelect" class="custom-select d-block w-100" id="country" required>
                  <option value="" disabled>Choose...</option>
                </select>
                <div class="invalid-feedback">
                  Please select a valid country.
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <label for="state">Region</label>
                <select id='RegionSelect' class="custom-select d-block w-100" id="state" required>
                  <option value="">Choose...</option>
              
                </select>
                <div class="invalid-feedback">
                  Please provide a valid state.
                </div>
              </div>

               <div class="col-md-3 mb-3">
                    <label for="searchBar">Post Code</label>
                    <input type="text" class="form-control" id="searchBar" required name="PostCode" placeholder='Postcode'/>
                    <ul id="DisplayPostCodes" class="p30 BorderRound" onclick="PopulateAddressField(1)"></ul>
                    <div class="invalid-feedback">
                         Post Code code required.
                    </div>
                    <ul id="HiddenPostCodeValue" style="display: none;"></ul>
                </div> 



            <div class="mb-3">
              <label for="address">Address</label>
              <input type="text" class="form-control" id="AddressLine1" placeholder="1234 Main St" required>
              <div class="invalid-feedback">
                Please enter your shipping address.
              </div>
            </div>

            <div class="mb-3">
              <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
              <input type="text" class="form-control" id="AddressLine2" placeholder="Apartment or suite">
            </div>
            </div>

         <hr class="mb-4">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="same-address">
              <label class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="save-info">
              <label class="custom-control-label" for="save-info">Save this information for next time</label>
            </div>
         <hr class="mb-4">

            <!--- SHIPPING ADDRESS -->
            
            <div>
            <h4 class="mb-3">Shipping address</h4>
        
             <div class="row">
              <div class="col-md-5 mb-3">
                <label for="country">Country</label>
                <select id="CountrySelect" class="custom-select d-block w-100" id="country" required>
                  <option value="" disabled>Choose...</option>
                </select>
                <div class="invalid-feedback">
                  Please select a valid country.
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <label for="state">Region</label>
                <select id='RegionSelect' class="custom-select d-block w-100" id="state" required>
                  <option value="">Choose...</option>
              
                </select>
                <div class="invalid-feedback">
                  Please provide a valid state.
                </div>
              </div>

               <div class="col-md-3 mb-3">
                    <label for="searchBarShipping">Post Code</label>
                    <input type="text" class="form-control" id="searchBarShipping" required name="PostCode" placeholder='Postcode'/>
                    <ul id="DisplayPostCodes" class="p30 BorderRound" onclick="PopulateAddressField(2)"></ul>
                    <div class="invalid-feedback">
                         Post Code code required.
                    </div>
                    <ul id="HiddenPostCodeValue" style="display: none;">Test to remove</ul>
                </div> 

                
                <div class="mb-3">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="AddressLine1" placeholder="1234 Main St" required>
                    <div class="invalid-feedback">
                        Please enter your shipping address.
                    </div>
                    </div>

                    <div class="mb-3">
                    <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
                    <input type="text" class="form-control" id="AddressLine2" placeholder="Apartment or suite">
                </div>
            </div>



            </div>



            <hr class="mb-4">

            <h4 class="mb-3">Payment</h4>

            <div class="d-block my-3">
              <div class="custom-control custom-radio">
                <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked required onclick=showDropDown(0)>
                <label class="custom-control-label" for="credit">Credit card</label>
              </div>
              <div class="custom-control custom-radio">
                <input id="debit" name="paymentMethod" type="radio" class="custom-control-input" required onclick=showDropDown(1)>
                <label class="custom-control-label" for="debit">Debit card</label>
              </div>
              <div class="custom-control custom-radio">
                <input id="paypal" name="paymentMethod" type="radio" class="custom-control-input" required onclick=showDropDown(2)>
                <label class="custom-control-label" for="paypal">Paypal</label>
              </div>
            </div>

            <div id="CreditCard"  style="display: block;" class="row">
                <div>
                    <i class="bi bi-bank2"></i>
               
                    <?php echo $CardHolderName;?>
                    <?php echo $CreditCardNumber;?>
                    <?php echo $ExpirationAndSpecialCode;?>
                </div>
            </div>

            
            <div id="DebitCard"  style="display: none;" class="row">
                <div>
                    <?php echo $CardHolderName;?>
                
                    <?php echo $ExpirationAndSpecialCode;?>
                </div>
            </div>

            
            <div id="PayPal"  style="display: none;" class="row">
                <div>
                 
                    <?php echo $ExpirationAndSpecialCode;?>
                </div>
            </div>


            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
          </form>
        </div>
      </div>

      <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2017-2018 Company Name</p>
        <ul class="list-inline">
          <li class="list-inline-item"><a href="#">Privacy</a></li>
          <li class="list-inline-item"><a href="#">Terms</a></li>
          <li class="list-inline-item"><a href="#">Support</a></li>
        </ul>
      </footer>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <script>
      // Example starter JavaScript for disabling form submissions if there are invalid fields
      (function() {
        'use strict';

        window.addEventListener('load', function() {
          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.getElementsByClassName('needs-validation');

          // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();
    </script>

    <script src="index.js"></script>

  </body>
</html>
