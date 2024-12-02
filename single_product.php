<?php
include "conn.php";

if (isset($_GET['id'])) {
  $product_id = intval($_GET['id']);
  $query = "SELECT * FROM products WHERE id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $product_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
  } else {
    echo "Product not found!";
    exit;
  }
} else {
  echo "Invalid product ID!";
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title><?= htmlspecialchars($product['product_name']) ?> - Product Details</title>
  <?php include "header_link.php"; ?>
</head>

<body>
  <div class="site-wrap">
    <?php include "sidebar.php"; ?>

    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0">
            <a href="main.php">Home</a> <span class="mx-2 mb-0">/</span>
            <strong class="text-black"><?= htmlspecialchars($product['product_name']) ?></strong>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <img src="uploads/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>" class="img-fluid">
          </div>
          <div class="col-md-6">
            <h2 class="text-black"><?= htmlspecialchars($product['product_name']) ?></h2>
            <p><?= htmlspecialchars($product['description']) ?></p>
            <p><strong class="text-primary h4">$<?= number_format($product['price'], 2) ?></strong></p>

            <div class="mb-5">
              <div class="input-group mb-3" style="max-width: 120px;">
                <div class="input-group-prepend">
                  <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
                </div>
                <input type="text" class="form-control text-center" value="1" placeholder="" aria-label="Quantity">
                <div class="input-group-append">
                  <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                </div>
              </div>
            </div>
            <p>
              <a href="#" class="add-to-cart-btn btn btn-sm height-auto px-4 py-3 btn-primary" data-id="<?= $product['id'] ?>">Add To Cart</a>
            </p>
            <div id="error-message" class="text-danger" style="display: none;"></div>
            <div id="success-message" class="text-success" style="display: none;"></div>
          </div>

        </div>
      </div>
    </div>
    <?php include "footer.php"; ?>
  </div>

  <?php include "footer_link.php"; ?>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $(".add-to-cart-btn").click(function(e) {
        e.preventDefault();

        const productId = $(this).data("id");
        const qty = parseInt($(".form-control.text-center").val()) || 1;

        $("#error-message, #success-message").text("").hide();

        $.ajax({
          url: "add_to_cart.php",
          type: "POST",
          data: {
            id: productId,
            qty: qty
          },
          success: function(response) {
            try {
              const data = JSON.parse(response);

              if (data.status === "success") {
                $("#success-message").html("Product added to cart successfully!<a href='cart.php'>View</a>").show();
                updateCartCount();
              } else {
                $("#error-message").text("Error: " + data.message).show();
              }
            } catch (err) {
              $("#error-message").text("An unexpected error occurred.").show();
            }
          },
          error: function() {
            $("#error-message").text("An error occurred while adding the product to the cart.").show();
          },
        });
      });
    });

    function updateCartCount() {
      $.get("get_cart_count.php", function(data) {
        $("#cart-count").text(data.count);
      });
    }
  </script>

</body>

</html>