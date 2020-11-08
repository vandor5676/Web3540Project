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
                    <!-- Main Page -->
                    <div class="MainPage">
                        <div class="headder">
                            <h1 class="rightHeader">Home Page</h1>
                        </div>
                        <h2 class="rightDescription">Make a post</h2>
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

                    </div>
                    <!-- end findUsers -->
                </div>
            </div>

        </div>

        <div></div>
    </div>
    <script>
        var controller = "controller.php";
        $("#makePostButton").click(function() {
            var postText = $("#makeApostText").val();
            var username = '<?php echo $_SESSION['username']  ?>';
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
        $("#SubscriptionsButton").click(function() {

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
        $("#FindUsersButton").click(function() {

            $.post(controller, {
                    page: "MainPage",
                    command: "FindUsers",
                    username: username,
                    postText: postText
                },
                function(data) {
                    alert("in find users callback");
                    $(".MainPage").css('display', 'none');
                }
            )
        })
    </script>
</body>

</html>