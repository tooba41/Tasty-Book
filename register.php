<?php 
include 'db.php';  

if(isset($_POST['submit'])){

    $full_name = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirmPassword'];

    // VALIDATION VARIABLES
    // $uppercase = preg_match('@[A-Z]@', $password);
    // $lowercase = preg_match('@[a-z]@', $password);
    // $number    = preg_match('@[0-9]@', $password);
    // $specialChars = preg_match('@[^\w]@', $password);

    // 1. Check if passwords match
    if($password != $confirm_password){
        echo "<script> alert('Passwords do not match'); </script>";
    }
    // 2. Email format validation
    // else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    //     echo "<script> alert('Invalid email format'); </script>";
    // }
    // // 3. Password Length Check (Min 8 characters)
    // else if(strlen($password) < 8) {
    //     echo "<script> alert('Password must be at least 8 characters long'); </script>";
    // }
    // // 4. Password Complexity Check
    // else if(!$uppercase || !$lowercase || !$number || !$specialChars) {
    //     echo "<script> alert('Password must include at least one uppercase letter, one number, and one special character.'); </script>";
    // }
    else {

        // Check if email exists
        $check_email = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email'");
        
        if(mysqli_num_rows($check_email) > 0){
            echo "<script> alert('Email already registered'); </script>";
        }
        else {

            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert Query
            $query = mysqli_query($conn, "INSERT INTO users (full_name, email, password) VALUES ('$full_name', '$email', '$hashed_password')");

            if($query){
                echo "<script> alert('Account created Successfully. Please Login'); window.location.href='login.php'; </script>";
            }
            else{
                echo "<script> alert('Could not run query'); </script>";
            }
        }
    }
} 
?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - TastyBook</title>
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="d-flex flex-column min-vh-100">

  <?php include('header.php') ?>

  <div class="container my-auto py-5">
      <div class="row justify-content-center">
          <div class="col-md-8 col-lg-6 col-xl-5">
              <div class="card auth-card">
                  <div class="card-header auth-header">
                      <h3 class="fw-bold mb-1">Join TastyBook</h3>
                      <p class="text-muted small">Create an account to save and share your favorite recipes.</p>
                  </div>
                  <div class="card-body p-4 pt-2">
                      <form action="register.php" method="POST">
                          <div class="mb-3">
                              <label class="form-label fw-bold small text-muted">Full Name</label>
                              <input type="text" name="fullname" class="form-control bg-light" required>
                          </div>
                          <div class="mb-3">
                              <label class="form-label fw-bold small text-muted">Email Address</label>
                              <input type="email" name="email" class="form-control bg-light">
                          </div>
                              <div class="mb-3">
                                  <label class="form-label fw-bold small text-muted">Password</label>
                                  <input type="password" name="password" class="form-control bg-light" required>
                              </div>
                              <div class="mb-3">
                                  <label class="form-label fw-bold small text-muted">Confirm</label>
                                  <input type="password" name="confirmPassword" class="form-control bg-light" required>
                              </div>
                          <div class="d-grid mb-4">
                              <button type="submit" name="submit" class="btn mybtn-orange py-2 fw-bold shadow-sm">CREATE ACCOUNT</button>
                          </div>
                      </form>
                  </div>
                  <div class="card-footer bg-light text-center py-3 border-0 rounded-bottom">
                      <p class="mb-0 small">Already have an account? <a href="login.php" class="text-orange fw-bold text-decoration-none">Log In</a></p>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <?php include('footer.php') ?>
</body>
</html>