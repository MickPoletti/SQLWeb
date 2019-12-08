<?php

$link = mysqli_connect('localhost:3307','root','Gayasfuck21!','carrental2019');
if(mysqli_connect_errno())
{
    printf("\n\nDatabase Connection Failed: %s\n", mysqli_connect_error());
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A quick webtool made to bbe used for phase 3 of CSE3330's design project.">
    <meta name="author" content="Mason McDaniel">


    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/grayscale.min.css" rel="stylesheet">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Return a Rental</title>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body id="page-top">

  <!-- Navigation -->  
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="/index.php">Database Project</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="/index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="/newCustomer.php">New Customer</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="/newVehicle.php">New Vehicle</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="/newRental.php">Reserve a Vehicle</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="/returns.php">Return a Vehicle</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="/searchCustomer.php">Search for a Customer</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="/searchVehicle.php">Search for a Vehicle</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>


    
    <!-- Header -->
    <header class="signup-section">
      <div class="container d-flex h-100 align-items-center"> 
        <div class="mx-auto text-center">
            <div class="form-group" id="customerDiv">
            <h1 class="mx-auto my-0 text-uppercase">Return a Rented Vehicle</h1><br>
            <?php ?>
            <form method="get" class="form-group" id="returns">
                <table class="col-md-6" align="center">
                    <tr>
                        <td align="right">Phone*:</td>
                        <td align="left"><input type="text" name="phone" maxlength="14" class="form-control" placeholder="(409) 867-5309" /></td>
                    </tr>
                    <?php
                    $sql = "SELECT DISTINCT v.VehicleID, v.Description
                    FROM Vehicle v, Rental r
                    WHERE v.VehicleID = r.VehicleID and Returned = '0'";
                    $result = mysqli_query($link, $sql);
                    if(!mysqli_query($link,$sql))
                    {
                      echo("Error description: " . mysqli_error($link));
                      return false;
                    }

                    echo "<td align=\"right\">Rented Vehicles:</td><td align='left'><select align='left' name='VehicleID' class=\"form-control\">";
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<option value='" . $row['Description'] . "'>" . $row['Description'] . "</option>";
                    }
                    echo "</select></td>";
                    

                  ?>
                  <p><?php echo $VehicleID?></p>
                    <tr>
                      <td align="right">ReturnDate*:</td>
                      <td align="left"><input type="text" name="return" maxlength="10"class="form-control" placeholder="2019-01-29" /></td>
                    </tr>
                    <tr style="display: none;">
                      <td align="right">Year*:</td>
                      <td align="left"><input type="text" name="customer" class="form-control" value="1" /></td>
                    </tr>
                </table>
                <p align="center" style="color: red;">* - required field </p>
            </form>
            <button type="submit" class="btn btn-primary js-scroll-trigger" form="returns" id="submit">Submit</button>
            <?php $phone = $_GET['phone']; $return = $_GET['return']; $Description = $_GET['VehicleID'];
            $sql2 = "SELECT v.VehicleID
            FROM Vehicle v, rental r
            WHERE v.VehicleID = r.VehicleID and v.Description = '$Description' and r.ReturnDate = '$return'";           
            $result = mysqli_query($link, $sql2);
            $value = mysqli_fetch_object($result);
            $VehicleID = $value->VehicleID;
            $sql1 = "
            SELECT CustID
            FROM Customer
            WHERE Phone = '$phone'
            LIMIT 1
            "; 
            $result = mysqli_query($link, $sql1);
            $value = mysqli_fetch_object($result);
            $Customer = $value->CustID;?>
            <?php
            
            $sql2 = "SELECT c.Name as 'Name', c.Phone as 'Phone', r.ReturnDate as 'ReturnDate', SUM(r.TotalAmount) as 'PaymentDue' 
            FROM customer c, rental r , Vehicle v
            WHERE c.CustID = '$Customer' and c.CustID = r.CustID and r.VehicleID = v.VehicleID and v.VehicleID = '$VehicleID'";       
            $transactionSet = mysqli_query($link,$sql2);
            if(!mysqli_query($link,$sql2))
            {
              echo("<p>Error description: " . mysqli_error($link). "</p>");
              return false;
            }
            $value = mysqli_fetch_object($transactionSet);?>         


            <script src="vendor/jquery/jquery.min.js"></script>
            <script type="text/javascript">
             // this is the id of the submit button
             $("#submit").click(function() {
                var x = document.forms["returns"]["phone"].value;
                if (x == null || x == "") {
                    alert("Phone must be filled out");
                    return false;
                }    
            });
             
            </script>
            <script>
            function validateForm() {
                var x = document.forms["newcustomer"]["name"].value;
                if (x == null || x == "") {
                    alert("Name must be filled out");
                    return false;
                }
            }
            </script>          
          </div>
          <table class="table table-dark table-striped table-bordered table-hover" style="table-layout: fixed; display: inline-table;" id="#table">
              <tr>
              <th>Name</th>
              <th>Phone</th>
              <th>Return Date</th>
              <th>Total Due</th>
              </tr>
              <?php
                  
                      $statement[] = $rows;
              ?>
              <tr>
                      <td><?php echo $value->Name;?></td>
                      <td><?php echo $value->Phone;?></td>
                      <td><?php echo $value->ReturnDate?></td>
                      <td>$<?php echo $value->PaymentDue?></td>
              </tr>
              <?php
                  
              ?>
          </table>
          <button type="submit" class="btn btn-primary js-scroll-trigger" id="paynowButton" form="paynow">PAY NOW</button>     
          <form method="post" class="form-group" id="paynow" onsubmit="return false;">
                <table class="col-md-6" align="center">
                    <tr style="display: none;">
                      <td align="right">paynow:</td>
                      <td align="left"><input type="text" name="paynow" class="form-control" value="1" /></td>
                    </tr>
                    <tr style="display: none;">
                      <td align="right">value:</td>
                      <td align="left"><input type="text" name="Value" class="form-control" value="<?php echo $value->PaymentDue?>" /></td>
                    </tr>
                    <tr style="display: none;">
                      <td align="right">customer:</td>
                      <td align="left"><input type="text" name="Customer" class="form-control" value="<?php echo $Customer?>" /></td>
                    </tr>
                    <tr style="display: none;">
                      <td align="right">return:</td>
                      <td align="left"><input type="text" name="Return" class="form-control" value="<?php echo $return?>" /></td>
                    </tr>
                    <tr style="display: none;">
                      <td align="right">VehicleID:</td>
                      <td align="left"><input type="text" name="VehicleID" class="form-control" value="<?php echo $VehicleID?>" /></td>
                    </tr>
                </table>
            </form>
            <script src="vendor/jquery/jquery.min.js"></script> 
            <script type="text/javascript">
               $("#paynowButton").click(function() {
                var url = "submit.php"; // the script where you handle the form input.
                
                $.ajax({
                       type: "POST",
                       url: url,
                       data: $("#paynow").serialize(), // serializes the form's elements.
                       success: function(data)
                       {
                           alert(data); // show response from the php script.
                       }
                     });

               
                return false; // avoid to execute the actual submit of the form.
            });
            </script>
         
        </div>

      </div>
    </header>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/grayscale.min.js"></script>
  </body>
</html>