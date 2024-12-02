<?php
include "conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $cart_id = intval($_POST['id']);
    $query = "DELETE FROM cart WHERE id = $cart_id";

    if (mysqli_query($conn, $query)) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to remove item."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
?>

