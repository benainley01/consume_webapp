<!-- 1. create HTML5 doctype -->
<!DOCTYPE html>
<html lang="en">
  <!-- Link -->
  <!-- https://cs4640.cs.virginia.edu/bsa2up/sprint2/ -->
  <head>
    <meta charset="UTF-8" />

    <!-- 2. include meta tag to ensure proper rendering and touch zooming -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- 
  Bootstrap is designed to be responsive to mobile.
  Mobile-first styles are part of the core framework.
   
  width=device-width sets the width of the page to follow the screen-width
  initial-scale=1 sets the initial zoom level when the page is first loaded   
  -->

    <meta name="author" content="Nancy Hoang and Benjamin Ainley" />
    <meta
      name="description"
      content="Consume is a online restaurant review system allowing users to write and read reviews for local restaurants."
    />

    <title>Consume</title>

    <!-- 3. link bootstrap -->
    <!-- if you choose to use CDN for CSS bootstrap -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU"
      crossorigin="anonymous"
    />
    <!-- 
  Use a link tag to link an external resource. A rel (relationship) specifies relationship between the current document and the linked resource. 
  -->

    <!-- For development, we may want a better-printed CSS, but with larger download size.  Ignore "min"
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.css" rel="stylesheet"> 
  -->
    <!-- if you choose to download bootstrap and host it locally -->
    <!-- <link rel="stylesheet" href="path-to-your-file/bootstrap.min.css" /> -->

    <!-- include your CSS
       by including your CSS last, anything you write may override (depending on specificity) the Bootstrap CSS -->
    <link rel="stylesheet" href="styles.css" />

    <!--star rating buttons from https://www.w3schools.com/howto/howto_css_star_rating.asp-->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    
  </head>

  <body onload="reviewCount()">
    <!-- header and navbar -->
    <header class="p-3 mb-3 border-bottom">
      <div class="container">
        <div
          class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start"
        >
          <a
            href="/"
            class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none"
          >
            <svg
              class="bi me-2"
              width="40"
              height="32"
              role="img"
              aria-label="Bootstrap"
            >
              <use xlink:href="#bootstrap"></use>
            </svg>
          </a>

          <ul
            class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center align-items-center mb-md-0"
          >
            <!-- added align-items-center css-->
            <li>
              <a class="navbar-brand px-2" href="?command=home"
                ><img
                  src="Consume-logos/Consume-logos_transparent.png"
                  width="70"
                  height="70"
                  alt="consume web logo"
              /></a>
            </li>
            <li><a href="?command=home" class="nav-link px-2">Home</a></li>
            <li>
              <a href="?command=myReviews" class="nav-link px-2">My Reviews</a>
            </li>
            <li><a href="?command=addRestaurantPage" class="nav-link px-2">Add Resturaunt</a></li>
            <li><a href="?command=account" class="nav-link px-2">Account</a></li>
            <?php if (!isset($_SESSION["name"])): ?>
            <li><a href="?command=login" class="nav-link px-2">Login</a></li>
            <?php endif; ?>
            <?php if (isset($_SESSION["name"])): ?>
              <li><a href="?command=logout" class="nav-link px-2">Logout</a></li>
            <?php endif; ?>
          </ul>

          <!-- <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
            <input
              type="search"
              class="form-control"
              placeholder="Search..."
              aria-label="Search"
            />
          </form> -->

          <?php
            if (isset($_SESSION["name"])){
              echo $_SESSION["name"];
            }
          ?>
        </div>
      </div>
    </header>
<!-- Page Content -->
    <div class="container">
      <div class="row row-cols-1 g-4">
        <h1><?= $data[0]["name"] ?></h1>
      </div>
      <div class="row row-cols-1 row-cols-md-3 g-4">
        <h4><?= $data[0]["address"] ?></h4>
      </div>
      <div class = "media pb-4">
          <h5> Average Star Rating: <?= $avg; ?> </h5>
      </div>

      <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Write Review
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Write Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Submit review -->
                <form action="?command=addReview" method="post">
                    <div class="mb-3">
                        <label for="restaurantReview" class="form-label">Review</label>
                        <textarea class="form-control" id="restaurantReview" name="restaurantReview" rows="3" required></textarea>
                    </div>

                    <!-- Stars -->
                    <h4>How many stars? </h1>
                    <div class="form-check-inline">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="1">
                        <label class="form-check-label" for="flexRadioDefault1">
                          ★
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="2">
                        <label class="form-check-label" for="flexRadioDefault2">
                          ★★
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3" value="3">
                        <label class="form-check-label" for="flexRadioDefault3">
                          ★★★
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault4" value="4">
                        <label class="form-check-label" for="flexRadioDefault4">
                          ★★★★
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault5" value="5" checked>
                        <label class="form-check-label" for="flexRadioDefault5">
                          ★★★★★
                        </label>
                    </div>    
                    <br><br>
                    <label for="imageReview" class="form-label">Image Link (Optional)</label>
                    <input class="form-control" type="text" id="imageReview" name="imageReview" placeholder="Image URL">
                    <br>
                    <input 
                        type="hidden" 
                        class="form-control" 
                        id="getRestaurant" 
                        name="getRestaurant" 
                        value="<?= $data[0]["restaurantid"]; ?>"
                    />
                    <div class="text-center">                
                        <button type="submit" class="btn btn-primary">Submit Review</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Submit Review</button> -->
            </div>
            </div>
          </div>
        </div>
        <div class="container pt-5">

        <!-- image section -->
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel" style="margin: auto;" >
          <div class="carousel-inner">
            <?php $active = true; ?>
            <?php foreach($reviews as $review): ?>
              <?php if ($review["imageURL"] != NULL):?>
                <div class="carousel-item <?php echo ($active == true)?"active":"" ?>">
                  <img class="img-fluid d-block w-100" src=<?= $review["imageURL"]?> alt="First slide" style="object-fit: cover; overflow: hidden; height: 75vh; object-position: center;">
                  <div class="carousel-caption">
                    <h6>Photo posted by: <?= $review["name"]?></h6>
                  </div>
                </div>
                <?php $active = false; ?>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
        <br>
        <div id="reviewCount">
          
        </div>
                   
        <table class="table" id="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Name</th>
              <th scope="col">Review</th>
              <th scope="col">Rating</th>
            </tr>
          </thead>
          
          <tbody>
            <?php foreach($reviews as $review): ?>
            <tr>
              <td><?=$review["name"]?></td>
              <td><?=$review["text"]?></td>
              <td><?=$review["rating"]?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        </div>
    </div>
<!-- footer -->
    <div class="container">
      <footer
        class="d-flex flex-wrap justify-content-center align-items-center py-3 my-4 border-top"
      >
        <p class="col-md-4 mb-0 text-muted">© 2022, Consume</p>

        <a
          href="/"
          class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none"
        >
          <svg class="bi me-2" width="40" height="32">
            <use xlink:href="#bootstrap"></use>
          </svg>
          <img
            src="Consume-logos/Consume-logos_transparent.png"
            width="70"
            height="70"
            alt="consume web logo"
          />
        </a>

        <ul class="d-flex nav col-md-4 justify-content-end">
          <li class="nav-item">
            <a href="?command=home" class="nav-link px-2">Home</a>
          </li>
          <li class="nav-item">
            <a href="?command=myReviews" class="nav-link px-2">My Reviews</a>
          </li>
          <li><a href="?command=addRestaurantPage" class="nav-link px-2">Add Resturaunt</a></li>
          <li class="nav-item">
            <a href="#" class="nav-link px-2">Account</a>
          </li>
          <?php if (!isset($_SESSION["name"])): ?>
            <li><a href="?command=login" class="nav-link px-2">Login</a></li>
            <?php endif; ?>
            <?php if (isset($_SESSION["name"])): ?>
              <li><a href="?command=logout" class="nav-link px-2">Logout</a></li>
            <?php endif; ?>
        </ul>
      </footer>
    </div>

    <!-- 4. include bootstrap Javascript
        Why at the end of the body?
    -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
      crossorigin="anonymous"
    ></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <!-- <script>
        $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
        })
    </script> -->
    <script>
      function reviewCount(){
        var table = document.getElementById("table");
        var totalRowCount = table.rows.length -1; // 5
        // console.log(totalRowCount)
        if(totalRowCount == 1){
          $('#reviewCount').html("This restaurant has " + totalRowCount + " review");
        } else{
          $('#reviewCount').html("This restaurant has " + totalRowCount + " reviews");
        }
      }
    </script>
  </body>
</html>
