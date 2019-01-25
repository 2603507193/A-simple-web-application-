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
    <?php
    if(!(isset($_SESSION['u_email']))){
      echo "<h1 class='title'>Welcome to the Solar Energy Sharing platform, please sign in to sell the Electricity </h1>
              <img src = 'background.jpg' width='2000' height='800'; > ";

    }else {
      echo "<form class = 'default' action='include/Sell.inc.php' method='post'>
        <h2>Sell Electricity</h2>
          <p>
            <label for='begin_time' class = 'floatLabel'>Transaction Begin Time (Year-month-day Hour:minute)</label>
            <input id = 'begin_time' type='text' name='begin_time'>
          </p>
          <p>
            <label for='end_time' class = 'floatLabel'>Transaction Stop Time (Year-month-day Hour:minute)</label>
            <input id = 'end_time' type='text' name='end_time'>
          </p>
          <p>
            <label for='price' class = 'floatLabel'>Price($)</label>
            <input id = 'price' type='text' name='price'>
          </p>
          <p>
            <input type='submit' value='Begin to sell' id='submit'name = 'submit'>
          </p>
           <a href='Cancel.php'>Cancel</a>
  	  </form>";
    }
     ?>
    <?php
      $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

      if(strpos($fullUrl, "sell=empty")==true){
        echo "<p class = 'error'> You did not fill in all fields!</p>";
        exit();
      }
      elseif(strpos($fullUrl, "sell=invalidTime")==true){
        echo "<p class = 'error'> You used invalid Time!</p>";
        exit();
      }
      elseif(strpos($fullUrl, "sell=invalidprice")==true){
        echo "<p class = 'error'> You enter an invalid price</p>";
        exit();
      }
      elseif(strpos($fullUrl, "sell=success")==true){
          echo "<p class = 'success'>The sell information has been added to the schedule</p>";
          exit();
      }
    ?>
  </body>
</html>
