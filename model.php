<?php
$conn = mysqli_connect('localhost', 'ssteinerf20', 'password5676', 'C354_ssteinerf20');
//$conn = mysqli_connect('localhost', 'root', 'password', 'sys');

function check_validity($u, $p)
{
    global $conn;

    $sql = "select * from projectUsers where username = '$u' and password = '$p'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
        return true;
    else
        return false;
}

function check_existence($u)
{
    global $conn;

    $sql = "select * from projectUsers where username = '$u'";
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

    $sql = "Insert into projectUsers values (NULL, '$u', '$p')";
    $result = mysqli_query($conn, $sql);

    return $result;
}

function get_user_id($u)
{
    global $conn;

    $sql = "select * from projectUsers where username = '$u'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['userId'];
    } else
        return -1;
}

//main page

function make_post($userId, $postText)
{
    global $conn;
    $sql = "insert into projectPosts values (null, $userId, '$postText')";
    $result = mysqli_query($conn, $sql);
    return $result;
}
function get_users($userId)
{
    global $conn;
    $sql = "SELECT userId, username FROM projectUsers 
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
function get_users_from_search($searchusername , $userId)
{
    global $conn;
    $sql = "SELECT userId, username FROM projectUsers 
    where username = '$searchusername' and userId != $userId";
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
    $sql = "insert into projectSubscriptions values (null, $userId, $subscriberId);";
    $result = mysqli_query($conn, $sql);
    return $result;
}
function check_already_subscribed($userId, $subscriberId)
{
    global $conn;

    $sql = "SELECT * FROM projectSubscriptions 
    where userId = '$userId' and subscribedToId = '$subscriberId';";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
        return true;
    else
        return false;
}
function get_posts($userId)
{
    global $conn;
    $sql = "select t2.userId, postText, t2.postId, username from
    (SELECT p.userId, postText,postId FROM projectUsers u
    inner join projectPosts p on u.userId = p.userId
    where u.userId = $userId
    union all
    SELECT p.userId, postText, postId FROM projectUsers u
    inner join projectSubscriptions s on u.userId = s.userId 
    inner join projectPosts p on subscribedToId = p.userId
    where u.userId = $userId  ) as t2
    inner join projectUsers u on t2.userId = u.userId";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $data = [];
        while ($row  = mysqli_fetch_assoc($result))
            $data[] = $row;
        return $data;
    }
}
function delete_post($postId)
{
    global $conn;
    $sql = "delete from projectPosts
    where postId = $postId";
    $result = mysqli_query($conn, $sql);
    return $result;
}
function ShowOtherUserHome($otheruserId)
{

}
function get_subscriptions($userId)
{
    global $conn;
    $sql ="select t1.subscribedToId,  u.username from
    (select subscribedToId from projectUsers u
    inner join projectSubscriptions s on u.userId = s.userId
    where u.userId =$userId) as t1
    inner join projectUsers u on t1.subscribedToId = u.userId";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $data = [];
        while ($row  = mysqli_fetch_assoc($result))
            $data[] = $row;
        return $data;
    }
}
function delete_subscription($userId,$subscriptionuserId)
{
    global $conn;
    $sql ="select subscriptionId from projectSubscriptions
    where userId = $userId and subscribedToId = $subscriptionuserId";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
       $row= (int)$row['subscriptionId'];
    }
    else{
        return false;
    }
    //delete from table
    $sql = "delete from projectSubscriptions
    where subscriptionId = $row";

    $result = mysqli_query($conn, $sql);
    return $result;
}
function change_username($newusername,$userId)
{
    if(check_existence($newusername))
    {
        return false;
    }

    global $conn;
    $sql ="update projectUsers
    set username = '$newusername'
    where
    userId = $userId";

    $result = mysqli_query($conn, $sql);
    return $result;
}
function delete_account($userId)
{
    global $conn;
    $sql ="delete FROM projectPosts
    where userId = $userId;";
    $result = mysqli_query($conn, $sql);

    $sql ="delete FROM projectSubscriptions
    where userId = $userId;";
    $result = mysqli_query($conn, $sql);

    $sql ="delete FROM projectUsers
    where userId = $userId;";
    $result = mysqli_query($conn, $sql);
}
