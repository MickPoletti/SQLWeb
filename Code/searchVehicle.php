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
    <meta name="description" content="A quick webtool made to be used for phase 3 of CSE3330's design project.">
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
    <title>Search</title>

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
            <div class="form-group" id="searchDiv">
            <h1 class="mx-auto my-0 text-uppercase">Search by Vehicle</h1><br>
            <form method="get" action="" class="form-group" id="search">
                <table class="col-md-6" align="center">
                    <tr>
                        <td align="right">VIN:</td>
                        <td align="left"><input type="text" name="VIN" maxlength="17" class="form-control" placeholder="JM3KE4DY4F0441471" /></td>
                    </tr>
                    <tr>
                        <td align="right">Description:</td>
                        <td align="left"><input type="text" name="Description" maxlength="35" class="form-control" placeholder="Ford F-150" /></td>
                    </tr>
                    <tr style="display: none;">
                      <td align="right">search*:</td>
                      <td align="left"><input type="text" name="search" class="form-control" value="1" /></td>
                    </tr>
                </table>
                <p align="center" style="color: red;"></p>
            </form>

            <button type="submit" class="btn btn-primary js-scroll-trigger" form="search" id="submit">Search</button>
            <?php 
            $searchSet = mysqli_query($link, "
                  SELECT VIN, Vehicle, round((OrderAmount / TotalDays),2) as 'DailyPrice'
                  FROM vRentalInfo
                  ORDER BY DailyPrice");

              if(isset($_GET["search"])){
                $VIN = $_GET["VIN"]; 
                $Name = $_GET["Description"];

                if(($VIN == NULL) && ($Name == NULL))
                {
                  $searchSet = mysqli_query($link, "
                  SELECT VIN, Vehicle, CONCAT('$', round((OrderAmount/TotalDays),2)) as 'DailyPrice'
                  FROM vRentalInfo
                  UNION
                  select v.VehicleID, v.Description, 'N/A' AS 'DailyPrice' from vehicle v, rate r where v.Type = r.Type and v.Category = r.Category
                  and v.VehicleID NOT IN (select VehicleID from rental)");
                }
                else if($VIN == NULL)
                {
                  $searchSet = mysqli_query($link, "
                  SELECT VIN, Vehicle, CONCAT('$', round((OrderAmount/TotalDays),2)) as 'DailyPrice'
                  FROM vRentalInfo
                  WHERE Vehicle Like '%$Name%'
                  UNION
                  select v.VehicleID, v.Description, 'N/A' AS 'DailyPrice' from vehicle v, rate r where v.Type = r.Type and v.Category = r.Category
                  and v.Description like '%$Name%' and VehicleID NOT IN (select VehicleID from rental)");
                }
                else if($Name == NULL)
                {
                  $searchSet = mysqli_query($link, "
                  SELECT VIN, Vehicle, CONCAT('$', round((OrderAmount/TotalDays),2)) as 'DailyPrice'
                  FROM vRentalInfo
                  WHERE VIN = '$VIN'
                  UNION
                  select v.VehicleID, v.Description, 'N/A' AS 'DailyPrice' from vehicle v, rate r where v.Type = r.Type and v.Category = r.Category
                  and v.VehicleID = '$VIN' and v.VehicleID NOT IN (select VehicleID from rental)");
                }
              }
            ?>
            <script src="vendor/jquery/jquery.min.js"></script>
            <script type="text/javascript">
             // this is the id of the submit button
            $("#submit").click(function() {


                var url = "submit.php"; // the script where you handle the form input.
                /*
                $.ajax({
                       type: "POST",
                       url: url,
                       data: $("#search").serialize(), // serializes the form's elements.
                       success: function(data)
                       {
                           alert(data); // show response from the php script.
                       }
                     });

                return false; // avoid to execute the actual submit of the form.*/
            });
            </script>
            <script>
            function validateForm() {
                var x = document.forms["date"]["reserve"].value;
                var y = document.forms["date"]["return"].value;
                if (x == null || x == "" || y == null || y == "" || z == null || z == "" || x1 == null || x1 == "" || y1 == null || y1 == "") {
                    alert("All fields must have a value");
                    return false;
                }
            }
            </script>          
          </div>
          <table class="table table-dark table-striped table-bordered table-hover" style="table-layout: fixed; display: inline-table;" id="#table">
            <tr>
            <th>VIN</th>
            <th>Vehicle</th>
            <th>Daily Price</th>
            </tr>
            <?php
                  while ($rows=mysqli_fetch_assoc($searchSet)) 
                  {
                    # code...
                    $statement[] = $rows;
            ?>
            <tr>
                    <td><?php echo $rows['VIN'];?></td>
                    <td><?php echo $rows['Vehicle'];?></td>
                    <td><?php echo $rows['DailyPrice']?></td>
            <?php } ?>           
            </tr>
                
          </table>                 
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