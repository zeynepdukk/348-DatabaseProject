<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

ob_start();
session_start();

include "./sqldb.php";


if(isset($_POST['new_tweet'])){

    $session_user = $sql_object->prepare("SELECT * FROM users where user_username=:user_name");
    $session_user->execute(
        array(
            'user_name' => $_SESSION['mail']
        )
    );
    $user = $session_user->fetch(PDO::FETCH_ASSOC);


    $post_tweet = $sql_object->prepare("INSERT INTO tweets SET
    user_id=:user_id,
    tweet_content=:tweet_content,
    tweet_created_at=:tweet_created_at
    ");

    $post_tweet->execute(array(
        'user_id'=>$user['user_id'],
        'tweet_content'=>$_POST['tweet_content'],
        'tweet_created_at'=>date_create($datetime = "now", timezone_open("Europe/Istanbul"))->format('Y-m-d H:i:s')

    ));
    if($post_tweet){
        Header("location:/profile.php?response=basarili");

    }else{
        Header("location:/profile.php?response=hata");

    }
}

if(isset($_POST['register'])){


    $check_user_name = $sql_object->prepare("SELECT * FROM users where user_username=:user_name");
    $check_user_name->execute(array(
        'user_name'=>$_POST['username']
    ));


    $is_registered = $check_user_name->rowCount();

   if($is_registered){

    Header("location:/register.php?response=alreadyregistered");
   }else{

    $new_user = $sql_object->prepare("INSERT INTO users SET
    user_name=:user_name,
    user_username=:user_username,
    user_password=:user_password,
    user_register_date=:register_date
    ");

    $new_user->execute(array(
        'user_name'=>$_POST['name'],
        'user_username'=>$_POST['username'],
        'user_password'=>md5($_POST['password']),
        'register_date'=>date_create($datetime = "now", timezone_open("Europe/Istanbul"))->format('Y-m-d H:i:s')
    ));


    if($new_user){
        Header("location:/login.php?response=success");

    }else{
        Header("location:/register.php?response=hata");

    }
   }


}

if(isset($_POST['login'])){

    $user_name = htmlspecialchars($_POST['username']);
    $pass = md5($_POST['password']);


    $fetch_user = $sql_object->prepare("SELECT * FROM users WHERE user_username=:user_username and user_password=:user_password ");
    $fetch_user->execute(
        array(
            'user_username' => $user_name,
            'user_password' => $pass
        )
    );


    $count = $fetch_user->rowCount();



    if ($count == 1) {

        $_SESSION['mail'] = $user_name;

        header("location:./index.php");
        exit;
    } else {


        header("location:./login.php?response=error");
    }
}




?>