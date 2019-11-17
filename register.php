<?php
// Include config file
require_once "connect.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $email = "";
$username_err = $password_err = $confirm_password_err = $email_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM citizens WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
	if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email-id.";     
    }
	else{
        $sql = "SELECT id FROM citizens WHERE emailid = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_emailid);
            
            // Set parameters
            $param_emailid = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email-id is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
		}
		// Close statement
        mysqli_stmt_close($stmt);
	}		
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 8){
        $password_err = "Password must have atleast 8 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO citizens (username, emailid, password) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_emailid, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_emailid=$email;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
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
                    <li class="dropdown"><a href="login.html"><i class="icon-user"></i> LOGIN|SIGNUP</a></li>
                    <ul class="dropdown-menu sub-menu">
                    <li><a href="login.html">USER LOGINS</a></li>
                    <li><a href="login1.html">DEPARTMENT LOGIN</a></li>
                  </li>
                </ul>
              </nav>
            </div></head>
            <div id="container_demo" >
	<br><br><ul></ul><ul></ul>
	<div class="navigation">
              <nav>
                <ul class="nav centrenav">
                  <li class="active">
		<div id="register" class="animate form">
			<form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" autocomplete="on" method="post"> 
				<div class="navigation">
              <nav>
                <ul class="nav centrenav">
                  <li class="active">
                  	<h1> Sign up </h1> 
				<p> 
					<label for="username" class="uname" data-icon="u">Your username</label>
					<input id="username" name="username" required="required" type="text" placeholder="username" />
					<span class="help-block"><?php echo $username_err; ?></span>
				</p>
				<p> 
					<label for="email" class="youmail" data-icon="e" >Email</label>
					<input id="email" name="email" required="required" type="email" placeholder="********@mail.com"/>
				</p>
				<p> 
					<label for="password" class="youpasswd" data-icon="p">Your password </label>
					<input id="password" name="password" required="required" type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" placeholder="eg. XXXXXXXX"/>
					<span class="help-block"><?php echo $password_err; ?></span>
				</p>
				<p> 
					<label for="confirm_password" class="youpasswd" data-icon="p">Please confirm your password </label>
					<input id="confirm_password" name="confirm_password" required="required" type="password" placeholder="eg. XXXXXXXX"/>
					<span class="help-block"><?php echo $confirm_password_err; ?></span>
				</p>
				<p class="signin button"> 
					<input type="submit" class="btn btn-primary" value="Sign Up">
					<input type="reset" class="btn btn-default" value="Reset"> 
				</p>
				<p class="change_link">  
					Already a member ?
					<a href="login.html" class="to_register"> Go and log in </a>
				</li></ul>
								</p>
			</form>
		</div>
		
	</div>
</div>
</li>
</ul>
</nav>
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
