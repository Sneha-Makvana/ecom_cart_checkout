<!DOCTYPE html>
<html lang="en">

<head>
  <title>Cart</title>
  <?php
  include "header_link.php";
  ?>

</head>

<body>

  <div class="site-wrap">


    <?php
    include "sidebar.php";
    ?>

    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="main.php">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Cart</strong></div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row mb-5">
          <form class="col-md-12" method="post">
            <div class="site-blocks-table">

              <table class="table table-bordered" id="cart-table">
                <thead>
                  <tr>
                    <th class="product-thumbnail">Image</th>
                    <th class="product-name">Product</th>
                    <th class="product-price">Price</th>
                    <th class="product-quantity">Quantity</th>
                    <th class="product-total">Total</th>
                    <th class="product-remove">Remove</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  include "conn.php";
                  $query = "SELECT * FROM cart";
                  $result = $conn->query($query);

                  while ($row = $result->fetch_assoc()) { ?>
                    <tr data-id="<?= $row['id'] ?>">
                      <td class="product-thumbnail">
                        <img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['product_name']) ?>" class="img-fluid" style="width: 75px; height: auto;">
                      </td>
                      <td class="product-name"><?= htmlspecialchars($row['product_name']) ?></td>
                      <td class="product-price">$<?= number_format($row['price'], 2) ?></td>
                      <td>
                        <input type="number" class="form-control text-center qty-input" value="<?= $row['qty'] ?>" min="1">
                      </td>
                      <td class="product-total">$<?= number_format($row['total_price'], 2) ?></td>
                      <td><button class="btn btn-danger btn-sm remove-btn">X</button></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>

            </div>
          </form>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="row mb-5">

              <div class="col-md-6">
                <button class="btn btn-outline-primary btn-sm btn-block"><a href="main.php">Continue Shopping</a></button>
              </div>
            </div>

          </div>
          <div class="col-md-6 pl-5">
            <div class="row justify-content-end">
              <div class="col-md-7">
                <div class="row">
                  <div class="col-md-12 text-right border-bottom mb-5">
                    <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-6">
                    <span class="text-black">Subtotal</span>
                  </div>
                  <div class="col-md-6 text-right">
                    <strong class="text-black cart-subtotal">$<?= $subtotal_formatted ?></strong>
                  </div>
                </div>
                <div class="row mb-5">
                  <div class="col-md-6">
                    <span class="text-black">Total</span>
                  </div>
                  <div class="col-md-6 text-right">
                    <strong class="text-black cart-total">$<?= $subtotal_formatted ?></strong>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <button class="btn btn-primary btn-lg btn-block" onclick="window.location='checkout.php'">Proceed To Checkout</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
    include "footer.php";
    ?>
  </div>

  <?php
  include "footer_link.php";
  ?>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {

      function updateSubtotal() {
        let subtotal = 0;

        $("#cart-table tbody tr").each(function() {
          const qty = parseInt($(this).find(".qty-input").val()) || 1;
          const price = parseFloat($(this).find(".product-price").text().replace("$", ""));

          const rowTotal = qty * price;
          subtotal += rowTotal;

          $(this).find(".product-total").text(`$${rowTotal.toFixed(2)}`);
        });

        $(".cart-subtotal").text(`$${subtotal.toFixed(2)}`);
        $(".cart-total").text(`$${subtotal.toFixed(2)}`);
      }

      $(".qty-input").on("change", function() {
        const row = $(this).closest("tr");
        const id = row.data("id");
        const qty = parseInt($(this).val()) || 1;

        $.ajax({
          url: "update_cart.php",
          type: "POST",
          data: {
            id: id,
            qty: qty,
          },
          success: function(response) {
            updateSubtotal();
          },
          error: function() {
            alert("Failed to update quantity. Please try again.");
          },
        });
      });

      $(".remove-btn").on("click", function(e) {
        e.preventDefault();

        const row = $(this).closest("tr");
        const id = row.data("id");

        $.ajax({
          url: "remove_from_cart.php",
          type: "POST",
          data: {
            id: id
          },
          success: function(response) {
            const res = JSON.parse(response);

            if (res.status === "success") {
              row.remove(); 
              updateSubtotal();
            } else {
              alert(res.message || "Failed to remove item. Please try again.");
            }
          },
          error: function() {
            alert("Failed to remove item. Please try again.");
          }
        });
      });

      updateSubtotal();
    });
  </script>


</body>

</html>