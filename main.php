<?php
include "conn.php"
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Shopping</title>
  <?php
  include "header_link.php"
  ?>

</head>

<body>

  <div class="site-wrap">

    <?php
    include "sidebar.php";
    ?>

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="title-section mb-5 col-12">
            <h2 class="text-uppercase">Popular Products</h2>
          </div>
        </div>
        <div class="row">
          <?php
          include 'conn.php';

          $query = "SELECT * FROM products ORDER BY id DESC";
          $result = $conn->query($query);

          while ($row = $result->fetch_assoc()) {
            $product_name = htmlspecialchars($row['product_name']);
            $price = number_format($row['price'], 2);
            $image = "uploads/" . htmlspecialchars($row['image']);
          ?>
            <div class="col-lg-4 col-md-6 item-entry mb-4">
              <a href="single_product.php?id=<?= $row['id'] ?>" class="product-item md-height bg-gray d-block">
                <img src="<?= $image ?>" alt="<?= $product_name ?>" class="img-fluid">
              </a>
              <div class="d-flex">
                <h2 class="item-title">
                  <a href="single_product.php?id=<?= $row['id'] ?>"><?= $product_name ?></a>
                </h2>
                <strong class="item-price">$<?= $price ?></strong>
              </div>
            </div>

          <?php } ?>
        </div>
      </div>
    </div>


    <?php
    include "footer.php"
    ?>
  </div>

  <?php
  include "footer_link.php"
  ?>
</body>

</html>