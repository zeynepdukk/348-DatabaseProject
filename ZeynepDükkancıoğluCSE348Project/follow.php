<?php

ob_start();
session_start();
if (!isset($_SESSION['mail'])) {

    header("location:./index.php");
    exit;
}




include "./sqldb.php";



$act_user = $sql_object->prepare("SELECT * FROM users where user_username=:user_name");
$act_user->execute(
    array(
        'user_name' => $_SESSION['mail']
    )
);
$user = $act_user->fetch(PDO::FETCH_ASSOC);


$follow_user = $sql_object->prepare("INSERT INTO follows SET
user_id =:user_id,
following_user_id=:following_user_id
");



$follow_user->execute(
    array(
        'user_id' => $user['user_id'],
        'following_user_id'=>$_POST['follow_user_id']
    )
);
if($follow_user){
    Header("Location:/index.php?response=following_success");

}else{
    Header("Location:/index.php?response=error_following");

}


?>