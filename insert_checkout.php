<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = $_POST['fname'] ?? '';
    $lname = $_POST['lname'] ?? '';
    $address = $_POST['address'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $notes = $_POST['notes'] ?? '';
    $city = $_POST['city'] ?? '';
    $order_total = str_replace(',', '', $_POST['order_total']);

    $fname = mysqli_real_escape_string($conn, $fname);
    $lname = mysqli_real_escape_string($conn, $lname);
    $address = mysqli_real_escape_string($conn, $address);
    $email = mysqli_real_escape_string($conn, $email);
    $phone = mysqli_real_escape_string($conn, $phone);
    $notes = mysqli_real_escape_string($conn, $notes);
    $city = mysqli_real_escape_string($conn, $city);
    $order_total = mysqli_real_escape_string($conn, $order_total);

    mysqli_begin_transaction($conn);

    try {
        $sql = "INSERT INTO orders (fname, lname, address, email, phone, notes, city, total_amt)
                VALUES ('$fname', '$lname', '$address', '$email', '$phone', '$notes', '$city', '$order_total')";

        if (!mysqli_query($conn, $sql)) {
            throw new Exception('Error inserting order: ' . mysqli_error($conn));
        }

        $order_id = mysqli_insert_id($conn);

        $cart_query = "SELECT * FROM cart";
        $cart_result = mysqli_query($conn, $cart_query);

        if (!$cart_result) {
            throw new Exception('Error retrieving cart items: ' . mysqli_error($conn));
        }

        while ($cart_item = mysqli_fetch_assoc($cart_result)) {
            $product_id = $cart_item['id'];
            $product_name = mysqli_real_escape_string($conn, $cart_item['product_name']);
            $qty = $cart_item['qty'];
            $price = $cart_item['price'];
            $total_price = $price * $qty;

            $order_items_sql = "INSERT INTO order_items (order_id, product_id, product_name, qty, price, total_price)
                                VALUES ('$order_id', '$product_id', '$product_name', '$qty', '$price', '$total_price')";

            if (!mysqli_query($conn, $order_items_sql)) {
                throw new Exception('Error inserting order items: ' . mysqli_error($conn));
            }
        }

        $clear_cart_sql = "DELETE FROM cart";
        if (!mysqli_query($conn, $clear_cart_sql)) {
            throw new Exception('Error clearing cart: ' . mysqli_error($conn));
        }

        mysqli_commit($conn);

        echo json_encode(['success' => true, 'message' => 'Order placed successfully, and cart cleared.']);
    } catch (Exception $e) {

        mysqli_rollback($conn);

        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    mysqli_close($conn);
}
