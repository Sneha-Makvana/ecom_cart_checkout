<?php
include "conn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Shopping</title>
    <?php
    include "header_link.php";
    ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            justify-content: center;
            margin-top: 21px;
        }

        .pagination li {
            margin-right: 10px;
        }

        .pagination li a {
            text-decoration: none;
            color: #007bff;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .pagination li a:hover {
            background-color: #f1f1f1;
        }

        .pagination li.active a {
            background-color: #007bff;
            color: #fff;
        }
    </style>
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

                <div class="form-group d-flex">
                    <input type="text" id="search-input" class="form-control w-50" placeholder="Search for products..." />

                    <select id="category-filter" class="form-control w-50 mx-2">
                        <option value="">Select Category</option>
                        <option value="Women">Women</option>
                        <option value="Children">Children</option>
                        <option value="Men">Men</option>
                    </select>
                </div>

                <div id="product-list" class="row">
                </div>

                <div id="pagination" class="pagination">
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

    <script>
        $(document).ready(function() {

            loadProducts();

            $('#search-input').on('keyup', function() {
                loadProducts(1, $(this).val(), $('#category-filter').val());
            });

            $('#category-filter').on('change', function() {
                loadProducts(1, $('#search-input').val(), $(this).val());
            });

            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                var page = $(this).data('page');
                var search = $('#search-input').val();
                var category = $('#category-filter').val();
                loadProducts(page, search, category);
            });

            function loadProducts(page = 1, search = '', category = '') {
                $.ajax({
                    url: 'fetch_products.php',
                    method: 'GET',
                    data: {
                        page: page,
                        search: search,
                        category: category
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        var products = data.products;
                        var pagination = data.pagination;

                        $('#product-list').html('');

                        if (products === null || products.length === 0) {
                            $('#product-list').html('<p>No products found.</p>');
                        } else {
                            products.forEach(function(product) {
                                var productHtml = `
                        <div class="col-lg-4 col-md-6 item-entry mb-4">
                            <a href="single_product.php?id=${product.id}" class="product-item md-height bg-gray d-block">
                                <img src="uploads/${product.image}" alt="${product.product_name}" class="img-fluid">
                            </a>
                            <div class="d-flex">
                                <h2 class="item-title">
                                    <a href="single_product.php?id=${product.id}">${product.product_name}</a>
                                </h2>
                                <strong class="item-price">$${parseFloat(product.price).toFixed(2)}</strong>
                            </div>
                        </div>
                    `;
                                $('#product-list').append(productHtml);
                            });
                        }

                        $('#pagination').html(pagination);
                    }
                });
            }
        });
    </script>

</body>

</html>