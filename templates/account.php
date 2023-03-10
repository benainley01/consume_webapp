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
        <div class = "container"> 
          <div class="row col-xs-8">
              <div class="h-100 p-5 bg-light border rounded-3">
                  <h2>Account Information</h2>
                  <?= $error_msg ?>
                  <form action="?command=updateEmail" method="post">
                      <div class="mb-3">
                          <label for="email" class="form-label">Change Email</label>
                          <input type="text" class="form-control" id="newEmail" name="newEmail" placeholder=<?=$_SESSION["email"] ?>>
                          <div id="ehelp" class="form-text"></div>
                      </div>
                      <div class="text-center">                
                          <button type="submit" class="btn btn-primary" id = "submitEmail" name = "submitEmail">Change Email</button>
                      </div>
                  </form>
                  <form action="?command=updatePassword" method="post">
                      <div class="mb-3">
                          <label for="newPassword" class="form-label">New Password</label>
                          <p>Password must contain minimum eight characters, at least one letter, one number, and one special character @$!%*#?&. The only special characters accepted are @$!%*#?&.</p>
                          <input type="password" class="form-control" id="newPassword" name="newPassword"/>
                          <div id="pwhelp" class="form-text"></div>
                      </div>
                      <div class="mb-3">
                          <label for="passwordConfirm" class="form-label">Confirm Password</label>
                          <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm"/>
                          <div id="pwhelp2" class="form-text"></div>
                      </div>
                      <div class="text-center">                
                          <button type="submit" class="btn btn-primary" id = "submit" name = "submit">Change Password</button>
                      </div>
                  </form>
              </div>
          </div>
        </div>
<!-- footer -->
    <div class="container">
      <footer
        class="d-flex flex-wrap justify-content-center align-items-center py-3 my-4 border-top"
      >
        <p class="col-md-4 mb-0 text-muted">?? 2022, Consume</p>

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

    <!-- javascript validation  -->
    <script>
        /*
        passwordValidate() disables the submit button and makes password field invalid
        until password field meets the requirements
        */
        function passwordValidate(len=8){
            var password = document.getElementById("newPassword");
            var passval = password.value;
            var submit = document.getElementById("submit");
            var pwhelp = document.getElementById("pwhelp");
            var regex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;

            if (!regex.test(passval)){
                password.classList.add("is-invalid");
                submit.disabled = true; 
                pwhelp.textContent = "Password must meet requirements";
            }else {
                password.classList.remove("is-invalid");
                submit.disabled = false;
                pwhelp.textContent = "";
            }

        }
        /*
        passwordConfirmValidate() disables submit button and makes confirm password field invalid
        until the confirm password field meets the requirements
        */
        function passwordConfirmValidate(len=8){
            var password = document.getElementById("passwordConfirm");
            var passval = password.value;
            var submit = document.getElementById("submit");
            var pwhelp = document.getElementById("pwhelp2");
            var regex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;

            if (!regex.test(passval)){
                password.classList.add("is-invalid");
                submit.disabled = true; 
                pwhelp.textContent = "Password must meet requirements";
            }else {
                password.classList.remove("is-invalid");
                submit.disabled = false;
                pwhelp.textContent = "";
            }

        }

        // anonymous function below
        document.getElementById("newPassword").addEventListener("keyup", function() {
            passwordValidate(8);
        });
        document.getElementById("passwordConfirm").addEventListener("keyup", function() {
            passwordConfirmValidate(8);
        });

        /*
        emailValidate() disables the submit button and makes email field invalid until 
        email field meets the requirements
        */
        function emailValidate(){
            // var email = document.getElementById("newEmail");
            // var emailval = email.value
            // var submit = document.getElementById("submitEmail");
            // var ehelp = document.getElementById("ehelp");
            // var regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

            //use of JS object
            class emailValidator{
              constructor() {
                this.email = document.getElementById("newEmail");
                this.emailval = this.email.value;
                this.submit = document.getElementById("submitEmail");
                this.ehelp = document.getElementById("ehelp");
                this.regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
              }
            }
            var checker = new emailValidator();
            if (!checker.regex.test(checker.emailval)){
              checker.email.classList.add("is-invalid");
              checker.submit.disabled = true; 
              checker.ehelp.textContent = "Invalid email format.";
            }else {
              console.log("error");
              checker.email.classList.remove("is-invalid");
              checker.submit.disabled = false;
              checker.ehelp.textContent = "";
            }
        }
        document.getElementById("newEmail").addEventListener("keyup", function() {
            emailValidate();
        });

    </script>
  </body>
</html>
