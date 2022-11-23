<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $address = $salary638 = $username = $password ="";
$name_err = $address_err = $salary638_err = $username_err =$password_err ="";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    
    // Validate salary
    $input_salary638 = trim($_POST["salary638"]);
    if(empty($input_salary638)){
        $salary638_err = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_salary638)){
        $salary638_err = "Please enter a positive integer value.";
    } else{
        $salary638 = $input_salary638;
    }

    // Validate username
if(empty(trim($_POST["username"]))){
    $username_err = "Please enter a username.";
} elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
    $username_err = "Username can only contain letters, numbers, and underscores.";
} else{
    // Prepare a select statement
    $sql = "SELECT id FROM employees WHERE username = ?";
    
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

        // Close statement
        mysqli_stmt_close($stmt);
    }
}

// Validate confirm password
if(empty(trim($_POST["password"]))){
    $password_err = "Please confirm password.";     
} else{
    $password = trim($_POST["password"]);
    if(empty($password_err) && ($password != $password)){
        $password_err = "Password did not match.";
    }
}
 
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($salary638_err)&& empty($username_err)&& empty($password_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO employees (name, address, salary638, username, password) VALUES (?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssiss", $param_name, $param_address, $param_salary638, $param_username, $param_password);
            
            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_salary638 = $salary638;
            $param_username = $username;
            $param_password = $password;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: welcome.php");
                exit();
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
    <title>Baker - Bakery Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top py-lg-0 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
    <img src="product-images/logo.jpg" alt="logo" class="logo">
        <a href="index.html" class="navbar-brand ms-4 ms-lg-0">
            <h1 class="text-primary m-0">Baker</h1>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav mx-auto p-4 p-lg-0">
                <a href="index.html" class="nav-item nav-link active">Home</a>
                <a href="about.html" class="nav-item nav-link">About</a>
                <a href="upload.html" class="nav-item nav-link">careers</a>
                <a href="login.php" class="nav-item nav-link">orderonline</a>
                <a href="contact.html" class="nav-item nav-link">Contact</a>
                <a href="create.php" class="nav-item nav-link">register</a>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid page-header py-6 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center pt-5 pb-3">
            <h1 class="display-4 text-white animated slideInDown mb-3">register</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="#">Register an account and join us</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- register Start -->
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Salary</label>
                            <input type="text" name="salary638" class="form-control <?php echo (!empty($salary638_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $salary638; ?>">
                            <span class="invalid-feedback"><?php echo $salary638_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                            <span class="invalid-feedback"><?php echo $username_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                            <span class="invalid-feedback"><?php echo $password_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        
                        <a href="create.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
    <!-- register End -->


    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer my-6 mb-0 py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Evan</h4>
                    <p class="mb-2">Shen Xinkai</p>
                    <p class="mb-2">203190638</p>
                </div>
                    <div class="col-lg-3 col-md-6">
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>Phone*(757) 808-7056</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@example.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-square btn-outline-light rounded-circle me-1" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-square btn-outline-light rounded-circle me-1" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square btn-outline-light rounded-circle me-1" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-square btn-outline-light rounded-circle me-0" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Quick Links</h4>
                    <a class="btn btn-link" href="">About Us</a>
                    <a class="btn btn-link" href="">Contact Us</a>
                    <a class="btn btn-link" href="">Our Services</a>
                    <a class="btn btn-link" href="">Terms & Condition</a>
                    <a class="btn btn-link" href="">Support</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Copyright Start -->
    <div class="container-fluid copyright text-light py-4 wow fadeIn" data-wow-delay="0.1s">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a href="#">loca's loaves</a>, All Right Reserved.
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                    Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>