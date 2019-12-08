<?php

$link = mysqli_connect('localhost:3307','root','Gayasfuck21!','carrental2019');
if(mysqli_connect_errno())
{
    printf("\n\nDatabase Connection Failed: %s\n", mysqli_connect_error());
}

?>
<?php
	if(isset($_POST['customer'])){
	$name = $_POST["name"];
	$phone = $_POST["phone"];
	$sql1 = "
        SELECT CustID
        FROM Customer
        WHERE Phone = '$Phone'
        LIMIT 1
        ";
        $result = mysqli_query($link, $sql1);
        $value = mysqli_fetch_object($result);
       	$Customer = $value->CustID;

	if($customer == NULL)
	{
		$sql = "INSERT INTO customer (Name, Phone) VALUES ('$name', '$phone')";
	}
	else
	{	
		$sql = "INSERT INTO customer (CustID, Name, Phone) VALUES ('$Customer', '$name', '$phone')";
	}
    if(isset($_POST['name'])){
    	if(!mysqli_query($link,$sql))
    	{
    		echo("Error description: " . mysqli_error($link));
    		return false;
    	}
    	else
    	{
    		echo("Customer Name: " .$name . " \nID: " .$Customer ." \nPhone: " . $phone . "\nhas been successfully inserted");
    	}
       
        //and then execute a sql query here
    }
	}
?>
<?php
	if(isset($_POST['Vehicle']))
	{
	$VehicleID = $_POST["VehicleID"];
	$Description = $_POST["description"];
	$Year = $_POST["year"];
	$Type = $_POST["type"];
	$Category = $_POST["Category"];
	$sql = "INSERT INTO vehicle (VehicleID, Description, Year, Type, Category) VALUES ('$VehicleID', '$Description', '$Year', '$Type', '$Category')";
    if(isset($_POST['VehicleID'])){
    	if(!mysqli_query($link,$sql))
    	{
    		echo("Error description: " . mysqli_error($link));
    		return false;
    	}
    	else
    	{
    		echo("VehicleID: " .$VehicleID . " \nDescription: " .$Description ." \nYear: " . $Year . "\nType: " .$Type . "\nCategory: " .$Category . "\nhas been successfully inserted");
    	}
       
        //and then execute a sql query here
        }
        else {
        	echo" dhur";
        }
	}
	
?>

<?php
	if(isset($_POST["paynow"])){
	  $PaymentDue = $_POST["Value"];
	  $Customer = $_POST["Customer"];
	  $return = $_POST["Return"];
	  $VehicleID = $_POST["VehicleID"];
	  if($PaymentDue == 0)
	  {
	    $sql = "UPDATE rental 
	    SET Returned = '1'
	    WHERE CustID='$Customer' and ReturnDate='$return' and VehicleID='$VehicleID'";
	    if(!mysqli_query($link,$sql))
	    {
	      echo("Error description: " . mysqli_error($link));
	      return false;
	    }
	    echo("Vehicle successfully returned! Thank you and have a wonderful day!");
	  }
	  else
	  {
	    $sql = "UPDATE rental 
	    SET Returned = '1', TotalAmount = '0'
	    WHERE CustID='$Customer' and ReturnDate='$return' and VehicleID='$VehicleID'";
	    mysqli_query($link,$sql);
	    echo("Thank you for your payment, have a nice day!");
	  }
	}
?>

<?php
	if(isset($_POST['Rental']))
	{
		$Phone = $_POST["Phone"];
        $sql1 = "
        SELECT CustID
        FROM Customer
        WHERE Phone = '$Phone'
        LIMIT 1
        ";
        $result = mysqli_query($link, $sql1);
        $value = mysqli_fetch_object($result);
       	$CustID = $value->CustID;
        
        if(!mysqli_query($link,$sql1))
        {
          echo("Error description: " . mysqli_error($link));
          return false;
        }

        
		$StartDate = $_POST["StartDate"];
		$ReturnDate = $_POST["ReturnDate"];
		$Type = $_POST["Type"];
		$Category = $_POST["Category"];
		$Description = $_POST["Description"]; 
        $sql2 = "SELECT VehicleID
        FROM Vehicle
        WHERE Description = '$Description' and Type = '$Type' and Category = '$Category'";           
        $result = mysqli_query($link, $sql2);
        $value = mysqli_fetch_object($result);
       	$VehicleID = $value->VehicleID;
       	if(!mysqli_query($link,$sql2))
        {
          echo("Error description: " . mysqli_error($link));
          return false;
        }
        $Qty = $_POST["qty"];
        $dateOne = DateTime::createFromFormat("Y-m-d", $ReturnDate);
    	$dateTwo = DateTime::createFromFormat("Y-m-d", $StartDate);
    	$interval = $dateOne->diff($dateTwo);
        if($interval->d>=7){
			$RentalType = '7';
			$sql2 = "SELECT Weekly
	        FROM rate
	        WHERE Type = '$Type' and Category = '$Category'";           
	        $result = mysqli_query($link, $sql2);
	        $value = mysqli_fetch_object($result);
	       	$TotalAmount = $value->Weekly * $interval->d * $Qty;
		}
		else
		{
			$RentalType = '1';
			$sql2 = "SELECT Daily
	        FROM rate
	        WHERE Type = '$Type' and Category = '$Category'";           
	        $result = mysqli_query($link, $sql2);
	        $value = mysqli_fetch_object($result);
	       	$TotalAmount = $value->Daily * $interval->d * $Qty;
		}
           
		$OrderDate = date("Y-m-d"); 
		
		$PaymentDate = $_POST['PaymentDate'];
		if(empty($PaymentDate)){
			$PaymentDate = "NULL";
		}

		$sql = "INSERT INTO rental (CustID, VehicleID, StartDate, OrderDate, RentalType, Qty, ReturnDate, TotalAmount, PaymentDate, Returned) VALUES ('$CustID', '$VehicleID', '$StartDate', '$OrderDate','$RentalType',  '$Qty', '$ReturnDate', '$TotalAmount', $PaymentDate, '0')";
 
    		if(!mysqli_query($link,$sql))
	    	{
	    		echo("Error description: " . mysqli_error($link));
	    		return false;
	    	}
	    	else
	    	{
	    		echo("CustID: " .$Qty . " \nVehicleID: " .$VehicleID ." \nStartDate: " . $StartDate . "\nOrderDate: " .$OrderDate . "\nRentalType: " .$RentalType . 
	    			"\nQty:" . $Qty . "\nReturnDate:" . $ReturnDate . "\nhas been successfully inserted");
	    	}
	       
	        //and then execute a sql query here
	    
	}
	
?>


