<?php
class ProjectController {
    private $command;
    private $db;
    
    // If using Monolog (with Composer)
    //private $logger;

    public function __construct($command) {
        //***********************************
        // If we use Composer to include the Monolog Logger
        // global $log;
        // $this->logger = new \Monolog\Logger("TriviaController");
        // $this->logger->pushHandler($log);
        //***********************************

        $this->command = $command;

        $this->db = new Database();
    }

    public function run() {
        switch($this->command) {
            case "home":
                $this->home();
                break;
            case "addRestaurantPage":
                $this->addRestaurantPage();
                break;
            case "addRestaurant":
                $this->addRestaurant();
                break;
            case "myReviews":
                $this->myReviews();
                break; 
            case "myRestaurantsJSON":
                $this->myRestaurantsJSON();
                break;
            case "editReview":
                $this->editReview();
                break;
            case "deleteReview":
                $this->deleteReview();
                break; 
            case "getRestaurant":
                $this->getRestaurant();
                break;
            case "addReview":
                $this->addReview();
                break;
            case "account":
                $this->account();
                break;
            case "updateEmail":
                $this->updateEmail();
                break;
            case "updatePassword":
                $this->updatePassword();
                break;
            case "logout":
                $this->destroySessions();
                break;
            case "signup":
                $this->signup();
                break;
            case "login":
            default:
                $this->login();
        }
    }
    
    /*
    home() displays the homepage for Consume. It querys all their restaurants and their data in our database to display on the homaepage. 
    */
    private function home(){
        $restaurants = [];
        $data = $this->db->query("select * from project_restaurant;");
        // SELECT AVG(project_review.rating)
        // FROM project_review NATURAL JOIN project_restaurant

        if ($data === false){
            $error_msg = "<div class='alert alert-danger'>Error getting all restaurants.</div>";
        } else if(!empty($data)){
            $restaurants = $data;

            // $avg_rating = $this->db->query("SELECT AVG(project_review.rating) from project_restaurant NATURAL JOIN project_review WHERE restaurantid = ?;", "i", $data["restaurantid"]);
            // $avg = round($avg_rating[0]["AVG(project_review.rating)"], 1);
            // print_r($avg);
        }
        include("templates/home.php");
    }

    /*
    account() displays the account page that allows users to change their email and/or password. 
    */
    private function account(){
        $error_msg = "";
        include("templates/account.php");
    }

    /*
    updateEmail() changes the user email based on the supplied input. It checks to make sure that the new email deoes not already 
    exist in our database. 
    */
    private function updateEmail(){
        $error_msg = "";
        if ($_POST["newEmail"]!= ""){
            $data = $this->db->query("select * from project_user where email = ?;", "s", $_POST["newEmail"]);
            if (!empty($data)){
                $error_msg = "<div class='alert alert-danger'>Email is already in use. Use another.</div>";
            } else {
                $userid = $_SESSION["userid"];
                $updateEmail = $this->db->query("UPDATE project_user set email = ? WHERE project_user.id = $userid;", "s", $_POST["newEmail"]);
                if ($updateEmail === false){
                    $error_msg = "<div class='alert alert-danger'>Error changing to new email.</div>";
                } else{
                    $_SESSION["email"] = $_POST["newEmail"];
                    $error_msg = "<div class='alert alert-success'>Successful changing email to " . $_SESSION["email"] . "</div>";
                }
            }
        }else{
            $error_msg = "<div class='alert alert-danger'>You didn't enter a new email. Try again.</div>";
        }
        include("templates/account.php");
    }

    /*
    updatePassword() changes the user password based on the supplied input. It checks to make sure both password input fields are equal 
    and that the new password follows the password requirements listed in the instructions. 
    */
    private function updatePassword(){
        $error_msg = "";
        if ($_POST["newPassword"]== "" or $_POST["passwordConfirm"]== ""){
            $error_msg = "<div class='alert alert-danger'>Password inputs fields can not be empty. Try again</div>";
        } else{
            if ($_POST["newPassword"]!= $_POST["passwordConfirm"]){
                $error_msg = "<div class='alert alert-danger'>Password inputs do not match. Try again.</div>";
            } else if (!preg_match("^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$^", $_POST["newPassword"])){
                $error_msg = "<div class='alert alert-danger'>New password does not meet guideline. Try another password.</div>";
            }else{
                $userid = $_SESSION["userid"];
                $updatePassword = $this->db->query("UPDATE project_user set password = ? WHERE project_user.id = $userid;", "s", password_hash($_POST["newPassword"], PASSWORD_DEFAULT));
                if ($updatePassword === false){
                    $error_msg = "<div class='alert alert-danger'>Unexpected error changing to new password.</div>";
                } else{
                    // $_SESSION["password"] = $_POST["newPassword"];
                    $error_msg = "<div class='alert alert-success'>Change password success!</div>";
                }
            }
        }
        include("templates/account.php");
    }

    /*
    myReviews() function retrieves all the reviews that users have written for restaurants. 
    */
    private function myReviews(){
        $myReviews = [];
        $data = $this->db->query("SELECT * from project_restaurant NATURAL JOIN project_review WHERE project_review.userid = ?;", "i", $_SESSION["userid"]);
        if ($data === false){
            $error_msg = "<div class='alert alert-danger'>Error getting your reviews.</div>";
        } else if(!empty($data)){
            $myReviews = $data;
        }
        include("templates/myreviews.php");
    }

    /*
    myRestaurantsJSON() returns a JSON containing all reviews for restaurants the user has created
    */
    private function myRestaurantsJSON(){
        $myRestaurantsJSON;
        $data = $this->db->query("SELECT * from project_restaurant NATURAL JOIN project_review WHERE project_review.userid = ?;", "i", $_SESSION["userid"]);
        $myRestaurantsJSON = json_encode($data, JSON_PRETTY_PRINT);
        echo $myRestaurantsJSON;
        return $myRestaurantsJSON;
    }

    /*
    editReview() performs a SQL query to update a user's review based upon the POST data for editing a review
    */
    private function editReview(){
        $data = $this->db->query("UPDATE project_review set rating = ?, text = ?, imageURL = ? WHERE project_review.reviewid = ?;", "issi", $_POST["flexRadioDefault"], $_POST["editReviewText"], $_POST["imageReview"], $_POST["editReviewID"]);
        if ($data === false){
            $error_msg = "<div class='alert alert-danger'>Error deleting your review.</div>";
        } else{
            header("Location: ?command=myReviews");
        }
    }

    /*
    deleteReview() will remove a review in the database
    */
    private function deleteReview(){
        $data = $this->db->query("delete from project_review where project_review.reviewid = ?;", "i", $_POST["deleteReview"]);
        if ($data === false){
            $error_msg = "<div class='alert alert-danger'>Error deleting your review.</div>";
        } else{
            header("Location: ?command=myReviews");
        }
    }

    /*
    destroySessions() destroys the current $_SESSION variable and is used to log users out 
    */
    private function destroySessions() {
        session_destroy();
        $error_msg="";
        include("templates/login.php");
    }

    /*
    login() allows users to create an account or login to their account. Error messages are displayed for situations 
    where no input was provided in one or more fields, wrong password for the account, and if their password does not
    reach our requirements. Password must contain minimum eight characters, at least one letter, one number and 
    one special character.
    */
    private function login() {
        $error_msg = "";
        if (isset($_POST["email"])) {
            if (($_POST["email"] == "") or ($_POST["name"]=="") or ($_POST["password"] == "")) {
                $error_msg = "<div class='alert alert-danger'>No input was provided in one or more fields. Try again</div>";
            } else{
                $data = $this->db->query("select * from project_user where email = ?;", "s", $_POST["email"]);
                if ($data === false) {
                    $error_msg = "<div class='alert alert-danger'>Error checking for user.</div>";
                } else if (!empty($data)) {
                    if (password_verify($_POST["password"], $data[0]["password"])) {
                        $_SESSION["name"] = $data[0]["name"];
                        $_SESSION["email"] = $data[0]["email"];
                        // $_SESSION["password"] = $data[0]["password"];
                        $_SESSION["userid"] = $data[0]["id"];
                        header("Location: ?command=home");
                    } else {
                        $error_msg = "<div class='alert alert-danger'>Wrong password.</div>";
                    }
                } else { // empty, no user found
                    // TODO: input validation
                    // Note: never store clear-text passwords in the database
                    //       PHP provides password_hash() and password_verify()
                    //       to provide password verification
                    if(
                        !preg_match("^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$^", $_POST["password"])
                    ){
                        echo $error_msg;
                        $error_msg = "<div class='alert alert-danger'>
                        Password must contain minimum eight characters, at least one letter, one number, and one special character @$!%*#?&. 
                        The only special characters accepted are @$!%*#?&. 
                        </div>"; 
                    } else {
                        $insert = $this->db->query("insert into project_user (name, email, password) values (?, ?, ?);", 
                            "sss", $_POST["name"], $_POST["email"], 
                            password_hash($_POST["password"], PASSWORD_DEFAULT));
                        if ($insert === false) {
                            $error_msg = "<div class='alert alert-danger'>Error inserting user</div>";
                        } else {
                            $_SESSION["name"] = $_POST["name"];
                            $_SESSION["email"] = $_POST["email"];
                            $retrieveUserID = $this->db->query("select id from project_user where email = ?;", "s", $_POST["email"]);
                            // $_SESSION["password"] = $data[0]["password"];
                            // $_SESSION["password"] = $data[0]["password"];
                            // $_SESSION["password"] = $data[0]["password"];
                            $_SESSION["userid"] = $retrieveUserID[0]["id"];
                            header("Location: ?command=home");
                        }
                    }
                }    
            }
        }
        // echo $_SESSION["name"];
        include("templates/login.php");
    }

    /*
    addRestaurantPage() displays the page for adding a restaurant to the database
    */
    private function addRestaurantPage(){
        $error_msg = "";
        include("templates/add-restaurant.php");
    }

    /*
    addRestaurant() displays the page but for after the user has enter POST data into the form to add a restaurant. 
    This function checks for it fields were missing and does not allow for duplicate restaurants by checking to make sure 
    addresses are unique.
    */
    private function addRestaurant(){
        $error_msg = "";
        if (($_POST["restaurantName"] == "") or ($_POST["restaurantName"] == "") or ($_POST["address"]=="") or ($_POST["cuisine"] == "") or ($_POST["website"] == "")) {
            $error_msg = "<div class='alert alert-danger'>No input was provided in one or more fields. Try again</div>";
        } else{
            $data = $this->db->query("select * from project_restaurant where address = ?;", "s", $_POST["address"]);
            if ($data == false){
                $insert = $this->db->query("insert into project_restaurant (name, address, cuisine, website) values (?, ?, ?, ?);",
                "ssss", $_POST["restaurantName"], $_POST["address"], $_POST["cuisine"], $_POST["website"]);
                if ($insert = false){
                    $error_msg = "<div class='alert alert-danger'>Error adding restaurant</div>";
                } else {
                    header("Location: ?command=home");
                }
            } else {
                $error_msg = "<div class='alert alert-danger'>Error adding restaurant at that address</div>";
            }
        }
        include("templates/add-restaurant.php");
    }

    /*
    getRestaurant() displays the page for an individual restaurant containing its information, average rating, and reviews. 
    */
    private function getRestaurant(){
        $error_msg = "";
        if(isset($_POST["getRestaurant"])){
            $data = $this->db->query("select * from project_restaurant where restaurantid = ?;", "s", $_POST["getRestaurant"]);
            $avg_rating = $this->db->query("SELECT AVG(project_review.rating) from project_restaurant NATURAL JOIN project_review WHERE restaurantid = ?;", "i", $_POST["getRestaurant"]);
            $avg = round($avg_rating[0]["AVG(project_review.rating)"], 1);

            // SELECT *
            // FROM project_user INNER JOIN project_review 
            // ON project_user.id = project_review.userid
            // WHERE project_review.restaurantid=3

            $reviews = $this->db->query(
                "SELECT name, text, rating, imageURL
                from project_user INNER JOIN project_review
                ON project_user.id = project_review.userid
                WHERE restaurantid = ?;", "i", $_POST["getRestaurant"]
                );

            if ($_POST["getRestaurant"] == ""){
                $error_msg = "<div class='alert alert-danger'>Error getting restaurant</div>";
            }
        } else {
            $data = $this->db->query("select * from project_restaurant where restaurantid = ?;", "s", $_GET["getRestaurant"]);
        }
        include("templates/getRestaurant.php");
    }

    /*
    addReview() adds a review to a restaurant by gathering the POST data for a user's inputted rating and text review.
    The function checks to make sure the user has not already posted a review for that restaurant. 
    */
    private function addReview(){
        $error_msg = "";
        if(($_POST["restaurantReview"]) == "" or ($_POST["flexRadioDefault"]) == 0){
            $error_msg = "<div class='alert alert-danger'>At least one field was left blank</div>";
        }else{
            $check = $this->db->query("SELECT * from project_review WHERE project_review.userid = ? and project_review.restaurantid = ?;", "ii", $_SESSION["userid"], $_POST["getRestaurant"]);
            if(!$check){
                if (empty($_POST["imageReview"])){
                    $insert = $this->db->query("insert into project_review (rating, text, userid, restaurantid) values (?, ?, ?, ?);",
                    "ssii", $_POST["flexRadioDefault"], $_POST["restaurantReview"], $_SESSION["userid"], $_POST["getRestaurant"]);
                    if ($insert = false){
                        $error_msg = "<div class='alert alert-danger'>Error adding restaurant</div>";
                    } else {
                        header("Location: ?command=getRestaurant");
                    }
                }else{
                    $insert = $this->db->query("insert into project_review (rating, text, userid, restaurantid,imageURL) values (?, ?, ?, ?, ?);",
                    "ssiis", $_POST["flexRadioDefault"], $_POST["restaurantReview"], $_SESSION["userid"], $_POST["getRestaurant"], $_POST["imageReview"]);
                    if ($insert = false){
                        $error_msg = "<div class='alert alert-danger'>Error adding restaurant</div>";
                    } else {
                        header("Location: ?command=getRestaurant");
                    }
                }
            } else {
                $error_msg = "<div class='alert alert-danger'>You already wrote a review</div>";
            }
            header("Location: ?command=getRestaurant");
        }
        // include("templates/getRestaurant.php");
        // header("Location: ?command=getRestaurant");
        $id = $_POST["getRestaurant"];
        header("Location: ?command=myReviews");
        // header("Location: ?command=getRestaurant/?getRestaurant= $id");
        
    }

}