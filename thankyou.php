<!DOCTYPE html>
<html lang="en">

<head>
  <title>Thank You</title>
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
          <div class="col-md-12 mb-0"><a href="main.php">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Thank You</strong></div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <span class="icon-check_circle display-3 text-success"></span>
            <h2 class="display-3 text-black">Thank you!</h2>
            <p class="lead mb-5">You order was successfuly completed.</p>
            <p><a href="main.php" class="btn btn-sm height-auto px-4 py-3 btn-primary">Back to shop</a></p>
          </div>
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