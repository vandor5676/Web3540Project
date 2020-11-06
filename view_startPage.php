<!DOCTYPE html>

<html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    </link>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="main.css">

</head>

<body>
    <div class="container">
        <div></div>
        <div class="mainDiv">
            <button id="showSignIn" type="button" class="btn btn-primary">Sign in</button>
            <button id="showCreateAccount" type="button" class="btn btn-primary">Create an account</button>

            <!-- sign in modal -->
            <div id="signInModal">
                <h1>Sign in</h1>
                <form id="loginform"  method='post' action='controller.php'>
                <input type='hidden' name='page' value='StartPage'>
                <input type='hidden' name='command' value='SignIn'>
                    <div class="form-group">
                        <label for="usernameForLogin">Username</label>
                        <input type="text" name="username" class="form-control" id="usernameForLogin" aria-describedby="" placeholder="Enter username">

                    </div>
                    <div class="form-group">
                        <label for="passwordForLogin">Password</label>
                        <input type="password" name="password" class="form-control" id="passwordForLogin" placeholder="Password">
                    </div>
                    <button id="logIn" type="button" class="btn btn-primary">Sign in</button>
                </form>
            </div>
            <!-- sign up modal -->
            <div id="signUpModal">
                <h1>Create an account</h1>
                <form>
                <input type='hidden' name='page' value='StartPage'>
                <input type='hidden' name='command' value='SignIn'>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="usernameForCreate" aria-describedby="emailHelp" placeholder="Enter username">

                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="passwordForCreate" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
                </form>
            </div>

        </div>
        <div></div>

    </div>

    <script>
        $("#showSignIn").click(function() {
            $("#signInModal").css('display', 'block');
            $("#signUpModal").css('display', 'none');
        })
        $("#showCreateAccount").click(function() {
            $("#signInModal").css('display', 'none');
            $("#signUpModal").css('display', 'block');
        })
        
        $("#logIn").click(function() {
        $("#loginform").submit();
        })
        // $("#logIn").click(function() {
        //     alert("login");
        //     var controller = "controller.php";
        //     var username = $("#usernameForLogin").val();
        //     var password = $("#passwordForLogin").val();
        //     $.post(controller, {

        //             page: "MainPage",
        //             command: "logIn",
        //             username: username,
        //             password: password
        //         }
        //         // ,
        //         // function(data) {
        //         //     $("#pane-result").html("<h1>" + data) + "</h1>";
        //         // }
        //     )
        // })
    </script>
</body>


</html>