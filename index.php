<?php
//Benjamin Ainley (bsa2up)
//Sources used: 
// Sources used: https://cs4640.cs.virginia.edu
// https://stackoverflow.com/questions/19011861/is-there-a-float-input-type-in-html5 -->
// https://stackoverflow.com/questions/10258345/php-simple-foreach-loop-with-html -->
// Link to website: https://cs4640.cs.virginia.edu/bsa2up/hw5/ 

session_start();
// Register the autoloader
spl_autoload_register(function($classname) {
    include "classes/$classname.php";
});

// Parse the query string for command
$command = "login";
if (isset($_GET["command"]))
    $command = $_GET["command"];

// If the user's email is not set in the cookies, then it's not
// a valid session (they didn't get here from the login page),
// so we should send them over to log in first before doing
// anything else!
if (!isset($_SESSION["email"])) {
    // they need to see the login
    $command = "login";
}

// Instantiate the controller and run
$project = new ProjectController($command);
$project->run();
?>
