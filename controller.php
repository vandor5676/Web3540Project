<?php 

$x = $_POST['page'];

if (empty($_POST['page'])) {  // When no page is sent from the client; The initial display
                                // You may use if (!isset($_POST['page'])) instead of empty(...).
    $display_type = 'none';  // This variable will be used in 'view_startpage.php'.
                              // It will display the start page without any box, i.e., no SignIn box, no Join box, ...
    $error_message_username = "";
    $error_message_password = "";
    include ('view_startpage.php');
    exit();
}
require('model.php');

if ($_POST['page'] == 'StartPage')
{
    $command = $_POST['command'];
    switch($command) {  // When a command is sent from the client
        case 'SignIn':  // With username and password
            // if (there is an error in username and password) {
            if (!check_validity($_POST['username'], $_POST['password'])) {
                $error_msg_username = '* Wrong username, or';
                $error_msg_password = '* Wrong password'; 

                $display_type = 'signin';  // It will display the start page with the SignIn box.
                                           // This variable will be used in 'view_startpage.php'.
                include('view_startpage.php');
            } 
            else {
                $_SESSION['SignIn'] = 'Yes';
                $_SESSION['username'] = $_POST['username'];
                include('view_mainpage.php');
            }
            exit();

        case 'Join':  // With username, password, email, some other information
            // if (there is an error in username and password) {
            if (check_existence($_POST['username'])) {
                $join_error_msg_username = '* Username exists';
                $display_type = 'join';  // It will display the start page with the SignIn box.
                                           // This variable will be used in 'view_startpage.php'.
                include('view_startpage.php');
            } 
            else if (join_a_user($_POST['username'], $_POST['password'])) {
                $error_msg_username = '';
                $error_msg_password = ''; 

                $display_type = 'signin';
                include('view_startpage.php');
            } 
            else {
                $join_error_msg_username = '* Something wrong';
                $display_type = 'join';  // It will display the start page with the SignIn box.
                                           // This variable will be used in 'view_startpage.php'.
                include('view_startpage.php');
            }
            exit();
        //...
    }
}

?>