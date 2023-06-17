<html><head>
  
  
  <?php
      ob_start();
      session_start();
      if (isset($_SESSION['mail'])) {
        
          header("location:./index.php");
      }
  
      ?>
    
    
    <title>Register</title>
    
  </head>
  <body>
    <div class="container">
      

      <div class="card">
        <h1>Registration</h1>
        <?php
            if(isset($_GET['response'])&&($_GET['response']=='alreadyregistered')){
                echo "<h5>Username is using.</h5>";
            }
            
            ?>
        <form method="post" action="./do.php">
          <div class="form-group">
            <label for="idname">Name:</label>
            <input type="text" id="idname" name="name" required>
          </div>
          <div class="form-group">
            <label for="idusername">Username:</label>
            <input type="text" id="idusername" name="username" required>
          </div>
          <div class="form-group">
            <label for="idpassword">Password:</label>
            <input type="password" id="idpassword" name="password" required>
          </div>
          <div class="form-group">
            <input type="submit" name="register"value="Register">
          </div>
        </form>
      </div>
    </div>
  

</body></html>