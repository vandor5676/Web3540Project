<?php
//$conn = mysqli_connect('localhost', 'ssteinerf20', 'password5676', 'C354_ssteinerf20');
$conn = mysqli_connect('localhost', 'root', 'password', 'sys');

function check_validity($u, $p) 
{
    global $conn;
    
    $sql = "select * from projectusers where userName = '$u' and password = '$p'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
        return true;
    else
        return false;
}

function check_existence($u) 
{
    global $conn;
    
    $sql = "select * from projectusers where userName = '$u'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
        return true;
    else
        return false;
}

function join_a_user($u, $p) 
{
    global $conn;
    
    $date = date("Ymd");
    
    $sql = "Insert into projectusers values (NULL, '$u', '$p')";
    $result = mysqli_query($conn, $sql);
    
    return $result;
}

function get_user_id($u) 
{
    global $conn;
    
    $sql = "select * from projectusers where userName = '$u'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['userId'];
    } else
        return -1;
}
?>
