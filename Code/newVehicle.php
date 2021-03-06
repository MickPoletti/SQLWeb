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
    <title>Create a New Vehicle</title>

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
            <h1 class="mx-auto my-0 text-uppercase text-white">Create a New Vehicle</h1><br>
            <form method="post" action="" class="form-group" id="newvehicle" onsubmit="return false;">
                <table class="" align="center">
                    <tr>
                        <td align="right">VehicleID*:</td>
                        <td align="left"><input type="text" maxlength="17" name="VehicleID" class="form-control" placeholder="19VDE1F3XEE414842" /></td>
                    </tr>
                    <tr>
                        <td align="right">Description*:</td>
                        <td align="left"><input type="text" name="description" class="form-control" placeholder="Acura ILX" /></td>
                    </tr>
                    <tr>
                        <td align="right">Year*:</td>
                        <td align="left"><input type="text" maxlength="4" name="year" class="form-control" placeholder="2014" /></td>
                    </tr>
                    <tr>
                        <td align="right">Type*:</td>
                        <td align="left"><input type="text" maxlength="1" name="type" class="form-control" placeholder="0,Basic ; 1,Luxury" /></td>
                    </tr>
                    <tr>
                        <td align="right">Category*:</td>
                        <td align="left"><input type="text" maxlength="1" name="Category" class="form-control" placeholder="1-6" /></td>
                    </tr>
                    <tr style="display: none;">
                      <td align="right">Year*:</td>
                        <td align="left"><input type="text" name="Vehicle" class="form-control" value="1" /></td>
                    </tr>
                </table>
                <p align="center" style="color: red;">* - required field </p>

                <a align="center" style="color: blue;" href="#types"><i><u> Type(s)</i></u></a>
            </form>

            <button type="submit" class="btn btn-primary js-scroll-trigger" form="newvehicle" id="submit">Submit</button>
            <script src="vendor/jquery/jquery.min.js"></script>
            <script type="text/javascript">
             // this is the id of the submit button
            $("#submit").click(function() {

                var x = document.forms["newvehicle"]["VehicleID"].value;
                var y = document.forms["newvehicle"]["description"].value;
                var z = document.forms["newvehicle"]["year"].value;
                var x1 = document.forms["newvehicle"]["type"].value;
                var y1 = document.forms["newvehicle"]["Category"].value;
                if (x == null || x == "" || y == null || y == "" || z == null || z == "" || x1 == null || x1 == "" || y1 == null || y1 == "") {
                    alert("All fields must have a value");
                    return false;
                }

                var url = "submit.php"; // the script where you handle the form input.

                $.ajax({
                       type: "POST",
                       url: url,
                       data: $("#newvehicle").serialize(), // serializes the form's elements.
                       success: function(data)
                       {
                           alert(data); // show response from the php script.
                       }
                     });

                return false; // avoid to execute the actual submit of the form.
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
        </div>
      </div>
    </header>

    <!-- About Section -->
    <section id="types" class="about-section text-center">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <h2 class="text-white mb-4">Vehicle Types</h2>
            <table class="table table-dark" align="left">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Type</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td>Compact</td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>Medium</td>
                </tr>
                <tr>
                  <th scope="row">3</th>
                  <td>Large</td>
                </tr>
                <tr>
                  <th scope="row">4</th>
                  <td>SUV</td>
                </tr>
                <tr>
                  <th scope="row">5</th>
                  <td>Truck</td>
                </tr>
                <tr>
                  <th scope="row">6</th>
                  <td>Van</td>
                </tr>  
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/grayscale.min.js"></script>
  </body>
</html>