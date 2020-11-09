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
                            <textarea name="postText" class="form-control" id="makeApostText" rows="3"></textarea>
                            <button type="button" id="makePostButton" class="btn btn-primary">Post</button>
                        </form>
                        <div class="devider"></div>
                        <h3 class="rightPostName">Shane</h3>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                    <!-- end Mainpage -->

                    <!-- profile -->
                    <div class="Profile"></div>

                    <!-- subscriptions -->
                    <div class="Sbscriptions"></div>

                    <!-- findUsers -->
                    <div class="FindUsers">
                        <!-- <div class="alert alert-success" role="alert">
                            A simple success alert—check it out!
                            <button type="button" onclick="userButtonClick('test')" class="btn btn-primary">Primary</button>
                        </div> -->
                    </div>
                    <!-- end findUsers -->
                </div>
            </div>

        </div>

        <div></div>
    </div>
    <script>
        var controller = "controller.php";       
        var username = '<?php echo $_SESSION['username']  ?>';

        $("#makePostButton").click(function() {
            var postText = $("#makeApostText").val();
            $.post(controller, {
                    page: "MainPage",
                    command: "MakeAPost",
                    username: username,
                    postText: postText
                },
                function(data) {
                    alert(data);
                }
            )
        })

        $("#ProfileButton").click(function() {
            var postText = $("#makeApostText").val();
            $.post(controller, {
                    page: "MainPage",
                    command: "ShowProfile",
                    username: username,
                    postText: postText
                },
                function(data) {
                    alert(data);
                }
            )
        })
        $("#SubscriptionsButton").click(function() {

            $.post(controller, {
                    page: "MainPage",
                    command: "ShowSubscriptions",
                    username: username,
                    postText: postText
                },
                function(data) {
                    alert(data);
                }
            )
        })
        $("#FindUsersButton").click(function() {

            $.post(controller, {
                    page: "MainPage",
                    command: "FindUsers",
                    username: username

                },
                function(data) {
                    var users = JSON.parse(data);
                    var userList = "";
                    for (i = 0; i < users.length; i++) {

                        userList += "<div class='alert alert-success userListItem' role='alert'>" +
                            users[i]['username'] +
                            "<button type='button' id='userButton' onclick='userButtonClick(" + users[i]['userId'] + ")' class='btn btn-primary'>Subscribe</button> </div>";
                    }

                    $(".MainPage").css('display', 'none');
                    $(".rightHeader").text("Find Users");
                    $(".rightDescription").text("Users");
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
                    subscribeId : id

                },
                function(data) {
                    alert(data)
                })

        }
    </script>
</body>

</html>