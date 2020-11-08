<?php
if (!isset($_SESSION['SignIn'])) {
    include('w7_view_startpage.php');
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
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <div class="container">
        <div></div>
        <div class="mainDiv">
            <div class="leftRightWraper">
                <div class="left">left</div>
                <div class="right">right</div>
            </div>

        </div>

        <div></div>
    </div>
</body>

</html>