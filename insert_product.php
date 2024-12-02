<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $qty = mysqli_real_escape_string($conn, $_POST['qty']);
    
    $image = $_FILES['image'];
    $image_name = time() . "_" . basename($image['name']);
    $image_target = "uploads/" . $image_name;

    if (move_uploaded_file($image['tmp_name'], $image_target)) {
        
        $sql = "INSERT INTO products (product_name, description, price, category, qty, image) 
                VALUES ('$product_name', '$description', $price, '$category', $qty, '$image_name')";
        if (mysqli_query($conn, $sql)) {
            echo "success";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error uploading image.";
    }
}
?>
