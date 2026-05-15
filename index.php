<?php
session_start();
include 'db.php';

// Helper function to fetch recipes
function getRecipesByCategory($conn, $category) {
    $sql = "SELECT recipes.*, users.full_name 
            FROM recipes 
            JOIN users ON recipes.user_id = users.id 
            WHERE category = '$category' 
            ORDER BY created_at DESC LIMIT 3";
    return mysqli_query($conn, $sql);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TastyBook | Food Recipes</title>
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">


  <!-- Bootstrap Icons CDN -->
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/bootstrap-icons.svg"></script>


  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    xintegrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
<?php include('header.php') ?>
<!-- slider starts -->
<div id="carouselExampleDark" class="carousel slide bg-dark" data-bs-ride="carousel" data-bs-interval="5000">

<!-- Indicators -->
<div class="carousel-indicators">
  <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active"></button>
  <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1"></button>
  <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2"></button>
  <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="3"></button>
  <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="4"></button>
</div>

<!-- Slides -->
<div class="carousel-inner">

  <!-- Slide 1 -->
  <div class="carousel-item active">
    <img src="images/1.png" class="d-block w-100 opacity-50" alt="Desserts">
    <div class="carousel-caption d-none d-md-block text-white bg-dark bg-opacity-50 p-3 rounded">
      <h1 class="text-white">Desserts</h1>
      <p class="text-white">Explore our handcrafted collection of desserts that make every meal memorable.</p>
    </div>
  </div>

  <!-- Slide 2 -->
  <div class="carousel-item">
    <img src="images/3.png" class="d-block w-100 opacity-50" alt="Drinks">
    <div class="carousel-caption d-none d-md-block text-white bg-dark bg-opacity-50 p-3 rounded">
      <h1 class="text-white">Drinks</h1>
      <p class="text-white">Refreshing elixirs and artisanal beverages designed for every season.</p>
    </div>
  </div>

  <!-- Slide 3 -->
  <div class="carousel-item">
    <img src="images/2.png" class="d-block w-100 opacity-50" alt="Pakistani Foods">
    <div class="carousel-caption d-none d-md-block text-white bg-dark bg-opacity-50 p-3 rounded">
      <h1 class="text-white">Pakistani Foods</h1>
      <p class="text-white">A journey through the spices and soul of authentic Pakistani cuisine.</p>
    </div>
  </div>

  <!-- Slide 4 -->
  <div class="carousel-item">
    <img src="images/continental.png" class="d-block w-100 opacity-50" alt="Continental">
    <div class="carousel-caption d-none d-md-block text-white bg-dark bg-opacity-50 p-3 rounded">
      <h1 class="text-white">Continental</h1>
      <p class="text-white">Experience classic continental recipes crafted with passion.</p>
    </div>
  </div>

  <!-- Slide 5 -->
  <div class="carousel-item">
    <img src="images/bakery.png" class="d-block w-100 opacity-50" alt="Bakery">
    <div class="carousel-caption d-none d-md-block text-white bg-dark bg-opacity-50 p-3 rounded">
      <h1 class="text-white">Bakery</h1>
      <p class="text-white">Freshly baked treats that bring warmth and flavor to every bite.</p>
    </div>
  </div>

</div>

<!-- Controls -->
<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
  <span class="visually-hidden">Previous</span>
</button>

<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
  <span class="carousel-control-next-icon" aria-hidden="true"></span>
  <span class="visually-hidden">Next</span>
</button>

</div>

  <br><br>


  <!-- drinks starts  -->
  <div class="container pb-5">
    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
      <h3 class="m-0" id="drinks"> Cocktails/Drinks:</h3>
      <a href="drinks.php" class="btn mybtn-orange btn-lg">See All</a>
    </div>
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <?php 
      $result = getRecipesByCategory($conn, 'Drinks');
      if(mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
      ?>
      <div class="col">
        <div class="card h-100">
          <img
            src="<?php echo $row['img_url']; ?>"
            class="card-img-top-custom" alt="<?php echo $row['title']; ?>">
          <div class="card-body">
            <h5 class="card-title"><?php echo $row['title']; ?></h5>
            
            <!-- Added Subtitle as requested -->
            <p class="card-text" style="color: #db6b33; font-weight: bold; margin-bottom: 5px;">
                By: <?php echo $row['full_name']; ?>
            </p>

            <p class="card-text"><?php echo substr($row['description'], 0, 100) . '...'; ?></p>
            <a href="recipe-details.php?id=<?php echo $row['id']; ?>" class="btn mybtn-orange">View Recipe</a>
          </div>
        </div>
      </div>
      <?php 
          }
      } else {
          echo "<div class='col-12'><p>No drinks recipes found.</p></div>";
      }4
      ?>
    </div>
  </div>


  <!-- Bakery starts  -->
  <div class="container pb-5">
    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
      <h3 class="m-0" id="bakery">Bakery Items:</h3>
      <a href="bakery.php" class="btn mybtn-orange btn-lg">See All</a>
    </div>
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <?php 
      $result = getRecipesByCategory($conn, 'Bakery');
      if(mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
      ?>
      <div class="col">
        <div class="card h-100">
          <img
            src="<?php echo $row['img_url']; ?>"
            class="card-img-top-custom" alt="<?php echo $row['title']; ?>">
          <div class="card-body">
            <h5 class="card-title"><?php echo $row['title']; ?></h5>
            
            <!-- Added Subtitle -->
            <p class="card-text" style="color: #db6b33; font-weight: bold; margin-bottom: 5px;">
                By: <?php echo $row['full_name']; ?>
            </p>

            <p class="card-text"><?php echo substr($row['description'], 0, 100) . '...'; ?></p>
            <a href="recipe-details.php?id=<?php echo $row['id']; ?>" class="btn mybtn-orange">View Recipe</a>
          </div>
        </div>
      </div>
      <?php 
          }
      } else {
          echo "<div class='col-12'><p>No bakery items found.</p></div>";
      }
      ?>
    </div>
  </div>


  <!-- desserts starts  -->
  <div class="container pb-5">
    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
      <h3 class="m-0" id="dessert">Desserts:</h3>
      <a href="dessert.php" class="btn mybtn-orange btn-lg">See All</a>
    </div>
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <?php 
      $result = getRecipesByCategory($conn, 'Desserts');
      if(mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
      ?>
      <div class="col">
        <div class="card h-100">
          <img
            src="<?php echo $row['img_url']; ?>"
            class="card-img-top-custom" alt="<?php echo $row['title']; ?>">
          <div class="card-body">
            <h5 class="card-title"><?php echo $row['title']; ?></h5>
            
            <!-- Added Subtitle -->
            <p class="card-text" style="color: #db6b33; font-weight: bold; margin-bottom: 5px;">
                By: <?php echo $row['full_name']; ?>
            </p>

            <p class="card-text"><?php echo substr($row['description'], 0, 100) . '...'; ?></p>
            <a href="recipe-details.php?id=<?php echo $row['id']; ?>" class="btn mybtn-orange">View Recipe</a>
          </div>
        </div>
      </div>
      <?php 
          }
      } else {
          echo "<div class='col-12'><p>No dessert recipes found.</p></div>";
      }
      ?>
    </div>
  </div>


  <!-- pakistani starts  -->
  <div class="container pb-5">
    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
      <h3 class="m-0" id="pakistani">Pakistani Cuisine:</h3>
      <a href="pakistani.php" class="btn mybtn-orange btn-lg">See All</a>
    </div>
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <?php 
      $result = getRecipesByCategory($conn, 'Pakistani');
      if(mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
      ?>
      <div class="col">
        <div class="card h-100">
          <img
            src="<?php echo $row['img_url']; ?>"
            class="card-img-top-custom" alt="<?php echo $row['title']; ?>">
          <div class="card-body">
            <h5 class="card-title"><?php echo $row['title']; ?></h5>
            
            <!-- Added Subtitle -->
            <p class="card-text" style="color: #db6b33; font-weight: bold; margin-bottom: 5px;">
                By: <?php echo $row['full_name']; ?>
            </p>

            <p class="card-text"><?php echo substr($row['description'], 0, 100) . '...'; ?></p>
            <a href="recipe-details.php?id=<?php echo $row['id']; ?>" class="btn mybtn-orange">View Recipe</a>
          </div>
        </div>
      </div>
      <?php 
          }
      } else {
          echo "<div class='col-12'><p>No Pakistani recipes found.</p></div>";
      }
      ?>
    </div>
  </div>


  <!-- Continental starts  -->
  <div class="container pb-5">
    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
      <h3 class="m-0" id="continental">Continental:</h3>
      <a href="continental.php" class="btn mybtn-orange btn-lg">See All</a>
    </div>
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <?php 
      $result = getRecipesByCategory($conn, 'Continental');
      if(mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
      ?>
      <div class="col">
        <div class="card h-100">
          <img
            src="<?php echo $row['img_url']; ?>"
            class="card-img-top-custom" alt="<?php echo $row['title']; ?>">
          <div class="card-body">
            <h5 class="card-title"><?php echo $row['title']; ?></h5>
            
            <!-- Added Subtitle -->
            <p class="card-text" style="color: #db6b33; font-weight: bold; margin-bottom: 5px;">
                By: <?php echo $row['full_name']; ?>
            </p>

            <p class="card-text"><?php echo substr($row['description'], 0, 100) . '...'; ?></p>
            <a href="recipe-details.php?id=<?php echo $row['id']; ?>" class="btn mybtn-orange">View Recipe</a>
          </div>
        </div>
      </div>
      <?php 
          }
      } else {
          echo "<div class='col-12'><p>No Continental recipes found.</p></div>";
      }
      ?>
    </div>
  </div>


  <?php include('footer.php') ?>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    xintegrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
</body>

</html>