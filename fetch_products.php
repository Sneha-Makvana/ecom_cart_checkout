<?php
include "conn.php";

$limit = 3;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';

$searchQuery = "";
$categoryQuery = "";

if ($search) {
    $searchQuery = " WHERE product_name LIKE '%" . $conn->real_escape_string($search) . "%'";
}

if ($category) {
    $categoryQuery = " AND category = '" . $conn->real_escape_string($category) . "'";
}

$finalQuery = $searchQuery . $categoryQuery;

$countQuery = "SELECT COUNT(*) FROM products" . $finalQuery;
$countResult = $conn->query($countQuery);
$totalRecords = $countResult->fetch_row()[0];
$totalPages = ceil($totalRecords / $limit);

$query = "SELECT * FROM products" . $finalQuery . " ORDER BY id DESC LIMIT $start, $limit";
$result = $conn->query($query);

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = [
        'id' => $row['id'],
        'product_name' => htmlspecialchars($row['product_name']),
        'price' => $row['price'],
        'image' => htmlspecialchars($row['image']),
        'category' => htmlspecialchars($row['category'])
    ];
}

if (empty($products)) {
    $products = null;
}

$pagination = '<ul class="pagination">';
if ($page > 1) {
    $pagination .= '<li><a href="#" data-page="' . ($page - 1) . '">Prev</a></li>';
}

for ($i = 1; $i <= $totalPages; $i++) {
    $pagination .= '<li class="' . ($i == $page ? 'active' : '') . '"><a href="#" data-page="' . $i . '">' . $i . '</a></li>';
}

if ($page < $totalPages) {
    $pagination .= '<li><a href="#" data-page="' . ($page + 1) . '">Next</a></li>';
}

$pagination .= '</ul>';

echo json_encode([
    'products' => $products,
    'pagination' => $pagination
]);
