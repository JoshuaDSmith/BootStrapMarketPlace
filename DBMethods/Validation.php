<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}



class DBMethods {

    public $conn;

     function ValidateUser($conn, $prop1, $prop2) 
     {
        
        $DatabaseQuery = "SELECT * FROM userdetails WHERE email = '". $prop1 ."' AND passwordChr = '". $prop2 ."'";

        $result = $conn->query($DatabaseQuery);


        ;
        if (!$result) {
        trigger_error('Invalid query: ' . $conn->error);
        }
        if($result->num_rows == 0) {
            echo "No Match here";
                mysqli_query($conn, $sql) ;
                
                $_SESSION["value"]["error"] = "No matching Record";
                
            
        } else 
        {
            $_SESSION["value"]['SuccessMsg'] = 1;
            $Rows = $result -> fetch_Object();
        
            $_SESSION["value"]["id"]= $Rows -> id;
            $_SESSION["value"]["username"] = $Rows -> username;
            $_SESSION["value"]["password"] = $Rows -> passwordChr;
            $_SESSION["value"]["name"] = $Rows -> firstname;
            $_SESSION["value"]["surname"] = $Rows -> lastname;
            $_SESSION["value"]["Email"] = $Rows -> email;
            $_SESSION["value"]["occupation"] = $Rows -> occupation;
            $_SESSION["value"]["StartDate"] = $Rows -> reg_date;
            $_SESSION["value"]["ManagerKey"] = $Rows -> ManagerKey;
            
            //print("<pre>".print_r($_SESSION['value'],true)."</pre>");
            header('Location: http://localhost/BOOTSTRAPPROJECT/Homepage/index.php');
            
                
        }
        print_r($_SESSION["value"]);
        //$conn->close();

    }

    function InsertNewUser($conn,$sql,$prop1,$prop2)
    {
        $DatabaseQuery = "SELECT * FROM userdetails WHERE email = '". $prop1 ."' AND passwordChr = '". $prop2 ."'";

        $result = $conn->query($DatabaseQuery);
        if (!$result) {
        trigger_error('Invalid query: ' . $conn->error);
        }
        if($result->num_rows > 0) { 
            return 2;
        }
        else
        {
            if (mysqli_query($conn, $sql)) 
            {
            echo "New record created successfully";
            $this->ValidateUser($conn, $prop1, $prop2);

            //header('Location: http://localhost/BOOTSTRAPPROJECT/Homepage/index.php');
            } 
            else 
            {
            echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        
    }

    function GrabMarketPlaceVehicles($conn,$sql)
    {

        if ($conn->connect_error) 
        {
                die("Connection failed: " . $conn->connect_error);
        }

        # FETCH TO DATABASE USING QUERY
        $result = mysqli_query($conn, $sql);

        return $result;
    }
}





?>