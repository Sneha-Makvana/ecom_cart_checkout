<?php
include "conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['qty'])) {
    $product_id = intval($_POST['id']);
    $qty = intval($_POST['qty']);

    $query = "SELECT * FROM products WHERE id = $product_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        $product_name = $product['product_name'];
        $price = $product['price'];
        $image = $product['image'];
        $total_price = $price * $qty;

        $cart_check_query = "SELECT * FROM cart WHERE product_name = '$product_name'";
        $check_result = mysqli_query($conn, $cart_check_query);

        if (mysqli_num_rows($check_result) > 0) {

            $update_query = "
                UPDATE cart 
                SET qty = qty + $qty, 
                    total_price = total_price + $total_price 
                WHERE product_name = '$product_name'";
            mysqli_query($conn, $update_query);
        } else {
            
            $insert_query = "
                INSERT INTO cart (product_name, price, image, qty, total_price) 
                VALUES ('$product_name', $price, '$image', $qty, $total_price)";
            mysqli_query($conn, $insert_query);
        }

        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Product not found!"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid product ID or quantity!"]);
}
