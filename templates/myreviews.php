<!-- 1. create HTML5 doctype -->
<!DOCTYPE html>
<html lang="en">
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

  <body>
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

          <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
            <input
              type="search"
              class="form-control"
              placeholder="Search..."
              aria-label="Search"
            />
          </form>

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
        <h1>Your Reviews</h1>
        <div id = "cuisineBox">
          <table class="table" id = "table">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Cuisine</th>
                <th scope="col">Count</th>
              </tr>
            </thead>
            
            <tbody>
            </tbody>
          </table>
        </div>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php foreach($myReviews as $review): ?>  
                <div class="col">
                    <div class="card h-100 text-center">
                        <img
                        src="<?= ($review["imageURL"] == NULL) ? "https://wtwp.com/wp-content/uploads/2015/06/placeholder-image.png" : $review["imageURL"] ?>"
                        class="card-img-top"
                        alt="restaurant picture"
                        height="180"
                        />
                        <div class="card-body">
                            <h5 class="card-title"><?= $review["name"]; ?></h5>
                            <p>My Rating: <?= $review["rating"]; ?> stars 
                            <br>
                            <?= $review["text"]; ?>
                            </p>

                            <div class="card-buttons btn-toolbar justify-content-center">
                                <!-- Button trigger modal -->
                                <div>
                                  <button type="button" class="btn btn-outline-success m-1" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $review["reviewid"]; ?>">
                                  Edit
                                  </button>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal<?= $review["reviewid"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Edit Review</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>

                                      <div class="modal-body">
                                        <!-- Submit review -->
                                        <form action="?command=editReview" method="post">
                                            <div class="mb-3">
                                                <label for="editReviewText" class="form-label">Review</label>
                                                <textarea class="form-control" id="editReviewText" name="editReviewText" rows="3"required><?= $review["text"]; ?></textarea>
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
                                            <input class="form-control" type="text" id="imageReview" name="imageReview" placeholder="image URL" value = <?=$review["imageURL"]?>>
                                            <br>
                                            <input 
                                                type="hidden" 
                                                class="form-control" 
                                                id="editReviewID" 
                                                name="editReviewID" 
                                                value="<?= $review["reviewid"]; ?>"
                                            />       
                                            <br>   
                                            <div class="text-center">                
                                                <button type="submit" class="btn btn-outline-success">Submit</button>
                                            </div>
                                        </form>
                                      </div>

                                      <div class="modal-footer"> 
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>          
                                </div> 


                                <!-- Form for processing deleting a review -->
                                <!-- onSubmit = "return confirm('Are you sure you want to delete your review?');" -->
                                <div>
                                  <form action="?command=deleteReview" method="post" id = "deleteForm">
                                      <input type="hidden" class="form-control" id="deleteReview" name="deleteReview" value="<?= $review["reviewid"]; ?>"/>          
                                      <button type="submit" class="btn btn-outline-danger m-1" id = "deleteButton">Delete</button>
                                  </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<!-- footer -->
    <div class="container">
      <footer
        class="d-flex flex-wrap justify-content-center align-items-center py-3 my-4 border-top"
      >
        <p class="col-md-4 mb-0 text-muted">©2022, Consume</p>

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
            <li><a href="?command=home" class="nav-link px-2">Home</a></li>
            <li>
                <a href="?command=myReviews" class="nav-link px-2">My Reviews</a>
            </li>
            <li><a href="?command=addRestaurantPage" class="nav-link px-2">Add Resturaunt</a></li>
            <li><a href="#" class="nav-link px-2">Account</a></li>
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

    <script>
      function getCuisine(){
        var map = new Map();

        // instantiate the object
        var ajax = new XMLHttpRequest();
        // ask for a specific response
        ajax.responseType = "json";
        // open the request
        ajax.open("GET", "?command=myRestaurantsJSON", true);
        // send the request
        ajax.send(null);

        // What happens if the load succeeds
        ajax.addEventListener("load", function() {
          // set question
          if (this.status == 200) { // worked 
            var json = ajax.response;
            var table = document.getElementById("table");

            for (var i = 0; i < json.length; i++){
              if (map.has(json[i].cuisine)){
                map.set(json[i].cuisine, map.get(json[i].cuisine)+1);
              } else{
                map.set(json[i].cuisine, 1);
              }
            }

            map.forEach((value, key, map) => {
              var row = table.insertRow();
              var cell1 = row.insertCell(0);
              var cell2 = row.insertCell(1);
              cell1.innerHTML = key;
              cell2.innerHTML = value;
            }); 
          }
        });

        // What happens on error
        ajax.addEventListener("error", function() {
          document.getElementById("cuisineBox").textContent = "did not work!";
        });

      }
      getCuisine();
  </script>
  </body>
</html>
