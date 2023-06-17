<html>

<head>


    <?php
    ob_start();
    session_start();
    if (!isset($_SESSION['mail'])) {

        header("location:./login.php?response=pleasesignin");
    }

    include "./sqldb.php";

    ?>
    <title>Twitter</title>
</head>

<body>
    <div class="container">
        <div class="card">
            <span>@
                <?php


                $act_user = $sql_object->prepare("SELECT * FROM users where user_username=:user_name");
                $act_user->execute(
                    array(
                        'user_name' => $_SESSION['mail']
                    )
                );
                $user = $act_user->fetch(PDO::FETCH_ASSOC);


                $following = $sql_object->prepare("SELECT * FROM follows where user_id=:user_id");
                $following->execute(
                    array(
                        'user_id' => $user['user_id']
                    )
                );
                $f_users = array();
                while ($following_fetch = $following->fetch(PDO::FETCH_ASSOC)) {
                    array_push($f_users, $following_fetch['following_user_id']);
                }


                if (!empty($f_users)) {
                    $user_tweets = $sql_object->prepare("SELECT * FROM tweets where user_id in (" . implode(',', $f_users) . ") order by tweet_created_at desc");
                    $user_tweets->execute();
                }


                echo $user['user_name']; ?>
            </span>
            <form action="index.php" method="get" style="padding-top:20px">

                <input type="text" name="search" placeholder="Search users" required>
                <button type="submit">Search</button>
            </form>
            <?php



            if (isset($_GET['response']) && ($_GET['response'] == 'following_success')) {
                echo "<h5>User is following now.</h5>";
            } elseif (isset($_GET['response']) && ($_GET['response'] == 'error_following')) {
                echo "<h5>Error!</h5>";

            }
            ?>


            <?php if (isset($_GET['search'])) { ?>


                <h3>Search results:</h3>
                <?php

                $search_object = $_GET['search'];
                $get_users = $sql_object->prepare("SELECT * FROM users WHERE user_name LIKE '%$search_object%' ");
                $get_users->execute();

                while ($search_user = $get_users->fetch(PDO::FETCH_ASSOC)) {
                    if ($search_user['user_id'] != $user['user_id']) {

                        ?>
                        <div class="card">
                            <p><b>Username: </b> <span>
                                    <?php echo $search_user['user_username']; ?>
                                </span> </p>
                            <p><b>Full Name: </b> <span>
                                    <?php echo $search_user['user_name']; ?>
                                </span> </p>


                            <?php

                            $check_following = $sql_object->prepare("SELECT * FROM follows where user_id=:user_id and following_user_id=:f_user_id");
                            $check_following->execute(
                                array(
                                    'user_id' => $user['user_id'],
                                    'f_user_id' => $search_user['user_id']
                                )
                            );
                            $count = $check_following->rowCount();
                            if ($count <= 0) {
                                ?>
                                <form action="./follow.php" method="post">
                                    <input type="hidden" name="follow_user_id" value="<?php echo $search_user['user_id']; ?>">

                                    <input type="submit" value="Follow">
                                </form>

                            <?php } ?>
                        </div>
                        <?php
                    }
                } ?>

                <br>
            <?php } else { ?>
                <h2>Tweets from the Users You are Follow</h2>
                <?php if (!empty($f_users)) {
                    while ($user_tweet = $user_tweets->fetch(PDO::FETCH_ASSOC)) {
                        $ask_tweet_owner = $sql_object->prepare("SELECT * FROM users where user_id=:user_id");
                        $ask_tweet_owner->execute(
                            array(
                                'user_id' => $user_tweet['user_id']
                            )
                        );
                        $owner = $ask_tweet_owner->fetch(PDO::FETCH_ASSOC);
                        ?>


                        <div class="card">
                            <span>@
                                <?php echo $owner['user_name']; ?>
                            </span>

                            <br>

                            <p><b>Content</b>: <span>
                                    <?php echo $user_tweet['tweet_content']; ?>
                                </span></p>
                            <p><b>Created At: </b>: <span>
                                    <?php echo $user_tweet['tweet_created_at']; ?>
                                </span></p>
                            <br>
                        </div>
                    <?php }
                } ?>
            <?php } ?>

            <br>
            <br>
            <button><a href="profile.php" style="color:black;text-decoration:none">Profile</a></button>
            <form action="logout.php" method="post" style="padding-top:20px">

                <input type="submit" name="logout_user" value="Logout">
            </form>
        </div>
    </div>
</body>

</html>