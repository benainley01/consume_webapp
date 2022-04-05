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
            case "getRestaurant":
                $this->getRestaurant();
                break;
            case "addReview":
                $this->addReview();
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
    private function home(){
        $restaurants = [];
        $data = $this->db->query("select * from project_restaurant");
        if ($data === false){
            $error_msg = "<div class='alert alert-danger'>Error getting all restaurants.</div>";
        } else if(!empty($data)){
            $restaurants = $data;
        }
        include("templates/home.php");
    }

    private function destroySessions() {
        session_destroy();
        // include("templates/login.php");
        header("Refresh:0");
    }

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
                        $_SESSION["password"] = $data[0]["password"];
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

                    $insert = $this->db->query("insert into project_user (name, email, password) values (?, ?, ?);", 
                            "sss", $_POST["name"], $_POST["email"], 
                            password_hash($_POST["password"], PASSWORD_DEFAULT));
                    if ($insert === false) {
                        $error_msg = "<div class='alert alert-danger'>Error inserting user</div>";
                    } else {
                        $_SESSION["name"] = $data[0]["name"];
                        $_SESSION["email"] = $data[0]["email"];
                        $_SESSION["password"] = $data[0]["password"];
                        header("Location: ?command=home");
                    }
                }    
            }
        }
        // echo $_SESSION["name"];
        include("templates/login.php");
    }
    private function addRestaurantPage(){
        $error_msg = "";
        include("templates/add-restaurant.php");
    }

    //fields: name, address, cuisine
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

    private function getRestaurant(){
        $error_msg = "";
        if(isset($_POST["getRestaurant"])){
            $data = $this->db->query("select * from project_restaurant where restaurantid = ?;", "s", $_POST["getRestaurant"]);
            if ($_POST["getRestaurant"] == ""){
                $error_msg = "<div class='alert alert-danger'>Error getting restaurant</div>";
            }
        } else {
            $data = $this->db->query("select * from project_restaurant where restaurantid = ?;", "s", $_GET["getRestaurant"]);
        }
        include("templates/getRestaurant.php");
    }

    private function addReview(){
        $error_msg = "";
        if(($_POST["restaurantReview"]) == "" or ($_POST["flexRadioDefault"]) == 0){
            $error_msg = "<div class='alert alert-danger'>At least one field was left blank</div>";
        }else{
            $insert = $this->db->query("insert into project_review (rating, text, userid, restaurantid) values (?, ?, ?, ?);",
            "ssss", $_POST["flexRadioDefault"], $_POST["restaurantReview"], $_SESSION["userid"], $_POST["getRestaurant"]);
            if ($insert = false){
                $error_msg = "<div class='alert alert-danger'>Error adding restaurant</div>";
            } else {
                header("Location: ?command=getRestaurant");
            }
        }
        // include("templates/getRestaurant.php");
        // header("Location: ?command=getRestaurant");
        $id = $_POST["getRestaurant"];
        header("Location: ?command=home");
        // header("Location: ?command=getRestaurant/?getRestaurant= $id");
        
    }

}