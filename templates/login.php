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
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
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
            <li><a href="#" class="nav-link px-2">Account</a></li>
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

          <!-- <img
            src="https://t4.ftcdn.net/jpg/03/64/21/11/360_F_364211147_1qgLVxv1Tcq0Ohz3FawUfrtONzz8nq3e.jpg"
            alt="profile picture"
            width="38"
            height="38"
            class="profile rounded-circle"
          /> -->

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
      <!-- <?= $error_msg ?> -->
      <section id="section-basic-example">
        <h1>Login/Signup</h1>
        <!-- <h1>Signup</h1> -->
          <div class="bg-white border rounded-5">
            <section class="w-100">
              <div class="container-fluid h-custom">
                <div class="row d-flex justify-content-center  h-100">
                  <!-- <div class="col-md-8 col-lg-6 col-xl-5 offset-xl-1 my-lg-5 py-lg-5"> -->
                    <!-- <h1>Signup</h1> -->
                    
                  <!-- </div> -->
                  <div class="col-md-8 col-lg-6 col-xl-5 offset-xl-1 my-lg-5 m-1">
                    <!-- <h1>Login/Signup</h1> -->
                    <h6 style="color: #2f6dba;">If you are new to consume, enter the information that you will use to login next time. <br><br>
                      If you have signed up before, enter the information that you used last time. 
                    </h6>
                    <h6 style="color: #2f6dba;">
                      Password must contain minimum eight characters, at least one letter, one number, and one special character @$!%*#?&. 
                      The only special characters accepted are @$!%*#?&.
                    </h6>
                    <h6><?= $error_msg ?> </h6>

                    <form action="?command=login" method="post">
                       <!-- Name input -->
                       <div class="form-outline mb-4">
                        <h5>
                          <label class="form-label">Name </label>
                        </h5>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name"/>
                      </div>
                      <!-- Email input -->
                      <div class="form-outline mb-4">
                        <h5>
                          <label class="form-label">Email address</label>
                        </h5>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter an email address"/>
                      </div>

                      <!-- Password input -->
                      <div class="form-outline mb-3">
                        <h5>
                          <label class="form-label">Password</label>
                        </h5>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password"/>
                        <div id="pwhelp" class="form-text"></div>
                      </div>

                      <div class="text-center text-lg-start mt-4 pt-2" id = "loginButton">
                        <button
                          type="submit"
                          class="btn btn-primary btn-lg"
                          style="padding-left: 2.5rem; padding-right: 2.5rem"
                        >
                          Login
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </section>
          </div>
      </section>
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
      function loginPasswordValidate(len=8){
          var password = document.getElementById("password");
          var passval = password.value;
          var pwhelp = document.getElementById("pwhelp");
          var regex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;

          if (!regex.test(passval)){
              password.classList.add("is-invalid");
              pwhelp.textContent = "Password must meet requirements";
          }else {
              password.classList.remove("is-invalid");
              pwhelp.textContent = "";
          }
      }
      document.getElementById("password").addEventListener("keyup", function() {
        loginPasswordValidate(8);
      });

      function loginEmailValidate(){
            var email = document.getElementById("email");
            var emailval = email.value
            var regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

            if (!regex.test(emailval)){
                email.classList.add("is-invalid");
                submit.disabled = true; 
            }else {
                email.classList.remove("is-invalid");
                submit.disabled = false;
            }
        }
        document.getElementById("email").addEventListener("keyup", function() {
          loginEmailValidate();
        });

    </script>

  </body>
</html>
