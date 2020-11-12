<?php
if (!isset($_SESSION['SignIn'])) {
    include('view_startpage.php');
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    </link>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="mainPageStyle.css">
    <link rel="stylesheet" href="main.css">

    <style>

    </style>
</head>

<body>
    <div class="container">
        <div></div>
        <div class="mainDiv">
            <div class="leftRightWraper">
                <div class="left">
                    <div class="headder">
                        <h1 class="leftName"><?php echo $_SESSION['username'] ?></h1>
                    </div>
                    <button type="button" id="HomeButton" class="btn btn-primary">Home</button>
                    <button type="button" id="ProfileButton" class="btn btn-primary">Profile</button>
                    <button type="button" id="SubscriptionsButton" class="btn btn-primary">Subscriptions</button>
                    <button type="button" id="FindUsersButton" class="btn btn-primary">Find Users</button>
                </div>
                <div class="right">

                    <div class="headder">
                        <h1 class="rightHeader">Home Page</h1>
                    </div>
                    <h2 class="rightDescription">Make a post</h2>
                    <!-- Main Page -->
                    <div class="MainPage">

                        <!-- post form -->
                        <form>
                            <input type='hidden' name='page' value='MainPage'>
                            <input type='hidden' name='command' value='MakePost'>
                            <textarea name="postText" require class="form-control" id="makeApostText" rows="3"></textarea>
                            <button type="button" id="makePostButton" class="btn btn-primary">Post</button>
                        </form>

                        <div class="devider"></div>
                        <div class="MainPagePostContainer">
                            <!-- <h3 class="rightPostName">Shane</h3>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea> -->


                        </div>

                    </div>
                    <div class="profilePage">
                        <form>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="newUsername" class="form-control" id="newUsername" placeholder="Enter new username">
                                <small id="emailHelp" class="form-text text-muted">The new Username can't already exist</small>
                            </div>
                            <button id="changeNameButton" type="button" class="btn btn-primary">Chane</button>
                        </form>
                    </div>
                    <!-- end Mainpage -->

                    <!-- profile -->
                    <div class="Profile"></div>

                    <!-- subscriptions -->
                    <div class="Subscriptions"></div>

                    <!-- findUsers -->
                    <div class="findusersContainer">
                        <div class="alert alert-success" role="alert">
                            Search for a user
                            <input type="text" name="user" class="form-control" id="searchUsername" placeholder="Enter a username">
                            <button type="button" class="btn btn-primary" id="searchUsernameButton">Search</button>
                        </div>
                        <div class="devider"></div>
                        <div class="FindUsers"></div>
                    </div>
                    <!-- end findUsers -->

                    <!-- otherUserHomePage -->
                    <div class="otherUserHomePageInject"></div>
                </div>
            </div>

        </div>

        <div></div>
    </div>
    <script>
        var controller = "controller.php";
        var username = '<?php echo $_SESSION['username']  ?>';
        displayPosts();

        $("#makePostButton").click(function() {
            var postText = $("#makeApostText").val();
            if (postText == "") {
                alert("Enter your post first")
            } else {
                $.post(controller, {
                        page: "MainPage",
                        command: "MakeAPost",
                        username: username,
                        postText: postText
                    },
                    function(data) {
                        alert(data);
                        displayPosts();
                    }
                )
            }

        })
        //home page
        $("#HomeButton").click(displayPosts);

        function displayPosts() {
            var controller = "controller.php";
            username = username;
            $.post(controller, {
                    page: "MainPage",
                    command: "ShowHome"
                },
                function(data) {
                    var posts = JSON.parse(data);
                    var postList = "";
                    if (posts != null)
                        for (i = 0; i < posts.length; i++) {
                            
                            postList += "<h3 class='rightPostName' onclick='usernameClick(\"" + posts[i]['username']+"\")\' style='cursor: pointer'>" + posts[i]['username'] + "</h3>" +
                                "<textarea readonly class='form-control post' id='exampleFormControlTextarea1' rows='3'>" + posts[i]['postText'] + "</textarea>" +
                                "<button type='button' onclick = 'deletePost(\""+posts[i]['username']+"\",\""+posts[i]['postId']+"\")' class='btn btn-danger'>Delete</button>"
                        }
                    clearScreen();
                    $(".rightHeader").text("Home Page");
                    $(".rightDescription").text("Make a post");
                    $(".MainPage").css('display', 'initial');
                    $(".MainPagePostContainer").html(postList);
                }
            )
        }
        function deletePost(username, postid)
        {
            $.post(controller, {
                    page: "MainPage",
                    command: "DeletePost",
                    postUsername: username,
                    postid: postid
                },
                function(data) {
                    alert(data);
                    displayPosts();
                }
            )
        }
        function usernameClick(username)
        {
            $.post(controller, {
                    page: "MainPage",
                    command: "ShowOtherUserHome",
                    otherUserName:username
                },
                function(data) {
                    var posts = JSON.parse(data);
                    var postList = "";
                    if (posts != null)
                        for (i = 0; i < posts.length; i++) {
                            
                            postList += "<h3 class='rightPostName' onclick='usernameClick(\"" + posts[i]['username']+"\")\' style='cursor: pointer'>" + posts[i]['username'] + "</h3>" +
                                "<textarea readonly class='form-control post' id='exampleFormControlTextarea1' rows='3'>" + posts[i]['postText'] + "</textarea>"
                        }
                    clearScreen();
                    $(".rightHeader").text("Home Page");
                    $(".rightDescription").text(username + "'s homepage");  
                    $(".otherUserHomePageInject").css('display', 'initial');                   
                    $(".otherUserHomePageInject").html(postList);
                }
            )
        }

        //profile
        $("#ProfileButton").click(function() {
            clearScreen();
            $(".rightHeader").text("Profile");
            $(".rightDescription").text("change your username");
            $(".MainPage").css('display', 'none');
            $(".profilePage").css('display', 'initial');
        })
        $("#changeNameButton").click(function() {
            var newUsername = $("#newUsername").val();
            var username = '<?php echo $_SESSION['username']  ?>';
            $.post(controller, {
                    page: "MainPage",
                    command: "ChangeUsername",
                    newUsername: newUsername,
                    username: username
                },
                function(data) {
                    alert(data);
                    if (data == "Name changed")
                        $(".leftName").text(newUsername);
                }
            )
        })
        $("#SubscriptionsButton").click(displaySubscriptions);

        function displaySubscriptions() {
            var controller = "controller.php";
            var username = '<?php echo $_SESSION['username']  ?>';

            $.post(controller, {
                    page: "MainPage",
                    command: "ShowSubscriptions",
                    username: username,
                },
                function(data) {
                    var subscriptions = JSON.parse(data);
                    var subscriptionList = "";
                    if (subscriptions != null)
                        for (i = 0; i < subscriptions.length; i++) {

                            subscriptionList += "<div class='alert alert-success userListItem' role='alert'>" +
                                subscriptions[i]['username'] +
                                "<button type='button' id='userButton' onclick='unSubscribeButtonClick(" + subscriptions[i]['subscribedToId'] + ")' class='btn btn-primary'>unSubscribe</button> </div>";
                        }

                    clearScreen();
                    $(".rightHeader").text("Subscriptions");
                    $(".rightDescription").text("Your subscriptions");
                    $(".Subscriptions").css('display', 'initial');
                    $(".Subscriptions").html(subscriptionList);
                }
            )
        }
        //find users section
        $("#FindUsersButton").click(function() {

            $.post(controller, {
                    page: "MainPage",
                    command: "FindUsers",
                    username: username

                },
                function(data) {
                    var users = JSON.parse(data);
                    var userList = "";
                    if (users != null)
                        for (i = 0; i < users.length; i++) {

                            userList += "<div class='alert alert-success userListItem' role='alert'>" +
                                users[i]['username'] +
                                "<button type='button' id='userButton' onclick='userButtonClick(" + users[i]['userId'] + ")' class='btn btn-primary'>Subscribe</button> </div>";
                        }

                    clearScreen();
                    $(".rightHeader").text("Find Users");
                    $(".rightDescription").text("Users");
                    $(".findusersContainer").css('display', 'initial');
                    $(".FindUsers").html(userList);
                }
            )
        })

        $("#searchUsernameButton").click(function()
        {
            var searchUsername = $("#searchUsername").val();
            $.post(controller, {
                    page: "MainPage",
                    command: "SearchUsername",
                    searchUsername: searchUsername

                },
                function(data) {
                    var users = JSON.parse(data);
                    var userList = "";
                    if (users != null)
                        for (i = 0; i < users.length; i++) {

                            userList += "<div class='alert alert-success userListItem' role='alert'>" +
                                users[i]['username'] +
                                "<button type='button' id='userButton' onclick='userButtonClick(" + users[i]['userId'] + ")' class='btn btn-primary'>Subscribe</button> </div>";
                        }

                    clearScreen();
                    $(".rightHeader").text("Find Users");
                    $(".rightDescription").text("Users");
                    $(".findusersContainer").css('display', 'initial');
                    $(".FindUsers").html(userList);
                }
            )
        })
        
        

        //subscribe button in users was clicked
        function userButtonClick(id) {
            $.post(controller, {
                    page: "MainPage",
                    command: "subscribe",
                    username: username,
                    subscribeId: id

                },
                function(data) {
                    alert(data)
                })

        }
        //unsubscribe button was ckicked
        function unSubscribeButtonClick(id) {
            $.post(controller, {
                    page: "MainPage",
                    command: "unSubscribe",
                    username: username,
                    unSubscribeId: id

                },
                function(data) {
                    alert(data)
                    displaySubscriptions();
                })

        }


        function clearScreen() {
            $(".MainPage").css('display', 'none');
            $(".findusersContainer").css('display', 'none');
            $(".Subscriptions").css('display', 'none');
            $(".profilePage").css('display', 'none');
            $(".otherUserHomePageInject").css('display', 'none');
        }
    </script>
</body>

</html>