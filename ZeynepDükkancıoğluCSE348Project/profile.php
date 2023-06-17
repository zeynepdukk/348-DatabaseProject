<html>

<head>

    <?php


    ob_start();
    session_start();
    if (!isset($_SESSION['mail'])) {

        header("location:./login.php?response=notloggedin");
    }




    include "./sqldb.php";


    $act_user = $sql_object->prepare("SELECT * FROM users where user_username=:user_name");
    $act_user->execute(
        array(
            'user_name' => $_SESSION['mail']
        )
    );
    $user = $act_user->fetch(PDO::FETCH_ASSOC);


    ?>
    <title>Profile</title>
</head>

<body>
    <div class="container">
        <div class="card">

            <h1>Welcome, <?php echo $user['user_name']; ?></h1>
            <?php
            if (isset($_GET['response']) && ($_GET['response'] == 'successfull')) {
                echo "<h5>Successfully posted!</h5>";
            } elseif (isset($_GET['response']) && ($_GET['response'] == 'error')) {
                echo "<h5>Something went wrong </h5>";

            }

            ?>
            <p><b>Username:</b> <span>
                    <?php echo $user['user_username']; ?>
                </span> </p>


            <p><b>Tweets:</b> <span>
                    <?php
                    $user_tweets = $sql_object->prepare("SELECT * FROM tweets where user_id=:user_id");
                    $user_tweets->execute(
                        array(
                            'user_id' => $user['user_id']
                        )
                    );
                    $tweet_count = $user_tweets->rowCount();
                    echo $tweet_count;

                    ?>
                </span> </p>

            <p><b>Followers:</b> <span>
                    <?php
                    $user_followers = $sql_object->prepare("SELECT * FROM follows where following_user_id=:user_id");
                    $user_followers->execute(
                        array(
                            'user_id' => $user['user_id']
                        )
                    );
                    $fllwrs_count = $user_followers->rowCount();
                    echo $fllwrs_count;

                    ?>
                </span> </p>
            <p><b>Following:</b> <span>
                    <?php
                    $user_following = $sql_object->prepare("SELECT * FROM follows where user_id=:user_id");
                    $user_following->execute(
                        array(
                            'user_id' => $user['user_id']
                        )
                    );
                    $following_count = $user_following->rowCount();
                    echo $following_count;

                    ?>
                </span> </p>
            <p><b>Creation Date:</b> <span>
                    <?php
                    echo $user['user_register_date'];
                    ?>
                </span> </p>
            <form action="./do.php" method="POST">

                <textarea name="tweet_content" id="" cols="30" rows="3" placeholder="Write a tweet"></textarea>
                <input type="submit" value="Tweet" name="new_tweet">


            </form>

            <h2>Your Tweets:</h2>
            <?php

            $user_tweets = $sql_object->prepare('SELECT * FROM tweets where user_id=:user_id order by tweet_created_at desc');
            $user_tweets->execute(
                array(
                    'user_id' => $user['user_id']
                )
            );

            while ($user_tweet = $user_tweets->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="card">
                    <p>Content: <span>
                            <?php echo $user_tweet['tweet_content']; ?>
                        </span></p>
                    <p>Created At:  <span>
                            <?php echo $user_tweet['tweet_created_at']; ?>
                        </span></p>
                    <br>
                </div>
            <?php } ?>
            <button><a href="./index.php" >Home</a></button>
            <form action="logout.php" method="post" style="padding-top:25px">

                <input type="submit" value="Logout">
            </form>
        </div>


    </div>


</body>

</html>