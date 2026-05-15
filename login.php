<?php
session_start();
include 'db.php';

if(isset($_POST['submit'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Email format validation (ADDED)
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo "<script> alert('Invalid email format'); </script>";
    }
    else {

        // Select user from database
        $query = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
        
        // Check if email exists
        if(mysqli_num_rows($query) > 0){
            $user = mysqli_fetch_array($query);
            
            // Verify the hashed password
            if(password_verify($password, $user['password'])){
                // Password is correct, start session
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'];
                
                echo "<script> alert('Login Successful'); window.location.href='index.php'; </script>";
            }
            else{
                echo "<script> alert('Invalid Password'); </script>";
            }
        }
        else{
            echo "<script> alert('No account found with this email'); </script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TastyBook</title>
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { background-color: #f8f9fa; }
        /* Remove blue focus border */
        .form-control:focus { border-color: #E97438; box-shadow: none; }
        
        .auth-card { border: none; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .auth-header { background-color: white; border-bottom: none; padding-top: 2rem; padding-bottom: 1rem; text-align: center; border-radius: 12px 12px 0 0; }
        
        .text-orange { color: #E97438 !important; }
        .text-orange:hover { color: #db6b33 !important; }
        
        /* Ensure button matches register page style */
        .mybtn-orange { background-color: #E97438 !important; color: white !important; }
        .mybtn-orange:hover { background-color: #db6b33 !important; }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

  <!-- Navbar -->
  <?php include('header.php') ?>

  <!-- Main Login Content -->
  <div class="container my-auto py-5">
      <div class="row justify-content-center">
          <div class="col-md-6 col-lg-5 col-xl-4">
              
              <div class="card auth-card">
                  <div class="card-header auth-header">
                      <h3 class="fw-bold mb-1">Welcome Back!</h3>
                      <p class="text-muted small">Please login to continue to your kitchen.</p>
                  </div>
                  <div class="card-body p-4 pt-2">
                      <form action="login.php" method="POST">
                          <div class="mb-3">
                              <label class="form-label fw-bold small text-muted">Email Address</label>
                              <div class="input-group">
                                  <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                                  <input type="email" name="email" placeholder="Enter Your Email Address." class="form-control border-start-0 ps-0 bg-light" required>
                              </div>
                          </div>

                          <div class="mb-3">
                              <label class="form-label fw-bold small text-muted">Password</label>
                              <div class="input-group">
                                  <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                                  <input type="password" name="password" placeholder="Enter Your Password." class="form-control border-start-0 ps-0 bg-light" required>
                              </div>
                          </div>

                          <div class="d-grid mb-4">
                              <button type="submit" name="submit" class="btn mybtn-orange py-2 fw-bold shadow-sm">LOG IN</button>
                          </div>
                      </form>
                  </div>
                  <div class="card-footer bg-light text-center py-3 border-0 rounded-bottom">
                      <p class="mb-0 small">Don't have an account? <a href="register.php" class="text-orange fw-bold text-decoration-none">Sign Up</a></p>
                  </div>
              </div>

          </div>
      </div>
  </div>

  <?php include('footer.php') ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>