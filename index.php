<?php
    session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Solar Energy Sharing</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale = 1.0">
    <link rel="stylesheet" href="indexStyle.css">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
  <header>
    <nav>
      <div class=" main-wrapper">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="Buy.php">Buy</a></li>
            <li><a href="Sell.php">Sell</a></li>
        </ul>
      </div>
        <div class="nav-login">
          <?php
              if (isset($_SESSION['u_email'])) {
                echo '<form  action="include/logout.inc.php" method="post">
                       <button type="submit" name="submit">Logout</button>
                      </form>';
              }else {
                echo '<form  action="include/login.inc.php" method="POST">
                        <input name="Email" type="text" placeholder="E-mail">
                        <input name ="pwd" type="password"  placeholder="password">
                        <button type="submit" name="submit">Login</button>
                      </form>';
              }
           ?>
        </div>
      </nav>
    </header>
      <section>
        <h1 class="title">Welcome to the Solar Energy Sharing platform </h1>
        <section class = "main-contianer">
           <h2>Creat an Account</h2>
          <div class="main-wrapper">
           <form class="signup-form" action="include/signup.inc.php" method="POST">
             <input type="text" name="first"  placeholder="Firstname">
             <input type="text" name="last"   placeholder="Lastname">
             <input type="text" name="email"  placeholder="E-mail">
             <input type="text" name="residentialAddress"  placeholder="Residential Adress">
             <input type="password" name="pwd" placeholder="Password">
             <button type="submit" name="submit">Sign up</button>
           </form>
               <?php
                 $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                 if(strpos($fullUrl, "signup=empty")==true){
                   echo "<p class = 'error'> You did not fill in all fields!</p>";
                   exit();
                 }
                 elseif(strpos($fullUrl, "signup=invalidName")==true){
                   echo "<p class = 'error'> You did used invalid characters!</p>";
                   exit();
                 }
                 elseif(strpos($fullUrl, "signup=email")==true){
                   echo "<p class = 'error'> You used an invalid e-mail!</p>";
                   exit();
                 }
                 elseif(strpos($fullUrl, "signup=success")==true){
                   echo "<p class = 'success'> You have been signed up!</p>";
                   exit();
                 }
                 elseif(strpos($fullUrl, "signup=usertaken")==true){
                   echo "<p class = 'error'> the user have been taken!</p>";
                   exit();
                 }
               ?>
           </div>
       </section>
      </section>
  </body>
</html>
