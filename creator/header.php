
<header class="navbar navbar-expand-lg bg-orange sticky-top">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01"
        aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <a class="navbar-brand" href="../index.php"><img style=" width: 75px; height:65px" src="../images/TastyBook.png" alt=""></a>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../drinks.php">Drinks</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../bakery.php">Bakery</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="dessert.php">Desserts</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pakistani.php">Pakistani</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="continental.php">Continental</a>
          </li>
        </ul>
        
        <!-- Only show Login button if NOT logged in -->
        <?php if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true): ?>
            <!-- Changed button to 'a' tag so it links to login.php -->
            <a href="login.php" class="btn btn-primary">Login</a>
        <?php else: ?>
            <a href="../logout.php" class="btn btn-dark">Logout</a>
        <?php endif; ?>

      </div>
    </div>
  </header>