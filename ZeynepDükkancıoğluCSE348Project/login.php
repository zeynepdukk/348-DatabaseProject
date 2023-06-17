<html>

<head>
    
    <?php
    
    
    ob_start();
    session_start();
    
    if (isset($_SESSION['mail'])) {
        
        header("location:./index.php");
    }
    
    ?>
    <title>Login </title>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </title>
</head>

<body>
    <div class="container">
        <div class="card">
          
            <h1>Login</h1>
            <?php
            if(isset($_GET['response'])&&($_GET['response']=='success')){
                echo "<h5>Registered successfully.</h5>";
            }elseif(isset($_GET['response'])&&($_GET['response']=='error')){
                echo "<h5>Username or password is wrong!</h5>";

            }elseif(isset($_GET['response'])&&($_GET['response']=='pleasesignin')){
                echo "<h5>Login first!</h5>";

            }
            
            ?>
            <form method="post" action="./do.php">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="login" value="Login">
                </div>
            </form>
        </div>

    </div>


</body>

</html>