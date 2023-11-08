<?php
$conn = 0;
include 'DBconnection.php';
session_start();
$IDmedico = -1;

$stmt = $conn->prepare("SELECT IDmedico FROM MEDICO WHERE CF=? AND password=?");
    
if(empty($_POST["remember"])){
  setcookie ("login_cf",0,time()-1);
	setcookie ("login_password",0,time()-1);
}
if (isset($_POST['login']) && !empty($_POST['CFmedico']) && !empty($_POST['password'])) {
  $CFmedico = $_POST['CFmedico'];
  $password = $_POST['password'];
  if(empty($_POST["remember"])){
	  setcookie ("login_cf","");
	  setcookie ("login_password","");  
  }       
  print("Eseguo query");
	$stmt->bind_param('ss', $CFmedico, $password);
  $stmt->execute();
  $stmt->bind_result($IDmedico);
  $stmt->store_result();
  print("$stmt->num_rows");
  if($stmt->num_rows == 1){  
    $_SESSION['CFmedico'] = "$CFmedico"; 
    $_SESSION['password'] = "$password"; 
    
    if(!empty($_POST["remember"])) {
      setcookie ("login_cf",$CFmedico,time()+ (10 * 365 * 24 * 60 * 60));
      setcookie ("login_password",$password,time()+ (10 * 365 * 24 * 60 * 60));
    }	
    header("Location: index.php");
  }
}
else if(isset($_COOKIE["login_cf"]) && isset($_COOKIE["login_password"])&&isset($_POST['login'])) {
	$_SESSION['CFmedico'] = $_COOKIE["login_cf"]; 
  $_SESSION['password'] = $_COOKIE["login_password"];
  header("Location: index.php"); 
}


?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Bentornato!</h1>
                  </div>
                  <form class="user" method="post">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="CFmedico" name="CFmedico" placeholder="Codice fiscale...">
                    </div>
                    <div class="form-group">
                      <input type="password"  class="form-control form-control-user" id="password" name = "password" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck" name="remember">
                        <label class="custom-control-label" for="customCheck">Ricordati di me</label>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block" name="login">
                      Login
                    </button>
                    <hr>    
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="forgot-password.html">Password dimenticata?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="register.html">Crea un account!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>