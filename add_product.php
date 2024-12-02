<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> -->
    <title>Product Form</title>
    <style>
        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
    <?php include "header_link.php"; ?>
</head>

<body>
    <div class="wrapper">
        <?php include "sidebar.php"; ?>
        <div class="main">

            <main class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content">
                    <div class="row">
                        <div class="col-12 col-lg-8 mx-auto">
                            <div class="card mt-5">
                                <div class="card-header">
                                    <h5 class="card-title mb-0 text-secondary fs-4">Add Product</h5>
                                </div>
                                <form action="" id="customerForm" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="form-row align-items-center">
                                            <input type="hidden" name="id">

                                            <div class="form-group col-md-3">
                                                <label for="name" class="col-form-label">Product Name</label>
                                            </div>
                                            <div class="form-group col-md-9 mb-4">
                                                <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter product name">
                                                <div class="error" id="nameError"></div>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="phone_no" class="col-form-label">Description</label>
                                            </div>
                                            <div class="form-group col-md-9 mb-4">
                                                <textarea type="text" class="form-control" id="description" name="description" row="4" placeholder="Enter description"></textarea>
                                                <div class="error" id="decError"></div>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="price" class="col-form-label">Price</label>
                                            </div>
                                            <div class="form-group col-md-9 mb-4">

                                                <input type="number" class="form-control" id="price" name="price" placeholder="Enter price">

                                                <div class="error" id="priceError"></div>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="category" class="col-form-label">Category</label>
                                            </div>
                                            <div class="form-group col-md-9">

                                                <select class="form-select w-100" name="category" id="category" required>
                                                    <option selected disabled>Select category</option>
                                                    <option value="Mens">Mens</option>
                                                    <option value="Women">Women</option>
                                                    <option value="Children">Children</option>
                                                </select>

                                                <div class="error" id="catError"></div>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="qty" class="col-form-label">Qty</label>
                                            </div>
                                            <div class="form-group col-md-9 mb-4">

                                                <input type="number" class="form-control" id="qty" name="qty" placeholder="Enter quantity">

                                                <div class="error" id="qtyError"></div>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="image" class="col-form-label">Product Image</label>
                                            </div>
                                            <div class="form-group col-md-9">
                                                <input type="file" class="form-control" name="image" id="image" accept="image/*">
                                                <div class="error" id="imgError"></div>
                                            </div>

                                            <div class="form-group col-md-12 text-center">
                                                <button type="submit" id="submitBtn" class="btn btn-info btn-lg mt-3">Submit</button>
                                            </div>
                                        </div>
                                        <div id="message"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php include "footer.php"; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#submitBtn").click(function(e) {
                e.preventDefault();
                var isValid = true;
                $(".error").text("");

                var imageInput = $("#image")[0];
                var allowedExtensions = ["jpg", "jpeg", "png", "gif"];
                if (imageInput.files.length > 0) {
                    var fileName = imageInput.files[0].name;
                    var fileExtension = fileName.split(".").pop().toLowerCase();
                    if (!allowedExtensions.includes(fileExtension)) {
                        $("#imageError").text("Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.");
                        isValid = false;
                    }
                }

                if ($("#product_name").val().trim() === "") {
                    $("#nameError").text("Product Name is required.");
                    isValid = false;
                }


                if ($("#description").val().trim() === "") {
                    $("#decError").text("description is required.");
                    isValid = false;
                }

                if ($("#price").val().trim() === "") {
                    $("#priceError").text("price is required.");
                    isValid = false;
                }

                if ($("#category").val() === null) {
                    $("#catError").text("Please select a category.");
                    isValid = false;
                }

                if ($("#qty").val().trim() === "") {
                    $("#qtyError").text("qty is required.");
                    isValid = false;
                }

                if ($("#image")[0].files.length === 0) {
                    $("#imgError").text("Please upload product image.");
                    isValid = false;
                }

                if (isValid) {
                    var formData = new FormData($('#customerForm')[0]);
                    $.ajax({
                        url: 'insert_product.php',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.includes('success')) {
                                $("#message").html(`<div class="text-success">'Product added successfully!'</div>`);
                            } else {
                                $("#message").html(`<div class="text-danger">${response}</div>`);
                            }
                        },
                        error: function(xhr, status, error) {
                            $("#message").html(`<div class="text-danger">An error occurred: ${error}</div>`);
                        }
                    });
                }
            });
        });
    </script>

    <?php include "footer_link.php"; ?>
</body>

</html>