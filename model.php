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

//main page

function make_post($userID, $postText)
{
    global $conn;
    $sql = "insert into projectposts values (null, $userID, '$postText')";
    $result = mysqli_query($conn, $sql);
    return $result;
}
function get_users($userId)
{
    global $conn;
    $sql = "SELECT userId, username FROM projectusers 
    where userId != $userId";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $data = [];
        while ($row = mysqli_fetch_assoc($result))
            $data[] = $row;
        return $data;
    } else
        return -1;
}
function add_subscription($userId, $subscriberId)
{

    global $conn;
    $sql = "insert into projectsubscriptions values (null, $userId, $subscriberId);";
    $result = mysqli_query($conn, $sql);
    return $result;
}
function check_already_subscribed($userId, $subscriberId)
{
    global $conn;

    $sql = "SELECT * FROM sys.projectsubscriptions 
    where userid = '$userId' and subscribedToId = '$subscriberId';";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
        return true;
    else
        return false;
}
function get_posts($userId)
{
    global $conn;
    $sql = "select t2.userId, postText, username from
    (SELECT p.userId, postText FROM projectusers u
    inner join projectposts p on u.userId = p.userId
    where u.userId = $userId 
    union all
    SELECT p.userId, postText FROM projectusers u
    inner join projectsubscriptions s on u.userId = s.userId 
    inner join projectposts p on subscribedToId = p.userId
    where u.userId = $userId  ) as t2
    inner join projectusers u on t2.userId = u.userId";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $data = [];
        while ($row  = mysqli_fetch_assoc($result))
            $data[] = $row;
        return $data;
    }
}
function get_subscriptions($userId)
{
    global $conn;
    $sql ="select t1.subscribedToId,  u.username from
    (select subscribedToId from projectusers u
    inner join projectsubscriptions s on u.userId = s.userId
    where u.userId =$userId) as t1
    inner join projectusers u on t1.subscribedToId = u.userId";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $data = [];
        while ($row  = mysqli_fetch_assoc($result))
            $data[] = $row;
        return $data;
    }
}
function delete_subscription($userId,$subscriptionUserId)
{
    global $conn;
    $sql ="select subscriptionId from projectsubscriptions
    where userId = $userId and subscribedToId = $subscriptionUserId";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
       $row= (int)$row['subscriptionId'];
    }
    else{
        return false;
    }
    //delete from table
    $sql = "delete from projectsubscriptions
    where subscriptionId = $row";

    $result = mysqli_query($conn, $sql);
    return $result;
}
function change_username($newUsername,$userId)
{
    if(check_existence($newUsername))
    {
        return false;
    }

    global $conn;
    $sql ="update projectusers
    set username = '$newUsername'
    where
    userId = $userId";

    $result = mysqli_query($conn, $sql);
    return $result;
}
