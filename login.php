<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: welcome.php");
  exit;
}
 
// Include config file
require_once "connect.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM citizens WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "Invalid Username/Password";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "Invalid Username/Password";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>eNAGAR</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- styles -->
  <link href="assets/css/bootstrap.css" rel="stylesheet">
  <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
  <link href="assets/css/prettyPhoto.css" rel="stylesheet">
  <link href="assets/js/google-code-prettify/prettify.css" rel="stylesheet">
  <link href="assets/css/flexslider.css" rel="stylesheet">

  <link href="assets/css/style.css" rel="stylesheet">
  <link href="assets/color/default.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Droid+Serif:400,600,400italic|Open+Sans:400,600,700" rel="stylesheet">

  <!-- fav and touch icons -->
  <link rel="shortcut icon" href="assets/ico/favicon.ico">
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">

  <!-- =======================================================
    Theme Name: enagar
  ======================================================= -->
</head>


<body>
  <div id="wrapper">
    <header>
      <!-- Navbar
    ================================================== -->
      <div class="navbar navbar-static-top">
        <div class="navbar-inner">
          <div class="container">
            <!-- logo -->
            <div class="logo">
              <a href="index.html"><img src="assets/img/logo.png" alt="" /></a>
            </div>
            <!-- end logo -->

            <!-- top menu -->
            <div class="navigation">
              <nav>
                <ul class="nav topnav">
                  <li class="active">
                    <a href="index.html"><i class="icon-home"></i> HOME </a>
                  </li>
                  <li class="dropdown">
                    <a href="#"><i class="icon-cog"></i> SERVICES <i class="icon-angle-down"></i></a>
                    <ul class="dropdown-menu">
                      <li><a href="waste.html">WASTE MANAGEMENT</a></li>
                      <li><a href="color-scheme.html">ISSUE LICENSE</a></li>
                      </ul>
                  <li class="dropdown">
                    <a href="#"><i class="icon-leaf"></i> E-APPOINTMENTS <i class="icon-angle-down"></i></a>
                    <ul class="dropdown-menu">
                      <li><a href="about.html">MLA</a></li>
                      <li><a href="pricingbox.html">MP</a></li>
                      <li><a href="testimonials.html">###</a></li>
                    </ul>
                  </li>
                  <li class="dropdown">
                    <a href="#"><i class="icon-money"></i> E-PAYMENTS <i class="icon-angle-down"></i></a>
                    <ul class="dropdown-menu">
                      <li><a href="portfolio-2cols.html">WATER TAX</a></li>
                      <li><a href="portfolio-3cols.html">ELECTRICITY BILL<a></li>
                      <li><a href="portfolio-4cols.html">PROPERTY TAX</a></li>
                      <li><a href="portfolio-detail.html">PROFESSIONALTAX</a></li>
                    </ul>
                  </li><BR>
                  <li class="dropdown">
                    <a href="#"><i class="icon-book"></i> BOOKING <i class="icon-angle-down"></i></a>
                    <ul class="dropdown-menu">
                      <li><a href="blog-left-sidebar.html">HALLBOOKING</a></li>
                      <li><a href="blog-right-sidebar.html">GAS BOOKING</a></li>
                    </ul>
                  </li>
                      <li class="dropdown">
                    <a href="#"><i class="icon-download-alt"></i> DOWNLOADS<i class="icon-angle-down"></i></a>
                    <ul class="dropdown-menu">
                      <li><a href="#">BIRTH CERTIFICATE</a></li>
                      <li><a href="#">DEATH CERTIFICATE</a></li>
                      <li><a href="#">MARRIAGE CERTIFICATE</a></li>
                      <li><a href="#">APPLICATION FORMS</a></li>
                    </ul>
                  </li>
                  <li>
                     <li class="dropdown">
                      <a href="#"> <i class="icon-folder-open-alt"></i>OTHER SERVICES<i class="icon-angle-down"></i></a>
                        <ul class="dropdown-menu sub-menu">
                          <li><a href="#">BUILDING PERMISSIONS</a></li>
                          <li><a href="#">WATER SUPPLY</a></li>
                          <li><a href="#">GRIEVANCE</a></li>
                          <li class="dropdown"><a href="#"> REGISTRATIONS<i class="icon-angle-down"></i></a>
                        <ul class="dropdown-menu sub-menu">
                          <li><a href="#">BIRTH REGISTRATION</a></li>
                          <li><a href="#">DEATH REGISTRATION</a></li>
                          <li><a href="#">MARRIAGE REGISTRATION</a></li>
                        </ul>
                      </li>
                    </ul>
                  </li>
                    <li><a href="login.html"><i class="icon-user"></i> LOGIN|SIGNUP</a></li>
                  </li>
                </ul>
              </nav>
            </div></head>
<div id="container_demo" >
	<ul></ul><ul></ul>
	<div class="navigation">
              <nav>
                <ul class="nav centrenav">
	<div id="wrapper">
		<div id="login" class="animate form">
			<form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" autocomplete="on"> 
				<h1>Log in</h1> 
				<p> 
					<label for="username" class="uname" data-icon="u" > Your email or username </label>
					<input id="username" name="username" required="required" type="text" placeholder="myusername or mymail@mail.com"/>
				</p>
				<p> 
					<label for="password" class="youpasswd" data-icon="p"> Your password </label>
					<input id="password" name="password" required="required" type="password" placeholder="eg. X8df!90EO" /> 
				</p>
				<p class="keeplogin"> 
					<input type="checkbox" name="loginkeeping" id="loginkeeping" value="loginkeeping" /> 
					<label for="loginkeeping">Keep me logged in</label>
				</p>
				<span class="help-block"><?php echo $username_err; ?></span>
				<span class="help-block"><?php echo $password_err; ?></span>
				<p class="login button"> 
					<input type="submit" class="btn btn-primary" value="Login"/>
				</p>
				<p class="change_link">
					Not a member yet ?
					<a href="register1.php" class="to_register">Join us</a>
				</p>
			</form>
		</div></div></li></ul>

				</li></ul>
								</p>
			</form>
		</div>
		
	</div>
</div>
   <!-- Footer
 ================================================== -->
    <footer class="footer">
      <div class="container">
        <div class="row">
          <div class="span4">
            <div class="widget">
              <h5>Interesting pages</h5>
              <ul class="regular">
                <li><a href="#">About eNagar</a></li>
                <li><a href="#">How we do all stuff</a></li>
                <li><a href="#">Our recent works</a></li>
                <li><a href="#">Press releases</a></li>
                <li><a href="#">Get in touch with us</a></li>
              </ul>
            </div>
          </div>
          <div class="span4">
         
          </div>
          <div class="span4">
            <div class="widget">
              <h5>How to find us</h5>
              <address>
                <i class="icon-home"></i> <strong>enagar,gov</strong><br>
                india<br>
                kerala,686506
                </address>
              <p>
                <i class="icon-phone"></i> (091) XXXXXXXXXX<br>
                <i class="icon-envelope-alt"></i> enagar@gmail.com
              </p>
            </div>
            <div class="widget">
              <ul class="social">
                <li><a href="#" data-placement="bottom" title="Twitter"><i class="icon-twitter icon-square icon-32"></i></a></li>
                <li><a href="#" data-placement="bottom" title="Facebook"><i class="icon-facebook icon-square icon-32"></i></a></li>
                <li><a href="#" data-placement="bottom" title="Linkedin"><i class="icon-linkedin icon-square icon-32"></i></a></li>
                <li><a href="#" data-placement="bottom" title="Pinterest"><i class="icon-pinterest icon-square icon-32"></i></a></li>
                <li><a href="#" data-placement="bottom" title="Google plus"><i class="icon-google-plus icon-square icon-32"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="verybottom">
        <div class="container">
          <div class="row">
            <div class="span6">
              <p>
                &copy; enagar- All right reserved
              </p>
            </div>
            <div class="span6">
              <div class="pull-right">
                <div class="credits">
               </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>

  </div>
  <!-- end wrapper -->
  <a href="#" class="scrollup"><i class="icon-chevron-up icon-square icon-48 active"></i></a>

  <script src="assets/js/jquery.js"></script>
  <script src="assets/js/raphael-min.js"></script>
  <script src="assets/js/jquery.easing.1.3.js"></script>
  <script src="assets/js/bootstrap.js"></script>
  <script src="assets/js/google-code-prettify/prettify.js"></script>
  <script src="assets/js/jquery.elastislide.js"></script>
  <script src="assets/js/jquery.prettyPhoto.js"></script>
  <script src="assets/js/jquery.flexslider.js"></script>
  <script src="assets/js/jquery-hover-effect.js"></script>
  <script src="assets/js/animate.js"></script>

  <!-- Template Custom JavaScript File -->
  <script src="assets/js/custom.js"></script>

</body>
</html>
