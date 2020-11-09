<?php require "elements/doctype.php"; ?>
<html>

<head>
  <title><?php echo App_Name; ?></title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <link rel="stylesheet" href="assets/css/main.css" />
  <style>
    * {
      box-sizing: border-box
    }

    .mySlides1,
    .mySlides2 {
      display: none
    }

    img {
      vertical-align: middle;
    }

    /* Slideshow container */
    .slideshow-container {
      max-width: 1000px;
      position: relative;
      margin: auto;
    }

    /* Next & previous buttons */
    .prev,
    .next {
      cursor: pointer;
      position: absolute;
      top: 50%;
      width: auto;
      padding: 16px;
      margin-top: -22px;
      color: white;
      font-weight: bold;
      font-size: 18px;
      transition: 0.6s ease;
      border-radius: 0 3px 3px 0;
      user-select: none;
    }

    /* Position the "next button" to the right */
    .next {
      right: 0;
      border-radius: 3px 0 0 3px;
    }

    /* On hover, add a grey background color */
    .prev:hover,
    .next:hover {
      background-color: #f1f1f1;
      color: black;
    }
  </style>
</head>

<body class="is-preload">
  <div id="page-wrapper">

    <!-- Header -->
    <?php include_once 'elements/top-bar-normal.php'; ?>

    <!-- Main -->
    <section id="main" class="container">
      <header>
        <h2>Page name</h2>
        <p>Description of the page role for example</p>
      </header>
      <div class="row">
        <div class="col-12">

          <!-- Text -->
          <section class="box">

            <h2 style="text-align:center">Multiple Slideshows</h2>

            <p>Slideshow 1:</p>
            <div class="slideshow-container">
              <div class="mySlides1">
                <img src="images/pic01.jpg" style="width:100%">
              </div>

              <div class="mySlides1">
                <img src="images/pic02.jpg" style="width:100%">
              </div>

              <div class="mySlides1">
                <img src="images/pic03.jpg" style="width:100%">
              </div>

              <a class="prev" onclick="plusSlides(-1, 0)">&#10094;</a>
              <a class="next" onclick="plusSlides(1, 0)">&#10095;</a>
            </div>

            <p>Slideshow 2:</p>
            <div class="slideshow-container">
              <div class="mySlides2">
                <img src="img_band_chicago.jpg" style="width:100%">
              </div>

              <div class="mySlides2">
                <img src="img_band_la.jpg" style="width:100%">
              </div>

              <div class="mySlides2">
                <img src="img_band_ny.jpg" style="width:100%">
              </div>

              <a class="prev" onclick="plusSlides(-1, 1)">&#10094;</a>
              <a class="next" onclick="plusSlides(1, 1)">&#10095;</a>
            </div>
          </section>

        </div>
      </div>
    </section>

    <!-- Footer -->
    <?php include_once 'elements/footer.php'; ?>

  </div>

  <!-- Scripts -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/jquery.dropotron.min.js"></script>
  <script src="assets/js/jquery.scrollex.min.js"></script>
  <script src="assets/js/browser.min.js"></script>
  <script src="assets/js/breakpoints.min.js"></script>
  <script src="assets/js/util.js"></script>
  <script src="assets/js/main.js"></script>
  <script>
    var slideIndex = [1, 1];
    var slideId = ["mySlides1", "mySlides2"]
    showSlides(1, 0);
    showSlides(1, 1);

    function plusSlides(n, no) {
      showSlides(slideIndex[no] += n, no);
    }

    function showSlides(n, no) {
      var i;
      var x = document.getElementsByClassName(slideId[no]);
      if (n > x.length) {
        slideIndex[no] = 1
      }
      if (n < 1) {
        slideIndex[no] = x.length
      }
      for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
      }
      x[slideIndex[no] - 1].style.display = "block";
    }
  </script>
</body>

</html>