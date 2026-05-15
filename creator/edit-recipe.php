<?php
session_start();

// Initialize variables to avoid undefined variable warnings
$recipe = [];
$recipe_id = '';

// 1. Security Check
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo "<script> alert('Please Login First'); window.location.href='../login.php'; </script>";
    exit();
}

include '../db.php';

// 2. Fetch Existing Data (GET Request)
if(isset($_GET['id'])){
    $recipe_id = mysqli_real_escape_string($conn, $_GET['id']);
    $user_id = $_SESSION['user_id'];

    // SECURITY: Only fetch if the recipe belongs to the logged-in user
    $query = mysqli_query($conn, "SELECT * FROM recipes WHERE id='$recipe_id' AND user_id='$user_id'");

    if(mysqli_num_rows($query) > 0){
        $recipe = mysqli_fetch_array($query);
        $recipe_id = $recipe['id'];
    }
    else{
        echo "<script> alert('Recipe not found or you do not have permission to edit it.'); window.location.href='edit-recipes.php'; </script>";
        exit();
    }
}

// 3. Handle Update (POST Request)
if(isset($_POST['update'])){
    $recipe_id = $_POST['recipe_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $prep_time = $_POST['prep_time'];
    $cook_time = $_POST['cook_time'];
    $servings = $_POST['servings'];
    $instructions = mysqli_real_escape_string($conn, $_POST['instructions']);
    $img_url = mysqli_real_escape_string($conn, $_POST['img_url']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
    
    // Nutrition
    $cal = $_POST['cal'];
    $pro = $_POST['pro'];
    $carb = $_POST['carb'];
    $fat = $_POST['fat'];

    // Update Query
    $update_sql = "UPDATE recipes SET 
                    title='$title', 
                    description='$description', 
                    prep_time='$prep_time', 
                    cook_time='$cook_time', 
                    servings='$servings', 
                    category='$category', 
                    img_url='$img_url', 
                    instructions='$instructions', 
                    ingredients='$ingredients', 
                    nutrition_calories='$cal', 
                    nutrition_protein='$pro', 
                    nutrition_carbs='$carb', 
                    nutrition_fat='$fat' 
                   WHERE id='$recipe_id' AND user_id='".$_SESSION['user_id']."'";

    if(mysqli_query($conn, $update_sql)){
        echo "<script> alert('Recipe Updated Successfully!'); window.location.href='manage-recipes.php'; </script>";
    }
    else{
        echo "<script> alert('Error updating recipe: " . mysqli_error($conn) . "'); </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Recipe - TastyBook</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .form-control:focus, .form-select:focus { border-color: #E97438; box-shadow: none; }
        .text-orange { color: #E97438 !important; }
        .bg-orange { background-color: #db6b33 !important; }
        .mybtn-orange { background-color: #E97438 !important; color: white !important; }
        .img-preview-box img { width: 100%; height: 100%; object-fit: cover; }
    </style>
</head>
<body>

  <!-- Navbar -->
  <?php include('header.php'); ?>

    <div class="container mb-5 mt-4">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="fw-bold text-dark">Edit Recipe</h2>
                <p class="text-muted">Update the details of your shared recipe.</p>
            </div>
        </div>

        <form action="edit-recipe.php?id=<?php echo htmlspecialchars(isset($recipe['id']) ? $recipe['id'] : $recipe_id); ?>" method="POST">
            <!-- Hidden ID Field -->
            <input type="hidden" name="recipe_id" value="<?php echo $recipe['id']; ?>">

            <div class="row">
                <!-- LEFT COLUMN -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm p-4 mb-4 bg-white rounded">
                        <h4 class="fw-bold mb-3 text-orange">General Information</h4>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Recipe Title</label>
                            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($recipe['title']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Short Description</label>
                            <textarea name="description" class="form-control" rows="3" required><?php echo htmlspecialchars($recipe['description']); ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label small text-muted">Prep Time (mins)</label>
                                <input type="number" name="prep_time" class="form-control" value="<?php echo $recipe['prep_time']; ?>">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label small text-muted">Cook Time (mins)</label>
                                <input type="number" name="cook_time" class="form-control" value="<?php echo $recipe['cook_time']; ?>">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label small text-muted">Servings</label>
                                <input type="number" name="servings" class="form-control" value="<?php echo $recipe['servings']; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm p-4 mb-4 bg-white rounded">
                        <h4 class="fw-bold mb-3 text-orange">Instructions</h4>
                        <textarea name="instructions" class="form-control" rows="8" required><?php echo htmlspecialchars($recipe['instructions']); ?></textarea>
                    </div>

                    <div class="card border-0 shadow-sm p-4 mb-4 bg-white rounded">
                        <h4 class="fw-bold mb-3 text-orange">Recipe Photo</h4>
                        <div class="mb-3">
                            <label class="form-label">Image URL</label>
                            <input type="url" name="img_url" id="imgUrl" class="form-control" value="<?php echo htmlspecialchars($recipe['img_url']); ?>">
                        </div>
                        <div class="img-preview-box" style="height: 250px; background-color: #eee; border-radius: 8px; overflow:hidden;">
                            <img id="imagePreview" src="<?php echo $recipe['img_url']; ?>" onerror="this.src='https://via.placeholder.com/400x200?text=No+Image';">
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3 text-orange">Category</h5>
                            <select name="category" class="form-select">
                                <option value="Pakistani" <?php if($recipe['category'] == 'Pakistani') echo 'selected'; ?>>Pakistani</option>
                                <option value="Continental" <?php if($recipe['category'] == 'Continental') echo 'selected'; ?>>Continental</option>
                                <option value="Desserts" <?php if($recipe['category'] == 'Desserts') echo 'selected'; ?>>Desserts</option>
                                <option value="Bakery" <?php if($recipe['category'] == 'Bakery') echo 'selected'; ?>>Bakery</option>
                                <option value="Drinks" <?php if($recipe['category'] == 'Drinks') echo 'selected'; ?>>Drinks</option>
                            </select>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                            <h5 class="fw-bold text-orange">Ingredients</h5>
                        </div>
                        <div class="card-body px-4">
                            <p class="text-muted small">One ingredient per line.</p>
                            <textarea name="ingredients" class="form-control" rows="10" required><?php echo htmlspecialchars($recipe['ingredients']); ?></textarea>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4 bg-light">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Nutrition Facts</h5>
                            <div class="row g-2 align-items-center mb-2">
                                <div class="col-6"><label>Calories</label></div>
                                <div class="col-6"><input type="text" name="cal" class="form-control form-control-sm" value="<?php echo $recipe['nutrition_calories']; ?>"></div>
                            </div>
                            <div class="row g-2 align-items-center mb-2">
                                <div class="col-6"><label>Protein</label></div>
                                <div class="col-6"><input type="text" name="pro" class="form-control form-control-sm" value="<?php echo $recipe['nutrition_protein']; ?>"></div>
                            </div>
                            <div class="row g-2 align-items-center mb-2">
                                <div class="col-6"><label>Carbs</label></div>
                                <div class="col-6"><input type="text" name="carb" class="form-control form-control-sm" value="<?php echo $recipe['nutrition_carbs']; ?>"></div>
                            </div>
                            <div class="row g-2 align-items-center">
                                <div class="col-6"><label>Fat</label></div>
                                <div class="col-6"><input type="text" name="fat" class="form-control form-control-sm" value="<?php echo $recipe['nutrition_fat']; ?>"></div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" name="update" class="btn mybtn-orange py-2 text-uppercase fw-bold">Update Recipe</button>
                        <a href="edit-recipes.php" class="btn btn-secondary py-2">Cancel</a>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer class="text-center text-lg-start mt-auto bg-orange">
        <div class="text-center py-3 text-white">
            &copy; 2025 TastyBook. All Rights Reserved
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const imgInput = document.getElementById('imgUrl');
        const imgPreview = document.getElementById('imagePreview');
        imgInput.addEventListener('input', function() {
            if (this.value) { imgPreview.src = this.value; }
        });
    </script>
</body>
</html>