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
        header("Location: templates/home.php");
    }

    private function destroySessions() {
        session_destroy();
        header("templates/login.php");
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
                        header("Location: ?command=transactions");
                    }
                }    
            }
        }
        // echo $_SESSION["name"];
        include("templates/login.php");
    }

    //fields: name, category (text or pre-defined select), date, amount, type (credit(deposit)/debit(withdrawal))
    private function addTransaction(){
        $error_msg = "";
        include("templates/addTransaction.php");
    }

    private function add(){
        $error_msg = "";
        if (($_POST["transactionName"] == "") or ($_POST["category"]=="") or ($_POST["date"] == "") or ($_POST["amount"] == 0.00) or ($_POST["type"] == "")) {
            $error_msg = "<div class='alert alert-danger'>No input was provided in one or more fields. Try again</div>";
        } else{
            if (($_POST["type"] == "credit" and $_POST["amount"] > 0) or ($_POST["type"] == "debit" and $_POST["amount"] < 0)){
                $insert = $this->db->query("insert into hw5_transaction (user_id, name, category, t_date, amount, type) values (?, ?, ?, ?, ?, ?);", 
                "isssds", $_SESSION["userid"],$_POST["transactionName"], $_POST["category"], $_POST["date"], $_POST["amount"], $_POST["type"]);
                if ($insert === false) {
                    $error_msg = "<div class='alert alert-danger'>Error adding transaction</div>";
                } else {
                    header("Location: ?command=transactions");
                }
            } else{
                $error_msg = "<div class='alert alert-danger'>You must enter a positive number for credit and a negative number for debit.</div>";
            }
        }
        include("templates/addTransaction.php");
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