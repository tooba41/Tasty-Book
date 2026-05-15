<?php 
session_start();
include 'db.php'; // Ensure this matches your connection file name

// Check if ID is set in URL
if(isset($_GET['id'])){
    $id = $_GET['id'];
    
    // Fetch recipe details AND the author's name using a JOIN
    $safe_id = mysqli_real_escape_string($conn, $id);
    
    // Query for the MAIN recipe
    $query = mysqli_query($conn, "SELECT recipes.*, users.full_name 
                                  FROM recipes 
                                  JOIN users ON recipes.user_id = users.id 
                                  WHERE recipes.id = '$safe_id'");
    
    if(mysqli_num_rows($query) > 0){
        $recipe = mysqli_fetch_array($query);
        
        // Split Ingredients into array
        $ingredients_list = preg_split('/\r\n|\r|\n/', $recipe['ingredients']);
        
        // Split Instructions into array
        $instructions_list = preg_split('/\r\n|\r|\n/', $recipe['instructions']);
    }
    else{
        echo "<script> alert('Recipe not found'); window.location.href='index.php'; </script>";
        exit();
    }
}
else{
    echo "<script> alert('No Recipe Selected'); window.location.href='index.php'; </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $recipe['title']; ?> - TastyBook</title>
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .text-theme { color: #db6b33 !important; }
        .bg-theme { background-color: #db6b33 !important; }
        .btn-theme { background-color: #db6b33; color: white; border: none; }
        .btn-theme:hover { background-color: #c05a28; color: white; }
        .btn-outline-theme { color: #db6b33; border: 1px solid #db6b33; background: white; }
        .btn-outline-theme:hover { background-color: #db6b33; color: white; }
        
        .recipe-hero-img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 8px;
        }
        
        .form-check-input:checked {
            background-color: #db6b33;
            border-color: #db6b33;
        }
    </style>
</head>
<body>

    <?php include('header.php') ?>
    <br>

    <div class="container mb-5">
        <div class="row">
            
            <!-- LEFT COLUMN -->
            <div class="col-lg-8">
                
                <div class="card border-0 shadow-sm p-3 mb-4 bg-white rounded">
                    <!-- Title & Author -->
                    <h1 class="fw-bold mb-2">
                        <?php echo $recipe['title']; ?> 
                        <span class="fs-4 text-muted" style="font-weight: 400;">by </span>
                        <span class="fs-4 text-theme" style="font-weight: 400;"><?php echo $recipe['full_name']; ?></span>
                    </h1>
                    
                    <div class="d-flex align-items-center mb-3 text-muted small">
                        <span class="me-3"><i class="far fa-clock text-theme me-1"></i> Prep: <?php echo $recipe['prep_time']; ?> mins</span>
                        <span class="me-3"><i class="fas fa-fire text-theme me-1"></i> Cook: <?php echo $recipe['cook_time']; ?> mins</span>
                        <span class="me-3"><i class="fas fa-user-friends text-theme me-1"></i> Serves: <?php echo $recipe['servings']; ?></span>
                    </div>

                    <!-- Main Image -->
                    <img src="<?php echo !empty($recipe['img_url']) ? htmlspecialchars(trim($recipe['img_url'])) : 'https://via.placeholder.com/800x400?text=No+Image'; ?>" 
                         alt="<?php echo htmlspecialchars($recipe['title']); ?>" 
                         class="recipe-hero-img mb-4"
                         onerror="this.src='https://via.placeholder.com/800x400?text=Image+Not+Found';">
                    
                    <p class="lead">
                        <?php echo $recipe['description']; ?>
                    </p>
                    
                    <div class="d-flex gap-2">
                        <button class="btn btn-theme" onclick="window.print()"><i class="fas fa-print me-2"></i>Print Recipe</button>
                    </div>
                </div>

                <!-- Instructions Section -->
                <div class="card border-0 shadow-sm p-4 mb-4 bg-white rounded">
                    <h3 class="fw-bold mb-4 text-theme">Instructions</h3>
                    
                    <?php 
                    $step_num = 1;
                    foreach($instructions_list as $instruction): 
                        if(trim($instruction) != ""):
                    ?>
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <span class="badge bg-theme rounded-circle p-2" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                    <?php echo $step_num; ?>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="fw-bold">Step <?php echo $step_num; ?></h5>
                                <p><?php echo $instruction; ?></p>
                            </div>
                        </div>
                    <?php 
                        $step_num++;
                        endif;
                    endforeach; 
                    ?>
                    
                </div>
            </div>

            <!-- RIGHT COLUMN -->
            <div class="col-lg-4">
                
                <!-- Ingredients Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                        <h4 class="fw-bold text-theme">Ingredients</h4>
                    </div>
                    <div class="card-body px-4">
                        <ul class="list-group list-group-flush">
                            <?php foreach($ingredients_list as $ingredient): 
                                if(trim($ingredient) != ""):
                            ?>
                            <li class="list-group-item border-0 ps-0">
                                <input class="form-check-input me-2" type="checkbox">
                                <label class="form-check-label"><?php echo $ingredient; ?></label>
                            </li>
                            <?php endif; endforeach; ?>
                        </ul>
                    </div>
                </div>

                <!-- Nutrition Facts -->
                <div class="card border-0 shadow-sm mb-4 bg-light">
                    <div class="card-body">
                        <h5 class="fw-bold">Nutrition Facts</h5>
                        <p class="text-muted small mb-3">Per Serving</p>
                        
                        <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                            <span>Calories</span> <span class="fw-bold"><?php echo $recipe['nutrition_calories']; ?></span>
                        </div>
                        <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                            <span>Protein</span> <span class="fw-bold"><?php echo $recipe['nutrition_protein']; ?></span>
                        </div>
                        <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                            <span>Carbs</span> <span class="fw-bold"><?php echo $recipe['nutrition_carbs']; ?></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Fat</span> <span class="fw-bold"><?php echo $recipe['nutrition_fat']; ?></span>
                        </div>
                    </div>
                </div>

                <!-- You Might Also Like (Fixed Click Issue) -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">You might also like</h5>
                        
                        <?php
                        // Fetch 3 random recipes EXCLUDING the current one
                        $related_sql = "SELECT id, title, img_url, cook_time FROM recipes WHERE id != '$safe_id' ORDER BY RAND() LIMIT 3";
                        $related_query = mysqli_query($conn, $related_sql);

                        if(mysqli_num_rows($related_query) > 0){
                            while($related = mysqli_fetch_assoc($related_query)){
                        ?>
                            <!-- 
                                FIX: Added 'position-relative' here.
                                This ensures the 'stretched-link' inside stays contained within this specific div.
                            -->
                            <div class="d-flex align-items-center mb-3 position-relative">
                                <img src="<?php echo !empty($related['img_url']) ? trim($related['img_url']) : 'https://via.placeholder.com/60'; ?>" 
                                     class="rounded me-3" 
                                     alt="<?php echo $related['title']; ?>"
                                     style="width: 60px; height: 60px; object-fit: cover;"
                                     onerror="this.src='https://via.placeholder.com/60?text=No+Img';">
                                <div>
                                    <h6 class="mb-0 fw-bold">
                                        <a href="recipe-details.php?id=<?php echo $related['id']; ?>" class="text-decoration-none text-dark stretched-link">
                                            <?php echo $related['title']; ?>
                                        </a>
                                    </h6>
                                    <small class="text-muted"><?php echo $related['cook_time']; ?> Mins</small>
                                </div>
                            </div>
                        <?php 
                            }
                        } else {
                            echo "<p class='small text-muted'>No other recipes found.</p>";
                        }
                        ?>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center text-lg-start" id="contactus" style="background-color: #db6b33;">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4 mb-md-0 text-center">
                    <h5 style="color: #fff;">Follow Us</h5>
                    <div class="footer-icons" style="color: #fff; font-size: 1.2rem;">
                        <a href="#" style="color: #fff; margin: 0 10px;"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" style="color: #fff; margin: 0 10px;"><i class="fab fa-instagram"></i></a>
                        <a href="#" style="color: #fff; margin: 0 10px;"><i class="fab fa-twitter"></i></a>
                        <a href="#" style="color: #fff; margin: 0 10px;"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 mb-md-0 text-center">
                    <h5 style="color: #fff;">Email Address</h5>
                    <span style="color: #fff;">
                        <i class="fas fa-envelope"></i>&nbsp; &nbsp;
                        <a href="mailto:info@tastybook.com" style="color: #fff; text-decoration: none;">info@tastybook.com</a>
                    </span>
                </div>
                <div class="col-lg-4 col-md-12 mb-4 mb-md-0 text-center">
                    <h5 style="color: #fff;">Tel+</h5>
                    <span style="color: #fff;">
                        <i class="fas fa-phone-alt"></i>&nbsp; &nbsp;
                        <a href="tel:(808) 555-0111" style="color: #fff; text-decoration: none;">(808) 555-0111</a>
                    </span>
                </div>
            </div>
        </div>
        <div class="text-center py-3" style="background-color: #db6b33; color: #fff;">
            &copy; 2025 TastyBook. All Rights Reserved
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>