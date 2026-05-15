<?php
session_start();
include 'db.php';
$category = 'Desserts';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TastyBook | Desserts</title>
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
  <!-- Bootstrap Icons CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/bootstrap-icons.svg"></script>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <style> .card-img-top-custom { width: 100%; height: 200px; object-fit: cover; } </style>
</head>

<body>
<?php include('header.php') ?>
<!-- Static Banner Start -->
<div class="position-relative bg-dark text-white" style="max-height: 500px; overflow: hidden;">
    <img src="images/1.png" alt="Desserts Banner" class="w-100 h-100 object-fit-cover" style="max-height: 500px;">
    <div class="position-absolute top-50 start-50 translate-middle text-center bg-dark bg-opacity-50 p-4 rounded" style="max-width: 600px;">
      <h1 class="display-4 fw-bold">Desserts</h1>
      <p class="lead">Explore our handcrafted collection of desserts that make every meal memorable.</p>
    </div>
  </div>
  <!-- Static Banner End -->
  
  <br><br>

  <!-- Content starts  -->
  <div class="container pb-5">
    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
      <h3 class="m-0">All Desserts:</h3>
    </div>
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <?php 
      $sql = "SELECT recipes.*, users.full_name FROM recipes JOIN users ON recipes.user_id = users.id WHERE category = '$category' ORDER BY created_at DESC";
      $result = mysqli_query($conn, $sql);

      if(mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
      ?>
      <div class="col">
        <div class="card h-100">
          <img src="<?php echo trim($row['img_url']); ?>" class="card-img-top-custom" alt="<?php echo $row['title']; ?>" onerror="this.src='https://via.placeholder.com/400x200?text=No+Image';">
          <div class="card-body">
            <h5 class="card-title"><?php echo $row['title']; ?></h5>
            <p class="card-text" style="color: #db6b33; font-weight: bold; margin-bottom: 5px;">By: <?php echo $row['full_name']; ?></p>
            <p class="card-text"><?php echo substr($row['description'], 0, 100) . '...'; ?></p>
            <a href="recipe-details.php?id=<?php echo $row['id']; ?>" class="btn mybtn-orange">View Recipe</a>
          </div>
        </div>
      </div>
      <?php 
          }
      } else {
          echo "<div class='col-12'><p>No recipes found.</p></div>";
      }
      ?>
    </div>
  </div>

  <?php include('footer.php') ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>