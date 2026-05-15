
<header class="navbar navbar-expand-lg bg-orange sticky-top">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01"
        aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <a class="navbar-brand" href="index.php"><img style=" width: 75px; height:65px" src="images/TastyBook.png" alt=""></a>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link text-white active" aria-current="page" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="drinks.php">Drinks</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="bakery.php">Bakery</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="dessert.php">Desserts</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="pakistani.php">Pakistani</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="continental.php">Continental</a>
          </li>
        </ul>
        
        <!-- Only show Login button if NOT logged in -->
        <?php if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true): ?>
            <!-- Changed button to 'a' tag so it links to login.php -->
            <a href="login.php" class="btn btn-primary">Login</a>
        <?php else: ?>
            <a href="logout.php" class="btn btn-dark">Logout</a>
        <?php endif; ?>

      </div>
    </div>
  </header>

  <!-- USER WELCOME SECTION (Only shows when logged in) -->
  <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
  <div class="container mt-4">
    <div class="p-4 rounded shadow-sm" style="background-color: #fdf2eb; border-left: 5px solid #db6b33;">
        <div class="row align-items-center">
            <div class="col-md-7">
                <h2 class="fw-bold" style="color: #333;">Welcome, <span style="color: #db6b33;"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>! 👋</h2>
                <p class="mb-0 text-muted">What would you like to cook today?</p>
            </div>
            <div class="col-md-5 text-md-end mt-3 mt-md-0">
                <a href="creator/add-recipe.php" class="btn mybtn-orange me-2">
                    <i class="fas fa-plus-circle me-1"></i> Add New Recipe
                </a>
                <a href="creator/manage-recipes.php" class="btn btn-outline-dark">
                    <i class="fas fa-edit me-1"></i> Edit Your Recipes
                </a>
            </div>
        </div>
    </div>
  </div>
  <br>
  <?php endif; ?>
  <!-- End User Section -->
