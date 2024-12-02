<?php
include "conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['qty'])) {
    $cart_id = intval($_POST['id']);
    $qty = intval($_POST['qty']);

    if ($qty < 1) {
        echo json_encode(["status" => "error", "message" => "Quantity cannot be less than 1."]);
        exit;
    }

    $query = "UPDATE cart SET qty = $qty, total_price = qty * price WHERE id = $cart_id";

    if (mysqli_query($conn, $query)) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update quantity."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
?>



