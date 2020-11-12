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
session_start();

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
       
        
    }
}
else if ($_POST['page'] == 'MainPage')
{
    $command = $_POST['command'];

    // if(isset($_POST['username']))
    // $userId = get_user_id($_POST['username']);
    if(isset($_SESSION['username']))
    $userId = get_user_id($_SESSION['username']);
    
    switch($command)
    {
        case 'MakeAPost':
            $postText = str_replace("'","''",$_POST['postText']);
            if(make_post($userId,$postText ))
            {
                echo('Posted Successfully');
            }
           else
           {
            echo('Something went wrong');
           }
            exit();

        case 'FindUsers':
            $users = get_users($userId);
            $users = json_encode($users);
            echo($users);
            exit();
        case 'subscribe':
            if(check_already_subscribed($userId,$_POST['subscribeId'] ))
            {
                echo("You are already subscribed");
            }
            else{
                add_subscription($userId, $_POST['subscribeId']);
                echo("Subscribed!");
            }
            exit();
        case 'ShowHome':
            $posts= get_posts($userId);
            $posts = json_encode($posts);
            echo($posts);
            exit();
        case 'ShowSubscriptions':
            $subscriptions = get_subscriptions($userId);
            $subscriptions = json_encode($subscriptions);
            echo($subscriptions);
            exit();
        case 'unSubscribe':
            $subscriptionUserId = $_POST['unSubscribeId'];
            if(delete_subscription($userId,$subscriptionUserId))
            {
                echo("Unsubscribed");
            }
            else{
                echo("Something went wrong");
            }
        case 'ChangeUsername':
            $newUsername = $_POST['newUsername'];           
            if(change_username($newUsername,$userId))
            {
                session_unset();
                session_destroy();
                session_start();
                $_SESSION['SignIn'] = 'Yes';
                $_SESSION['username'] = $newUsername;
                echo("Name changed");                
            }
            else{
                echo("That name is already taken");
            }
    }
}
