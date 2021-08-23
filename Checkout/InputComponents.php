<?php

    $CardHolderName = '   
        <div class="col-md-6 mb-3">
            <label for="cc-name">Name on card</label>
            <input type="text" class="form-control" id="cc-name" placeholder="" required>
            <small class="text-muted">Full name as displayed on card</small>
            <div class="invalid-feedback">
            Name on card is required
            </div>
        </div>
    ';

    $CreditCardNumber = '
       <div class="col-md-6 mb-3">
            <label for="cc-number">Credit card number</label>
            <input type="text" class="form-control" id="cc-number" placeholder="" required>
            <div class="invalid-feedback">
            Credit card number is required
            </div>
        </div>
    ';
                 
    $ExpirationAndSpecialCode = '
    
        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="cc-expiration">Expiration</label>
                <input type="text" class="form-control" id="cc-expiration" placeholder="" required>
                <div class="invalid-feedback">
                Expiration date required
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <label for="cc-expiration">CVV</label>
                <input type="text" class="form-control" id="cc-cvv" placeholder="" required>
                <div class="invalid-feedback">
                Security code required
                </div>
            </div>
        </div>
    ';

    var_dump($_SESSION["value"]["Checkout"]);
if(!!$_SESSION["value"]["Checkout"])
{
    $BasketItems = join(",", $_SESSION["value"]["Checkout"]);    
    # PUT TOGETHER FILTER OPTIONS AND CREATE SEARCH PARAMETER
    $ARR_Data['sql'] = '
        SELECT * FROM vehiclemarket
        WHERE Vehicle_ID IN (' . $BasketItems . ')
    
    ';


    $ARR_Data['ClassSwitchMethod'] = new ClassSwitch();
    # CALL NEW INSTANCE OF DB CLASS AND VALIDATE 
    $ARR_Data['DatabaseMethods'] = new DBMethods();


    $ARR_Data['LoadDBVehicles'] = $ARR_Data['DatabaseMethods']->GrabMarketPlaceVehicles($conn, $ARR_Data['sql']);


    # COLLECT THE ARRAY OF BASKET ITEMS AND STORE IN STATIC ARRAY TO PASS TO JS 
    $ARR_Data['TotalPrice'] = [];

    if ($ARR_Data['LoadDBVehicles'] -> num_rows > 0) 
    {
        $ARR_Data['DisplayCheckoutItems'] = '';
        $SetDescriptionLength = 40;
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

            

            $TrimmedDescription = substr($ARR_Data['VehicleDescription'], 0, $SetDescriptionLength);

            if(strlen($ARR_Data['VehicleDescription']) > $SetDescriptionLength)
            {
                $ARR_Data['DisplayVehicleDescription'] = $TrimmedDescription;
            }
            else
            {
                    $ARR_Data['DisplayVehicleDescription'] = $ARR_Data['VehicleDescription'];
            }
            
            
            $ARR_Data['DisplayCheckoutItems'] .= '
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">' . $ARR_Data['VehicleModel'] . ' </h6>
                        <small class="text-muted">' . $ARR_Data['DisplayVehicleDescription'] . '</small>
                    </div>
                    <span class="text-muted">£' . $ARR_Data['VehiclePrice'] . '</span>
                </li>
            ';

            array_push($ARR_Data['TotalPrice'], $ARR_Data['VehiclePrice']);
        }
    }

    $ARR_Data['Total'] = array_sum($ARR_Data['TotalPrice']);
}
    ?>

                   