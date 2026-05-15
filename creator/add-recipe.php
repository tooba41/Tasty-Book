<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login.php");
    exit();
}

include( '../db.php');

if(isset($_POST['submit'])){

    // Get current user ID
    $user_id = $_SESSION['user_id'];
    
    // Get form data and ESCAPE SPECIAL CHARACTERS
    // mysqli_real_escape_string is vital here, otherwise a recipe named "Chef's Special" will crash the database because of the (') quote.
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

    // Insert Query
    $query = mysqli_query($conn, "INSERT INTO recipes (user_id, title, description, prep_time, cook_time, servings, category, img_url, instructions, ingredients, nutrition_calories, nutrition_protein, nutrition_carbs, nutrition_fat) 
    VALUES ('$user_id', '$title', '$description', '$prep_time', '$cook_time', '$servings', '$category', '$img_url', '$instructions', '$ingredients', '$cal', '$pro', '$carb', '$fat')");

    if($query){
        // Success: Alert and redirect to home
        echo "<script> alert('Recipe Published Successfully!'); window.location.href='../index.php'; </script>";
    }
    else{
        // Error: Show the specific error message for debugging
        echo "<script> alert('Error: " . mysqli_error($conn) . "'); </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Recipe - TastyBook</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
<body>

  <!-- Navbar -->
  <?php include('header.php') ?>

    <div class="container mb-5 mt-4">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="fw-bold text-dark">Share Your Recipe</h2>
                <p class="text-muted">Fill in the details below to add your dish to TastyBook.</p>
            </div>
        </div>

        <form action="add-recipe.php" method="POST">
            <div class="row">
                <!-- LEFT COLUMN -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm p-4 mb-4 bg-white rounded">
                        <h4 class="fw-bold mb-3 text-orange">General Information</h4>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Recipe Title</label>
                            <input type="text" name="title" class="form-control" placeholder="e.g., Spicy Chicken Biryani" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Short Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="A brief description of your dish..." required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label small text-muted">Prep Time (mins)</label>
                                <input type="number" name="prep_time" class="form-control" placeholder="20">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label small text-muted">Cook Time (mins)</label>
                                <input type="number" name="cook_time" class="form-control" placeholder="45">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label small text-muted">Servings</label>
                                <input type="number" name="servings" class="form-control" placeholder="4">
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm p-4 mb-4 bg-white rounded">
                        <h4 class="fw-bold mb-3 text-orange">Instructions</h4>
                        <p class="text-muted small"><strong>Important:</strong> Please write each step on a <strong>new line</strong>.</p>
                        <textarea name="instructions" class="form-control" rows="8" placeholder="1. Marinate the chicken...&#10;2. Boil the rice...&#10;3. Layer the pot..." required></textarea>
                    </div>

                    <div class="card border-0 shadow-sm p-4 mb-4 bg-white rounded">
                        <h4 class="fw-bold mb-3 text-orange">Recipe Photo</h4>
                        <div class="mb-3">
                            <label class="form-label">Image URL</label>
                            <input type="url" name="img_url" id="imgUrl" class="form-control" placeholder="https://..." required>
                        </div>
                        <div class="img-preview-box">
                            <img id="imagePreview" src="" style="display: none;">
                            <span id="previewText">Image Preview</span>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3 text-orange">Category</h5>
                            <select name="category" class="form-select">
                                <option value="Pakistani">Pakistani</option>
                                <option value="Continental">Continental</option>
                                <option value="Desserts">Desserts</option>
                                <option value="Bakery">Bakery</option>
                                <option value="Drinks">Drinks</option>
                            </select>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                            <h5 class="fw-bold text-orange">Ingredients</h5>
                        </div>
                        <div class="card-body px-4">
                            <p class="text-muted small"><strong>Important:</strong> Write each ingredient on a <strong>new line</strong>.</p>
                            <textarea name="ingredients" class="form-control" rows="10" placeholder="1 kg Chicken&#10;2 cups Rice&#10;1 cup Yogurt" required></textarea>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4 bg-light">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Nutrition Facts</h5>
                            <div class="row g-2 align-items-center mb-2">
                                <div class="col-6"><label>Calories</label></div>
                                <div class="col-6"><input type="text" name="cal" class="form-control form-control-sm" placeholder="e.g. 500 kcal"></div>
                            </div>
                            <div class="row g-2 align-items-center mb-2">
                                <div class="col-6"><label>Protein</label></div>
                                <div class="col-6"><input type="text" name="pro" class="form-control form-control-sm" placeholder="e.g. 20g"></div>
                            </div>
                            <div class="row g-2 align-items-center mb-2">
                                <div class="col-6"><label>Carbs</label></div>
                                <div class="col-6"><input type="text" name="carb" class="form-control form-control-sm" placeholder="e.g. 50g"></div>
                            </div>
                            <div class="row g-2 align-items-center">
                                <div class="col-6"><label>Fat</label></div>
                                <div class="col-6"><input type="text" name="fat" class="form-control form-control-sm" placeholder="e.g. 10g"></div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" name="submit" class="btn mybtn-orange py-2 text-uppercase fw-bold">Publish Recipe</button>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <script>
        const imgInput = document.getElementById('imgUrl');
        const imgPreview = document.getElementById('imagePreview');
        const previewText = document.getElementById('previewText');

        imgInput.addEventListener('input', function() {
            if (this.value) {
                imgPreview.src = this.value;
                imgPreview.style.display = 'block';
                previewText.style.display = 'none';
            } else {
                imgPreview.style.display = 'none';
                previewText.style.display = 'block';
            }
        });
    </script>
</body>
</html>