<div class="site-navbar bg-white py-2">

    <div class="search-wrap">
        <div class="container">
            <a href="#" class="search-close js-search-close"><span class="icon-close2"></span></a>
            <form action="#" method="post">
                <input type="text" class="form-control" placeholder="Search keyword and hit enter...">
            </form>
        </div>
    </div>

    <div class="container">
        <div class="d-flex align-items-center justify-content-between">
            <div class="logo">
                <div class="site-logo">
                    <a href="main.php" class="js-logo-clone">ShopMax</a>
                </div>
            </div>
            <div class="main-nav d-none d-lg-block">
                <nav class="site-navigation text-right text-md-center" role="navigation">
                    <ul class="site-menu js-clone-nav d-none d-lg-block">
                        <li class="">
                            <a href="main.php">Home</a>
                        </li>
                        <li class="">
                            <a href="product.php">Products</a>
                        </li>
                        <li>
                            <a href="add_product.php">Add Product</a>
                        </li>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="icons">
                <a href="#" class="icons-btn d-inline-block js-search-open"><span class="icon-search"></span></a>
                <a href="#" class="icons-btn d-inline-block"><span class="icon-heart-o"></span></a>
                <?php
                include "conn.php";

                $cart_query = "SELECT count(product_name) as total_items FROM cart";
                $cart_result = $conn->query($cart_query);
                $cart_count = 0;
                if ($cart_result && $row = $cart_result->fetch_assoc()) {
                    $cart_count = $row['total_items'] ?? 0;
                }
                ?>
                <a href="cart.php" class="icons-btn d-inline-block bag">
                    <span class="icon-shopping-bag"></span>
                    <span class="number" id="cart-count"><?= $cart_count ?></span>
                </a>

                <a href="#" class="site-menu-toggle js-menu-toggle ml-3 d-inline-block d-lg-none"><span class="icon-menu"></span></a>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function updateCartCount() {
        $.get("get_cart_count.php", function(data) {
            $("#cart-count").text(data);
        });
    }

    setInterval(updateCartCount, 1000);
</script>