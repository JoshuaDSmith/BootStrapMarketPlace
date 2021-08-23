<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

require('../DBMethods/Validation.php');
require('../ClassMethods/ClassSwitch.php');

$ARR_Data['ClassSwitchMethod'] = new ClassSwitch();
# CALL NEW INSTANCE OF DB CLASS AND VALIDATE 
$ARR_Data['DatabaseMethods'] = new DBMethods();

$ARR_Data['sql'] = '
    SELECT * FROM vehiclemarket
';
$ARR_Data['conn'] = $conn;


function FetchVehicleInformation($ARR_Data)
{
    
    $ARR_Data['DisplayCards'] = '';
    $ARR_Data['AdditionalVehicles'] = [];
    $ARR_Data['AdditionalVehicleBio'] = [];
    $OBJ_CoverLeadInformationSelect = $ARR_Data['DatabaseMethods'] -> GrabMarketPlaceVehicles($ARR_Data['conn'], $ARR_Data['sql']);
    for ($i = 0; $i < $OBJ_CoverLeadInformationSelect -> num_rows; $i+=1)
    {
        $OBJ_CoverLeadInformationRow = $OBJ_CoverLeadInformationSelect -> fetch_object();
        # SET RETURN VALUES TO VARIABLES 
        $ARR_Data['VehicleOwners'] = $OBJ_CoverLeadInformationRow -> Vehicle_Owners;
        $ARR_Data['VehiclePrice'] = $OBJ_CoverLeadInformationRow -> Vehicle_Price;
        $ARR_Data['VehicleImage'] = $OBJ_CoverLeadInformationRow -> Vehicle_Image;
        $ARR_Data['VehicleColor'] = $OBJ_CoverLeadInformationRow -> Vehicle_Color;
        $ARR_Data['VehicleStock'] = $OBJ_CoverLeadInformationRow -> Vehicle_Stock;
        $ARR_Data['VehicleMPG'] = $OBJ_CoverLeadInformationRow -> Vehicle_MPG;
        $ARR_Data['VehicleName'] = $OBJ_CoverLeadInformationRow -> VehicleMake_Name;
        $ARR_Data['VehicleModel'] = $OBJ_CoverLeadInformationRow -> VehicleMake_Model;
        $ARR_Data['VehicleDescription'] = $OBJ_CoverLeadInformationRow -> Vehicle_Description;
            
            # FORMAT
            $ARR_Data['VehicleColor'] = $ARR_Data['ClassSwitchMethod'] -> CarColorSwitch($ARR_Data['VehicleColor']);
            $ARR_Data['VehicleBrand'] = $ARR_Data['ClassSwitchMethod'] -> CarBrandSwitch($ARR_Data['VehicleName']);

            $SetDescriptionLength = 160;

            $TrimmedDescription = substr($ARR_Data['VehicleDescription'], 0, $SetDescriptionLength);

            if($ARR_Data['VehicleDescription'] > $SetDescriptionLength)
            {
                $ARR_Data['DisplayVehicleDescription'] = $TrimmedDescription . ' ' . '<button class="btn btn-sm btn-outline-secondary"> READ MORE</button>';
            }
            else
            {
                    $ARR_Data['DisplayVehicleDescription'] = $ARR_Data['VehicleDescription'];
            }
            
            if($i < 3 )
            {
                $ARR_Data['DisplayCards'] .= '   
                    <div class="col-lg-4">
                        <img class="rounded-circle" src="../'. $ARR_Data['VehicleImage'] .'" alt="Generic placeholder image" width="140" height="140">
                        <h2>' . $ARR_Data['VehicleBrand'] . ' ' . $ARR_Data['VehicleModel'] . '</h2>
                        <p>MPG: ' . $ARR_Data['VehicleMPG'] . ' | ' . $ARR_Data['VehicleColor'] .' | Prev Owners: '. $ARR_Data['VehicleOwners'] .'</p>
                        <p>' . $ARR_Data['DisplayVehicleDescription'] . '</p>
                        <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>
                    </div>
                ';
            }

           
            if($i > 4 && $i <= 7 )
            {
                    array_push($ARR_Data['AdditionalVehicles'], $ARR_Data['VehicleImage']);
                    array_push($ARR_Data['AdditionalVehicleBio'], $ARR_Data['DisplayVehicleDescription']); 
                    
                
            }
            
            
    }

    # RETURN ARR_DATA
    return $ARR_Data;
}


$ARR_Data = FetchVehicleInformation($ARR_Data);




require('../HeaderBar/index.php');
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Carousel Template for Bootstrap</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/carousel/">

    <!-- Bootstrap core CSS -->
    <!-- <link href="../../dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="../Homepage/index.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <!-- Custom styles for this template -->
    <link href="carousel.css" rel="stylesheet">

    
  </head>
  <body>
    <main role="main">

      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="first-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="First slide">
            <div class="container">
              <div class="carousel-caption text-left">
                <h1>Example headline.</h1>
                <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                <p><a class="btn btn-lg btn-primary" href="#" role="button">Sign up today</a></p>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img class="second-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Second slide">
            <div class="container">
              <div class="carousel-caption">
                <h1>Another example headline.</h1>
                <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img class="third-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Third slide">
            <div class="container">
              <div class="carousel-caption text-right">
                <h1>One more for good measure.</h1>
                <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                <p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p>
              </div>
            </div>
          </div>
        </div>




        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>


      <!-- Marketing messaging and featurettes
      ================================================== -->
      <!-- Wrap the rest of the page in another container to center all the content. -->

      <div class="container marketing">

        <!-- Three columns of text below the carousel -->
        <div class="row">
          <?php echo $ARR_Data['DisplayCards'];?>
        </div><!-- /.row -->


        <!-- START THE FEATURETTES -->

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7">
            <h2 class="featurette-heading">First featurette heading. <span class="text-muted">It'll blow your mind.</span></h2>
            <p class="lead"><?php echo $ARR_Data['AdditionalVehicleBio'][0];?></p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto" src="../<?php echo $ARR_Data['AdditionalVehicles'][0];?>" alt="Generic placeholder image">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7 order-md-2">
            <h2 class="featurette-heading">Oh yeah, it's that good. <span class="text-muted">See for yourself.</span></h2>
            <p<p class="lead"><?php echo $ARR_Data['AdditionalVehicleBio'][0];?></p>
          </div>
          <div class="col-md-5 order-md-1">
            <img class="featurette-image img-fluid mx-auto" src="../<?php echo $ARR_Data['AdditionalVehicles'][1];?>" alt="Generic placeholder image">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7">
            <h2 class="featurette-heading">And lastly, this one. <span class="text-muted">Checkmate.</span></h2>
            <p class="lead"><?php echo $ARR_Data['AdditionalVehicleBio'][0];?></p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto" src="../<?php echo $ARR_Data['AdditionalVehicles'][2];?>" alt="Generic placeholder image">
          </div>
        </div>

        <hr class="featurette-divider">

        <!-- /END THE FEATURETTES -->

      </div><!-- /.container -->


      <!-- FOOTER -->
      <footer class="container">
        <p class="float-right"><a href="#">Back to top</a></p>
        <p>&copy; 2017-2018 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
      </footer>
    </main>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  
    <!-- <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script> -->
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>

  </body>
</html>
