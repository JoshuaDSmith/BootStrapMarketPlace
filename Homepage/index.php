<?php
session_start();

require('../DBMethods/Validation.php');
require('../ClassMethods/ClassSwitch.php');


$_COOKIE['myJavascriptVar'];
$_SESSION["value"]["Checkout"] = [];
 
array_push($_SESSION["value"]["Checkout"], $_COOKIE['myJavascriptVar']);


// var_dump($_COOKIE['myJavascriptVar']);
print_r($_SESSION["value"]["Checkout"]);



# CHECK WHETHER FILTER SELECTION HAS BEEN MADE IF SO, UPDATE DATABASE CALL
if(isset($_POST['submitFilterSearch']))
{

    var_dump($_POST['PriceRangeBar']);
    # BUILD COLOR FILTER
    if(!empty($_POST['Coloroptions']))
    {
    
        $ARR_Data['Coloroptions'] = [];
        # PUSH ARRAY TO SESSION TO USE FOR VEHICLE FILTER OPTIONS 
        foreach($_POST['Coloroptions'] as $value)
        {
        
            array_push($ARR_Data['Coloroptions'], $value); 
        }  

        $VehiclesColorSQLParameter = join(",", $ARR_Data['Coloroptions']);    
    }
    else
    {
        $VehiclesColorSQLParameter = '1,2,3,4';
    }

    # BUILD OWNERSHIP FILTER
    if(!empty($_POST['Owneroptions']))
    {
    
        $ARR_Data['Owneroptions'] = [];
        # PUSH ARRAY TO SESSION TO USE FOR VEHICLE FILTER OPTIONS 
        foreach($_POST['Owneroptions'] as $value)
        {
        
            array_push($ARR_Data['Owneroptions'], $value); 
        }  

        $VehiclesOwnershipSQLParameter = join(",", $ARR_Data['Owneroptions']);    
    }
    else
    {
         $VehiclesOwnershipSQLParameter = '1,2,3';
    }
    
    
    # BUILD OWNERSHIP FILTER
    if(!empty($_POST['PriceRangeBar']))
    {
        $VehiclesPriceRangeBarSQLParameter = $_POST['PriceRangeBar'];    
    }
    else
    {
         $VehiclesPriceRangeBarSQLParameter = '100000';
    }



    # PUT TOGETHER FILTER OPTIONS AND CREATE SEARCH PARAMETER
      $ARR_Data['sql'] = '
            SELECT * FROM vehiclemarket
            WHERE Vehicle_Color IN (' . $VehiclesColorSQLParameter . ')
            AND Vehicle_Owners IN (' . $VehiclesOwnershipSQLParameter .') 
            AND Vehicle_Price <= ' . $VehiclesPriceRangeBarSQLParameter . '
        ';


}  
else
{
    
    $ARR_Data['sql'] = '
        SELECT * FROM vehiclemarket
    ';
}

var_Dump($ARR_Data['sql'] );

$ARR_Data['ClassSwitchMethod'] = new ClassSwitch();
# CALL NEW INSTANCE OF DB CLASS AND VALIDATE 
$ARR_Data['DatabaseMethods'] = new DBMethods();
$ARR_Data['LoadDBVehicles'] = $ARR_Data['DatabaseMethods']->GrabMarketPlaceVehicles($conn, $ARR_Data['sql']);



# SET VARIABLES TO BE USED ACROSS THE PAGE
$ARR_Data['DisplayCards'] = '';
$ARR_Data['ColorRadio'] = '';
$ARR_Data['PreviousOwnersRadio'] = '';


function FetchVehicleInformation($ARR_Data)
{
    if ($ARR_Data['LoadDBVehicles'] -> num_rows > 0) 
    {
        while($row = $ARR_Data['LoadDBVehicles']->fetch_assoc()) 
        {
            # SET RETURN VALUES TO VARIABLES 
            $ARR_Data['VehicleOwners'] = $row['Vehicle_Owners'];
            $ARR_Data['VehiclePrice'] = $row['Vehicle_Price'];
            $ARR_Data['VehicleImage'] = $row['Vehicle_Image'];
            $ARR_Data['VehicleColor'] = $row['Vehicle_Color'];
            $ARR_Data['VehicleStock'] = $row['Vehicle_Stock'];
            $ARR_Data['VehicleMPG'] = $row['Vehicle_MPG'];
            $ARR_Data['VehicleName'] = $row['VehicleMake_Name'];
            $ARR_Data['VehicleModel'] = $row['VehicleMake_Model'];
            $ARR_Data['VehicleDescription'] = $row['Vehicle_Description'];
            
            # FORMAT
            $ARR_Data['VehicleColor'] = $ARR_Data['ClassSwitchMethod'] -> CarColorSwitch($ARR_Data['VehicleColor']);
            $ARR_Data['VehicleBrand'] = $ARR_Data['ClassSwitchMethod'] -> CarBrandSwitch($ARR_Data['VehicleName']);

            $SetDescriptionLength = 160;

            $TrimmedDescription = substr($ARR_Data['VehicleDescription'], 0, $SetDescriptionLength);

            if(strlen($ARR_Data['VehicleDescription']) > $SetDescriptionLength)
            {
                $ARR_Data['DisplayVehicleDescription'] = $TrimmedDescription . ' ' . '<button class="btn btn-sm btn-outline-secondary"> READ MORE</button>';
            }
            else
            {
                    $ARR_Data['DisplayVehicleDescription'] = $ARR_Data['VehicleDescription'];
            }
            
            $SelectVehicleArray = json_encode($row);
    
            $ARR_Data['DisplayCards'] .= "   
                <div class='card border mb-4 bg-light'>
                    <img class='card-img-top' src='../" . $ARR_Data['VehicleImage'] ."' alt='Card image cap'>
                        <div class='card-body'>
                        <h4>" . $ARR_Data['VehicleBrand'] . " "  . $ARR_Data['VehicleModel'] . "</h4>
                        <p>" . $ARR_Data['DisplayVehicleDescription'] . "</p>
                        <p>MPG: " . $ARR_Data['VehicleMPG'] . " | " . $ARR_Data['VehicleColor'] . " | Prev Owners: ". $ARR_Data['VehicleOwners'] . "</p>
                            <div class='d-flex justify-content-between align-items-center'>
                                <div class='btn-group'>
                                    <button type='button' class='btn btn-outline-secondary' data-toggle='modal' data-target='#exampleModalCenter' onclick='SelectVehicleToModal($SelectVehicleArray)'>View More </button>
                                </div>
                                <small class='text-muted'>9 mins</small>
                            </div>
                        </div>
                    </div>
            ";
        }
    }

    # RETURN ARR_DATA
    return $ARR_Data;
}


function FetchCreateVehicleFilterOptions($ARR_Data)   
{
     $ARR_RadioID = ['red','green','blue','grey', 'white', 'black'];
     $ARR_RadioIDValue = ['1','2','3','4', '5', '6'];
   

    for($i=0;$i <=5;$i++)
    {
            $ARR_Data['ColorRadio'] .= ' 
                <div class="col-sm-1">
                    <input type="checkbox" class="form-check-check" name="Coloroptions[]" id="' . $ARR_RadioID[$i] . '" value="' . $ARR_RadioIDValue[$i] . '" autocomplete="off">
                    <label class=" border form-check-label' . $ARR_RadioID[$i] . '" for="' . $ARR_RadioID[$i] . '">' . $ARR_RadioID[$i]  . '</label>
                </div>
            ';
        
        if($i < 3)
        {
            $IndexNotZero = $i + 1;
            $ARR_Data['PreviousOwnersRadio'] .= ' 
                <div class="col-sm-2">
                    <input type="checkbox" class="form-check-check" name="Owneroptions[]" id="' . $IndexNotZero . '" value="' . $IndexNotZero . '" autocomplete="off">
                    <label class=" border form-check-label' . $IndexNotZero . '" for="' . $IndexNotZero . '"> ' . $IndexNotZero . '</label>
                </div>
            ';
        }
    }

    # RETURN ARR_DATA
    return $ARR_Data;

}

# INVOKE FUNCTION 1
$ARR_Data = FetchVehicleInformation($ARR_Data);

# INVOKE FUNCTION 2
$ARR_Data = FetchCreateVehicleFilterOptions($ARR_Data);


?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title></title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We"
      crossorigin="anonymous"
    /> -->
     <link rel="stylesheet" href="./index.css">
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="canonical" href="./navbar.css">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script> <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <link href="index.css" rel="stylesheet">
  </head>

  <body>
       <header>
            <div class="collapse bg-dark" id="navbarHeader">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-md-7 py-4">
                        <h4 class="text-white">Provision</h4>
                        <p class="text-muted">Add some information about the album below, the author, or any other background context. Make it a few sentences long so folks can pick up some informative tidbits. Then, link them off to some social networking sites or contact information.</p>
                    
                    
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="#">Dashboard <span class="sr-only">(current)</span></a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="../Profile/index.php">Profile</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link disabled" href="#">Market Place</a>
                            </li>

                             <li class="nav-item">
                                <a class="nav-link" href="../Checkout/index.php">Basket</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#">Settings</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                                <div class="dropdown-menu" aria-labelledby="dropdown03">
                                    <a class="dropdown-item" href="#">Add New Vehicle</a>
                                    <a class="dropdown-item" href="#">Edit Vehicle</a>
                                </div>
                            </li>

                        </ul>

                        <form class="form-inline my-2 my-md-0">
                            <input class="form-control" type="text" placeholder="Search">
                        </form>
                    </div>
                    <div class="col-sm-4 offset-md-1 py-4">
                        <h4 class="text-white">Contact</h4>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-white">Follow on Twitter</a></li>
                            <li><a href="#" class="text-white">Like on Facebook</a></li>
                            <li><a href="#" class="text-white">Email me</a></li>
                        </ul>

                    
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar navbar-dark bg-dark box-shadow">
            <div class="container d-flex justify-content-between">
            <a href="#" class="navbar-brand d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                <strong>Album</strong>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            </div>
        </div>
    </header>


    <main class="pt-md-5" style="padding-bottom: 50px;"role="main">
        <div id='Login-Success'></div>
        <div class="container justify-content-start">

             <form method="post" class="row">
                <span onclick="ShowColorOptions()" class="w-25 border bg-dark text-white display-6"> SELECT COLOR</span>
                   
                        <div class="px-3 py-3 pt-md-5 mx-auto border" id="ColorSelection" style="display:none;">
                            <div class="row w-50 justify-content-between">
                                <?php echo $ARR_Data['ColorRadio'];?>
                            </div>

                           
                        </div>
                
                </span>

                <span onclick="ShowPreviousOwners()" class="w-25 border bg-dark text-white display-6">OWNERS</span>
                    <div class="pt-md-5 border" id="OwnerSelection" style="display:none;">
                        <div class="row w-50">
                            <?php echo $ARR_Data['PreviousOwnersRadio'];?>
                        </div>
                    </div>
                </span>

                <span onclick="ShowPriceRangeDisplay()" class="w-25 border bg-dark text-white display-6">PRICE</span>
                    <div class="row" id="PriceRangeSelection" style="display:none;">
                       
                    <div class="col-sm-1">
                        <p class="w-25"> Min</p>
                    </div>

                        <div class="col-sm-1 w-25">
                            <label id="RangeBarDisplay" for="customRange2"  class="form-label">Price</label>
                            <input type="range" class="form-range" min="4000" max="100000" id="PriceRangeBar" name="PriceRangeBar">
                        </div>

                        <p class="col-sm-1"> Max </p>

                    </div>
                </span>
                 <div class="pt-md-5">
                    <input class="btn btn-sm btn-outline-secondary" name="submitFilterSearch" type="submit" value="Apply Filter"/>
                </div>
            </form>


            <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
                <?php echo $ARR_Data['DisplayCards'];?>
            </div>
        </div>
    </main>

    
<!-- MODEL CONTENT -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <span class="">
                <image src="" id="ModalImage" style='width: 400px;height:300px;'></image>
        </span>
<!-- 
        <div id="myModal">
             
            <p> test</p>
        
            <span class="Column p60 Center">
                <table class="Center padding ">
                    <tr>
                        <th>Price</th>
                        <th>MPG</th>
                        <th>Color</th>
                        <th>Stock Available</th>
                    </tr>
                    <tr id="tableContent">
                      
                    </tr>  
                 <p>test</p>

                </table>
       
        </div>
        -->
      <div class="modal-footer">
       
             <p id="VehicleSelection" name='VehicleID' style='display: hidden;'></p>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <input id="SubmitSelection" class="btn btn-sm btn-outline-secondary" onclick='AddToBasket()' value="Add to Basket"/>
 
      </div>
    </div>
  </div>
</div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj"
      crossorigin="anonymous"
    ></script>
        
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <!-- <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script> -->

    <script>
        let SuccessMsg = '<?php echo $_SESSION["value"]['SuccessMsg'];?>';
        console.log(SuccessMsg);

         if(SuccessMsg == 1)
        {
            let ValidationErrBox = document.getElementById('Login-Success');
            ValidationErrBox.classList.add("alert-success");
            var HeaderMsg = document.createElement("H4");
            HeaderMsg.innerText = 'Successfully Logged In';
            HeaderMsg.classList.add("alert-heading");

            var ParagraphMsg = document.createElement("P");
            ParagraphMsg.classList.add("mb-0");
            ParagraphMsg.innerText = 'You are logged in';

            var Spacing = document.createElement("hr");

            ValidationErrBox.classList.add("row");
            var Ielement = document.createElement("I");
            Ielement.classList.add("bi-bag-x");
          

           
            ValidationErrBox.appendChild(HeaderMsg)
            ValidationErrBox.appendChild(Spacing)
            ValidationErrBox.appendChild(ParagraphMsg)
            ValidationErrBox.appendChild(Ielement);

             setTimeout(function()
             { 
                 ValidationErrBox.remove();
            }, 3000);
        }    
    </script>
    <script src="./index.js"></script>

  </body>
</html>
