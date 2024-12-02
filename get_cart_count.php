<?php
include "conn.php";

$cart_query = "SELECT count(product_name) as total_items FROM cart";
$cart_result = $conn->query($cart_query);
$cart_count = 0;
if ($cart_result && $row = $cart_result->fetch_assoc()) {
    $cart_count = $row['total_items'] ?? 0;
}
echo $cart_count;
?>

