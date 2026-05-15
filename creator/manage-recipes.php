<?php
session_start();

// 1. Security Check: Redirect if not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo "<script> alert('Please Login First'); window.location.href='../login.php'; </script>";
    exit();
}

include '../db.php';

if(isset($_GET['del_id'])){
    $del_id = intval($_GET['del_id']);
    $user_id = intval($_SESSION['user_id']);

    $sql = "DELETE FROM recipes WHERE id=$del_id AND user_id=$user_id";
    $delete_query = mysqli_query($conn, $sql);

    if($delete_query){
        echo "<script> alert('Recipe Deleted Successfully'); window.location.href='manage-recipes.php'; </script>";
    } else {
        $error = addslashes(mysqli_error($conn));
        echo "<script> alert('Delete failed: {$error}'); window.location.href='manage-recipes.php'; </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Recipes - TastyBook</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* Theme Colors */
        .text-orange { color: #db6b33 !important; }
        .bg-orange { background-color: #db6b33 !important; }
        
        /* Table Styling */
        .table img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
        .action-icon {
            font-size: 1.1rem;
            margin: 0 5px;
            cursor: pointer;
        }
        .btn-edit { color: #db6b33; border: 1px solid #db6b33; }
        .btn-edit:hover { background-color: #db6b33; color: white; }
    </style>
</head>
<body>

    <?php include('header.php') ?>
    
    <div class="container mt-5 mb-5" style="min-height: 60vh;">
        
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">My Shared Recipes</h2>
                <p class="text-muted">Manage the recipes you have contributed to the community.</p>
            </div>
            <a href="add-recipe.php" class="btn btn-dark">
                <i class="fas fa-plus me-2"></i>Add New
            </a>
        </div>

        <!-- Recipes Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">#</th>
                                <th>Image</th>
                                <th>Recipe Title</th>
                                <th>Category</th>
                                <th>Posted On</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $user_id = $_SESSION['user_id'];
                            $sql = "SELECT * FROM recipes WHERE user_id = '$user_id' ORDER BY created_at DESC";
                            $result = mysqli_query($conn, $sql);
                            $count = 1;

                            if(mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_assoc($result)){
                            ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted"><?php echo $count; ?></td>
                                <td>
                                    <img src="<?php echo trim($row['img_url']); ?>" 
                                         alt="Recipe" 
                                         onerror="this.src='https://via.placeholder.com/50';">
                                </td>
                                <td>
                                    <h6 class="mb-0 fw-bold"><?php echo $row['title']; ?></h6>
                                    <small class="text-muted"><?php echo $row['cook_time']; ?> mins cook time</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        <?php echo $row['category']; ?>
                                    </span>
                                </td>
                                <td class="text-muted small">
                                    <?php echo date('M d, Y', strtotime($row['created_at'])); ?>
                                </td>
                                <td class="text-end pe-4">
                                    <!-- EDIT BUTTON -->
                                    <a href="edit-recipe.php?id=<?php echo $row['id']; ?>" 
                                       class="btn btn-sm btn-edit me-1" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>

                                    <!-- DELETE BUTTON -->
                                    <!-- We use onclick to ask for confirmation before deleting -->
                                    <a href="manage-recipes.php?del_id=<?php echo $row['id']; ?>"
                                     class="btn btn-sm btn-danger"
                                     onclick="return confirm('Are you sure you want to delete this recipe? This cannot be undone.');">
                                       <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php 
                                    $count++;
                                }
                            } else {
                                // If no recipes found
                                echo "<tr><td colspan='6' class='text-center py-5 text-muted'>You haven't shared any recipes yet! <br><a href='add-recipe.php' class='text-orange text-decoration-none fw-bold mt-2 d-inline-block'>Share your first recipe</a></td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <footer class="text-center text-lg-start mt-auto" style="background-color: #db6b33;">
        <div class="text-center py-3 text-white">
            &copy; 2025 TastyBook. All Rights Reserved
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>