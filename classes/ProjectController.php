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
        if (($_POST["restaurantName"] == "") or ($_POST["restaurantName"] == "") or ($_POST["address"]=="") or ($_POST["cuisine"] == "")) {
            $error_msg = "<div class='alert alert-danger'>No input was provided in one or more fields. Try again</div>";
        } else{
            $data = $this->db->query("select * from project_restaurant where address = ?;", "s", $_POST["address"]);
            if ($data == false){
                $insert = $this->db->query("insert into project_restaurant (name, address, cuisine) values (?, ?, ?);",
                "sss", $_POST["restaurantName"], $_POST["address"], $_POST["cuisine"]);
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

    private function transactions() {
        $error_msg = "";

        //handling current balance
        $balance = 0.00;
        $transactions = array();
        $categoryInfo = array();
        $data = $this->db->query("select sum(amount) as balance from hw5_transaction where user_id = ?;", "i", $_SESSION["userid"]);
        if ($data === false) {
            $error_msg = "<div class='alert alert-danger'>Error getting balance.</div>";
        } else if (!empty($data)) {
            $balance = $data[0]["balance"];
        } 

        // handling transaction list 
        $data = $this->db->query("select * from hw5_transaction where user_id = ? order by t_date desc;", "i", $_SESSION["userid"]);
        if ($data === false) {
            $error_msg = "<div class='alert alert-danger'>Error getting balance.</div>";
        } else if (!empty($data)) {
            $transactions = $data;
        } 

        //handling transaction by category 
        $data = $this->db->query("select category, sum(amount) as balance from hw5_transaction where user_id = ? group by category;", "i", $_SESSION["userid"]);
        if ($data === false) {
            $error_msg = "<div class='alert alert-danger'>Error getting balance.</div>";
        } else if (!empty($data)) {
            $categoryInfo = $data;
        } 

        include("templates/home.php");
    }
}