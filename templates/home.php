<!-- 1. create HTML5 doctype -->
<!DOCTYPE html>
<html lang="en">
  <!-- Link -->
  <!-- https://cs4640.cs.virginia.edu/ndh9tsj/final_project/ -->
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
      <div>
        <h1>Consume <button type="button" class="btn btn-primary" onClick="getRandom()">Check out a random restaurant</button></h1>
        
      </div>
      
      <div class="row row-cols-1 row-cols-md-3 g-4" id="row">
        <?php foreach($restaurants as $restaurant): ?>
          <?php $photos = $this->db->query("SELECT imageURL from project_restaurant NATURAL JOIN project_review WHERE restaurantid = ?;", "i", $restaurant["restaurantid"]);?>
          <?php $count = 0;
            foreach($photos as $photo){
              if(!empty($photo["imageURL"])){
                $count += 1;
              };
            }
          ?>

          <div class="col" id = "column">
            <div class="card h-100 text-center">
              <?php if ($count == 0): ?>
                <img
                  src="https://wtwp.com/wp-content/uploads/2015/06/placeholder-image.png"
                  class="card-img-top"
                  alt="restaurant picture"
                  height="180"
                  style="object-fit: cover; overflow: hidden; height: 180px; object-position: center;"
                />
              <div class="card-body">
              <?php else: ?>
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                  <div class="carousel-inner pb-3">
                    <?php $active = true; ?>
                    <?php foreach($photos as $photo): ?>
                      <?php if ($photo["imageURL"] != NULL):?>
                        <div class="carousel-item <?php echo ($active == true)?"active":"" ?>">
                          <img src=<?= $photo["imageURL"]?> class="d-block w-100" alt="image carousel" style="object-fit: cover; overflow: hidden; height: 180px; object-position: center;">
                        </div>
                      <?php $active = false; ?>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </div>

              <?php endif;?>
                <h5 class="card-title"><?= $restaurant["name"]; ?></h5>
                <p class = "card-text">
                  <?= $restaurant["address"]; ?>
                </p>
                <?php
                $avg_rating = $this->db->query("SELECT AVG(project_review.rating) from project_restaurant NATURAL JOIN project_review WHERE restaurantid = ?;", "i", $restaurant["restaurantid"]);
                $avg = round($avg_rating[0]["AVG(project_review.rating)"], 1);
                ?>
                <p class = "card-text">
                  Average Star Rating: 
                  <?= $avg; ?>
                </p>
              </div>

              <div class="card-buttons p-2">
                <!-- <a href="#link" class="btn btn-outline-primary" role="button">Reviews</a> -->
                <form action="?command=getRestaurant" method="post" id = "restForm">
                  <input type="hidden" class="form-control" id="getRestaurant" name="getRestaurant" value="<?= $restaurant["restaurantid"]; ?>"/>          
                  <button type="submit" class="btn btn-outline-primary">Reviews</button>
                  <a
                    href="<?= $restaurant["website"]; ?>"
                    class="btn btn-outline-primary"
                    role="button"
                    target="_blank"
                    >
                    Website
                  </a>
                </form>
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
      function getRestaurants() {
        const cards = document.querySelectorAll(".col");
        const titles = document.querySelectorAll(".card-title");
        document.getElementById("row").innerHTML = "";
        for (var i = 0; i < cards.length; i++) {
          console.log('card: ', cards[i]);
          // document.getElementById("row").appendChild(cards[i]);
        }
        document.getElementById("row").appendChild(cards[1]);
        
        for (var i = 0; i < titles.length; i++) {
          console.log('title: ', titles[i]);
        }
      }

      // https://stackoverflow.com/questions/4959975/generate-random-number-between-two-numbers-in-javascript
      function randomIntFromInterval(min, max) { // min and max included 
        return Math.floor(Math.random() * (max - min + 1) + min)
      }

      const rndInt = randomIntFromInterval(1, 6)
      console.log(rndInt)

      function getRandom() {
        const buttons = document.querySelectorAll("#restForm");
        const rndInt = randomIntFromInterval(0, buttons.length);
        // console.log(buttons[rndInt]);
        buttons[rndInt].submit();
        
      }

    </script>
  </body>
</html>
